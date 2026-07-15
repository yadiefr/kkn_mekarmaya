<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        return view('admin.datawarga', compact('wargaOff', 'wargaOn', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_kk' => 'required|string|max:16',
            'nik' => 'required|string|unique:users,nik|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'whatsapp' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'no_kk.required' => 'Nomor Kartu Keluarga wajib diisi.',
            'nik.required' => 'Nomor NIK wajib diisi.',
            'nik.unique' => 'Nomor NIK sudah terdaftar.',
            'nik.max' => 'Nomor NIK maksimal 16 karakter.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        User::create([
            'name' => $request->nama_lengkap,
            'no_kk' => $request->no_kk,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password), 
            'role' => 'warga',       
            'status_akses' => 'on', 
        ]);

        return back()->with('success', "Akun warga bernama {$request->nama_lengkap} berhasil dibuat dan langsung aktif.");
    }

    public function update(Request $request, $id)
    {
        $warga = User::where('role', 'warga')->findOrFail($id);

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'no_kk' => 'required|string|max:16',
            'nik' => 'required|string|max:16|unique:users,nik,' . $warga->id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'whatsapp' => 'required|string|max:15',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        $request->validate($rules, [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'no_kk.required' => 'Nomor Kartu Keluarga wajib diisi.',
            'nik.required' => 'Nomor NIK wajib diisi.',
            'nik.unique' => 'Nomor NIK sudah terdaftar.',
            'nik.max' => 'Nomor NIK maksimal 16 karakter.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'password.min' => 'Password minimal harus terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $data = [
            'name' => $request->nama_lengkap,
            'no_kk' => $request->no_kk,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'whatsapp' => $request->whatsapp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $warga->update($data);

        return back()->with('success', "Akun warga bernama {$request->nama_lengkap} berhasil diperbarui.");
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

    public function destroy($id)
    {
        $warga = User::where('role', 'warga')->findOrFail($id);
        $namaWarga = $warga->name;
        $warga->delete();

        return back()->with('success', "Akun warga bernama {$namaWarga} berhasil dihapus.");
    }
}