<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankSampahController extends Controller
{
    public function index()
    {
        // Mengambil data dari tabel trash_prices yang aktif saja
        $trashPrices = DB::table('trash_prices')
            ->where('is_active', true)
            ->get();

        // Mengirim data ke file view 'banksampah.blade.php'
        return view('banksampah', compact('trashPrices'));
    }
}