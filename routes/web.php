<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/berita', [BerandaController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [BerandaController::class, 'detailBerita'])->name('berita.detail');
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/visi-misi', [BerandaController::class, 'visiMisi'])->name('visi-misi');
Route::get('/struktur-organisasi', [BerandaController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
Route::get('/faq', [BerandaController::class, 'faq'])->name('faq');
Route::get('/dokumen', [BerandaController::class, 'dokumen'])->name('dokumen');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BerandaController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/beranda', [KontenController::class, 'beranda'])->name('konten.beranda');
    Route::post('/dashboard/beranda', [KontenController::class, 'updateBeranda'])->name('konten.beranda.update');
    Route::get('/dashboard/visi-misi', [KontenController::class, 'visiMisi'])->name('konten.visi-misi');
    Route::post('/dashboard/visi-misi', [KontenController::class, 'updateVisiMisi'])->name('konten.visi-misi.update');
    Route::get('/dashboard/struktur', [KontenController::class, 'struktur'])->name('konten.struktur');
    Route::post('/dashboard/struktur', [KontenController::class, 'updateStruktur'])->name('konten.struktur.update');
    Route::post('/dashboard/struktur/tambah', [KontenController::class, 'storeStruktur'])->name('konten.struktur.store');
    Route::delete('/dashboard/struktur/{id}', [KontenController::class, 'destroyStruktur'])->name('konten.struktur.destroy');
    Route::get('/dashboard/faq', [KontenController::class, 'faq'])->name('konten.faq');
    Route::post('/dashboard/faq', [KontenController::class, 'updateFaq'])->name('konten.faq.update');
    Route::post('/dashboard/faq/tambah', [KontenController::class, 'storeFaq'])->name('konten.faq.store');
    Route::delete('/dashboard/faq/{id}', [KontenController::class, 'destroyFaq'])->name('konten.faq.destroy');
    Route::get('/dashboard/dokumen', [KontenController::class, 'dokumen'])->name('konten.dokumen');
    Route::post('/dashboard/dokumen', [KontenController::class, 'updateDokumen'])->name('konten.dokumen.update');
    Route::post('/dashboard/dokumen/tambah', [KontenController::class, 'storeDokumen'])->name('konten.dokumen.store');
    Route::delete('/dashboard/dokumen/{id}', [KontenController::class, 'destroyDokumen'])->name('konten.dokumen.destroy');
    Route::get('/dashboard/berita', [KontenController::class, 'berita'])->name('konten.berita');
    Route::get('/dashboard/berita/{id}/edit', [KontenController::class, 'editBerita'])->name('konten.berita.edit');
    Route::post('/dashboard/berita', [KontenController::class, 'updateBerita'])->name('konten.berita.update');
    Route::put('/dashboard/berita/{id}', [KontenController::class, 'updateExistingBerita'])->name('konten.berita.existing.update');
    Route::delete('/dashboard/berita/{id}', [KontenController::class, 'destroyBerita'])->name('konten.berita.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
