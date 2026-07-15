<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrashDeposit;
use App\Models\WithdrawalRequest;
use Carbon\Carbon;

class AdminKasController extends Controller
{
    /**
     * Display the Jurnal & Kas view.
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', date('Y-m'));
        if ($selectedMonth === 'all') {
            $selectedMonth = null;
        }

        // Get list of all available months from deposits and withdrawals for filter options
        $monthsCollection = collect();

        $allDepositsDates = TrashDeposit::select('created_at')->get();
        foreach ($allDepositsDates as $d) {
            $monthsCollection->push($d->created_at->format('Y-m'));
        }

        $allWithdrawalDates = WithdrawalRequest::where('status', 'approved')->select('updated_at')->get();
        foreach ($allWithdrawalDates as $w) {
            $monthsCollection->push($w->updated_at->format('Y-m'));
        }

        // Add current month if it's not present
        $monthsCollection->push(date('Y-m'));

        $availableMonths = $monthsCollection->unique()->sortDesc()->map(function ($ym) {
            return [
                'value' => $ym,
                'label' => Carbon::parse($ym . '-01')->translatedFormat('F Y'),
            ];
        })->values()->all();

        $monthLabel = $selectedMonth 
            ? Carbon::parse($selectedMonth . '-01')->translatedFormat('F Y') 
            : 'Semua Waktu';

        // Hitung estimasi Kas Masuk
        $queryDeposits = TrashDeposit::with('trashPrice');
        if ($selectedMonth) {
            $queryDeposits->whereYear('created_at', substr($selectedMonth, 0, 4))
                          ->whereMonth('created_at', substr($selectedMonth, 5, 2));
        }
        $deposits = $queryDeposits->get();

        $kasMasuk = 0;
        foreach ($deposits as $deposit) {
            if ($deposit->trashPrice) {
                $kasMasuk += $deposit->weight * $deposit->trashPrice->sell_price;
            }
        }

        // Hitung Kas Keluar
        $queryWithdrawals = WithdrawalRequest::where('status', 'approved');
        if ($selectedMonth) {
            $queryWithdrawals->whereYear('updated_at', substr($selectedMonth, 0, 4))
                            ->whereMonth('updated_at', substr($selectedMonth, 5, 2));
        }
        $kasKeluar = $queryWithdrawals->sum('total_amount');
        
        // Sisa Saldo Kas
        $saldoKas = $kasMasuk - $kasKeluar;

        // Ambil Data Transaksi untuk Jurnal (Selalu hitung running balance dari semua transaksi agar saldo akhir logis)
        $transactionsAll = [];

        // 1. Kas Masuk (Semua)
        $depositsListAll = TrashDeposit::with('trashPrice')->get();
        foreach ($depositsListAll as $deposit) {
            if ($deposit->trashPrice) {
                $amount = $deposit->weight * $deposit->trashPrice->sell_price;
                $transactionsAll[] = [
                    'date' => $deposit->created_at,
                    'type' => 'masuk',
                    'title' => 'Penjualan Sampah ke Pengepul',
                    'subtitle' => 'Penjualan ' . number_format($deposit->weight, 2, ',', '.') . 'kg ' . $deposit->trashPrice->item_name,
                    'debit' => $amount,
                    'kredit' => 0,
                ];
            }
        }

        // 2. Kas Keluar (Semua)
        $withdrawalsListAll = WithdrawalRequest::with('user')->where('status', 'approved')->get();
        foreach ($withdrawalsListAll as $withdrawal) {
            $userName = $withdrawal->user ? $withdrawal->user->name : 'Warga (Terhapus)';
            $transactionsAll[] = [
                'date' => $withdrawal->updated_at,
                'type' => 'keluar',
                'title' => 'Pencairan Dana Warga (' . $userName . ')',
                'subtitle' => $withdrawal->admin_note ?: 'Penarikan saldo tabungan',
                'debit' => 0,
                'kredit' => $withdrawal->total_amount,
            ];
        }

        // Urutkan transaksi secara ASCENDING untuk menghitung saldo berjalan
        usort($transactionsAll, function ($a, $b) {
            return $a['date'] <=> $b['date'];
        });

        $runningBalance = 0;
        foreach ($transactionsAll as $key => $transaction) {
            $runningBalance += $transaction['debit'] - $transaction['kredit'];
            $transactionsAll[$key]['saldo'] = $runningBalance;
        }

        // Sekarang saring transaksi yang akan ditampilkan berdasarkan bulan terpilih
        $transactions = [];
        foreach ($transactionsAll as $trx) {
            if (!$selectedMonth) {
                $transactions[] = $trx;
            } else {
                $trxDate = Carbon::parse($trx['date'])->format('Y-m');
                if ($trxDate === $selectedMonth) {
                    $transactions[] = $trx;
                }
            }
        }

        // Urutkan transaksi berdasarkan tanggal secara DESCENDING untuk ditampilkan (Terbaru di atas)
        usort($transactions, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        $transactions = collect($transactions);

        return view('admin.kas', compact('kasMasuk', 'kasKeluar', 'saldoKas', 'transactions', 'availableMonths', 'selectedMonth', 'monthLabel'));
    }

    /**
     * Export Laporan Kas ke XLSX
     */
    public function export(Request $request)
    {
        $selectedMonth = $request->input('month');
        if ($selectedMonth === 'all') {
            $selectedMonth = null;
        }

        $transactionsAll = [];

        // 1. Kas Masuk (Semua)
        $depositsListAll = TrashDeposit::with(['trashPrice', 'user'])->get();
        foreach ($depositsListAll as $deposit) {
            if ($deposit->trashPrice) {
                $amount = $deposit->weight * $deposit->trashPrice->sell_price;
                $transactionsAll[] = [
                    'date' => $deposit->created_at,
                    'type' => 'masuk',
                    'title' => 'Penjualan Sampah ke Pengepul',
                    'subtitle' => 'Penjualan ' . number_format($deposit->weight, 2, ',', '.') . 'kg ' . $deposit->trashPrice->item_name,
                    'debit' => $amount,
                    'kredit' => 0,
                ];
            }
        }

        // 2. Kas Keluar (Semua)
        $withdrawalsListAll = WithdrawalRequest::with('user')->where('status', 'approved')->get();
        foreach ($withdrawalsListAll as $withdrawal) {
            $userName = $withdrawal->user ? $withdrawal->user->name : 'Warga (Terhapus)';
            $transactionsAll[] = [
                'date' => $withdrawal->updated_at,
                'type' => 'keluar',
                'title' => 'Pencairan Dana Warga (' . $userName . ')',
                'subtitle' => $withdrawal->admin_note ?: 'Penarikan saldo tabungan',
                'debit' => 0,
                'kredit' => $withdrawal->total_amount,
            ];
        }

        // Urutkan transaksi secara ASCENDING untuk menghitung saldo berjalan
        usort($transactionsAll, function ($a, $b) {
            return $a['date'] <=> $b['date'];
        });

        $runningBalance = 0;
        foreach ($transactionsAll as $key => $transaction) {
            $runningBalance += $transaction['debit'] - $transaction['kredit'];
            $transactionsAll[$key]['saldo'] = $runningBalance;
        }

        // Saring transaksi berdasarkan bulan terpilih
        $transactions = [];
        foreach ($transactionsAll as $trx) {
            if (!$selectedMonth) {
                $transactions[] = $trx;
            } else {
                $trxDate = Carbon::parse($trx['date'])->format('Y-m');
                if ($trxDate === $selectedMonth) {
                    $transactions[] = $trx;
                }
            }
        }

        // Format Data untuk XLSX
        $data = [];
        $columns = ['Tanggal', 'Jenis', 'Judul Transaksi', 'Keterangan', 'Debit (Rp)', 'Kredit (Rp)', 'Saldo (Rp)'];
        $data[] = $columns;

        foreach ($transactions as $row) {
            $data[] = [
                Carbon::parse($row['date'])->format('Y-m-d H:i:s'),
                strtoupper($row['type']),
                $row['title'],
                $row['subtitle'],
                $row['debit'],
                $row['kredit'],
                $row['saldo']
            ];
        }

        // Generate XLSX and save to temporary file
        $fileName = 'Laporan_Kas_Desa_' . ($selectedMonth ? $selectedMonth . '_' : '') . date('Ymd_His') . '.xlsx';
        $tempFile = storage_path('app/private/' . $fileName);
        
        \Shuchkin\SimpleXLSXGen::fromArray($data)->saveAs($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
