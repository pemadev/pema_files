<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileContentController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JobListingController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Login
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Protected routes
    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Profil Content
        Route::get('/profil', [ProfileContentController::class, 'index'])->name('profil.index');
        Route::get('/profil/{type}/edit', [ProfileContentController::class, 'edit'])->name('profil.edit');
        Route::put('/profil/{type}', [ProfileContentController::class, 'update'])->name('profil.update');

        // Bisnis
        Route::get('/bisnis', [BusinessController::class, 'index'])->name('bisnis.index');
        Route::get('/bisnis/create', [BusinessController::class, 'create'])->name('bisnis.create');
        Route::post('/bisnis', [BusinessController::class, 'store'])->name('bisnis.store');
        Route::get('/bisnis/{business}/edit', [BusinessController::class, 'edit'])->name('bisnis.edit');
        Route::put('/bisnis/{business}', [BusinessController::class, 'update'])->name('bisnis.update');
        Route::delete('/bisnis/{business}', [BusinessController::class, 'destroy'])->name('bisnis.destroy');

        // Berita
        Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
        Route::get('/berita/create', [NewsController::class, 'create'])->name('berita.create');
        Route::post('/berita', [NewsController::class, 'store'])->name('berita.store');
        Route::get('/berita/{news}/edit', [NewsController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/{news}', [NewsController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{news}', [NewsController::class, 'destroy'])->name('berita.destroy');

        // Pengumuman
        Route::get('/pengumuman', [NewsController::class, 'indexPengumuman'])->name('pengumuman.index');
        Route::get('/pengumuman/create', [NewsController::class, 'createPengumuman'])->name('pengumuman.create');
        Route::post('/pengumuman', [NewsController::class, 'storePengumuman'])->name('pengumuman.store');
        Route::get('/pengumuman/{news}/edit', [NewsController::class, 'editPengumuman'])->name('pengumuman.edit');
        Route::put('/pengumuman/{news}', [NewsController::class, 'updatePengumuman'])->name('pengumuman.update');
        Route::delete('/pengumuman/{news}', [NewsController::class, 'destroyPengumuman'])->name('pengumuman.destroy');

        // Galeri
        Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri.index');
        Route::get('/galeri/create', [GalleryController::class, 'create'])->name('galeri.create');
        Route::post('/galeri', [GalleryController::class, 'store'])->name('galeri.store');
        Route::get('/galeri/{gallery}/edit', [GalleryController::class, 'edit'])->name('galeri.edit');
        Route::put('/galeri/{gallery}', [GalleryController::class, 'update'])->name('galeri.update');
        Route::delete('/galeri/{gallery}', [GalleryController::class, 'destroy'])->name('galeri.destroy');

        // Laporan
        Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/create', [ReportController::class, 'create'])->name('laporan.create');
        Route::post('/laporan', [ReportController::class, 'store'])->name('laporan.store');
        Route::get('/laporan/{report}/edit', [ReportController::class, 'edit'])->name('laporan.edit');
        Route::put('/laporan/{report}', [ReportController::class, 'update'])->name('laporan.update');
        Route::delete('/laporan/{report}', [ReportController::class, 'destroy'])->name('laporan.destroy');
        Route::get('/laporan/{report}/file', [ReportController::class, 'downloadFile'])->name('laporan.file');

        // Agenda
        Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
        Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
        Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
        Route::get('/agenda/{agendum}/edit', [AgendaController::class, 'edit'])->name('agenda.edit');
        Route::put('/agenda/{agendum}', [AgendaController::class, 'update'])->name('agenda.update');
        Route::delete('/agenda/{agendum}', [AgendaController::class, 'destroy'])->name('agenda.destroy');

        // Direksi & Komisaris
        Route::get('/team', [TeamController::class, 'index'])->name('team.index');
        Route::get('/team/create', [TeamController::class, 'create'])->name('team.create');
        Route::post('/team', [TeamController::class, 'store'])->name('team.store');
        Route::get('/team/{team}/edit', [TeamController::class, 'edit'])->name('team.edit');
        Route::put('/team/{team}', [TeamController::class, 'update'])->name('team.update');
        Route::delete('/team/{team}', [TeamController::class, 'destroy'])->name('team.destroy');

        // Mitra
        Route::get('/mitra', [PartnerController::class, 'index'])->name('mitra.index');
        Route::get('/mitra/create', [PartnerController::class, 'create'])->name('mitra.create');
        Route::post('/mitra', [PartnerController::class, 'store'])->name('mitra.store');
        Route::get('/mitra/{partner}/edit', [PartnerController::class, 'edit'])->name('mitra.edit');
        Route::put('/mitra/{partner}', [PartnerController::class, 'update'])->name('mitra.update');
        Route::delete('/mitra/{partner}', [PartnerController::class, 'destroy'])->name('mitra.destroy');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Enquiry
        Route::get('/enquiry', [EnquiryController::class, 'index'])->name('enquiry.index');
        Route::get('/enquiry/{enquiry}', [EnquiryController::class, 'show'])->name('enquiry.show');
        Route::put('/enquiry/{enquiry}/read', [EnquiryController::class, 'markAsRead'])->name('enquiry.read');
        Route::put('/enquiry/{enquiry}/unread', [EnquiryController::class, 'markAsUnread'])->name('enquiry.unread');
        Route::delete('/enquiry/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiry.destroy');

        // Banner
        Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
        Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
        Route::post('/banner', [BannerController::class, 'store'])->name('banner.store');
        Route::get('/banner/{banner}/edit', [BannerController::class, 'edit'])->name('banner.edit');
        Route::put('/banner/{banner}', [BannerController::class, 'update'])->name('banner.update');
        Route::delete('/banner/{banner}', [BannerController::class, 'destroy'])->name('banner.destroy');

        // Job Listings (Karir)
        Route::get('/karir', [JobListingController::class, 'index'])->name('karir.index');
        Route::get('/karir/create', [JobListingController::class, 'create'])->name('karir.create');
        Route::post('/karir', [JobListingController::class, 'store'])->name('karir.store');
        Route::get('/karir/{job}/edit', [JobListingController::class, 'edit'])->name('karir.edit');
        Route::put('/karir/{job}', [JobListingController::class, 'update'])->name('karir.update');
        Route::delete('/karir/{job}', [JobListingController::class, 'destroy'])->name('karir.destroy');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
