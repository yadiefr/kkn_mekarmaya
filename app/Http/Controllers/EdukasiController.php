<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Edukasi;

class EdukasiController extends Controller
{
    public function index()
    {
        $edukasis = Edukasi::latest()->get();

        // Mengirimkan data ke view edukasi.blade.php
        return view('edukasi', compact('edukasis'));
    }
}