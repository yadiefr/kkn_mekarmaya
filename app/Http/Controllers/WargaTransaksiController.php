<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WargaTransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil SEMUA Riwayat Setor Sampah milik warga ini
        $setorHistory = DB::table('trash_deposits')
            ->join('trash_prices', 'trash_deposits.trash_price_id', '=', 'trash_prices.id')
            ->select('trash_deposits.*', 'trash_prices.item_name')
            ->where('trash_deposits.user_id', $user->id)
            ->orderBy('trash_deposits.created_at', 'desc')
            ->get();

        // 2. Ambil SEMUA Riwayat Tarik Saldo jika Anda memiliki tabel penarikan (atau tiruannya jika ditarik per nota)
        // Di sini kita ambil nota-nota yang statusnya 'sudah_ditarik' sebagai riwayat pencairan uang tunai warga
        $tarikHistory = DB::table('trash_deposits')
            ->join('trash_prices', 'trash_deposits.trash_price_id', '=', 'trash_prices.id')
            ->select('trash_deposits.*', 'trash_prices.item_name')
            ->where('trash_deposits.user_id', $user->id)
            ->where('trash_deposits.withdrawal_status', 'sudah_ditarik')
            ->orderBy('trash_deposits.updated_at', 'desc') // Menggunakan updated_at karena itu waktu saat status berubah jadi 'sudah_ditarik'
            ->get();

        return view('warga.riwayat', compact('user', 'setorHistory', 'tarikHistory'));
    }
}