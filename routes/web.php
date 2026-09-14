<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [KehadiranController::class, 'index']);
Route::post('/update-kehadiran', [KehadiranController::class, 'updateKehadiran'])->name('update.kehadiran');

Route::get('/profil', function () {
    return 'Selamat datang di Halaman Profil Sekolah!';
});

Route::get('/siswa/{nama}', function ($nama) {
 return 'Halo, ' . $nama . '! Ini adalah halaman detail siswa.';
});

// Rute statis ke Controller
Route::get('/daftar-siswa', [SiswaController::class, 'index']);


// Rute dinamis ke Controller
Route::get('/siswa/detail/{id}', [SiswaController::class, 'detail']);


// Rute Statis
Route::get('/selamat', function(){
    return 'Selamat Belajar Laravel Kelas XII!';
});

//Rute Dinamis
Route::get('/kelas/{nama_kelas}', function($nama_kelas){
    return 'Anda berada di kelas: ' . $nama_kelas;
});

Route::get('/detail/siswa/{id}', [SiswaController::class, 'detail']);

Route::get('/dashboard', [DashboardController::class, 'index']); 