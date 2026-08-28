<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/dashboard', [BerandaController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/beranda', [KontenController::class, 'beranda'])->name('konten.beranda');
    Route::post('/dashboard/beranda', [KontenController::class, 'updateBeranda'])->name('konten.beranda.update');
    Route::post('/dashboard/beranda/kartu', [KontenController::class, 'storeBerandaCard'])->name('konten.beranda.card.store');
    Route::get('/dashboard/visi-misi', [KontenController::class, 'visiMisi'])->name('konten.visi-misi');
    Route::post('/dashboard/visi-misi', [KontenController::class, 'updateVisiMisi'])->name('konten.visi-misi.update');
    Route::get('/dashboard/struktur', [KontenController::class, 'struktur'])->name('konten.struktur');
    Route::post('/dashboard/struktur', [KontenController::class, 'updateStruktur'])->name('konten.struktur.update');
    Route::get('/dashboard/berita', [KontenController::class, 'berita'])->name('konten.berita');
    Route::post('/dashboard/berita', [KontenController::class, 'updateBerita'])->name('konten.berita.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
