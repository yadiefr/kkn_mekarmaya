<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Edukasi;

class EdukasiController extends Controller
{
    public function index()
    {
        // Mengambil data kamus sampah dan menggabungkannya dengan data kategori
        $trashDictionaries = DB::table('trash_dictionaries')
            ->join('categories', 'trash_dictionaries.category_id', '=', 'categories.id')
            ->select(
                'trash_dictionaries.*', 
                'categories.name as category_name', 
                'categories.color_code as category_color'
            )
            ->get();

        $edukasis = Edukasi::latest()->get();

        // Mengirimkan data ke view edukasi.blade.php
        return view('edukasi', compact('trashDictionaries', 'edukasis'));
    }
}