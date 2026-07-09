<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminKasController extends Controller
{
    /**
     * Display the Jurnal & Kas view.
     */
    public function index()
    {
        // Hitung estimasi Kas Masuk berdasarkan total berat sampah ditarik dikali harga jual (ke pengepul)
        $kasMasuk = 0;
        $deposits = \App\Models\TrashDeposit::with('trashPrice')->get();
        foreach ($deposits as $deposit) {
            if ($deposit->trashPrice) {
                $kasMasuk += $deposit->weight * $deposit->trashPrice->sell_price;
            }
        }

        // Hitung Kas Keluar berdasarkan penarikan saldo warga yang telah disetujui
        $kasKeluar = \App\Models\WithdrawalRequest::where('status', 'approved')->sum('total_amount');
        
        // Sisa Saldo Kas
        $saldoKas = $kasMasuk - $kasKeluar;

        // Ambil Data Transaksi untuk Jurnal
        $transactions = [];

        // 1. Kas Masuk (Penjualan Sampah dari Setoran)
        $depositsList = \App\Models\TrashDeposit::with(['trashPrice', 'user'])->get();
        foreach ($depositsList as $deposit) {
            if ($deposit->trashPrice) {
                $amount = $deposit->weight * $deposit->trashPrice->sell_price;
                $transactions[] = [
                    'date' => $deposit->created_at,
                    'type' => 'masuk',
                    'title' => 'Penjualan Sampah ke Pengepul',
                    'subtitle' => 'Penjualan ' . number_format($deposit->weight, 2, ',', '.') . 'kg ' . $deposit->trashPrice->item_name,
                    'debit' => $amount,
                    'kredit' => 0,
                ];
            }
        }

        // 2. Kas Keluar (Pencairan Dana Warga yang disetujui)
        $withdrawalsList = \App\Models\WithdrawalRequest::with('user')->where('status', 'approved')->get();
        foreach ($withdrawalsList as $withdrawal) {
            $userName = $withdrawal->user ? $withdrawal->user->name : 'Warga (Terhapus)';
            $transactions[] = [
                'date' => $withdrawal->updated_at, // Menggunakan waktu persetujuan
                'type' => 'keluar',
                'title' => 'Pencairan Dana Warga (' . $userName . ')',
                'subtitle' => $withdrawal->admin_note ?: 'Penarikan saldo tabungan',
                'debit' => 0,
                'kredit' => $withdrawal->total_amount,
            ];
        }

        // Urutkan transaksi berdasarkan tanggal secara ASCENDING untuk menghitung saldo berjalan
        usort($transactions, function ($a, $b) {
            return $a['date'] <=> $b['date'];
        });

        $runningBalance = 0;
        foreach ($transactions as $key => $transaction) {
            $runningBalance += $transaction['debit'] - $transaction['kredit'];
            $transactions[$key]['saldo'] = $runningBalance;
        }

        // Urutkan transaksi berdasarkan tanggal secara DESCENDING untuk ditampilkan (Terbaru di atas)
        usort($transactions, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        // Untuk pagination, jika diperlukan, kita bisa menggunakan collect()->paginate() (Sederhananya kita jadikan array ke collection)
        // Kita tampilkan semua dulu atau paginate secara manual jika datanya banyak.
        // Di sini kita ubah menjadi collection
        $transactions = collect($transactions);

        return view('admin.kas', compact('kasMasuk', 'kasKeluar', 'saldoKas', 'transactions'));
    }

    /**
     * Export Laporan Kas ke CSV
     */
    public function export()
    {
        $transactions = [];

        // 1. Kas Masuk (Penjualan Sampah dari Setoran)
        $depositsList = \App\Models\TrashDeposit::with(['trashPrice', 'user'])->get();
        foreach ($depositsList as $deposit) {
            if ($deposit->trashPrice) {
                $amount = $deposit->weight * $deposit->trashPrice->sell_price;
                $transactions[] = [
                    'date' => $deposit->created_at,
                    'type' => 'masuk',
                    'title' => 'Penjualan Sampah ke Pengepul',
                    'subtitle' => 'Penjualan ' . number_format($deposit->weight, 2, ',', '.') . 'kg ' . $deposit->trashPrice->item_name,
                    'debit' => $amount,
                    'kredit' => 0,
                ];
            }
        }

        // 2. Kas Keluar (Pencairan Dana Warga yang disetujui)
        $withdrawalsList = \App\Models\WithdrawalRequest::with('user')->where('status', 'approved')->get();
        foreach ($withdrawalsList as $withdrawal) {
            $userName = $withdrawal->user ? $withdrawal->user->name : 'Warga (Terhapus)';
            $transactions[] = [
                'date' => $withdrawal->updated_at,
                'type' => 'keluar',
                'title' => 'Pencairan Dana Warga (' . $userName . ')',
                'subtitle' => $withdrawal->admin_note ?: 'Penarikan saldo tabungan',
                'debit' => 0,
                'kredit' => $withdrawal->total_amount,
            ];
        }

        // Urutkan transaksi berdasarkan tanggal secara ASCENDING untuk menghitung saldo berjalan
        usort($transactions, function ($a, $b) {
            return $a['date'] <=> $b['date'];
        });

        $runningBalance = 0;
        foreach ($transactions as $key => $transaction) {
            $runningBalance += $transaction['debit'] - $transaction['kredit'];
            $transactions[$key]['saldo'] = $runningBalance;
        }

        // Format Data untuk XLSX
        $data = [];
        $columns = ['Tanggal', 'Jenis', 'Judul Transaksi', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)'];
        $data[] = $columns;

        foreach ($transactions as $row) {
            $data[] = [
                \Carbon\Carbon::parse($row['date'])->format('Y-m-d H:i:s'),
                strtoupper($row['type']),
                $row['title'],
                $row['subtitle'],
                $row['debit'],
                $row['kredit'],
                $row['saldo']
            ];
        }

        // Generate XLSX and save to temporary file
        $fileName = 'Laporan_Kas_Desa_' . date('Ymd_His') . '.xlsx';
        $tempFile = storage_path('app/private/' . $fileName);
        
        \Shuchkin\SimpleXLSXGen::fromArray($data)->saveAs($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
