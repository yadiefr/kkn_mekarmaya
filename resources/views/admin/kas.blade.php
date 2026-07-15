@extends('layouts.admin')

@section('title', 'Kas Desa - Panel Admin')
@section('header_title', 'Buku Kas Desa Bank Sampah')

@section('content')
    <!-- ROW 1: KARTU STATISTIK & KAS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Total Kas Masuk -->
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Kas Masuk ({{ $monthLabel }})</p>
                <h3 class="text-lg font-bold text-gray-900 mt-1">Rp {{ number_format($kasMasuk, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i>Penjualan ke Pengepul</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-lg"><i class="fas fa-arrow-trend-up"></i></div>
        </div>
        <!-- Total Kas Keluar -->
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Kas Keluar ({{ $monthLabel }})</p>
                <h3 class="text-lg font-bold text-gray-900 mt-1">Rp {{ number_format($kasKeluar, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-red-500 mt-1"><i class="fas fa-arrow-down mr-1"></i>Pembayaran ke Warga</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-lg"><i class="fas fa-arrow-trend-down"></i></div>
        </div>
        <!-- Sisa Saldo Kas -->
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Saldo Selisih Kas ({{ $monthLabel }})</p>
                <h3 class="text-xl font-bold text-emerald-700 mt-1">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-gray-400 mt-1">Posisi Kas Periode Terpilih</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg"><i class="fas fa-wallet"></i></div>
        </div>
    </div>

    <!-- ROW 2: TABEL KAS TRANSAKSI -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider"><i class="fas fa-list-ol mr-2 text-emerald-600"></i>Riwayat Kas Transaksi</h4>
            <a href="{{ route('admin.kas.export', ['month' => $selectedMonth ?: 'all']) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-[11px] font-bold shadow-sm transition flex items-center">
                <i class="fas fa-download mr-2"></i> Ekspor Laporan
            </a>
        </div>
        
        <!-- Filter Section -->
        <div class="p-4 border-b border-gray-50 flex gap-3 flex-wrap">
            <form action="{{ route('admin.kas') }}" method="GET" class="flex gap-3 flex-wrap w-full">
                <select name="month" onchange="this.form.submit()" class="px-3 py-2 border border-gray-200 rounded-lg text-[11px] text-gray-600 focus:outline-none focus:border-emerald-500 bg-white">
                    <option value="all" {{ is_null($selectedMonth) ? 'selected' : '' }}>Semua Waktu</option>
                    @foreach($availableMonths as $m)
                        <option value="{{ $m['value'] }}" {{ $selectedMonth === $m['value'] ? 'selected' : '' }}>
                            {{ $m['label'] }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                        <th class="p-4 w-32">Tanggal</th>
                        <th class="p-4">Keterangan / Deskripsi</th>
                        <th class="p-4 text-right text-green-600">Debit (Masuk)</th>
                        <th class="p-4 text-right text-red-600">Kredit (Keluar)</th>
                        <th class="p-4 text-right font-bold">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-gray-500">
                                <span class="block font-medium text-gray-800">{{ \Carbon\Carbon::parse($trx['date'])->translatedFormat('d M Y') }}</span>
                                <span class="text-[10px]">{{ \Carbon\Carbon::parse($trx['date'])->translatedFormat('H:i') }} WIB</span>
                            </td>
                            <td class="p-4">
                                <p class="font-bold text-gray-900">{{ $trx['title'] }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $trx['subtitle'] }}</p>
                            </td>
                            <td class="p-4 text-right {{ $trx['debit'] > 0 ? 'font-bold text-green-600' : 'text-gray-400' }}">
                                {{ $trx['debit'] > 0 ? 'Rp ' . number_format($trx['debit'], 0, ',', '.') : '-' }}
                            </td>
                            <td class="p-4 text-right {{ $trx['kredit'] > 0 ? 'font-bold text-red-600' : 'text-gray-400' }}">
                                {{ $trx['kredit'] > 0 ? 'Rp ' . number_format($trx['kredit'], 0, ',', '.') : '-' }}
                            </td>
                            <td class="p-4 text-right font-bold text-emerald-700">Rp {{ number_format($trx['saldo'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-400">Belum ada riwayat transaksi kas tercatat pada bulan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination Info -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500">
            <span>Menampilkan {{ $transactions->count() }} transaksi terakhir</span>
        </div>
    </div>
@endsection
