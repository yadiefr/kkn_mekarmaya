<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WargaTarikSaldoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today(); // Mengambil waktu real-time hari ini

        // 1. Cek apakah ada jadwal penarikan yang aktif hari ini
        $activeSetting = DB::table('withdrawal_settings')
            ->where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();

        // 1.5 Ambil event terdekat yang AKAN DATANG jika hari ini tidak ada yang aktif
        $upcomingSetting = null;
        if (!$activeSetting) {
            $upcomingSetting = DB::table('withdrawal_settings')
                ->where('is_active', true)
                ->whereDate('start_date', '>', $today) // Tanggal mulainya di masa depan
                ->orderBy('start_date', 'asc')        // Urutkan dari yang paling dekat
                ->first();
        }

        // 2. Hitung total saldo yang belum ditarik
        $totalSaldo = DB::table('trash_deposits')
            ->where('user_id', $user->id)
            ->where('withdrawal_status', 'belum_ditarik')
            ->sum('earning');

        // 3. Cek apakah warga ini sudah punya pengajuan yang masih 'pending'
        $pendingRequest = DB::table('withdrawal_requests')
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        // 4. Ambil riwayat pengajuan tarik saldo warga ini
        $requestHistory = DB::table('withdrawal_requests')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('banksampahwarga.tariksaldo', compact('user', 'activeSetting', 'upcomingSetting', 'totalSaldo', 'pendingRequest', 'requestHistory'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Validasi double cek waktu penarikan
        $activeSetting = DB::table('withdrawal_settings')
            ->where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();

        if (!$activeSetting) {
            return back()->withErrors(['error' => 'Maaf, pengajuan gagal. Saat ini tidak dalam rentang waktu penarikan saldo!']);
        }

        // Hitung ulang saldo
        $totalSaldo = DB::table('trash_deposits')
            ->where('user_id', $user->id)
            ->where('withdrawal_status', 'belum_ditarik')
            ->sum('earning');

        if ($totalSaldo <= 0) {
            return back()->withErrors(['error' => 'Anda tidak memiliki saldo aktif untuk ditarik.']);
        }

        // Cek pending request
        $hasPending = DB::table('withdrawal_requests')
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return back()->withErrors(['error' => 'Anda masih memiliki pengajuan penarikan yang menunggu persetujuan admin.']);
        }

        // Simpan pengajuan
        DB::table('withdrawal_requests')->insert([
            'user_id' => $user->id,
            'total_amount' => $totalSaldo,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan pencairan saldo sebesar Rp ' . number_format($totalSaldo, 0, ',', '.') . ' telah dikirim ke Admin!');
    }
}