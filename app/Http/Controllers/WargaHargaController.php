<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WargaHargaController extends Controller
{
    public function index()
    {
        // Mengambil data harga sampah yang berstatus aktif dari database
        $trashPrices = DB::table('trash_prices')
            ->where('is_active', true)
            ->orderBy('item_name', 'asc') // Mengurutkan nama sampah dari A-Z agar rapi
            ->get();

        // Mengirim data ke file view hargasampah.blade.php
        return view('warga.hargasampah', compact('trashPrices'));
    }
}