<?php

namespace App\Http\Controllers\Ppid;

use App\Http\Controllers\Controller;
use App\Models\PpidKeberatan;
use App\Models\PpidPengaduan;
use App\Models\PpidPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $years = $this->availableYears();
        $year = (int) $request->input('tahun', $years[0]);
        $thisMonth = (int) now()->format('n');
        $isCurrentYear = $year === (int) now()->format('Y');

        $sources = [
            'pemohon'   => PpidPermohonan::class,
            'pengaduan' => PpidPengaduan::class,
            'keberatan' => PpidKeberatan::class,
        ];

        $monthly = [];
        $status = [];
        $totals = [];
        foreach ($sources as $key => $model) {
            $monthly[$key] = $this->monthlyCounts($model, $year);
            $status[$key] = $this->statusCounts($model, $year);
            $totals[$key] = array_sum($monthly[$key]);
        }

        // Pemohon unik (berdasarkan email) pada tahun terpilih
        $pemohonUnik = PpidPermohonan::whereYear('created_at', $year)->distinct()->count('email');

        // Permohonan yang melewati batas 10 hari kerja dan belum dijawab
        $terlambat = PpidPermohonan::where('status', 'diproses')->get()->filter->terlambat->count();

        $cards = [
            [
                'key'     => 'pemohon',
                'label'   => 'Jumlah pemohon',
                'total'   => $totals['pemohon'],
                'route'   => route('ppid.pemohon.index', ['tahun' => $year]),
                'icon'    => 'user-profile',
                'detail'  => number_format($pemohonUnik, 0, ',', '.') . ' pemohon unik',
                'pending' => $status['pemohon']['diproses'] ?? 0,
                'pendingLabel' => 'masih diproses',
            ],
            [
                'key'     => 'pengaduan',
                'label'   => 'Jumlah pengaduan',
                'total'   => $totals['pengaduan'],
                'route'   => route('ppid.pengaduan.index', ['tahun' => $year]),
                'icon'    => 'support-ticket',
                'detail'  => ($status['pengaduan']['selesai'] ?? 0) . ' selesai',
                'pending' => ($status['pengaduan']['baru'] ?? 0) + ($status['pengaduan']['diproses'] ?? 0),
                'pendingLabel' => 'belum selesai',
            ],
            [
                'key'     => 'keberatan',
                'label'   => 'Jumlah keberatan',
                'total'   => $totals['keberatan'],
                'route'   => route('ppid.keberatan.index', ['tahun' => $year]),
                'icon'    => 'task',
                'detail'  => ($status['keberatan']['diterima'] ?? 0) . ' diterima',
                'pending' => $status['keberatan']['diproses'] ?? 0,
                'pendingLabel' => 'masih diproses',
            ],
        ];

        $monthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonthNoOverflow()->startOfMonth();
        foreach ($cards as &$card) {
            $card['thisMonth'] = $isCurrentYear ? $monthly[$card['key']][$thisMonth - 1] : null;
            $model = $sources[$card['key']];
            $cur = $model::where('created_at', '>=', $monthStart)->count();
            $prev = $model::whereBetween('created_at', [$lastMonthStart, $monthStart])->count();
            $card['growth'] = $prev > 0 ? round(($cur - $prev) / $prev * 100, 1) : null;
            $card['monthNow'] = $cur;
        }
        unset($card);

        $kategoriPemohon = collect(PpidPermohonan::KATEGORI_PEMOHON)
            ->map(fn ($label, $key) => [
                'label' => $label,
                'total' => PpidPermohonan::whereYear('created_at', $year)->where('kategori_pemohon', $key)->count(),
            ])->values()->all();

        $kategoriPengaduan = collect(PpidPengaduan::KATEGORI)
            ->map(fn ($label, $key) => [
                'label' => $label,
                'total' => PpidPengaduan::whereYear('created_at', $year)->where('kategori', $key)->count(),
            ])->values()->all();

        $recent = collect()
            ->merge(PpidPermohonan::latest()->take(8)->get()->map(fn ($i) => $this->recentRow($i, 'Permohonan', 'pemohon')))
            ->merge(PpidPengaduan::latest()->take(8)->get()->map(fn ($i) => $this->recentRow($i, 'Pengaduan', 'pengaduan')))
            ->merge(PpidKeberatan::latest()->take(8)->get()->map(fn ($i) => $this->recentRow($i, 'Keberatan', 'keberatan')))
            ->sortByDesc('date')
            ->take(12)
            ->values();

        $rekap = [];
        foreach ($sources as $key => $model) {
            $rekap[$key] = $this->rekapBulanan($model, $year);
        }

        return view('ppid.dashboard', [
            'rekap'     => $rekap,
            'title'     => 'Dashboard PPID',
            'year'      => $year,
            'years'     => $years,
            'cards'     => $cards,
            'monthly'   => $monthly,
            'status'    => $status,
            'terlambat' => $terlambat,
            'recent'    => $recent,
            'kategoriPemohon'   => $kategoriPemohon,
            'kategoriPengaduan' => $kategoriPengaduan,
            'statusDefs' => [
                'pemohon'   => PpidPermohonan::STATUSES,
                'pengaduan' => PpidPengaduan::STATUSES,
                'keberatan' => PpidKeberatan::STATUSES,
            ],
        ]);
    }

    private function monthlyCounts(string $model, int $year): array
    {
        $result = array_fill(0, 12, 0);

        $model::query()
            ->whereYear('created_at', $year)
            ->pluck('created_at')
            ->each(function ($date) use (&$result) {
                $result[(int) $date->format('n') - 1]++;
            });

        return $result;
    }

    /**
     * Rekap per bulan: data masuk (berdasarkan tanggal masuk) dan data keluar
     * (selesai, berdasarkan tanggal selesai) dipisah per status akhir.
     */
    private function rekapBulanan(string $model, int $year): array
    {
        $final = $model::finalStatuses();
        $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $rows = [];
        foreach ($bulan as $m => $nama) {
            $rows[$m] = ['bulan' => $nama, 'm' => $m, 'masuk' => 0, 'keluar' => array_fill_keys($final, 0), 'total_keluar' => 0, 'belum' => 0];
        }

        $model::query()->whereYear('created_at', $year)->get(['created_at', 'status'])
            ->each(function ($r) use (&$rows, $final) {
                $m = (int) $r->created_at->format('n');
                $rows[$m]['masuk']++;
                if (! in_array($r->status, $final, true)) {
                    $rows[$m]['belum']++;
                }
            });

        $model::query()->whereYear('tanggal_selesai', $year)->whereIn('status', $final)->get(['tanggal_selesai', 'status'])
            ->each(function ($r) use (&$rows) {
                $m = (int) $r->tanggal_selesai->format('n');
                $rows[$m]['keluar'][$r->status]++;
                $rows[$m]['total_keluar']++;
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
            'final'  => array_map(fn ($k) => ['key' => $k, 'label' => $model::STATUSES[$k]['label'], 'color' => $model::STATUSES[$k]['color']], $final),
            'rows'   => array_values($rows),
            'total'  => $total,
        ];
    }

    private function statusCounts(string $model, int $year): array
    {
        return $model::query()
            ->whereYear('created_at', $year)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn ($v) => (int) $v)
            ->all();
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
        $first = collect(['ppid_permohonan', 'ppid_pengaduan', 'ppid_keberatan'])
            ->map(fn ($t) => DB::table($t)->whereNull('deleted_at')->min('created_at'))
            ->filter()
            ->min();

        $current = (int) now()->format('Y');
        $from = $first ? (int) substr((string) $first, 0, 4) : $current;

        return range($current, min($from, $current));
    }
}