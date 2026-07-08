<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankSampahController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\WargaDashboardController;
use App\Http\Controllers\WargaTransaksiController;
use App\Http\Controllers\WargaHargaController; // <-- Impor Controller baru di sini
use App\Http\Controllers\WargaTarikSaldoController;
use App\Http\Controllers\AdminAktivasiController;
use App\Http\Controllers\AdminSetorController;
use App\Http\Controllers\AdminPembayaranController;
use App\Http\Controllers\AdminHargaController;
use App\Http\Controllers\AdminJurnalController;
use App\Http\Controllers\AdminEdukasiController;
use App\Http\Controllers\AdminDashboardController;Route::get('/', function () {
    return view('beranda');
});
// Jalur untuk Halaman Edukasi
Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// Jalur untuk Halaman Edukasi
Route::get('/edukasi', function () {
    return view('edukasi');
})->name('edukasi');

Route::get('/bank-sampah', function () {
    return view('banksampah');
})->name('banksampah');

Route::get('/login', function () {
    return view('banksampahwarga.login');
})->name('login');

Route::get('/register', function () {
    return view('banksampahwarga.register');
})->name('register');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Rute untuk Halaman Dashboard Warga setelah Login
Route::get('/warga/dashboard', function () {
    return view('banksampahwarga.dashboardwarga');
})->name('warga.dashboard');



// RUTE AUTENTIKASI (LOGIN & REGISTER) MENGGUNAKAN CONTROLLER
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Rute Dashboard Warga yang dilindungi Auth (Dinamis)
Route::get('/warga/dashboard', [WargaDashboardController::class, 'index'])
    ->name('warga.dashboard')
    ->middleware('auth'); // Pastikan hanya yang sudah login yang bisa masuk


// Rute Riwayat Transaksi Warga
Route::get('/warga/riwayat', [WargaTransaksiController::class, 'index'])
    ->name('warga.riwayat')
    ->middleware('auth');

Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi');
// Rute Bank Sampah dinamis melalui Controller
Route::get('/bank-sampah', [BankSampahController::class, 'index'])->name('banksampah');


Route::middleware(['auth'])->group(function () {

    Route::get('/warga/harga-sampah', [WargaHargaController::class, 'index'])
    ->name('warga.harga'); // <-- Menggunakan nama unik 'warga.harga'
    // Fitur Baru Tarik Saldo Berkala Warga
    Route::get('/warga/tarik-saldo', [WargaTarikSaldoController::class, 'index'])->name('warga.tarik');
    Route::post('/warga/tarik-saldo/ajukan', [WargaTarikSaldoController::class, 'store'])->name('warga.tarik.ajukan');

    // Rute halaman manajemen aktivasi warga
    Route::get('/admin/aktivasi-warga', [AdminAktivasiController::class, 'index'])->name('admin.aktivasi');
    // Rute aksi mengubah status akses ON/OFF
    Route::post('/admin/aktivasi-warga/{id}/toggle', [AdminAktivasiController::class, 'toggleAkses'])->name('admin.aktivasi.toggle');
    // Tampilan Form & List Setor Sampah
    Route::get('/admin/setor-sampah', [AdminSetorController::class, 'index'])->name('admin.setor');
    // Eksekusi Simpan Nota Setoran
    Route::post('/admin/setor-sampah/simpan', [AdminSetorController::class, 'store'])->name('admin.setor.simpan');
    // Tampilan Utama Manajemen Pembayaran
    Route::get('/admin/setting-pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran');
        
    // Simpan Rentang Tanggal Pembayaran baru
    Route::post('/admin/setting-pembayaran/jadwal', [AdminPembayaranController::class, 'storeSetting'])->name('admin.pembayaran.jadwal');
    
    // Aksi Persetujuan/Penolakan Pengajuan Warga
    Route::post('/admin/setting-pembayaran/proses/{id}', [AdminPembayaranController::class, 'processRequest'])->name('admin.pembayaran.proses');
    
    // Jurnal & Kas
    Route::get('/admin/jurnal-kas', [AdminJurnalController::class, 'index'])->name('admin.jurnal');
    
    // Kelola Edukasi
    Route::get('/admin/edukasi', [AdminEdukasiController::class, 'index'])->name('admin.edukasi');
    Route::post('/admin/edukasi/simpan', [AdminEdukasiController::class, 'store'])->name('admin.edukasi.store');
    Route::post('/admin/edukasi/update/{id}', [AdminEdukasiController::class, 'update'])->name('admin.edukasi.update');
    Route::post('/admin/edukasi/hapus/{id}', [AdminEdukasiController::class, 'destroy'])->name('admin.edukasi.destroy');
    
    Route::get('/admin/setting-harga', [AdminHargaController::class, 'index'])->name('admin.harga.index');
    Route::post('/admin/setting-harga/simpan', [AdminHargaController::class, 'store'])->name('admin.harga.store');
    Route::post('/admin/setting-harga/update/{id}', [AdminHargaController::class, 'update'])->name('admin.harga.update');
    Route::post('/admin/setting-harga/toggle/{id}', [AdminHargaController::class, 'toggleStatus'])->name('admin.harga.toggle');
    Route::delete('/admin/setting-harga/hapus/{id}', [AdminHargaController::class, 'destroy'])->name('admin.harga.destroy');
});





   


