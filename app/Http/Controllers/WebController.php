<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Banner;
use App\Models\Business;
use App\Models\Gallery;
use App\Models\JobListing;
use App\Models\News;
use App\Models\Partner;
use App\Models\ProfileContent;
use App\Models\Report;
use App\Models\Setting;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Date;

class WebController extends Controller
{
    public function beranda()
    {
        $businesses = Business::orderBy('sort_order')->get()->groupBy('category');
        $latestNews = News::type('berita')->where('is_published', true)->latest()->take(3)->get();
        $partners = Partner::orderBy('sort_order')->get();
        $sambutan = ProfileContent::type('sambutan')->first();
        $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.beranda', compact(
            'businesses', 'latestNews', 'partners', 'sambutan', 'banners'
        ));
    }

    public function profil()
    {
        $sambutan = ProfileContent::type('sambutan')->first();
        $sejarah = ProfileContent::type('sejarah')->first();
        $visiMisi = ProfileContent::type('visi_misi')->first();
        $stakeholder = ProfileContent::type('stakeholder')->first();
        $direksi = Team::category('direksi')->orderBy('sort_order')->get();
        $komisaris = Team::category('komisaris')->orderBy('sort_order')->get();

        return view('pages.profil', compact(
            'sambutan', 'sejarah', 'visiMisi', 'stakeholder', 'direksi', 'komisaris'
        ));
    }

    public function bisnis()
    {
        $categories = [
            'migas' => ['label' => 'Migas', 'icon' => 'fi fi-rs-gas-pump', 'desc' => 'Minyak & Gas Bumi', 'color' => 'pema'],
            'agroindustri' => ['label' => 'Agroindustri', 'icon' => 'fi fi-rs-leaf', 'desc' => 'Perkebunan & Perikanan', 'color' => 'green'],
            'jasa' => ['label' => 'Jasa & Perdagangan', 'icon' => 'fi fi-rs-handshake', 'desc' => 'Jasa & Perdagangan', 'color' => 'amber'],
        ];

        return view('pages.bisnis', compact('categories'));
    }

    public function bisnisCategory(Request $request, string $category)
    {
        if (!in_array($category, ['migas', 'agroindustri', 'jasa'])) {
            abort(404);
        }

        $sortBy = in_array($request->sort_by, ['title', 'sort_order', 'created_at']) ? $request->sort_by : 'sort_order';
        $sortDir = in_array($request->sort_dir, ['asc', 'desc']) ? $request->sort_dir : 'asc';

        $items = Business::category($category)
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->orderBy($sortBy, $sortDir)
            ->orderBy('id', $sortDir)
            ->paginate(12)
            ->appends(request()->query());

        $catLabels = [
            'migas' => ['label' => 'Migas', 'icon' => 'fi fi-rs-gas-pump', 'desc' => 'Minyak & Gas Bumi', 'color' => 'pema'],
            'agroindustri' => ['label' => 'Agroindustri', 'icon' => 'fi fi-rs-leaf', 'desc' => 'Perkebunan & Perikanan', 'color' => 'green'],
            'jasa' => ['label' => 'Jasa & Perdagangan', 'icon' => 'fi fi-rs-handshake', 'desc' => 'Jasa & Perdagangan', 'color' => 'amber'],
        ];

        $cat = $catLabels[$category];

        return view('pages.bisnis-category', compact('items', 'category', 'cat'));
    }

    public function bisnisDetail(string $category, Business $business)
    {
        if (!in_array($category, ['migas', 'agroindustri', 'jasa'])) {
            abort(404);
        }

        if ($business->category !== $category) {
            abort(404);
        }

        $catLabels = [
            'migas' => ['label' => 'Migas', 'icon' => 'fi fi-rs-gas-pump', 'desc' => 'Minyak & Gas Bumi', 'color' => 'pema'],
            'agroindustri' => ['label' => 'Agroindustri', 'icon' => 'fi fi-rs-leaf', 'desc' => 'Perkebunan & Perikanan', 'color' => 'green'],
            'jasa' => ['label' => 'Jasa & Perdagangan', 'icon' => 'fi fi-rs-handshake', 'desc' => 'Jasa & Perdagangan', 'color' => 'amber'],
        ];

        $cat = $catLabels[$category];

        $relatedItems = Business::category($category)
            ->where('id', '!=', $business->id)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        return view('pages.bisnis-detail', compact('business', 'category', 'cat', 'relatedItems'));
    }

    public function berita(Request $request)
    {
        $sortBy = in_array($request->sort_by, ['created_at', 'title']) ? $request->sort_by : 'created_at';
        $sortDir = in_array($request->sort_dir, ['asc', 'desc']) ? $request->sort_dir : 'desc';

        $newsList = News::type('berita')
            ->where('is_published', true)
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->year, fn($q, $v) => $q->whereYear('date', $v))
            ->orderBy($sortBy, $sortDir)
            ->orderBy('id', $sortDir)
            ->paginate(10)
            ->appends(request()->query());

        $years = News::type('berita')->where('is_published', true)->whereNotNull('date')->get()->sortByDesc('date')->groupBy(fn($n) => $n->date instanceof \Carbon\Carbon ? $n->date->year : date('Y', strtotime($n->date)))->keys();

        return view('pages.berita.index', compact('newsList', 'years'));
    }

    public function beritaDetail(News $news)
    {
        if ($news->type !== 'berita') {
            abort(404);
        }
        $relatedNews = News::type('berita')->where('id', '!=', $news->id)->latest()->take(3)->get();
        return view('pages.berita.show', compact('news', 'relatedNews'));
    }

    public function pengumuman(Request $request)
    {
        $newsList = News::type('pengumuman')
            ->where('is_published', true)
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->year, fn($q, $v) => $q->whereYear('date', $v))
            ->latest()
            ->paginate(12)
            ->appends(request()->query());

        $years = News::type('pengumuman')->where('is_published', true)->whereNotNull('date')->get()->sortByDesc('date')->groupBy(fn($n) => $n->date instanceof \Carbon\Carbon ? $n->date->year : date('Y', strtotime($n->date)))->keys();

        return view('pages.pengumuman.index', compact('newsList', 'years'));
    }

    public function pengumumanDetail(News $news)
    {
        if ($news->type !== 'pengumuman') {
            abort(404);
        }
        $relatedNews = News::type('pengumuman')->where('id', '!=', $news->id)->latest()->take(3)->get();
        return view('pages.pengumuman.show', compact('news', 'relatedNews'));
    }

    public function galeri(Request $request)
    {
        $galleries = Gallery::query()
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends(request()->query());

        return view('pages.galeri', compact('galleries'));
    }

    public function laporan(Request $request)
    {
        $reports = Report::where('is_published', true)
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->year, fn($q, $v) => $q->where('year', $v))
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends(request()->query());

        $years = Report::where('is_published', true)->select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('pages.laporan', compact('reports', 'years'));
    }

    public function downloadLaporan(Report $report)
    {
        if (!$report->is_published) {
            abort(404);
        }

        if (!$report->file) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = $report->file;
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($path, $report->title . '.' . pathinfo($path, PATHINFO_EXTENSION));
    }

    public function viewLaporan(Report $report)
    {
        if (!$report->is_published) {
            abort(404);
        }

        if (!$report->file) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = $report->file;
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        return response($file, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $report->title . '.' . pathinfo($path, PATHINFO_EXTENSION) . '"',
        ]);
    }

    public function agenda(Request $request)
    {
        $agendaList = Agenda::where('is_published', true)
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->filter === 'upcoming', fn($q) => $q->where('date', '>=', now()))
            ->when($request->filter === 'past', fn($q) => $q->where('date', '<', now()))
            ->orderBy('date', 'desc')
            ->paginate(12)
            ->appends(request()->query());

        return view('pages.agenda', compact('agendaList'));
    }

    public function karir()
    {
        $activeJobs = JobListing::active()->orderBy('created_at', 'desc')->get();
        $karirLink = Setting::getValue('karir_link', '#');
        return view('pages.karir', compact('activeJobs', 'karirLink'));
    }

    public function kerjasama()
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('pages.kerjasama', compact('partners'));
    }

    public function kontak()
    {
        $settings = [
            'alamat' => Setting::getValue('alamat'),
            'email' => Setting::getValue('email'),
            'telepon' => Setting::getValue('telepon'),
            'fax' => Setting::getValue('fax'),
            'instagram' => Setting::getValue('instagram'),
            'facebook' => Setting::getValue('facebook'),
            'twitter' => Setting::getValue('twitter'),
            'youtube' => Setting::getValue('youtube'),
        ];
        return view('pages.kontak', compact('settings'));
    }

    public function beranda2()
    {
        $businesses = Business::orderBy('sort_order')->get()->groupBy('category');
        $latestNews = News::type('berita')->where('is_published', true)->latest()->take(3)->get();
        $partners = Partner::orderBy('sort_order')->get();
        $sambutan = ProfileContent::type('sambutan')->first();

        return view('pages.beranda2', compact(
            'businesses', 'latestNews', 'partners', 'sambutan'
        ));
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }
}
