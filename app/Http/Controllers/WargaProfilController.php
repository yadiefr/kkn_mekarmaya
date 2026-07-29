<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('warga.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('username')) {
            $request->merge([
                'username' => strtolower(str_replace(' ', '', $request->username)),
            ]);
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|regex:/^\S*$/u|max:50|unique:users,username,' . $user->id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'whatsapp' => 'required|string|max:15',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.regex' => 'Username tidak boleh mengandung spasi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.max' => 'Username maksimal 50 karakter.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $user->name = $request->nama_lengkap;
        $user->username = $request->username;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat = $request->alamat;
        $user->whatsapp = $request->whatsapp;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
