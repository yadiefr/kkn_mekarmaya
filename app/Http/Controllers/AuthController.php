<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. MENAMPILKAN HALAMAN LOGIN
    public function showLogin()
    {
        return view('banksampahwarga.login');
    }

    // 2. PROSES LOGIN
    public function login(Request $request)
    {
        // Validasi input dari form login
        $credentials = $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan NIK terlebih dahulu
        $user = User::where('nik', $credentials['nik'])->first();

        if ($user) {
            // Cek kecocokan password manual karena default Laravel memakai Email
            if (Hash::check($request->password, $user->password)) {
                
                // Cek status akses aktif (on) atau nonaktif (off)
                if ($user->status_akses === 'off') {
                    return back()->withErrors([
                        'auth_error' => 'Akun Anda belum aktif. Silakan hubungi Admin Desa untuk aktivasi.',
                    ])->onlyInput('nik');
                }

                // Lakukan login menggunakan instance user
                Auth::login($user, $request->has('remember'));
                $request->session()->regenerate();

                // REDIRECT SESUAI ROLE MASING-MASING
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                
                return redirect()->route('warga.dashboard');
            }
        }

        // Jika password salah atau NIK tidak ditemukan
        return back()->withErrors([
            'auth_error' => 'NIK atau Password yang Anda masukkan salah.',
        ])->onlyInput('nik');
    }

    // 3. MENAMPILKAN HALAMAN REGISTER
    public function showRegister()
    {
        return view('banksampahwarga.register');
    }

    // 4. PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|unique:users,nik|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'whatsapp' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->nama_lengkap,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password), 
            'role' => 'warga',       
            'status_akses' => 'off', 
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu aktivasi dari Admin Desa.');
    }

    // 5. PROSES LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('beranda');
    }
}