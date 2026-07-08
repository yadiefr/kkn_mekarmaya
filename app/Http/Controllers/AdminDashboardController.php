<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrashPrice;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Data Kas 
        // Hitung estimasi Kas Masuk berdasarkan total berat sampah ditarik dikali harga jual (ke pengepul)
        $kasMasuk = 0;
        $deposits = \App\Models\TrashDeposit::with('trashPrice')->get();
        foreach ($deposits as $deposit) {
            if ($deposit->trashPrice) {
                $kasMasuk += $deposit->weight * $deposit->trashPrice->sell_price;
            }
        }

        // Hitung Kas Keluar berdasarkan penarikan saldo warga yang telah disetujui
        $kasKeluar = \App\Models\WithdrawalRequest::where('status', 'approved')->sum('total_amount');
        
        // Sisa Saldo Kas
        $saldoKas = $kasMasuk - $kasKeluar;

        // 2. Data Aktivasi Warga
        $wargaOff = User::where('role', 'warga')->where('status_akses', 'off')->latest()->take(5)->get();
        $menungguAktivasiCount = User::where('role', 'warga')->where('status_akses', 'off')->count();

        // 3. Harga Sampah Aktif
        $hargaSampah = TrashPrice::where('is_active', true)->latest()->take(5)->get();

        return view('admin.dashboardadmin', compact(
            'kasMasuk',
            'kasKeluar',
            'saldoKas',
            'wargaOff',
            'menungguAktivasiCount',
            'hargaSampah'
        ));
    }
}
