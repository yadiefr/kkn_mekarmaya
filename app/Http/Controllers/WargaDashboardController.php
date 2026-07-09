<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WargaDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data user/warga yang sedang login saat ini
        $user = Auth::user();

        // 2. Ambil riwayat setoran sampah milik warga ini saja (Join dengan tabel harga sampah)
        $deposits = DB::table('trash_deposits')
            ->join('trash_prices', 'trash_deposits.trash_price_id', '=', 'trash_prices.id')
            ->select('trash_deposits.*', 'trash_prices.item_name')
            ->where('trash_deposits.user_id', $user->id)
            ->orderBy('trash_deposits.created_at', 'desc')
            ->get();

        // 3. Hitung Total Saldo Aktif (Hanya yang berstatus 'belum_ditarik')
        $totalSaldo = DB::table('trash_deposits')
            ->where('user_id', $user->id)
            ->where('withdrawal_status', 'belum_ditarik')
            ->sum('earning');

        // 4. Hitung Total Berat Sampah yang sudah pernah disumbangkan oleh warga ini
        $totalBerat = DB::table('trash_deposits')
            ->where('user_id', $user->id)
            ->sum('weight');

        // 5. Hitung Total Saldo yang sudah sukses ditarik/dicairkan tunai
        $totalDicairkan = DB::table('trash_deposits')
            ->where('user_id', $user->id)
            ->where('withdrawal_status', 'sudah_ditarik')
            ->sum('earning');

        // Kirim semua data dinamis ini ke halaman Blade
        return view('warga.dashboardwarga', compact('user', 'deposits', 'totalSaldo', 'totalBerat', 'totalDicairkan'));
    }
}