<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarik Saldo - Sobat Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-800 antialiased min-h-screen flex">

    <!-- Overlay Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-20 bg-black/50 md:hidden"></div>

    <!-- SIDEBAR -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-800 text-white flex flex-col justify-between shrink-0 transition-transform duration-300 md:relative md:translate-x-0 md:flex shadow-xl">
        <div>
            <div class="p-6 border-b border-emerald-700">
                <h1 class="font-bold text-sm leading-tight uppercase tracking-wider">SOBAT SAMPAH<br><span class="text-emerald-300 text-xs font-medium normal-case">Tabungan Warga</span></h1>
            </div>
            <nav class="p-4 space-y-1 text-xs">
                <a href="{{ route('warga.dashboard') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-2.5 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center text-sm"></i><span>Dashboard Utama</span>
                </a>
                <a href="{{ route('warga.riwayat') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-2.5 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-history text-emerald-300 w-5 text-center text-sm"></i><span>Riwayat Transaksi</span>
                </a>
                <a href="{{ route('warga.harga') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-2.5 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-tags text-emerald-300 w-5 text-center text-sm"></i><span>Harga Sampah</span>
                </a>
                <a href="#" class="flex items-center space-x-3 bg-emerald-900 text-white px-4 py-2.5 rounded-lg font-semibold transition duration-200">
                    <i class="fas fa-money-bill-wave text-emerald-300 w-5 text-center text-sm"></i><span>Tarik Saldo</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-emerald-700 text-xs">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-300 font-semibold px-4 py-2 block">Keluar</a>
        </div>
    </aside>

    <!-- CONTENT WRAPPER -->
    <div class="flex-grow flex flex-col min-w-0">
        
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex md:hidden items-center justify-between px-4 z-10">
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = true" class="text-gray-600 focus:outline-none text-lg cursor-pointer hover:text-emerald-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Tarik Saldo</h2>
            </div>
            <a href="{{ route('warga.dashboard') }}" class="text-emerald-700 text-xs font-bold"><i class="fas fa-arrow-left mr-1"></i> Dashboard</a>
        </header>

        <main class="flex-grow p-4 sm:p-6 lg:p-8 space-y-6 overflow-y-auto">
            
            <div>
                <h2 class="text-lg font-bold text-gray-900">Pengajuan Penarikan Saldo Global</h2>
                <p class="text-xs text-gray-500 mt-0.5">Sistem pencairan dana berskala besar yang membutuhkan verifikasi admin desa.</p>
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
                                    Sesuai dengan kebijakan Bank Sampah Desa Mekarmaya, penarikan saldo massal hanya dibuka pada hari-hari besar tertentu. Saat ini belum ada pengumuman jadwal pencairan dana terdekat dari admin desa.
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

        </main>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
</body>
</html>