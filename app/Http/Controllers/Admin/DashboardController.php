<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Agenda;
use App\Models\Business;
use App\Models\Enquiry;
use App\Models\Gallery;
use App\Models\News;

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

        return view('admin.dashboard', compact('stats', 'activities'));
    }
}
