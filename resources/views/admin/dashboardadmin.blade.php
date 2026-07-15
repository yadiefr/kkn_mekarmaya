@extends('layouts.admin')

@section('title', 'Dashboard Admin - Sobat Sampah Desa Mekarmaya')
@section('header_title', 'Ringkasan Utama')

@section('content')
    <!-- ROW 1: KARTU STATISTIK & KAS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Kas Masuk -->
        <div class="bg-white p-4 sm:p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider truncate">Total Kas Masuk</p>
                <h3 class="text-xs sm:text-lg font-bold text-gray-900 mt-1 truncate">Rp {{ number_format($kasMasuk, 0, ',', '.') }}</h3>
            </div>
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-sm sm:text-base shrink-0 ml-2"><i class="fas fa-arrow-trend-up"></i></div>
        </div>
        <!-- Total Kas Keluar -->
        <div class="bg-white p-4 sm:p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider truncate">Total Kas Keluar</p>
                <h3 class="text-xs sm:text-lg font-bold text-gray-900 mt-1 truncate">Rp {{ number_format($kasKeluar, 0, ',', '.') }}</h3>
            </div>
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-sm sm:text-base shrink-0 ml-2"><i class="fas fa-arrow-trend-down"></i></div>
        </div>
        <!-- Sisa Saldo Kas -->
        <div class="bg-white p-4 sm:p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider truncate">Saldo Kas Desa</p>
                <h3 class="text-xs sm:text-lg font-bold text-gray-900 mt-1 text-emerald-700 truncate">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
            </div>
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm sm:text-base shrink-0 ml-2"><i class="fas fa-wallet"></i></div>
        </div>
        <!-- Total Warga -->
        <div class="bg-white p-4 sm:p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold text-gray-400 uppercase tracking-wider truncate">Total Warga</p>
                <h3 class="text-xs sm:text-lg font-bold text-gray-900 mt-1 text-blue-600 truncate">{{ $totalWargaCount }} Orang</h3>
            </div>
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm sm:text-base shrink-0 ml-2"><i class="fas fa-users"></i></div>
        </div>
    </div>

    <!-- ROW 2: DUA KOLOM (KIRI: TABEL AKTIVASI, KANAN: HARGA SAMPAH KILAT) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KOLOM WARGA DENGAN SAMPAH TERBANYAK (2/3 Lebar) -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm lg:col-span-2 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider"><i class="fas fa-trophy mr-2 text-amber-500"></i>5 Warga dengan Sampah/Saldo Terbanyak</h4>
                <span class="text-[10px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Aktif Terkini</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                            <th class="p-4">Nama Warga / NIK</th>
                            <th class="p-4">Kontak WhatsApp</th>
                            <th class="p-4 text-right">Sampah Terolah</th>
                            <th class="p-4 text-right font-bold">Saldo Aktif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($topWarga as $index => $w)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4">
                                <p class="font-bold text-gray-900">{{ $w->name }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">NIK: {{ Str::mask($w->nik, 'X', 4, 8) }}</p>
                            </td>
                            <td class="p-4 text-gray-600 font-medium"><i class="fab fa-whatsapp text-emerald-600 mr-1"></i>{{ $w->whatsapp ?? '-' }}</td>
                            <td class="p-4 text-right font-medium text-gray-700">{{ number_format($w->total_berat, 2, ',', '.') }} kg</td>
                            <td class="p-4 text-right font-black text-emerald-700">Rp {{ number_format($w->total_saldo, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400">Belum ada data kontribusi setoran sampah dari warga.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- KOLOM PENENTUAN HARGA SAMPAH KILAT (1/3 Lebar) -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Pantau & Set Harga Sampah</h4>
            </div>
            <div class="p-5 space-y-4">
                @forelse($hargaSampah as $harga)
                <div class="flex items-center justify-between border-b border-gray-50 pb-3 text-xs">
                    <div>
                        <h5 class="font-bold text-gray-800">{{ $harga->item_name }}</h5>
                        <p class="text-[10px] text-gray-400">Beli: <span class="text-emerald-600">Rp {{ number_format($harga->buy_price, 0, ',', '.') }}</span> | Jual: <span class="text-blue-600">Rp {{ number_format($harga->sell_price, 0, ',', '.') }}</span></p>
                    </div>
                    <a href="{{ route('admin.harga.index') }}" class="text-emerald-700 hover:text-emerald-800 font-semibold transition duration-150"><i class="fas fa-edit mr-1"></i>Ubah</a>
                </div>
                @empty
                <div class="text-center text-gray-400 text-xs py-4">Belum ada harga sampah aktif.</div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
