<?php

namespace App\Http\Controllers\Ppid;

use App\Http\Controllers\Controller;
use App\Models\PpidKategoriPemohon;
use App\Models\PpidPermohonan;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\PpidUser;
use Illuminate\Http\Request;

/** Daftar akun pemohon informasi (tabel ppid_users di database production, hanya baca). */
class PenggunaController extends Controller
{
    /** Daftar pemohon informasi: data dari ppid_permohonan_informasi beserta identitas pemohonnya. */
    public function index(Request $request)
    {
        $filters = $request->only(['q', 'status', 'kategori', 'tahun']);

        $query = fn () => PpidPermohonan::query()
            ->filter($filters)
            ->when($filters['kategori'] ?? null, fn ($q, $k) => $q->whereHas('user', fn ($u) => $u->where('id_kategori_pemohon', $k)));

        $items = $query()
            ->with(['user.kategori', 'latestStatus'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $first = PpidPermohonan::min('created_at');
        $current = (int) now()->format('Y');

        return view('ppid.pengguna.index', [
            'title'      => 'Pemohon Informasi',
            'items'      => $items,
            'filters'    => $filters,
            'statuses'   => PpidPermohonan::STATUSES,
            'kategori'   => PpidKategoriPemohon::orderBy('id')->pluck('kategori_pemohon', 'id'),
            'years'      => range($current, min($first ? (int) substr((string) $first, 0, 4) : $current, $current)),
            'total'      => $query()->count(),
            'pemohonUnik'=> $query()->distinct()->count('ppid_users_id'),
            'selesai'    => $query()->whereCurrentStatus(PpidPermohonan::finalStatuses())->count(),
        ]);
    }

    /** Daftar pemohon: akun yang terdaftar di portal PPID (tabel ppid_users, hanya baca). */
    public function akun(Request $request)
    {
        $filters = $request->only(['q', 'kategori', 'aktif', 'tahun']);

        $items = PpidUser::query()
            ->with('kategori')
            ->withCount(['permohonan', 'keberatan'])
            ->filter($filters)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $first = PpidUser::min('created_at');
        $current = (int) now()->format('Y');

        return view('ppid.pengguna.akun', [
            'title'    => 'Daftar Pemohon',
            'items'    => $items,
            'filters'  => $filters,
            'kategori' => PpidKategoriPemohon::orderBy('id')->pluck('kategori_pemohon', 'id'),
            'years'    => range($current, min($first ? (int) substr((string) $first, 0, 4) : $current, $current)),
            'total'    => PpidUser::count(),
            'aktif'    => PpidUser::where('active', 1)->count(),
        ]);
    }

    public function show(int $id)
    {
        $item = PpidUser::with([
            'kategori',
            'permohonan' => fn ($q) => $q->with(['latestStatus', 'statuses'])->latest(),
            'keberatan'  => fn ($q) => $q->with(['latestStatus', 'statuses'])->latest(),
        ])->findOrFail($id);

        $final = PpidPermohonan::finalStatuses();
        $semua = $item->permohonan->concat($item->keberatan);

        $stats = [
            'permohonan' => $item->permohonan->count(),
            'keberatan'  => $item->keberatan->count(),
            'selesai'    => $semua->filter(fn ($r) => in_array($r->status, $final, true))->count(),
            'berjalan'   => $semua->reject(fn ($r) => in_array($r->status, $final, true))->count(),
            'terlambat'  => $item->permohonan->filter->terlambat->count(),
        ];

        // Linimasa: setiap perubahan status dari semua permohonan & keberatan pemohon ini
        $aktivitas = collect();
        foreach ([['Permohonan', 'ppid.pemohon.show', $item->permohonan], ['Keberatan', 'ppid.keberatan.show', $item->keberatan]] as [$jenis, $route, $rows]) {
            foreach ($rows as $r) {
                foreach ($r->statuses as $s) {
                    $aktivitas->push([
                        'jenis' => $jenis,
                        'nomor' => $r->no_permohonan,
                        'url'   => route($route, $r->id),
                        'label' => $s->label,
                        'color' => $s->color,
                        'info'  => $s->info,
                        'oleh'  => $s->status_by,
                        'date'  => $s->created_at,
                    ]);
                }
            }
        }

        return view('ppid.pengguna.show', [
            'title'     => 'Pemohon ' . $item->name,
            'item'      => $item,
            'stats'     => $stats,
            'aktivitas' => $aktivitas->sortByDesc('date')->values(),
            'whatsapp'  => $this->whatsappNumber($item->telepon),
        ]);
    }

    /** Kolom file dokumen di ppid_users. */
    private const DOKUMEN = [
        'ktp'   => ['kolom' => 'file_ktp',             'label' => 'KTP'],
        'surat' => ['kolom' => 'file_surat_pengantar', 'label' => 'Surat pengantar'],
    ];

    /**
     * Lihat / unduh dokumen pemohon. File disimpan di server portal PPID; diambil lewat aplikasi ini
     * supaya hanya admin yang login yang bisa membukanya. ?unduh=1 untuk mengunduh, selain itu dibuka di browser.
     */
    public function dokumen(Request $request, int $id, string $jenis)
    {
        abort_unless(isset(self::DOKUMEN[$jenis]), 404);

        $user = PpidUser::findOrFail($id);
        $label = self::DOKUMEN[$jenis]['label'];
        $file = $user->{self::DOKUMEN[$jenis]['kolom']};

        // Gagal: kembali ke profil pemohon dengan notifikasi, bukan halaman error
        $gagal = fn (string $pesan) => redirect()->route('ppid.pengguna.show', $user->id)->with('error', $pesan);

        if (blank($file) || str_contains($file, '/') || str_contains($file, '\\') || str_contains($file, '..')) {
            return $gagal("Dokumen {$label} tidak ditemukan.");
        }

        $url = rtrim((string) config('services.ppid_api.storage_url'), '/') . '/' . rawurlencode($file);

        try {
            // Coba 2 kali (jeda 1 detik) agar gangguan jaringan sesaat tidak langsung gagal
            $response = Http::connectTimeout(8)->timeout(30)->retry(2, 1000, throw: false)->get($url);
        } catch (\Throwable $e) {
            Log::warning("Gagal mengambil dokumen PPID {$file}: " . $e->getMessage());

            return $gagal("Dokumen {$label} tidak dapat dibuka: server portal PPID (hr-api.pema.co.id) sedang tidak dapat dihubungi. Coba lagi beberapa saat lagi.");
        }

        $type = strtolower((string) $response->header('Content-Type'));
        // Server portal mengembalikan halaman HTML bila file tidak ada
        if ($response->failed() || str_starts_with($type, 'text/html')) {
            Log::warning("Dokumen PPID {$file} tidak tersedia (HTTP {$response->status()}).");

            return $gagal("File dokumen {$label} tidak ditemukan di server portal PPID.");
        }

        $unduh = $request->boolean('unduh');
        ActivityLogger::log($unduh ? 'downloaded' : 'viewed', 'ppid', ($unduh ? 'Mengunduh' : 'Melihat') . ' dokumen ' . self::DOKUMEN[$jenis]['label'] . ' pemohon ' . $user->name);

        $nama = str_replace(['"', "\r", "\n"], '', $file);

        return response($response->body(), 200, [
            'Content-Type'           => $type ?: 'application/octet-stream',
            'Content-Disposition'    => ($unduh ? 'attachment' : 'inline') . '; filename="' . $nama . '"; filename*=UTF-8\'\'' . rawurlencode($nama),
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control'          => 'private, no-store',
        ]);
    }

    /** 0812xxxx / +62812xxxx -> 62812xxxx untuk tautan wa.me; null bila bukan nomor HP Indonesia. */
    private function whatsappNumber(?string $phone): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $phone);
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        return preg_match('/^628\d{7,12}$/', $digits) ? $digits : null;
    }
}
