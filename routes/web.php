<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Models\Team;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Ppid\DashboardController;
use App\Http\Controllers\Ppid\PermohonanController;
use App\Http\Controllers\Ppid\PenggunaController;
use App\Http\Controllers\Ppid\KeberatanController;
use App\Http\Controllers\VendorController;


Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/', [App\Http\Controllers\PageController::class, 'index'])->name('beranda');

Route::get('/', [WebController::class, 'beranda'])->name('beranda');
Route::get('/beranda2', [WebController::class, 'beranda2'])->name('beranda2');
Route::get('/profil', [WebController::class, 'profil'])->name('profil');
Route::get('/bisnis', [WebController::class, 'bisnis'])->name('bisnis');
Route::get('/bisnis/{category}', [WebController::class, 'bisnisCategory'])->name('bisnis.category');
Route::get('/bisnis/{category}/{business}', [WebController::class, 'bisnisDetail'])->name('bisnis.detail');

Route::get('/berita', [WebController::class, 'berita'])->name('berita.index');
Route::get('/berita/{news}', [WebController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/pengumuman', [WebController::class, 'pengumuman'])->name('pengumuman.index');
Route::get('/pengumuman/{news}', [WebController::class, 'pengumumanDetail'])->name('pengumuman.detail');

Route::get('/galeri', [WebController::class, 'galeri'])->name('galeri');
Route::get('/laporan', [WebController::class, 'laporan'])->name('laporan');
Route::get('/laporan/{report}/download', [WebController::class, 'downloadLaporan'])->name('laporan.download');
Route::get('/laporan/{report}/view', [WebController::class, 'viewLaporan'])->name('laporan.view');
Route::get('/agenda', [WebController::class, 'agenda'])->name('agenda');
Route::get('/karir', [WebController::class, 'karir'])->name('karir');
Route::get('/kerjasama', [WebController::class, 'kerjasama'])->name('kerjasama');
Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
Route::get('/kontak', [WebController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'send'])->name('kontak.store');

Route::get('/privacy-policy', [WebController::class, 'privacy'])->name('privacy');
Route::get('/id/privacy-policy', [WebController::class, 'policy'])->name('policy');
Route::get('/terms-of-service', [WebController::class, 'terms'])->name('terms');
Route::get('/direksi/{team}', function (Team $team) {return view('direksi.show', compact('team'));})->name('direksi.show');

// PPID ROUTES (wajib login admin)
Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('ppid.dashboard');

    Route::prefix('ppid')->name('ppid.')->group(function () {
        $resources = [
            'pemohon'   => PermohonanController::class,
            'keberatan' => KeberatanController::class,
        ];

        foreach ($resources as $slug => $controller) {
            Route::get("/{$slug}", [$controller, 'index'])->name("{$slug}.index");
            Route::get("/{$slug}/export", [$controller, 'export'])->name("{$slug}.export");
            Route::get("/{$slug}/{id}", [$controller, 'show'])->whereNumber('id')->name("{$slug}.show");
            Route::put("/{$slug}/{id}", [$controller, 'update'])->whereNumber('id')->name("{$slug}.update");
        }

        // Daftar pemohon informasi (ppid_permohonan_informasi) + profil pemohon
        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/akun', [PenggunaController::class, 'akun'])->name('akun.index');
        Route::get('/pengguna/{id}', [PenggunaController::class, 'show'])->whereNumber('id')->name('pengguna.show');
    });

    // Alamat lama, diarahkan ke halaman baru
    Route::redirect('/ppid_users', '/ppid/pengguna');
    Route::redirect('/ppid_request_information', '/ppid/pemohon');
    Route::redirect('/ppid_request_objection', '/ppid/keberatan');
});
// END PPID ROUTES
