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
use App\Http\Controllers\AdminKasController;
use App\Http\Controllers\AdminEdukasiController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSettingsController;Route::get('/', function () {
    try {
        $trashPrices = \App\Models\TrashPrice::where('is_active', true)->get();
        $edukasis = \App\Models\Edukasi::latest()->take(3)->get();
        $totalWarga = \App\Models\User::where('role', 'warga')->count();
        $totalSetor = \App\Models\TrashDeposit::count();
        $totalKg = \App\Models\TrashDeposit::sum('weight');
        $totalSaldo = \App\Models\TrashDeposit::sum('earning');
        $recentDeposits = \App\Models\TrashDeposit::with(['user', 'trashPrice'])->latest()->take(3)->get();
    } catch (\Exception $e) {
        $trashPrices = collect();
        $edukasis = collect();
        $totalWarga = 0;
        $totalSetor = 0;
        $totalKg = 0;
        $totalSaldo = 0;
        $recentDeposits = collect();
    }
    return view('beranda', compact('trashPrices', 'edukasis', 'totalWarga', 'totalSetor', 'totalKg', 'totalSaldo', 'recentDeposits'));
})->name('beranda');

// Jalur untuk Halaman Edukasi
Route::get('/edukasi', function () {
    return view('edukasi');
})->name('edukasi');

Route::get('/bank-sampah', function () {
    return view('banksampah');
})->name('banksampah');

Route::get('/login', function () {
    return view('warga.login');
})->name('login');

Route::get('/register', function () {
    return view('warga.register');
})->name('register');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Rute untuk Halaman Dashboard Warga setelah Login
Route::get('/warga/dashboard', function () {
    return view('warga.dashboardwarga');
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

    // Rute halaman manajemen data warga
    Route::get('/admin/data-warga', [AdminAktivasiController::class, 'index'])->name('admin.datawarga');
    // Rute simpan warga baru oleh admin
    Route::post('/admin/data-warga/store', [AdminAktivasiController::class, 'store'])->name('admin.datawarga.store');
    // Rute update data warga oleh admin
    Route::post('/admin/data-warga/update/{id}', [AdminAktivasiController::class, 'update'])->name('admin.datawarga.update');
    // Rute aksi mengubah status akses ON/OFF
    Route::post('/admin/data-warga/{id}/toggle', [AdminAktivasiController::class, 'toggleAkses'])->name('admin.datawarga.toggle');
    // Rute menghapus warga
    Route::delete('/admin/data-warga/{id}', [AdminAktivasiController::class, 'destroy'])->name('admin.datawarga.destroy');
    // Tampilan Form    // Transaksi Setor Sampah
    Route::get('/admin/setor-sampah', [AdminSetorController::class, 'index'])->name('admin.setor');
    Route::get('/admin/setor-sampah/rekap', [AdminSetorController::class, 'rekap'])->name('admin.setor.rekap');
    Route::post('/admin/setor-sampah/simpan', [AdminSetorController::class, 'store'])->name('admin.setor.simpan');
    Route::post('/admin/setor-sampah/update/{id}', [AdminSetorController::class, 'update'])->name('admin.setor.update');
    Route::delete('/admin/setor-sampah/hapus/{id}', [AdminSetorController::class, 'destroy'])->name('admin.setor.destroy');
    // Tampilan Utama Manajemen Pembayaran
    Route::get('/admin/setting-pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran');
        
    // Simpan Rentang Tanggal Pembayaran baru
    Route::post('/admin/setting-pembayaran/jadwal', [AdminPembayaranController::class, 'storeSetting'])->name('admin.pembayaran.jadwal');
    Route::post('/admin/setting-pembayaran/jadwal/update/{id}', [AdminPembayaranController::class, 'updateSetting'])->name('admin.pembayaran.jadwal.update');
    Route::delete('/admin/setting-pembayaran/jadwal/hapus/{id}', [AdminPembayaranController::class, 'destroySetting'])->name('admin.pembayaran.jadwal.destroy');
    
    // Aksi Persetujuan/Penolakan Pengajuan Warga
    Route::post('/admin/setting-pembayaran/proses/{id}', [AdminPembayaranController::class, 'processRequest'])->name('admin.pembayaran.proses');
    
    // Kas Desa
    Route::get('/admin/kas', [AdminKasController::class, 'index'])->name('admin.kas');
    Route::get('/admin/kas/export', [AdminKasController::class, 'export'])->name('admin.kas.export');
    
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
    Route::post('/admin/setting-harga/upload-logo', [AdminHargaController::class, 'uploadLogo'])->name('admin.harga.uploadLogo');
    Route::post('/admin/setting-harga/delete-logo', [AdminHargaController::class, 'deleteLogo'])->name('admin.harga.deleteLogo');

    // Pengaturan Admin
    Route::get('/admin/pengaturan', [AdminSettingsController::class, 'index'])->name('admin.pengaturan');
    Route::post('/admin/pengaturan/reset', [AdminSettingsController::class, 'reset'])->name('admin.pengaturan.reset');
    Route::post('/admin/pengaturan/upload-logo', [AdminSettingsController::class, 'uploadLogo'])->name('admin.pengaturan.uploadLogo');
    Route::post('/admin/pengaturan/delete-logo', [AdminSettingsController::class, 'deleteLogo'])->name('admin.pengaturan.deleteLogo');
});





   


