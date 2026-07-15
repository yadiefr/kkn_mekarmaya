@extends('layouts.warga')

@section('title', 'Tarik Saldo - Sobat Sampah')
@section('header_title', 'Tarik Saldo')

@section('header_right')
    <a href="{{ route('warga.dashboard') }}" class="text-emerald-700 text-xs font-bold"><i class="fas fa-arrow-left mr-1"></i> Dashboard</a>
@endsection

@section('content')
    <div>
        <h2 class="text-lg font-bold text-gray-900">Pengajuan Penarikan Saldo</h2>
        <p class="text-xs text-gray-500 mt-0.5">Sistem pencairan dana membutuhkan verifikasi dan mendatangi admin desa.</p>
    </div>

    <!-- Pesan Alert Sukses / Eror -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium">{{ session('success') }}</div>
    @endif
    @if($errors->has('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs rounded-xl font-medium">{{ $errors->first('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- PANEL AKSI UTAMA -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2 space-y-6">
            @if($activeSetting)
                <!-- JIKA SEDANG MASUK PERIODE PENARIKAN -->
                <div class="bg-amber-50/50 border border-amber-200/70 p-4 rounded-xl text-xs text-amber-900 flex items-start space-x-3">
                    <i class="fas fa-circle-info mt-0.5 text-amber-600"></i>
                    <div>
                        <h4 class="font-bold">Periode Penarikan Dibuka: {{ $activeSetting->event_name }}</h4>
                        <p class="mt-0.5 text-gray-600">Anda dapat mengajukan pencairan saldo mulai tanggal <strong>{{ \Carbon\Carbon::parse($activeSetting->start_date)->translatedFormat('d F') }}</strong> sampai <strong>{{ \Carbon\Carbon::parse($activeSetting->end_date)->translatedFormat('d F Y') }}</strong>.</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 text-center">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Saldo Yang Bisa Dicairkan Saat Ini</span>
                    <span class="text-3xl font-black text-emerald-700 block mt-1">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</span>
                    
                    @if($totalSaldo > 0)
                        @if(!$pendingRequest)
                            <form action="{{ route('warga.tarik.ajukan') }}" method="POST" class="mt-6">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-8 py-3 rounded-xl shadow-md transition duration-200 cursor-pointer">
                                    <i class="fas fa-paper-plane mr-2"></i>Ajukan Penarikan Seluruh Saldo
                                </button>
                            </form>
                        @else
                            <div class="mt-6 text-xs text-amber-700 font-semibold bg-amber-50 py-2.5 rounded-xl border border-amber-100 inline-block px-6">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Pengajuan sedang ditinjau admin. Harap tunggu uang tunai disiapkan.
                            </div>
                        @endif
                    @else
                        <button disabled class="mt-6 bg-gray-200 text-gray-400 text-xs font-bold px-8 py-3 rounded-xl cursor-not-allowed">
                            Saldo Kosong / Sudah Diambil
                        </button>
                    @endif
                </div>
            @else
                <!-- JIKA DI LUAR JADWAL PENARIKAN -->
                <div class="bg-red-50 text-center py-10 rounded-2xl border border-red-100 p-6 flex flex-col items-center justify-center">
                    <div class="w-12 h-12 bg-red-100 text-red-700 rounded-full flex items-center justify-center text-lg mb-3">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900">Fitur Penarikan Saldo Sedang Ditutup</h3>
                    
                    @if($upcomingSetting)
                        <!-- JIKA ADA JADWAL EVENT YANG AKAN AKTIF NANTI -->
                        <div class="mt-4 p-4 bg-white border border-red-200/60 rounded-xl max-w-md shadow-xs text-left">
                            <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded uppercase tracking-wider block w-fit mb-2">Jadwal Pencairan Terdekat</span>
                            <h4 class="text-xs font-bold text-gray-800 flex items-center">
                                <i class="fas fa-bullhorn text-amber-500 mr-2"></i> {{ $upcomingSetting->event_name }}
                            </h4>
                            <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">
                                Gerbang pencairan saldo global akan dibuka secara resmi mulai tanggal 
                                <strong class="text-gray-800">{{ \Carbon\Carbon::parse($upcomingSetting->start_date)->translatedFormat('d F Y') }}</strong> 
                                sampai dengan 
                                <strong class="text-gray-800">{{ \Carbon\Carbon::parse($upcomingSetting->end_date)->translatedFormat('d F Y') }}</strong>.
                            </p>
                        </div>
                    @else
                        <!-- JIKA SAMA SEKALI BELUM ADA EVENT BARU DI DATABASE -->
                        <p class="text-xs text-gray-500 mt-1 max-w-md mx-auto leading-relaxed">
                            Sesuai dengan kebijakan Bank Sampah Desa Mekarmaya, penarikan saldo massal hanya dibuka pada hari-hari tertentu. Saat ini belum ada pengumuman jadwal pencairan dana terdekat dari admin desa.
                        </p>
                    @endif
                    
                    <p class="text-[11px] text-gray-400 mt-4 italic">
                        *Silakan hubungi pengurus posko timbangan jika ada kebutuhan yang sangat mendesak.
                    </p>
                </div>
            @endif
        </div>

        <!-- RIWAYAT PENGAJUAN -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 space-y-4">
            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-100 pb-2">Status Pengajuan Anda</h3>
            <div class="space-y-3 max-h-72 overflow-y-auto text-xs">
                @forelse($requestHistory as $req)
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex justify-between items-center">
                        <div>
                            <h4 class="font-bold text-gray-800">Rp {{ number_format($req->total_amount, 0, ',', '.') }}</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($req->created_at)->translatedFormat('d M Y') }}</p>
                        </div>
                        <div>
                            @if($req->status === 'pending')
                                <span class="bg-amber-50 text-amber-700 font-medium px-2 py-0.5 text-[10px] rounded border border-amber-200">Pending</span>
                            @elseif($req->status === 'approved')
                                <span class="bg-emerald-50 text-emerald-700 font-medium px-2 py-0.5 text-[10px] rounded border border-emerald-200">Sukses</span>
                            @else
                                <span class="bg-red-50 text-red-700 font-medium px-2 py-0.5 text-[10px] rounded border border-red-200">Ditolak</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 py-6 text-xs">Belum ada riwayat pengajuan penarikan berkala.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection