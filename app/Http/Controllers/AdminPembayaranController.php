<?php

namespace App\Http\Controllers;

use App\Models\WithdrawalSetting;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Ditambahkan untuk menggunakan fitur DB transaction & update

class AdminPembayaranController extends Controller
{
    public function index()
    {
        // Ambil semua riwayat jadwal rentang tanggal pembayaran
        $settings = WithdrawalSetting::latest()->get();

        // Pisahkan data pengajuan berdasarkan statusnya
        $requestsPending = WithdrawalRequest::with('user')->where('status', 'pending')->latest()->get();
        $requestsHistory = WithdrawalRequest::with('user')->whereIn('status', ['approved', 'rejected'])->latest()->get();

        return view('admin.pembayaran', compact('settings', 'requestsPending', 'requestsHistory'));
    }

    // 1. Simpan Jadwal Pembayaran Baru
    public function storeSetting(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Nonaktifkan jadwal lain terlebih dahulu jika jadwal baru ini diset aktif
        WithdrawalSetting::where('is_active', true)->update(['is_active' => false]);

        WithdrawalSetting::create([
            'event_name' => $request->event_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
        ]);

        return back()->with('success_setting', 'Jadwal rentang tanggal pencairan dana berhasil dibuka!');
    }

    // 2. Proses Persetujuan / Penolakan Tarik Saldo + Otomatis Update Status Nota Sampah
    public function processRequest(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approved,rejected',
            'admin_note' => 'nullable|string|max:255',
        ]);

        // Menggunakan DB::transaction untuk memastikan kedua tabel ter-update bersamaan tanpa eror separuh jalan
        DB::transaction(function () use ($request, $id, &$statusTeks) {
            $withdrawal = WithdrawalRequest::findOrFail($id);
            
            // 1. Update status di tabel withdrawal_requests
            $withdrawal->status = $request->action;
            $withdrawal->admin_note = $request->admin_note;
            $withdrawal->save();

            // 2. Logika Khusus jika DISETUJUI (approved)
            if ($request->action === 'approved') {
                // Otomatis ubah status mutasi buku tabungan milik warga terkait menjadi 'sudah_ditarik'
                DB::table('trash_deposits')
                    ->where('user_id', $withdrawal->user_id)
                    ->where('withdrawal_status', 'belum_ditarik')
                    ->update([
                        'withdrawal_status' => 'sudah_ditarik',
                        'updated_at' => now()
                    ]);

                $statusTeks = 'DISETUJUI & seluruh nota buku tabungan warga telah diset menjadi sudah ditarik.';
            } else {
                $statusTeks = 'DITOLAK (Status nota tabungan tetap aman belum ditarik).';
            }
        });
        
        return back()->with('success_request', "Pengajuan tarik saldo warga berhasil diproses dengan status: {$statusTeks}");
    }

    public function updateSetting(Request $request, $id)
    {
        $setting = WithdrawalSetting::findOrFail($id);

        $request->validate([
            'event_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $setting->update([
            'event_name' => $request->event_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('success_setting', 'Jadwal rentang tanggal berhasil diperbarui!');
    }

    public function destroySetting($id)
    {
        $setting = WithdrawalSetting::findOrFail($id);
        $setting->delete();

        return back()->with('success_setting', 'Jadwal rentang tanggal berhasil dihapus!');
    }

    public function updateRequest(Request $request, $id)
    {
        $withdrawal = WithdrawalRequest::findOrFail($id);
        
        $request->validate([
            'admin_note' => 'nullable|string|max:255',
        ]);

        $withdrawal->update([
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success_request', 'Catatan penarikan berhasil diperbarui.');
    }

    public function destroyRequest($id)
    {
        $withdrawal = WithdrawalRequest::findOrFail($id);

        // Jika statusnya approved, kita kembalikan status deposit warga ke belum_ditarik
        if ($withdrawal->status === 'approved') {
            DB::table('trash_deposits')
                ->where('user_id', $withdrawal->user_id)
                ->where('withdrawal_status', 'sudah_ditarik')
                ->update(['withdrawal_status' => 'belum_ditarik']);
        }

        $withdrawal->delete();

        return back()->with('success_request', 'Data penarikan berhasil dihapus dan saldo dikembalikan.');
    }
}