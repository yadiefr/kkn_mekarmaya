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

        // Ambil riwayat transaksi setoran di desa (HARI INI)
        $recentDeposits = TrashDeposit::with(['user', 'trashPrice'])
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->latest()
            ->paginate(10);

        return view('admin.setorsampah', compact('wargaList', 'sampahList', 'recentDeposits'));
    }

    public function rekap()
    {
        // Ambil semua transaksi setoran
        $deposits = TrashDeposit::with(['user', 'trashPrice'])
            ->latest()
            ->paginate(20);
            
        // Ambil warga dan sampah untuk kebutuhan edit di modal
        $wargaList = User::where('role', 'warga')->orderBy('name', 'asc')->get();
        $sampahList = TrashPrice::orderBy('item_name', 'asc')->get();

        return view('admin.rekapsetoran', compact('deposits', 'wargaList', 'sampahList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'trash_items' => 'required|array|min:1',
            'trash_items.*.trash_price_id' => 'required|exists:trash_prices,id',
            'trash_items.*.weight' => 'required|numeric|min:0.01',
            'trash_items.*.note' => 'nullable|string|max:255',
        ], [
            'user_id.required' => 'Nama warga penabung wajib dipilih.',
            'user_id.exists' => 'Warga tidak ditemukan.',
            'trash_items.required' => 'Daftar item sampah wajib diisi.',
            'trash_items.array' => 'Format daftar item sampah tidak valid.',
            'trash_items.min' => 'Minimal harus ada 1 item sampah.',
            'trash_items.*.trash_price_id.required' => 'Kategori sampah wajib dipilih pada setiap baris.',
            'trash_items.*.trash_price_id.exists' => 'Kategori sampah tidak valid.',
            'trash_items.*.weight.required' => 'Berat hasil timbangan wajib diisi.',
            'trash_items.*.weight.numeric' => 'Berat harus berupa angka.',
            'trash_items.*.weight.min' => 'Berat minimal 0.01 Kg.',
            'trash_items.*.note.max' => 'Catatan maksimal 255 karakter.',
        ]);

        $userId = $request->user_id;
        $totalEarning = 0;

        DB::transaction(function () use ($request, $userId, &$totalEarning) {
            foreach ($request->trash_items as $item) {
                $trashPrice = TrashPrice::findOrFail($item['trash_price_id']);
                $weight = $item['weight'];
                $pricePerKg = $trashPrice->buy_price;
                $earning = $weight * $pricePerKg;
                $totalEarning += $earning;

                TrashDeposit::create([
                    'user_id' => $userId,
                    'trash_price_id' => $item['trash_price_id'],
                    'weight' => $weight,
                    'price_per_kg' => $pricePerKg,
                    'earning' => $earning,
                    'withdrawal_status' => 'belum_ditarik',
                    'note' => $item['note'] ?? null,
                ]);
            }
        });

        return back()->with('success', 'Transaksi berhasil! Total Saldo sebesar Rp ' . number_format($totalEarning, 0, ',', '.') . ' telah didepositokan ke akun warga.');
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