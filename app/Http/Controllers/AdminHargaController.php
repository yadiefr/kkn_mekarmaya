<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminHargaController extends Controller
{
    public function index()
    {
        // Mengambil semua data kategori sampah untuk dikelola admin
        $trashPrices = DB::table('trash_prices')->orderBy('item_name', 'asc')->get();
        return view('admin.settingharga', compact('trashPrices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Menyimpan gambar ke folder public/uploads/trash
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/trash'), $fileName);
            $imagePath = 'uploads/trash/' . $fileName;
        }

        DB::table('trash_prices')->insert([
            'item_name' => $request->item_name,
            'buy_price' => $request->buy_price,
            'sell_price' => $request->sell_price,
            'image_path' => $imagePath,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Kategori sampah baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $currentData = DB::table('trash_prices')->where('id', $id)->first();
        $imagePath = $currentData->image_path;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }

            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/trash'), $fileName);
            $imagePath = 'uploads/trash/' . $fileName;
        }

        DB::table('trash_prices')->where('id', $id)->update([
            'item_name' => $request->item_name,
            'buy_price' => $request->buy_price,
            'sell_price' => $request->sell_price,
            'image_path' => $imagePath,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data harga sampah berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
        $currentData = DB::table('trash_prices')->where('id', $id)->first();
        $newStatus = !$currentData->is_active;

        DB::table('trash_prices')->where('id', $id)->update([
            'is_active' => $newStatus,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Status keaktifan barang berhasil diubah!');
    }

    public function destroy($id)
    {
        $currentData = DB::table('trash_prices')->where('id', $id)->first();
        
        // Hapus file gambar fisik dari hosting/server lokal
        if ($currentData->image_path && file_exists(public_path($currentData->image_path))) {
            unlink(public_path($currentData->image_path));
        }

        DB::table('trash_prices')->where('id', $id)->delete();

        return back()->with('success', 'Kategori sampah berhasil dihapus dari sistem!');
    }
}