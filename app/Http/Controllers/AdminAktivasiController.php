<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminAktivasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query dasar: Hanya mengambil user yang rolenya 'warga'
        $queryWarga = User::where('role', 'warga');

        // Jika admin melakukan pencarian (berdasarkan Nama atau NIK)
        if (!empty($search)) {
            $queryWarga->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        // Pisahkan data warga berdasarkan status_akses menggunakan clone query
        $wargaOff = (clone $queryWarga)->where('status_akses', 'off')->latest()->get();
        $wargaOn = (clone $queryWarga)->where('status_akses', 'on')->latest()->get();

        return view('admin.aktivasi', compact('wargaOff', 'wargaOn', 'search'));
    }

    public function toggleAkses($id)
    {
        $warga = User::where('role', 'warga')->findOrFail($id);

        // Switch status akses
        if ($warga->status_akses === 'on') {
            $warga->status_akses = 'off';
            $pesan = "Akses warga bernama {$warga->name} berhasil dinonaktifkan (OFF).";
        } else {
            $warga->status_akses = 'on';
            $pesan = "Akun warga bernama {$warga->name} berhasil diaktifkan (ON).";
        }

        $warga->save();

        return back()->with('success', $pesan);
    }
}