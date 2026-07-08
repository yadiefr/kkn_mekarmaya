<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminJurnalController extends Controller
{
    /**
     * Display the Jurnal & Kas view.
     */
    public function index()
    {
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

        return view('admin.jurnal', compact('kasMasuk', 'kasKeluar', 'saldoKas'));
    }
}
