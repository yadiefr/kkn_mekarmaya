@extends('layouts.admin')

@section('title', 'Dashboard Admin - Bank Sampah Desa Mekarmaya')
@section('header_title', 'Ringkasan Utama')

@section('content')
    <!-- WELCOME BANNER -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 p-6 sm:p-8 rounded-2xl text-white shadow-lg border border-slate-800">
        <!-- Abstract shape decorations -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl"></div>
        <div class="absolute right-20 -bottom-10 w-32 h-32 bg-teal-500/10 rounded-full blur-xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-[10px] sm:text-xs font-bold text-emerald-400 uppercase tracking-widest">Selamat Datang Kembali</p>
                <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight mt-1">{{ Auth::user()->name }}</h2>
                <p class="text-xs text-slate-300 mt-1 leading-relaxed max-w-xl">
                    Kelola data setoran timbangan, pencairan saldo tabungan warga, dan pantau grafik keuangan Bank Sampah Desa Mekarmaya secara real-time.
                </p>
            </div>
        </div>
    </div>

    <!-- ROW 1: KARTU STATISTIK & KAS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Kas Masuk -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-xs hover:shadow-md transition-all duration-350 flex items-center justify-between group">
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Kas Masuk</p>
                <h3 class="text-xs sm:text-lg font-black text-slate-900 mt-1 truncate">Rp {{ number_format($kasMasuk, 0, ',', '.') }}</h3>
            </div>
            <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm sm:text-base shrink-0 ml-2 group-hover:scale-110 transition-transform"><i class="fas fa-arrow-trend-up"></i></div>
        </div>
        <!-- Total Kas Keluar -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-xs hover:shadow-md transition-all duration-350 flex items-center justify-between group">
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Kas Keluar</p>
                <h3 class="text-xs sm:text-lg font-black text-slate-900 mt-1 truncate">Rp {{ number_format($kasKeluar, 0, ',', '.') }}</h3>
            </div>
            <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-sm sm:text-base shrink-0 ml-2 group-hover:scale-110 transition-transform"><i class="fas fa-arrow-trend-down"></i></div>
        </div>
        <!-- Sisa Saldo Kas -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-xs hover:shadow-md transition-all duration-350 flex items-center justify-between group">
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Saldo Kas Desa</p>
                <h3 class="text-xs sm:text-lg font-black text-emerald-700 mt-1 truncate">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
            </div>
            <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm sm:text-base shrink-0 ml-2 group-hover:scale-110 transition-transform"><i class="fas fa-wallet"></i></div>
        </div>
        <!-- Total Warga -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-100 shadow-xs hover:shadow-md transition-all duration-350 flex items-center justify-between group">
            <div class="min-w-0">
                <p class="text-[9px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Warga</p>
                <h3 class="text-xs sm:text-lg font-black text-blue-600 mt-1 truncate">{{ $totalWargaCount }} Warga</h3>
            </div>
            <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm sm:text-base shrink-0 ml-2 group-hover:scale-110 transition-transform"><i class="fas fa-users"></i></div>
        </div>
    </div>

    <!-- ROW 2: DUA KOLOM (KIRI: TABEL AKTIVASI, KANAN: HARGA SAMPAH KILAT) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KOLOM WARGA DENGAN SAMPAH TERBANYAK (2/3 Lebar) -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm lg:col-span-2 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center"><i class="fas fa-trophy mr-2 text-amber-500"></i>5 Warga dengan Sampah/Saldo Terbanyak</h4>
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Aktif</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold border-b border-slate-100">
                            <th class="p-4">Nama Warga / NIK</th>
                            <th class="p-4">Kontak WhatsApp</th>
                            <th class="p-4 text-right">Sampah Terolah</th>
                            <th class="p-4 text-right font-bold">Saldo Aktif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($topWarga as $index => $w)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs uppercase shrink-0">
                                    {{ Str::substr($w->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 truncate">{{ $w->name }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">NIK: {{ Str::mask($w->nik, 'X', 4, 8) }}</p>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($w->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $w->whatsapp) }}" target="_blank" class="inline-flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-lg font-semibold transition">
                                        <i class="fab fa-whatsapp"></i> {{ $w->whatsapp }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-right font-medium text-slate-700">{{ number_format($w->total_berat, 2, ',', '.') }} kg</td>
                            <td class="p-4 text-right font-black text-emerald-700">Rp {{ number_format($w->total_saldo, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">Belum ada data kontribusi setoran sampah dari warga.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- KOLOM PENENTUAN HARGA SAMPAH KILAT (1/3 Lebar) -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Pantau Harga Sampah</h4>
                </div>
                <div class="p-5 space-y-3.5">
                    @forelse($hargaSampah as $harga)
                    <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 last:pb-0 text-xs">
                        <div class="min-w-0">
                            <h5 class="font-bold text-slate-800 truncate flex items-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 shrink-0"></span>
                                {{ $harga->item_name }}
                            </h5>
                            <p class="text-[10px] text-slate-400 mt-1">Beli: <span class="text-emerald-600 font-semibold">Rp {{ number_format($harga->buy_price, 0, ',', '.') }}</span> | Jual: <span class="text-blue-600 font-semibold">Rp {{ number_format($harga->sell_price, 0, ',', '.') }}</span></p>
                        </div>
                        <a href="{{ route('admin.harga.index') }}" class="text-emerald-700 hover:text-emerald-800 font-bold hover:bg-emerald-50 px-2 py-1.5 rounded-lg transition shrink-0"><i class="fas fa-edit"></i></a>
                    </div>
                    @empty
                    <div class="text-center text-slate-400 text-xs py-4">Belum ada harga sampah aktif.</div>
                    @endforelse
                </div>
            </div>
            <div class="p-5 bg-slate-50 border-t border-slate-100">
                <a href="{{ route('admin.harga.index') }}" class="w-full text-center block text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                    Kelola Seluruh Harga Sampah <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

    </div>
@endsection
