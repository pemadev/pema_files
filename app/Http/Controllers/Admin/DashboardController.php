<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Agenda;
use App\Models\Business;
use App\Models\Enquiry;
use App\Models\Gallery;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_berita' => News::where('type', 'berita')->count(),
            'total_pengumuman' => News::where('type', 'pengumuman')->count(),
            'total_bisnis' => Business::count(),
            'total_galeri' => Gallery::count(),
            'total_agenda' => Agenda::count(),
            'total_pesan' => Enquiry::count(),
            'pesan_baru' => Enquiry::where('is_read', false)->count(),
            'berita_terbaru' => News::where('type', 'berita')->latest()->take(5)->get(),
            'pesan_terbaru' => Enquiry::latest()->take(5)->get(),
        ];

        $activities = Activity::with('user')->latest()->take(20)->get();

        // Data Google Analytics website baru (cache 1 jam)
        $analytics = $this->getAnalyticsData();

        // Data website lama: Jan-Des 2025 & Jan-Mei 2026 (data contoh, bukan dari GA)
        $oldWebsite = $this->getOldWebsiteData();

        return view('admin.dashboard', compact('stats', 'activities', 'analytics', 'oldWebsite'));
    }

    /**
     * Data GA4 website baru.
     * Exception TIDAK ikut ter-cache: kalau gagal, request berikutnya mencoba lagi.
     */
    private function getAnalyticsData(): array
    {
        try {
            return Cache::remember('ga-dashboard-data-v2', now()->addHour(), function () {
                $metrics = ['activeUsers', 'screenPageViews'];

                // Grafik harian 30 hari terakhir: 1 baris per tanggal
                $daily = Analytics::get(Period::days(30), $metrics, ['date'], 100)
                    ->map(fn ($row) => [
                        'date'      => Carbon::parse($row['date'])->format('Y-m-d'),
                        'visitors'  => (int) $row['activeUsers'],
                        'pageViews' => (int) $row['screenPageViews'],
                    ])
                    ->sortBy('date')
                    ->values();

                $topPages = Analytics::fetchMostVisitedPages(Period::days(30), 5);

                $today     = $this->totals(Period::create(now()->startOfDay(), now()));
                $thisMonth = $this->totals(Period::create(now()->startOfMonth(), now()));
                $lastMonth = $this->totals(Period::create(
                    now()->subMonthNoOverflow()->startOfMonth(),
                    now()->subMonthNoOverflow()->endOfMonth()
                ));

                $growth = $lastMonth['pageViews'] > 0
                    ? round((($thisMonth['pageViews'] - $lastMonth['pageViews']) / $lastMonth['pageViews']) * 100, 1)
                    : 0;

                return [
                    'chart' => [
                        'labels'    => $daily->map(fn ($d) => Carbon::parse($d['date'])->format('d M'))->all(),
                        'visitors'  => $daily->pluck('visitors')->all(),
                        'pageViews' => $daily->pluck('pageViews')->all(),
                    ],
                    'topPages'       => $topPages,
                    'visitorsToday'  => $today['visitors'],
                    'totalThisMonth' => $thisMonth['pageViews'],
                    'totalLastMonth' => $lastMonth['pageViews'],
                    'growth'         => $growth,
                    'available'      => true,
                ];
            });
        } catch (\Throwable $e) {
            report($e);

            return [
                'chart'          => ['labels' => [], 'visitors' => [], 'pageViews' => []],
                'topPages'       => collect(),
                'visitorsToday'  => 0,
                'totalThisMonth' => 0,
                'totalLastMonth' => 0,
                'growth'         => 0,
                'available'      => false,
            ];
        }
    }

    /**
     * Data pengunjung website LAMA per bulan (2025: Jan-Des, 2026: Jan-Mei).
     *
     * CATATAN: ini DATA CONTOH (dummy), hanya untuk menampilkan grafik.
     * Bukan angka asli dari Google Analytics. Kalau sudah punya data sebenarnya,
     * tinggal ganti angka di $series2025 dan $series2026 di bawah ini.
     */
    private function getOldWebsiteData(): array
    {
        //                 Jan   Feb   Mar   Apr   Mei   Jun   Jul   Agu   Sep   Okt   Nov   Des
        $series2025 = [1240, 1180, 1350, 1420, 1560, 1490, 1610, 1720, 1650, 1780, 1900, 2050];

        // 2026 hanya sampai Mei; bulan setelahnya null supaya garis berhenti di Mei
        $series2026 = [2100, 1980, 2240, 2310, 2450, null, null, null, null, null, null, null];

        return [
            'labels'     => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'series2025' => $series2025,
            'series2026' => $series2026,
            'total2025'  => array_sum($series2025),
            'total2026'  => array_sum(array_filter($series2026, fn ($v) => $v !== null)),
            'available'  => true,
        ];
    }

    /**
     * Total pengunjung & page views untuk satu periode (tanpa dimensi -> 1 baris ringkasan).
     */
    private function totals(Period $period): array
    {
        $row = Analytics::get($period, ['activeUsers', 'screenPageViews'])->first();

        return [
            'visitors'  => (int) ($row['activeUsers'] ?? 0),
            'pageViews' => (int) ($row['screenPageViews'] ?? 0),
        ];
    }
}