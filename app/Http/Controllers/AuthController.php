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
        return view('warga.login');
    }

    // 2. PROSES LOGIN
    public function login(Request $request)
    {
        if ($request->filled('username')) {
            $request->merge([
                'username' => strtolower($request->input('username')),
            ]);
        }

        // Validasi input dari form login
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username terlebih dahulu
        $user = User::where('username', $credentials['username'])->first();

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

        // Jika password salah atau username tidak ditemukan
        return back()->withErrors([
            'auth_error' => 'Username atau Password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    // 3. MENAMPILKAN HALAMAN REGISTER
    public function showRegister()
    {
        return view('warga.register');
    }

    // 4. PROSES REGISTER
    public function register(Request $request)
    {
        if ($request->filled('username')) {
            $request->merge([
                'username' => strtolower($request->input('username')),
            ]);
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|regex:/^\S*$/u|unique:users,username|max:50',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'whatsapp' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
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
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus terdiri dari 6 karakter.',
            'password.confirmed' => 'Password tidak cocok dengan sebelumnya.',
        ]);

        User::create([
            'name' => $request->nama_lengkap,
            'username' => $request->username,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password), 
            'role' => 'warga',       
            'status_akses' => 'on', 
        ]);

        return redirect()->route('login')->with([
            'success' => 'Pendaftaran berhasil! Silahkan masuk menggunakan akun anda.',
            'registered_username' => $request->username,
            'registered_password' => $request->password
        ]);
    }

    // 5. PROSES GANTI PASSWORD
    public function updatePassword(Request $request)
    {
        if (Auth::user()->role !== 'warga') {
            abort(403, 'Akses khusus untuk Warga.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        // Cek apakah password saat ini benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        // Simpan password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('password_success', 'Password berhasil diubah!');
    }

    // 7. PROSES LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('beranda');
    }
}