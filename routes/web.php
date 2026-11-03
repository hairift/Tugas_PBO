<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('buku.index');
})->name('beranda');

Route::get('/buku', [BukuController::class, 'index'])
    ->name('buku.index');

Route::get('/buku/{id}', [BukuController::class, 'show'])
    ->name('buku.show');

Route::get('/anggota', [AnggotaController::class, 'index'])
    ->name('anggota.index');

Route::get('/anggota/{id}', [AnggotaController::class, 'show'])
    ->name('anggota.show');
