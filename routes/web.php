<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ContactController;

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
Route::get('/kontak', [WebController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'send'])->name('kontak.send');

Route::get('/privacy-policy', [WebController::class, 'privacy'])->name('privacy');
Route::get('/id/privacy-policy', [WebController::class, 'policy'])->name('policy');
Route::get('/terms-of-service', [WebController::class, 'terms'])->name('terms');
