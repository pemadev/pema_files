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
use App\Http\Controllers\Admin\StatistikPemaController;
use App\Http\Controllers\Admin\ProductController;

Route::prefix('admin')->name('admin.')->group(function () {

    // Login
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Forgot Password & Reset Password
    Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // Protected routes
    Route::middleware('admin')->group(function () {
        // Dashboard - semua yang login (admin & editor) boleh lihat
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // ── Profil Content ──────────────────────────────
            Route::middleware('permission:view profile content')->group(function () {
            Route::get('/profil', [ProfileContentController::class, 'index'])->name('profil.index');
            Route::get('/profil/{type}/edit', [ProfileContentController::class, 'edit'])->name('profil.edit');
        });
            Route::put('/profil/{type}', [ProfileContentController::class, 'update'])
            ->name('profil.update')->middleware('permission:edit profile content');

        // ── Bisnis ───────────────────────────────────────
            Route::middleware('permission:view business')->group(function () {
            Route::get('/bisnis', [BusinessController::class, 'index'])->name('bisnis.index');
            Route::get('/bisnis/{business}/edit', [BusinessController::class, 'edit'])->name('bisnis.edit');
        });
            Route::middleware('permission:create business')->group(function () {
            Route::get('/bisnis/create', [BusinessController::class, 'create'])->name('bisnis.create');
            Route::post('/bisnis', [BusinessController::class, 'store'])->name('bisnis.store');
        });
            Route::put('/bisnis/{business}', [BusinessController::class, 'update'])
            ->name('bisnis.update')->middleware('permission:edit business');
            Route::delete('/bisnis/{business}', [BusinessController::class, 'destroy'])
            ->name('bisnis.destroy')->middleware('permission:delete business');

        // ── Berita ───────────────────────────────────────
            Route::middleware('permission:view news')->group(function () {
            Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
            Route::get('/berita/{news}/edit', [NewsController::class, 'edit'])->name('berita.edit');
        });
            Route::middleware('permission:create news')->group(function () {
            Route::get('/berita/create', [NewsController::class, 'create'])->name('berita.create');
            Route::post('/berita', [NewsController::class, 'store'])->name('berita.store');
            Route::post('/berita/upload-image', [NewsController::class, 'uploadContentImage'])->name('berita.upload-image');
        });
            Route::put('/berita/{news}', [NewsController::class, 'update'])
            ->name('berita.update')->middleware('permission:edit news');
            Route::delete('/berita/{news}', [NewsController::class, 'destroy'])
            ->name('berita.destroy')->middleware('permission:delete news');
            Route::delete('/berita/photos/{photo}', [NewsController::class, 'destroyPhoto'])
            ->name('berita.photos.destroy')->middleware('permission:delete news');

        // ── Pengumuman (pakai permission 'news' yang sama, karena satu model/controller) ──
            Route::middleware('permission:view news')->group(function () {
            Route::get('/pengumuman', [NewsController::class, 'indexPengumuman'])->name('pengumuman.index');
            Route::get('/pengumuman/{news}/edit', [NewsController::class, 'editPengumuman'])->name('pengumuman.edit');
        });
            Route::middleware('permission:create news')->group(function () {
            Route::get('/pengumuman/create', [NewsController::class, 'createPengumuman'])->name('pengumuman.create');
            Route::post('/pengumuman', [NewsController::class, 'storePengumuman'])->name('pengumuman.store');
        });
            Route::put('/pengumuman/{news}', [NewsController::class, 'updatePengumuman'])
            ->name('pengumuman.update')->middleware('permission:edit news');
            Route::delete('/pengumuman/{news}', [NewsController::class, 'destroyPengumuman'])
            ->name('pengumuman.destroy')->middleware('permission:delete news');

        // ── Galeri ───────────────────────────────────────
            Route::middleware('permission:view gallery')->group(function () {
            Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri.index');
            Route::get('/galeri/{gallery}/edit', [GalleryController::class, 'edit'])->name('galeri.edit');
        });
            Route::middleware('permission:create gallery')->group(function () {
            Route::get('/galeri/create', [GalleryController::class, 'create'])->name('galeri.create');
            Route::post('/galeri', [GalleryController::class, 'store'])->name('galeri.store');
        });
            Route::put('/galeri/{gallery}', [GalleryController::class, 'update'])
            ->name('galeri.update')->middleware('permission:edit gallery');
            Route::delete('/galeri/{gallery}', [GalleryController::class, 'destroy'])
            ->name('galeri.destroy')->middleware('permission:delete gallery');

        // ── Laporan ──────────────────────────────────────
            Route::middleware('permission:view report')->group(function () {
            Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
            Route::get('/laporan/{report}/edit', [ReportController::class, 'edit'])->name('laporan.edit');
            Route::get('/laporan/{report}/file', [ReportController::class, 'downloadFile'])->name('laporan.file');
        });
            Route::middleware('permission:create report')->group(function () {
            Route::get('/laporan/create', [ReportController::class, 'create'])->name('laporan.create');
            Route::post('/laporan', [ReportController::class, 'store'])->name('laporan.store');
        });
            Route::put('/laporan/{report}', [ReportController::class, 'update'])
            ->name('laporan.update')->middleware('permission:edit report');
            Route::delete('/laporan/{report}', [ReportController::class, 'destroy'])
            ->name('laporan.destroy')->middleware('permission:delete report');

        // ── Agenda ───────────────────────────────────────
            Route::middleware('permission:view agenda')->group(function () {
            Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
            Route::get('/agenda/{agendum}/edit', [AgendaController::class, 'edit'])->name('agenda.edit');
        });
            Route::middleware('permission:create agenda')->group(function () {
            Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
            Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
        });
            Route::put('/agenda/{agendum}', [AgendaController::class, 'update'])
            ->name('agenda.update')->middleware('permission:edit agenda');
            Route::delete('/agenda/{agendum}', [AgendaController::class, 'destroy'])
            ->name('agenda.destroy')->middleware('permission:delete agenda');

        // ── Direksi & Komisaris (Team) ───────────────────
            Route::middleware('permission:view team')->group(function () {
            Route::get('/team', [TeamController::class, 'index'])->name('team.index');
            Route::get('/team/{team}/edit', [TeamController::class, 'edit'])->name('team.edit');
        });
            Route::middleware('permission:create team')->group(function () {
            Route::get('/team/create', [TeamController::class, 'create'])->name('team.create');
            Route::post('/team', [TeamController::class, 'store'])->name('team.store');
        });
            Route::put('/team/{team}', [TeamController::class, 'update'])
            ->name('team.update')->middleware('permission:edit team');
            Route::delete('/team/{team}', [TeamController::class, 'destroy'])
            ->name('team.destroy')->middleware('permission:delete team');

        // ── Mitra ────────────────────────────────────────
            Route::middleware('permission:view partner')->group(function () {
            Route::get('/mitra', [PartnerController::class, 'index'])->name('mitra.index');
            Route::get('/mitra/{partner}/edit', [PartnerController::class, 'edit'])->name('mitra.edit');
        });
            Route::middleware('permission:create partner')->group(function () {
            Route::get('/mitra/create', [PartnerController::class, 'create'])->name('mitra.create');
            Route::post('/mitra', [PartnerController::class, 'store'])->name('mitra.store');
        });
            Route::put('/mitra/{partner}', [PartnerController::class, 'update'])
            ->name('mitra.update')->middleware('permission:edit partner');
            Route::delete('/mitra/{partner}', [PartnerController::class, 'destroy'])
            ->name('mitra.destroy')->middleware('permission:delete partner');

        // ── Produk Vendor ────────────────────────────────
            Route::middleware('permission:view product')->group(function () {
            Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
            Route::get('/produk/{product}/edit', [ProductController::class, 'edit'])->name('produk.edit');
        });
            Route::middleware('permission:create product')->group(function () {
            Route::get('/produk/create', [ProductController::class, 'create'])->name('produk.create');
            Route::post('/produk', [ProductController::class, 'store'])->name('produk.store');
        });
            Route::put('/produk/{product}', [ProductController::class, 'update'])
            ->name('produk.update')->middleware('permission:edit product');
            Route::delete('/produk/{product}', [ProductController::class, 'destroy'])
            ->name('produk.destroy')->middleware('permission:delete product');

      // ── Statistik ────────────────────────────────────
        Route::middleware('permission:create statistik')->group(function () {
        Route::get('/statistik/create', [StatistikPemaController::class, 'create'])->name('statistik.create');
        Route::post('/statistik', [StatistikPemaController::class, 'store'])->name('statistik.store');});

        Route::middleware('permission:view statistik')->group(function () {
        Route::get('/statistik', [StatistikPemaController::class, 'index'])->name('statistik.index');
        Route::get('/statistik/{statistik}/edit', [StatistikPemaController::class, 'edit'])->name('statistik.edit');
        Route::get('/statistik/{statistik}', [StatistikPemaController::class, 'show'])->name('statistik.show');});

        Route::put('/statistik/{statistik}', [StatistikPemaController::class, 'update'])
        ->name('statistik.update')->middleware('permission:edit statistik');
        Route::patch('/statistik/{statistik}', [StatistikPemaController::class, 'update'])
        ->middleware('permission:edit statistik');
        Route::delete('/statistik/{statistik}', [StatistikPemaController::class, 'destroy'])
        ->name('statistik.destroy')->middleware('permission:delete statistik');

        // ── Profile (akun sendiri, semua role boleh) ─────
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // ── Users (KHUSUS admin & super_admin) ───────────
            Route::middleware('role:admin|super_admin')->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        // ── Enquiry ──────────────────────────────────────
        // Enquiry biasanya pesan masuk dari pengunjung: editor boleh lihat & tandai
        // dibaca, tapi tidak boleh hapus.
            Route::middleware('permission:view enquiry')->group(function () {
            Route::get('/enquiry', [EnquiryController::class, 'index'])->name('enquiry.index');
            Route::get('/enquiry/{enquiry}', [EnquiryController::class, 'show'])->name('enquiry.show');
        });
            Route::middleware('permission:edit enquiry')->group(function () {
            Route::put('/enquiry/{enquiry}/read', [EnquiryController::class, 'markAsRead'])->name('enquiry.read');
            Route::put('/enquiry/{enquiry}/unread', [EnquiryController::class, 'markAsUnread'])->name('enquiry.unread');
        });
            Route::delete('/enquiry/{enquiry}', [EnquiryController::class, 'destroy'])
            ->name('enquiry.destroy')->middleware('permission:delete enquiry');

        // ── Banner ───────────────────────────────────────
            Route::middleware('permission:view banner')->group(function () {
            Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
            Route::get('/banner/{banner}/edit', [BannerController::class, 'edit'])->name('banner.edit');
        });
            Route::middleware('permission:create banner')->group(function () {
            Route::get('/banner/create', [BannerController::class, 'create'])->name('banner.create');
            Route::post('/banner', [BannerController::class, 'store'])->name('banner.store');
        });
            Route::put('/banner/{banner}', [BannerController::class, 'update'])
            ->name('banner.update')->middleware('permission:edit banner');
            Route::delete('/banner/{banner}', [BannerController::class, 'destroy'])
            ->name('banner.destroy')->middleware('permission:delete banner');

        // ── Job Listings (Karir) ─────────────────────────
            Route::middleware('permission:view job listing')->group(function () {
            Route::get('/karir', [JobListingController::class, 'index'])->name('karir.index');
            Route::get('/karir/{job}/edit', [JobListingController::class, 'edit'])->name('karir.edit');
        });
            Route::middleware('permission:create job listing')->group(function () {
            Route::get('/karir/create', [JobListingController::class, 'create'])->name('karir.create');
            Route::post('/karir', [JobListingController::class, 'store'])->name('karir.store');
        });
            Route::put('/karir/{job}', [JobListingController::class, 'update'])
            ->name('karir.update')->middleware('permission:edit job listing');
            Route::delete('/karir/{job}', [JobListingController::class, 'destroy'])
            ->name('karir.destroy')->middleware('permission:delete job listing');

        // ── Settings (KHUSUS admin & super_admin) ────────
        // Pengaturan situs biasanya sensitif, jadi dibatasi untuk admin saja.
            Route::middleware('role:admin|super_admin')->group(function () {
            Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        });
    });
});