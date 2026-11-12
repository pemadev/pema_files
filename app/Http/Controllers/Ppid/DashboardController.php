<?php

namespace App\Http\Controllers\Ppid;

use App\Http\Controllers\Controller;
use App\Models\PpidKategoriPemohon;
use App\Models\PpidKeberatan;
use App\Models\PpidPermohonan;
use App\Services\PpidUserApi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** Sumber data dashboard: tabel PPID di database production. */
    private const SOURCES = [
        'pemohon'   => PpidPermohonan::class,
        'keberatan' => PpidKeberatan::class,
    ];

    public function index(Request $request, PpidUserApi $userApi)
    {
        $years = $this->availableYears();
        $year = (int) $request->input('tahun', $years[0]);
        $thisMonth = (int) now()->format('n');
        $isCurrentYear = $year === (int) now()->format('Y');

        // Data tahun terpilih beserta status terakhir (jumlah data kecil, cukup diolah di PHP)
        $records = [];
        $monthly = [];
        $status = [];
        $totals = [];
        foreach (self::SOURCES as $key => $model) {
            $records[$key] = $model::with(['user', 'latestStatus'])->whereYear('created_at', $year)->get();
            $monthly[$key] = $this->monthlyCounts($records[$key]);
            $status[$key] = $records[$key]->countBy(fn ($r) => $r->status)->all();
            $totals[$key] = $records[$key]->count();
        }

        $open = PpidPermohonan::openStatuses();
        $pemohonUnik = $records['pemohon']->pluck('ppid_users_id')->unique()->count();

        // Permohonan yang melewati batas 10 hari kerja dan belum selesai (semua tahun)
        $terlambat = PpidPermohonan::with('latestStatus')->whereCurrentStatus($open)->get()->filter->terlambat->count();

        $sum = fn (array $s, array $keys) => array_sum(array_intersect_key($s, array_flip($keys)));

        $cards = [
            [
                'key'     => 'pemohon',
                'label'   => 'Jumlah permohonan',
                'total'   => $totals['pemohon'],
                'route'   => route('ppid.pemohon.index', ['tahun' => $year]),
                'detail'  => number_format($pemohonUnik, 0, ',', '.') . ' pemohon unik',
                'pending' => $sum($status['pemohon'], $open),
                'pendingLabel' => 'belum selesai',
            ],
            [
                'key'     => 'keberatan',
                'label'   => 'Jumlah keberatan',
                'total'   => $totals['keberatan'],
                'route'   => route('ppid.keberatan.index', ['tahun' => $year]),
                'detail'  => ($status['keberatan']['selesai'] ?? 0) . ' selesai',
                'pending' => $sum($status['keberatan'], $open),
                'pendingLabel' => 'belum selesai',
            ],
        ];

        $monthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonthNoOverflow()->startOfMonth();
        foreach ($cards as &$card) {
            $card['thisMonth'] = $isCurrentYear ? $monthly[$card['key']][$thisMonth - 1] : null;
            $model = self::SOURCES[$card['key']];
            $cur = $model::where('created_at', '>=', $monthStart)->count();
            $prev = $model::whereBetween('created_at', [$lastMonthStart, $monthStart])->count();
            $card['growth'] = $prev > 0 ? round(($cur - $prev) / $prev * 100, 1) : null;
            $card['monthNow'] = $cur;
        }
        unset($card);

        // Kategori pemohon diambil dari profil akun pemohon (ppid_users.id_kategori_pemohon)
        $perKategori = $records['pemohon']->countBy(fn ($r) => $r->user?->id_kategori_pemohon);
        $kategoriPemohon = PpidKategoriPemohon::orderBy('id')->get()
            ->map(fn ($k) => ['label' => $k->kategori_pemohon, 'total' => (int) ($perKategori[$k->id] ?? 0)])
            ->values()->all();

        $caraSalinan = $records['pemohon']->countBy(fn ($r) => $r->cara_mendapatkan_salinan ?: 'Tidak diisi')
            ->sortDesc()
            ->map(fn ($total, $label) => ['label' => $label, 'total' => $total])
            ->values()->all();

        $recent = collect()
            ->merge(PpidPermohonan::with(['user', 'latestStatus'])->latest()->take(8)->get()->map(fn ($i) => $this->recentRow($i, 'Permohonan', 'pemohon')))
            ->merge(PpidKeberatan::with(['user', 'latestStatus'])->latest()->take(8)->get()->map(fn ($i) => $this->recentRow($i, 'Keberatan', 'keberatan')))
            ->sortByDesc('date')
            ->take(12)
            ->values();

        $rekap = [];
        foreach (self::SOURCES as $key => $model) {
            $rekap[$key] = $this->rekapBulanan($model, $records[$key], $year);
        }

        return view('ppid.dashboard', [
            'rekap'     => $rekap,
            'akun'      => $userApi->summary(10),
            'title'     => 'Dashboard PPID',
            'year'      => $year,
            'years'     => $years,
            'cards'     => $cards,
            'monthly'   => $monthly,
            'status'    => $status,
            'terlambat' => $terlambat,
            'recent'    => $recent,
            'kategoriPemohon' => $kategoriPemohon,
            'caraSalinan'     => $caraSalinan,
            'statusDefs' => [
                'pemohon'   => PpidPermohonan::STATUSES,
                'keberatan' => PpidKeberatan::STATUSES,
            ],
        ]);
    }

    private function monthlyCounts($records): array
    {
        $result = array_fill(0, 12, 0);
        foreach ($records as $r) {
            $result[(int) $r->created_at->format('n') - 1]++;
        }

        return $result;
    }

    /**
     * Rekap per bulan: data masuk (tanggal masuk) dan data keluar (tanggal status final
     * dicatat) per status akhir.
     */
    private function rekapBulanan(string $model, $records, int $year): array
    {
        $final = $model::finalStatuses();
        $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $rows = [];
        foreach ($bulan as $m => $nama) {
            $rows[$m] = ['bulan' => $nama, 'm' => $m, 'masuk' => 0, 'keluar' => array_fill_keys($final, 0), 'total_keluar' => 0, 'belum' => 0];
        }

        foreach ($records as $r) {
            $m = (int) $r->created_at->format('n');
            $rows[$m]['masuk']++;
            if (! in_array($r->status, $final, true)) {
                $rows[$m]['belum']++;
            }
        }

        // Keluar: semua data (termasuk yang masuk tahun sebelumnya) yang selesai pada tahun ini
        $model::with('latestStatus')->whereCurrentStatus($final)->get()
            ->each(function ($r) use (&$rows, $year) {
                $done = $r->tanggal_selesai;
                if ($done && (int) $done->format('Y') === $year) {
                    $m = (int) $done->format('n');
                    $rows[$m]['keluar'][$r->status]++;
                    $rows[$m]['total_keluar']++;
                }
            });

        $total = ['masuk' => 0, 'keluar' => array_fill_keys($final, 0), 'total_keluar' => 0, 'belum' => 0];
        foreach ($rows as $r) {
            $total['masuk'] += $r['masuk'];
            $total['total_keluar'] += $r['total_keluar'];
            $total['belum'] += $r['belum'];
            foreach ($final as $f) {
                $total['keluar'][$f] += $r['keluar'][$f];
            }
        }

        return [
            'final' => array_map(fn ($k) => ['key' => $k, 'label' => $model::STATUSES[$k]['label'], 'color' => $model::STATUSES[$k]['color']], $final),
            'rows'  => array_values($rows),
            'total' => $total,
        ];
    }

    private function recentRow($item, string $type, string $route): array
    {
        return [
            'type'   => $type,
            'key'    => $route,
            'nomor'  => $item->nomor,
            'nama'   => $item->nama,
            'status' => $item->status_label,
            'color'  => $item->status_color,
            'date'   => $item->created_at,
            'url'    => route("ppid.{$route}.show", $item->id),
        ];
    }

    private function availableYears(): array
    {
        $first = collect(self::SOURCES)->map(fn ($m) => $m::min('created_at'))->filter()->min();
        $current = (int) now()->format('Y');
        $from = $first ? (int) substr((string) $first, 0, 4) : $current;

        return range($current, min($from, $current));
    }
}
