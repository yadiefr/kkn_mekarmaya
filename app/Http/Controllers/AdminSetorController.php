<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TrashPrice;
use App\Models\TrashDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSetorController extends Controller
{
    public function index()
    {
        // Ambil warga yang status_aksesnya ON agar bisa menabung
        $wargaList = User::where('role', 'warga')->where('status_akses', 'on')->orderBy('name', 'asc')->get();
        
        // Ambil jenis sampah yang aktif
        $sampahList = TrashPrice::where('is_active', true)->orderBy('item_name', 'asc')->get();

        // Ambil riwayat transaksi setoran di desa
        $recentDeposits = TrashDeposit::with(['user', 'trashPrice'])
            ->latest()
            ->paginate(10);

        return view('admin.setorsampah', compact('wargaList', 'sampahList', 'recentDeposits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'trash_price_id' => 'required|exists:trash_prices,id',
            'weight' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        // Ambil data aturan harga sampah saat ini dari database
        $trashPrice = TrashPrice::findOrFail($request->trash_price_id);

        // LOGIKA UTAMA MATEMATIKA: Hitung pendapatan warga
        $weight = $request->weight;
        $pricePerKg = $trashPrice->buy_price; // Mengambil harga beli warga aktif
        $earning = $weight * $pricePerKg;

        // Simpan nota ke dalam database
        TrashDeposit::create([
            'user_id' => $request->user_id,
            'trash_price_id' => $request->trash_price_id,
            'weight' => $weight,
            'price_per_kg' => $pricePerKg, // Mengunci harga saat transaksi dilakukan
            'earning' => $earning,
            'withdrawal_status' => 'belum_ditarik',
            'note' => $request->note,
        ]);

        return back()->with('success', 'Transaksi berhasil! Saldo sebesar Rp ' . number_format($earning, 0, ',', '.') . ' telah didepositokan ke akun warga.');
    }

    public function update(Request $request, $id)
    {
        $deposit = TrashDeposit::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'trash_price_id' => 'required|exists:trash_prices,id',
            'weight' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        $trashPrice = TrashPrice::findOrFail($request->trash_price_id);
        $weight = $request->weight;
        $pricePerKg = $trashPrice->buy_price;
        $earning = $weight * $pricePerKg;

        $deposit->update([
            'user_id' => $request->user_id,
            'trash_price_id' => $request->trash_price_id,
            'weight' => $weight,
            'price_per_kg' => $pricePerKg,
            'earning' => $earning,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Data setoran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $deposit = TrashDeposit::findOrFail($id);
        
        // Cek jika statusnya sudah ditarik atau diproses, bisa saja ditambahkan validasi
        // if ($deposit->withdrawal_status !== 'belum_ditarik') {
        //     return back()->with('error', 'Setoran yang sudah ditarik tidak dapat dihapus.');
        // }

        $deposit->delete();

        return back()->with('success', 'Data setoran berhasil dihapus.');
    }
}