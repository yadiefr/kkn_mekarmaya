<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrashPrice;
use App\Models\TrashDeposit;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Data Kas (Keseluruhan/Total)
        $kasMasuk = 0;
        $deposits = TrashDeposit::with('trashPrice')->get();
        foreach ($deposits as $deposit) {
            if ($deposit->trashPrice) {
                $kasMasuk += $deposit->weight * $deposit->trashPrice->sell_price;
            }
        }

        // Hitung Kas Keluar berdasarkan penarikan saldo warga yang telah disetujui
        $kasKeluar = WithdrawalRequest::where('status', 'approved')->sum('total_amount');
        
        // Sisa Saldo Kas
        $saldoKas = $kasMasuk - $kasKeluar;

        // 2. Data Warga dengan Sampah Terbanyak (Saldo Terbanyak)
        $topWarga = User::where('role', 'warga')
            ->leftJoin('trash_deposits', function ($join) {
                $join->on('users.id', '=', 'trash_deposits.user_id')
                     ->where('trash_deposits.withdrawal_status', '=', 'belum_ditarik');
            })
            ->select(
                'users.id',
                'users.name',
                'users.nik',
                'users.whatsapp',
                DB::raw('COALESCE(SUM(trash_deposits.weight), 0) as total_berat'),
                DB::raw('COALESCE(SUM(trash_deposits.earning), 0) as total_saldo')
            )
            ->groupBy('users.id', 'users.name', 'users.nik', 'users.whatsapp')
            ->orderByDesc('total_saldo')
            ->orderByDesc('total_berat')
            ->take(5)
            ->get();

        $totalWargaCount = User::where('role', 'warga')->count();

        // 3. Harga Sampah Aktif
        $hargaSampah = TrashPrice::where('is_active', true)->latest()->take(5)->get();

        return view('admin.dashboardadmin', compact(
            'kasMasuk',
            'kasKeluar',
            'saldoKas',
            'topWarga',
            'totalWargaCount',
            'hargaSampah'
        ));
    }
}
