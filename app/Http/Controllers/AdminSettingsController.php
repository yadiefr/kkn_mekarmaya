<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // Ambil warga yang masih memiliki saldo aktif (belum ditarik)
        $activeWarga = User::where('role', 'warga')
            ->join('trash_deposits', function ($join) {
                $join->on('users.id', '=', 'trash_deposits.user_id')
                     ->where('trash_deposits.withdrawal_status', '=', 'belum_ditarik')
                     ->where('trash_deposits.is_reset', '=', false);
            })
            ->select(
                'users.id',
                'users.name',
                'users.nik',
                'users.whatsapp',
                DB::raw('SUM(trash_deposits.weight) as total_berat'),
                DB::raw('SUM(trash_deposits.earning) as total_saldo')
            )
            ->groupBy('users.id', 'users.name', 'users.nik', 'users.whatsapp')
            ->having('total_saldo', '>', 0)
            ->get();

        return view('admin.pengaturan', compact('activeWarga'));
    }

    public function reset(Request $request)
    {
        // 1. Cek apakah ada warga yang masih memiliki saldo aktif (belum ditarik)
        $activeBalance = DB::table('trash_deposits')
            ->where('withdrawal_status', 'belum_ditarik')
            ->where('is_reset', false)
            ->sum('earning');

        if ($activeBalance > 0) {
            return back()->with('error', 'Reset gagal! Masih ada warga yang memiliki saldo aktif yang belum dicairkan. Harap selesaikan seluruh proses penarikan/pencairan saldo warga terlebih dahulu.');
        }

        // 2. Cek apakah ada pengajuan penarikan dana dengan status pending yang belum diproses
        $pendingRequestsCount = DB::table('withdrawal_requests')
            ->where('status', 'pending')
            ->where('is_reset', false)
            ->count();

        if ($pendingRequestsCount > 0) {
            return back()->with('error', 'Reset gagal! Masih ada pengajuan penarikan saldo warga berstatus Pending yang belum diproses.');
        }

        // 3. Update status is_reset menjadi true pada data setoran sampah dan pengajuan penarikan
        DB::table('trash_deposits')->where('is_reset', false)->update(['is_reset' => true]);
        DB::table('withdrawal_requests')->where('is_reset', false)->update(['is_reset' => true]);

        return back()->with('success', 'Semua data kas masuk, kas keluar, dan saldo kas desa berhasil di-reset ke nol (0). Riwayat setoran dan penarikan tetap aman pada akun warga.');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $dir = public_path('uploads/logo');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            // Hapus logo lama jika ada
            $existing = glob($dir . '/site_logo.*');
            foreach ($existing as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }

            $file = $request->file('logo');
            $ext = strtolower($file->getClientOriginalExtension());
            $file->move($dir, 'site_logo.' . $ext);
        }

        return back()->with('success', 'Logo beranda & website berhasil diperbarui!');
    }

    public function deleteLogo()
    {
        $dir = public_path('uploads/logo');
        $existing = glob($dir . '/site_logo.*');
        foreach ($existing as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
        return back()->with('success', 'Logo khusus berhasil dihapus, sistem kembali menggunakan logo standar!');
    }
}
