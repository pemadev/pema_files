<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Agenda;
use App\Models\Business;
use App\Models\Enquiry;
use App\Models\Gallery;
use App\Models\News;
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

        // Data Google Analytics, di-cache 1 jam supaya tidak boros kuota API
        $analytics = $this->getAnalyticsData();

        return view('admin.dashboard', compact('stats', 'activities', 'analytics'));
    }

    /**
     * Ambil data Google Analytics (GA4) untuk dashboard.
     *
     * Catatan: package spatie/laravel-analytics v5 (GA4) tidak punya method
     * bawaan untuk "active users realtime". Semua method di package ini
     * berbasis periode/histori, jadi "pengguna aktif" di sini diganti jadi
     * "pengunjung hari ini" (data histori hari berjalan, bukan realtime detik-per-detik).
     */
    private function getAnalyticsData(): array
    {
        return Cache::remember('ga-dashboard-data', now()->addHour(), function () {
            try {
                $visitors = Analytics::fetchVisitorsAndPageViewsByDate(Period::days(30));
                $topPages = Analytics::fetchMostVisitedPages(Period::days(30), 5);

                $today = Analytics::fetchTotalVisitorsAndPageViews(
                    Period::create(now()->startOfDay(), now())
                );
                $visitorsToday = $today->sum('visitors');

                $thisMonth = Analytics::fetchTotalVisitorsAndPageViews(
                    Period::create(now()->startOfMonth(), now())
                );
                $lastMonth = Analytics::fetchTotalVisitorsAndPageViews(
                    Period::create(now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth())
                );

                $totalThisMonth = $thisMonth->sum('pageViews');
                $totalLastMonth = $lastMonth->sum('pageViews');

                $growth = $totalLastMonth > 0
                    ? round((($totalThisMonth - $totalLastMonth) / $totalLastMonth) * 100, 1)
                    : 0;

                return [
                    'visitors'        => $visitors,
                    'topPages'        => $topPages,
                    'visitorsToday'   => $visitorsToday,
                    'totalThisMonth'  => $totalThisMonth,
                    'totalLastMonth'  => $totalLastMonth,
                    'growth'          => $growth,
                    'available'       => true,
                ];
            } catch (\Throwable $e) {
                // Kalau credential GA belum diatur / API error, dashboard tetap tampil
                // tanpa mematikan seluruh halaman.
                report($e);

                return [
                    'visitors'       => collect(),
                    'topPages'       => collect(),
                    'visitorsToday'  => 0,
                    'totalThisMonth' => 0,
                    'totalLastMonth' => 0,
                    'growth'         => 0,
                    'available'      => false,
                ];
            }
        });
    }
}