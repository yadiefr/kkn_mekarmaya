<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Desa Mekarmaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <!-- Google Fonts Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        
        /* Animation utilities */
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: 200%;
            animation: marquee 25s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: float-slow 4s ease-in-out infinite;
        }
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.03); }
        }
        .animate-pulse-subtle {
            animation: pulse-subtle 3s ease-in-out infinite;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white overflow-x-hidden">

    <!-- 1. LIVE RUNNING TICKER BAR (DATA REAL DARI DATABASE) -->
    <div class="bg-emerald-950 text-emerald-300 text-xs py-2 px-4 border-b border-emerald-900/50 overflow-hidden relative z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2 shrink-0 pr-4 bg-emerald-950 z-10 font-semibold text-emerald-400">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping mr-1.5"></span> LIVE INFO
                </span>
                <span class="hidden sm:inline">Harga Hari Ini:</span>
            </div>
            <div class="overflow-hidden w-full relative">
                <div class="animate-marquee whitespace-nowrap flex gap-8 items-center text-slate-200">
                    @if(isset($trashPrices) && count($trashPrices) > 0)
                        @foreach($trashPrices as $tp)
                            <span>🔥 <strong>{{ $tp->item_name }}:</strong> Rp {{ number_format($tp->buy_price, 0, ',', '.') }} / kg</span>
                            <span>•</span>
                        @endforeach
                    @else
                        <span>📢 <strong>Bank Sampah Mekarmaya:</strong> Belum ada data harga sampah terdaftar</span>
                        <span>•</span>
                    @endif
                    <span>🌱 <strong>Total Sampah Didaur Ulang:</strong> {{ number_format($totalKg ?? 0, 0, ',', '.') }} kg</span>
                    <span>•</span>
                    <span>📍 <strong>Pos Bank Sampah:</strong> Balai Desa Mekarmaya</span>

                    <!-- Duplicate for smooth loop marquee -->
                    @if(isset($trashPrices) && count($trashPrices) > 0)
                        @foreach($trashPrices as $tp)
                            <span class="pl-8">🔥 <strong>{{ $tp->item_name }}:</strong> Rp {{ number_format($tp->buy_price, 0, ',', '.') }} / kg</span>
                            <span>•</span>
                        @endforeach
                    @else
                        <span class="pl-8">📢 <strong>Bank Sampah Mekarmaya:</strong> Belum ada data harga sampah terdaftar</span>
                        <span>•</span>
                    @endif
                    <span>🌱 <strong>Total Sampah Didaur Ulang:</strong> {{ number_format($totalKg ?? 0, 0, ',', '.') }} kg</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR MODERN (GLASSMORPHISM STICKY) -->
    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/80 shadow-xs transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                @php
                    $existingLogos = glob(public_path('uploads/logo/site_logo.*'));
                    $currentLogoUrl = (!empty($existingLogos) && file_exists($existingLogos[0])) ? asset('uploads/logo/' . basename($existingLogos[0])) : null;
                @endphp
                <!-- Logo & Name -->
                <a href="{{ route('beranda') }}" class="flex items-center space-x-3 group">
                    @if($currentLogoUrl)
                        <div class="w-11 h-11 rounded-xl bg-white p-1.5 border border-slate-200 shadow-sm flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform">
                            <img src="{{ $currentLogoUrl }}?v={{ time() }}" alt="Logo Bank Sampah" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-11 h-11 bg-gradient-to-tr from-emerald-600 to-teal-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-emerald-600/20 group-hover:scale-105 transition-transform">
                            <i class="fas fa-leaf text-xl text-emerald-100 group-hover:rotate-12 transition-transform"></i>
                        </div>
                    @endif
                    <div>
                        <span class="font-extrabold text-lg text-slate-900 tracking-tight leading-none block">
                            BANK SAMPAH
                        </span>
                        <span class="text-xs font-semibold text-emerald-600 tracking-wide flex items-center gap-1 mt-0.5">
                            Desa Mekarmaya <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="#beranda" class="px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 rounded-xl transition">Beranda</a>
                    <a href="#simulasi" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Simulasi Tabungan</a>
                    <a href="#harga" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Harga Sampah</a>
                    <a href="#cara-kerja" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Cara Kerja</a>
                    <a href="{{ route('edukasi') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Edukasi</a>
                    <a href="#faq" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">FAQ</a>
                </div>

                <!-- Desktop Action Buttons -->
                <div class="hidden lg:flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-emerald-600 hover:bg-slate-100 transition duration-200">
                        <i class="fas fa-sign-in-alt mr-1.5 text-xs text-emerald-600"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/25 hover:shadow-lg hover:shadow-emerald-600/35 transition duration-200 transform hover:-translate-y-0.5">
                        <i class="fas fa-user-plus mr-1.5 text-xs"></i> Daftar Warga
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="lg:hidden flex items-center">
                    <button id="mobileMenuBtn" aria-label="Menu Mobile" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 hover:text-emerald-600 focus:outline-none cursor-pointer">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-200 bg-white/95 backdrop-blur-xl px-4 pt-3 pb-6 shadow-xl">
            <div class="flex flex-col space-y-2 text-sm font-semibold">
                <a href="#beranda" class="px-4 py-3 bg-emerald-50 text-emerald-700 rounded-xl">Beranda</a>
                <a href="#simulasi" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Simulasi Tabungan</a>
                <a href="#harga" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Harga Sampah</a>
                <a href="#cara-kerja" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Cara Kerja</a>
                <a href="{{ route('edukasi') }}" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Edukasi</a>
                <a href="#faq" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">FAQ</a>
                
                <div class="pt-4 mt-2 border-t border-slate-100 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-3 rounded-xl border border-slate-200 font-bold text-slate-800 hover:bg-slate-50">
                        Masuk Akun
                    </a>
                    <a href="{{ route('register') }}" class="w-full text-center py-3 rounded-xl font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md">
                        Daftar Warga Baru
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 3. HERO SECTION WITH REAL DATABASE METRICS -->
    <header id="beranda" class="relative pt-12 pb-24 lg:pt-20 lg:pb-32 overflow-hidden bg-gradient-to-b from-emerald-50/70 via-slate-50 to-white">
        <!-- Decorative Glow Blobs -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full pointer-events-none overflow-hidden">
            <div class="absolute -top-24 left-10 w-96 h-96 bg-emerald-300/30 rounded-full blur-3xl"></div>
            <div class="absolute top-40 right-10 w-80 h-80 bg-teal-300/20 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Hero Content -->
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-emerald-100/80 border border-emerald-200 text-emerald-800 px-4 py-1.5 rounded-full text-xs font-bold shadow-xs mb-6 tracking-wide animate-pulse-subtle">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Program Resmi Desa Mekarmaya 2026
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight lg:leading-tight">
                        Ubah Sampah Rumah Tangga Jadi <span class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 bg-clip-text text-transparent">Saldo & Keberkahan</span> Desa
                    </h1>
                    
                    <p class="mt-5 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Selamat datang di portal digital <strong class="text-slate-800">Sobat Peduli Sampah</strong>. Mari bersama menjaga kebersihan Desa Mekarmaya, pilah sampah dari rumah, dan ubah sampah bernilai ekonomi menjadi tabungan rupiah transparan langsung dari smartphone Anda!
                    </p>

                    <!-- Hero Call-to-Actions -->
                    <div class="mt-8 flex flex-col sm:flex-row justify-center lg:justify-start gap-3 sm:gap-4 max-w-md mx-auto lg:mx-0">
                        <a href="{{ route('register') }}" class="px-7 py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-lg shadow-emerald-600/30 hover:shadow-xl hover:shadow-emerald-600/40 transition duration-200 text-center flex items-center justify-center gap-2 text-base">
                            <i class="fas fa-wallet text-sm"></i> Mulai Menabung Sampah
                        </a>
                        <a href="#simulasi" class="px-6 py-3.5 rounded-xl font-bold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 shadow-sm transition duration-200 text-center flex items-center justify-center gap-2 text-base">
                            <i class="fas fa-calculator text-emerald-600"></i> Hitung Simulasi
                        </a>
                    </div>

                    <!-- Quick Trust Indicators -->
                    <div class="mt-10 pt-8 border-t border-slate-200/60 flex items-center justify-center lg:justify-start gap-6 text-xs text-slate-500 font-medium">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-600 text-sm"></i> 100% Transparan
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-600 text-sm"></i> Timbangan Akurat
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-emerald-600 text-sm"></i> Saldo Bisa Ditarik Tunai
                        </div>
                    </div>
                </div>

                <!-- Right Hero Visual Card (REAL RECENT DEPOSITS FROM DATABASE) -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        
                        <!-- Main Visual Card -->
                        <div class="bg-gradient-to-br from-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-2xl shadow-emerald-950/20 relative overflow-hidden">
                            <!-- Background Pattern -->
                            <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-emerald-500/10 rounded-full blur-2xl"></div>
                            
                            <div class="flex items-center justify-between border-b border-emerald-700/60 pb-5 mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-700/80 flex items-center justify-center text-emerald-300 font-bold border border-emerald-600/50">
                                        <i class="fas fa-recycle text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-sm">Aktivitas Terbaru Warga</h3>
                                        <p class="text-[11px] text-emerald-200">Pos Bank Sampah Mekarmaya</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 uppercase">
                                    REALTIME
                                </span>
                            </div>

                            <!-- Live Activity Highlights (REAL DATABASE QUERY) -->
                            <div class="space-y-3.5">
                                @if(isset($recentDeposits) && count($recentDeposits) > 0)
                                    @foreach($recentDeposits as $deposit)
                                        <div class="bg-emerald-900/60 rounded-2xl p-3.5 border border-emerald-700/50 flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-amber-500/20 text-amber-300 flex items-center justify-center font-bold text-xs">
                                                    ♻️
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-white">Setor {{ $deposit->trashPrice->item_name ?? 'Sampah' }}</p>
                                                    <p class="text-[10px] text-emerald-300">{{ $deposit->user->name ?? 'Warga Mekarmaya' }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs font-extrabold text-amber-300">+ Rp {{ number_format($deposit->earning, 0, ',', '.') }}</p>
                                                <p class="text-[9px] text-emerald-200">{{ number_format($deposit->weight, 1, ',', '.') }} kg</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="bg-emerald-900/40 rounded-2xl p-6 border border-emerald-700/40 text-center space-y-1">
                                        <i class="fas fa-leaf text-2xl text-emerald-400/70 mb-2"></i>
                                        <p class="text-xs font-bold text-white">Belum Ada Transaksi Setor Hari Ini</p>
                                        <p class="text-[10px] text-emerald-300">Ayo jadi warga pertama yang menyetorkan sampah di Pos Desa Mekarmaya!</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Footer Quote inside card -->
                            <div class="mt-6 pt-4 border-t border-emerald-700/40 text-center">
                                <p class="text-[11px] text-emerald-200 italic">
                                    "Kebersihan lingkungan diawali dari pemilahan sampah di dapur kita sendiri."
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- OVERVIEW METRICS CARDS (DATABASES REAL STATS) -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                
                <div class="glass-card p-5 sm:p-6 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Sampah Diterima</span>
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-tags"></i>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                        {{ count($trashPrices ?? []) }} <span class="text-sm font-bold text-slate-500">Kategori</span>
                    </h3>
                    <p class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                        <i class="fas fa-check-circle text-[9px]"></i> Terdaftar & Siap Ditimbang
                    </p>
                </div>

                <div class="glass-card p-5 sm:p-6 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sampah Terkelola</span>
                        <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-scale-balanced"></i>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                        {{ number_format($totalKg ?? 0, 0, ',', '.') }} <span class="text-sm font-bold text-slate-500">Kg</span>
                    </h3>
                    <p class="text-[11px] text-teal-600 font-semibold mt-1 flex items-center gap-1">
                        <i class="fas fa-leaf text-[9px]"></i> Didaur Ulang Bebas Sampah
                    </p>
                </div>

                <div class="glass-card p-5 sm:p-6 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Warga Terdaftar</span>
                        <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                        {{ number_format($totalWarga ?? 0, 0, ',', '.') }} <span class="text-sm font-bold text-slate-500">Akun</span>
                    </h3>
                    <p class="text-[11px] text-blue-600 font-semibold mt-1 flex items-center gap-1">
                        <i class="fas fa-home text-[9px]"></i> Warga Terdaftar Aktif
                    </p>
                </div>

                <div class="glass-card p-5 sm:p-6 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Setoran</span>
                        <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                        {{ number_format($totalSetor ?? 0, 0, ',', '.') }} <span class="text-sm font-bold text-slate-500">Kali</span>
                    </h3>
                    <p class="text-[11px] text-purple-600 font-semibold mt-1 flex items-center gap-1">
                        <i class="fas fa-clock text-[9px]"></i> Transaksi Recorded
                    </p>
                </div>

            </div>

        </div>
    </header>

    <!-- 4. KALKULATOR SIMULASI TABUNGAN AKURAT DARI HARGA REAL DATABASE -->
    <section id="simulasi" class="py-20 bg-white border-t border-b border-slate-200/70 relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="bg-emerald-100 text-emerald-800 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                    Simulasi Penghasilan Real Time
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">
                    Kalkulator Simulasi Tabungan Sampah Warga
                </h2>
                <p class="text-sm text-slate-500 mt-2">
                    Masukkan perkiraan berat (kg) untuk jenis sampah terdaftar. Perhitungan otomatis 100% mengikuti harga resmi dari database Bank Sampah Desa Mekarmaya.
                </p>
            </div>

            <!-- Multi-Item Calculator Box -->
            <div class="bg-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                <!-- Background Glow -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Left: Item Input List directly from $trashPrices -->
                    <div class="lg:col-span-7 space-y-4">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                📋 Jenis Sampah (Harga Resmi DB)
                            </span>
                            <span class="text-xs text-slate-400">
                                Estimasi Berat (Kg)
                            </span>
                        </div>

                        @if(isset($trashPrices) && count($trashPrices) > 0)
                            <div class="space-y-3 max-h-[420px] overflow-y-auto pr-1">
                                @foreach($trashPrices as $item)
                                    <div class="bg-slate-800/70 p-3.5 rounded-2xl border border-slate-700/60 flex items-center justify-between gap-3 hover:border-emerald-500/50 transition">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-950 text-emerald-400 flex items-center justify-center font-bold text-base shrink-0 border border-emerald-800/60">
                                                @if(str_contains(strtolower($item->item_name), 'tutup')) 🔘
                                                @elseif(str_contains(strtolower($item->item_name), 'bening')) 🍶
                                                @elseif(str_contains(strtolower($item->item_name), 'warna')) 🍷
                                                @elseif(str_contains(strtolower($item->item_name), 'sampo')) 🧴
                                                @elseif(str_contains(strtolower($item->item_name), 'gelas')) 🍼
                                                @elseif(str_contains(strtolower($item->item_name), 'kardus')) 📦
                                                @elseif(str_contains(strtolower($item->item_name), 'kaleng')) 🥫
                                                @elseif(str_contains(strtolower($item->item_name), 'jelantah')) 🛢️
                                                @else ⚙️ @endif
                                            </div>
                                            <div>
                                                <h4 class="text-xs sm:text-sm font-bold text-white leading-tight">
                                                    {{ $item->item_name }}
                                                </h4>
                                                <p class="text-[11px] text-emerald-400 font-semibold mt-0.5">
                                                    Rp {{ number_format($item->buy_price, 0, ',', '.') }} <span class="text-slate-400 font-normal">/ kg</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-2 shrink-0">
                                            <button type="button" onclick="adjustWeight('item-qty-{{ $item->id }}', -1)" class="w-7 h-7 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-bold flex items-center justify-center text-xs cursor-pointer">
                                                -
                                            </button>
                                            <input type="number" 
                                                   id="item-qty-{{ $item->id }}" 
                                                   data-price="{{ $item->buy_price }}" 
                                                   data-name="{{ addslashes($item->item_name) }}"
                                                   value="0" 
                                                   min="0" 
                                                   max="500"
                                                   oninput="calculateTotalSimulasi()" 
                                                   class="simulasi-qty-input w-14 bg-slate-900 border border-slate-700 rounded-lg text-center font-bold text-emerald-400 text-xs py-1 focus:outline-none focus:border-emerald-500">
                                            <button type="button" onclick="adjustWeight('item-qty-{{ $item->id }}', 1)" class="w-7 h-7 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-bold flex items-center justify-center text-xs cursor-pointer">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400 italic">Belum ada harga sampah yang terdaftar di database.</p>
                        @endif

                    </div>

                    <!-- Right: Results Card -->
                    <div class="lg:col-span-5">
                        <div class="bg-gradient-to-br from-emerald-900/90 to-slate-800 p-6 rounded-2xl border border-emerald-500/30 text-center flex flex-col justify-between h-full space-y-6">
                            
                            <div>
                                <span class="text-[11px] font-extrabold text-emerald-300 uppercase tracking-widest bg-emerald-950 px-3 py-1 rounded-full border border-emerald-500/30">
                                    TOTAL HASIL SIMULASI
                                </span>
                                
                                <div class="mt-5">
                                    <span class="text-xs text-slate-300 font-medium">Estimasi Saldo Diterima:</span>
                                    <h3 class="text-3xl sm:text-4xl font-extrabold text-amber-400 mt-1" id="grandTotalRupiah">
                                        Rp 0
                                    </h3>
                                    <p class="text-xs text-emerald-200 mt-1" id="totalWeightSummary">
                                        Total Berat: 0 Kg
                                    </p>
                                </div>
                            </div>

                            <!-- Itemized Breakdown Box -->
                            <div class="bg-slate-900/90 p-4 rounded-xl text-left border border-slate-700 space-y-2">
                                <div class="flex items-center justify-between text-xs font-bold text-emerald-400 border-b border-slate-800 pb-2">
                                    <span>Rincian Simulasi</span>
                                    <span>Subtotal</span>
                                </div>
                                <div id="breakdownList" class="space-y-1 text-xs text-slate-300 max-h-32 overflow-y-auto pr-1">
                                    <p class="text-[11px] text-slate-500 italic">Masukkan jumlah berat pada daftar di samping untuk memulai simulasi.</p>
                                </div>
                            </div>

                            <!-- Eco Impact Calculation -->
                            <div class="bg-slate-900/70 p-3.5 rounded-xl text-left border border-slate-700/70 space-y-1">
                                <h4 class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fas fa-tree text-xs"></i> Dampak Positif Desa:
                                </h4>
                                <div class="text-xs text-slate-300 space-y-1 font-medium">
                                    <p class="flex items-center justify-between">
                                        <span>📉 Emisi Karbon Dicegah:</span>
                                        <strong class="text-white" id="co2Saved">0 kg CO₂</strong>
                                    </p>
                                    <p class="flex items-center justify-between">
                                        <span>💧 Air Sungai Terjaga:</span>
                                        <strong class="text-white" id="waterSaved">0 Liter</strong>
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button type="button" onclick="resetSimulasiInputs()" class="py-3 px-4 rounded-xl font-bold text-slate-300 bg-slate-800 hover:bg-slate-700 text-xs">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                                <a href="{{ route('register') }}" class="w-full py-3 rounded-xl font-extrabold text-slate-900 bg-amber-400 hover:bg-amber-300 shadow-md transition duration-200 text-center text-xs flex items-center justify-center gap-1.5">
                                    <i class="fas fa-plus-circle"></i> Mulai Tabung Sampah Ini
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- 5. DAFTAR HARGA SAMPAH DINAMIS DARI DATABASE -->
    <section id="harga" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="bg-teal-100 text-teal-800 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                        Katalog Terupdate
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">
                        Daftar Harga Sampah Yang Diterima
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Harga transparan dan terstandarisasi untuk kenyamanan warga Desa Mekarmaya.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('banksampah') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-100/60 hover:bg-emerald-100 px-4 py-2.5 rounded-xl transition">
                        Lihat Seluruh Harga <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Prices Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @if(isset($trashPrices) && count($trashPrices) > 0)
                    @foreach($trashPrices as $item)
                        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition group">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl font-bold group-hover:bg-emerald-600 group-hover:text-white transition overflow-hidden">
                                    @if($item->image_path && file_exists(public_path($item->image_path)))
                                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->item_name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-recycle"></i>
                                    @endif
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    Aktif Diterima
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">
                                {{ $item->item_name }}
                            </h3>
                            <div class="flex items-baseline gap-1 mt-3">
                                <span class="text-2xl font-extrabold text-emerald-700">
                                    Rp {{ number_format($item->buy_price, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium">/ kg</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-3 pt-3 border-t border-slate-100 flex items-center gap-1.5">
                                <i class="fas fa-check text-emerald-500 text-[10px]"></i> Harga beli resmi pos desa
                            </p>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full bg-white rounded-2xl p-10 text-center border border-slate-200">
                        <i class="fas fa-box-open text-4xl text-slate-300 mb-3"></i>
                        <p class="text-base font-bold text-slate-700">Belum ada daftar harga sampah yang diinput oleh Admin Desa.</p>
                        <p class="text-xs text-slate-400 mt-1">Silakan hubungi administrator pos bank sampah Desa Mekarmaya.</p>
                    </div>
                @endif

            </div>

        </div>
    </section>

    <!-- 6. ALUR CARA KERJA (TIMELINE 4 LANGKAH) -->
    <section id="cara-kerja" class="py-20 bg-white border-t border-slate-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="bg-emerald-100 text-emerald-800 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                    Alur Praktis Warga
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">
                    4 Langkah Mudah Menjadi Sobat Peduli Sampah
                </h2>
                <p class="text-sm text-slate-500 mt-2">
                    Proses sederhana, praktis, dan transparan dari rumah hingga penarikan saldo tabungan Anda.
                </p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                
                <!-- Step 1 -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/70 relative hover:border-emerald-400 transition group">
                    <div class="w-12 h-12 bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-2xl font-extrabold text-lg flex items-center justify-center shadow-md shadow-emerald-600/20 mb-5 group-hover:scale-110 transition">
                        1
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base mb-2">Daftar Akun Online</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Buat akun warga secara gratis dari HP Anda lewat tombol pendaftaran. Akun langsung disetujui petugas admin desa.
                    </p>
                    <span class="mt-4 inline-block text-[11px] font-bold text-emerald-600">
                        <i class="fas fa-mobile-alt mr-1"></i> Tanpa Biaya
                    </span>
                </div>

                <!-- Step 2 -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/70 relative hover:border-emerald-400 transition group">
                    <div class="w-12 h-12 bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-2xl font-extrabold text-lg flex items-center justify-center shadow-md shadow-emerald-600/20 mb-5 group-hover:scale-110 transition">
                        2
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base mb-2">Kumpulkan & Pilah</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pisahkan sampah anorganik (botol, kardus, kaleng, minyak) dari sampah dapur organik sebelum disetor.
                    </p>
                    <span class="mt-4 inline-block text-[11px] font-bold text-emerald-600">
                        <i class="fas fa-boxes mr-1"></i> Rapih & Kering
                    </span>
                </div>

                <!-- Step 3 -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/70 relative hover:border-emerald-400 transition group">
                    <div class="w-12 h-12 bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-2xl font-extrabold text-lg flex items-center justify-center shadow-md shadow-emerald-600/20 mb-5 group-hover:scale-110 transition">
                        3
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base mb-2">Setor ke Pos Desa</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Bawa sampah ke Pos Penimbangan Desa Mekarmaya. Petugas menimbang secara transparan dan menginput ke aplikasi.
                    </p>
                    <span class="mt-4 inline-block text-[11px] font-bold text-emerald-600">
                        <i class="fas fa-balance-scale mr-1"></i> Timbangan Digital
                    </span>
                </div>

                <!-- Step 4 -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/70 relative hover:border-emerald-400 transition group">
                    <div class="w-12 h-12 bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-2xl font-extrabold text-lg flex items-center justify-center shadow-md shadow-emerald-600/20 mb-5 group-hover:scale-110 transition">
                        4
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base mb-2">Cek & Cairkan Saldo</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Saldo otomatis bertambah di dashboard akun Anda. Dapat ditarik tunai atau ditransfer saat jadwal penarikan.
                    </p>
                    <span class="mt-4 inline-block text-[11px] font-bold text-emerald-600">
                        <i class="fas fa-hand-holding-usd mr-1"></i> Langsung Jadi Cuan
                    </span>
                </div>

            </div>

        </div>
    </section>

    <!-- 7. PANDUAN INTERAKTIF: SAMPAH BISA DIJUAL VS TIDAK BISA DIJUAL -->
    <section class="py-20 bg-emerald-950 text-white relative overflow-hidden">
        <!-- Glow accents -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="bg-emerald-800 text-emerald-200 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider border border-emerald-700">
                    Panduan Pemilahan
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-3 tracking-tight">
                    Mana Sampah yang Bernilai Jual & Mana yang Residu?
                </h2>
                <p class="text-sm text-emerald-200/80 mt-2">
                    Pelajari pembeda sederhana agar sampah Anda siap ditimbang tanpa hambatan di Bank Sampah.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- BISA DIJUAL -->
                <div class="bg-emerald-900/60 rounded-3xl p-6 sm:p-8 border border-emerald-500/40 shadow-lg">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-emerald-800">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 text-emerald-950 flex items-center justify-center font-black text-xl">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-extrabold text-lg text-white">Bisa Dijual / Didaur Ulang</h3>
                            <p class="text-xs text-emerald-300">Sampah anorganik bernilai ekonomi tinggi</p>
                        </div>
                    </div>

                    <ul class="space-y-3.5 text-xs text-emerald-100">
                        <li class="flex items-start gap-3">
                            <span class="text-emerald-400 font-bold text-sm">✓</span>
                            <span><strong>Botol & Gelas Plastik:</strong> Air mineral, botol kecap/sirup (dilepas sedotannya & dikeringkan).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-emerald-400 font-bold text-sm">✓</span>
                            <span><strong>Kertas & Kardus:</strong> Kardus kemasan, koran bekas, majalah, kertas HVS putih.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-emerald-400 font-bold text-sm">✓</span>
                            <span><strong>Logam & Kaleng:</strong> Kaleng susu, seng, paku tua, besi siku, tembaga.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-emerald-400 font-bold text-sm">✓</span>
                            <span><strong>Minyak Jelantah:</strong> Minyak bekas sisa penggorengan dapur (disaring dari ampas).</span>
                        </li>
                    </ul>
                </div>

                <!-- TIDAK BISA DIJUAL (RESIDU) -->
                <div class="bg-slate-900/80 rounded-3xl p-6 sm:p-8 border border-slate-700 shadow-lg">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-800">
                        <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center font-black text-xl">
                            ✕
                        </div>
                        <div>
                            <h3 class="font-extrabold text-lg text-white">Tidak Dapat Ditimbang (Residu)</h3>
                            <p class="text-xs text-slate-400">Sampah organik / tidak memenuhi kriteria daur ulang</p>
                        </div>
                    </div>

                    <ul class="space-y-3.5 text-xs text-slate-300">
                        <li class="flex items-start gap-3">
                            <span class="text-rose-400 font-bold text-sm">✕</span>
                            <span><strong>Sampah Dapur Basah:</strong> Sisa makanan, sayur busuk, sisa sisa tulang (cocok dibuat kompos).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-rose-400 font-bold text-sm">✕</span>
                            <span><strong>Popok & Pembalut:</strong> Diaper sekali pakai, tisu basah kotor.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-rose-400 font-bold text-sm">✕</span>
                            <span><strong>Kaca Pecah / Rawan:</strong> Kaca jendela pecah (membahayakan petugas timbang).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-rose-400 font-bold text-sm">✕</span>
                            <span><strong>Plastik Terbakar / Basah Oli:</strong> Kemasan berbahan B3 atau oli kendaraan.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </section>

    <!-- 8. ARTIKEL EDUKASI REAL DARI DATABASE -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                        Edukasi Lingkungan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">
                        Artikel & Tips Praktis Desa Mekarmaya
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Tambah wawasan mengenai pengelolaan lingkungan dan ide daur ulang kreatif.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('edukasi') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 px-4 py-2.5 rounded-xl transition">
                        Lihat Artikel Lainnya <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                @if(isset($edukasis) && count($edukasis) > 0)
                    @foreach($edukasis as $edu)
                        <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 hover:shadow-md transition flex flex-col justify-between">
                            <div class="p-6">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-md">
                                    {{ $edu->category ?? 'Edukasi' }}
                                </span>
                                <h3 class="font-extrabold text-slate-900 text-base mt-3 line-clamp-2">
                                    {{ $edu->title }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                                    {{ Str::limit(strip_tags($edu->content), 120) }}
                                </p>
                            </div>
                            <div class="p-6 pt-0">
                                <a href="{{ route('edukasi') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1.5">
                                    Baca Selengkapnya <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full bg-slate-50 rounded-2xl p-10 text-center border border-slate-200">
                        <i class="fas fa-book-reader text-4xl text-slate-300 mb-3"></i>
                        <p class="text-base font-bold text-slate-700">Belum ada artikel edukasi yang dipublikasikan.</p>
                        <p class="text-xs text-slate-400 mt-1">Artikel edukasi lingkungan akan segera dipublikasikan oleh administrator desa.</p>
                    </div>
                @endif

            </div>

        </div>
    </section>

    <!-- 9. INTERACTIVE FAQ ACCORDION -->
    <section id="faq" class="py-20 bg-slate-50 border-t border-slate-200/70">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="bg-emerald-100 text-emerald-800 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                    Pusat Bantuan Warga
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 tracking-tight">
                    Pertanyaan Yang Sering Diajukan (FAQ)
                </h2>
                <p class="text-sm text-slate-500 mt-2">
                    Jawaban cepat untuk memudahkan warga Desa Mekarmaya menggunakan layanan ini.
                </p>
            </div>

            <!-- Accordion List -->
            <div class="space-y-4">
                
                <!-- Q1 -->
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleFaq('faq-1')" class="w-full p-5 text-left font-bold text-slate-900 text-sm sm:text-base flex justify-between items-center hover:text-emerald-600 transition">
                        <span>1. Bagaimana cara mendaftar akun Warga?</span>
                        <i id="faq-icon-faq-1" class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                    </button>
                    <div id="faq-1" class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Klik tombol <strong>Daftar Warga</strong> di pojok kanan atas, isi nama lengkap, nomor HP (WhatsApp), serta alamat RT/RW Anda. Setelah itu, akun Anda akan dikonfirmasi admin desa dan siap digunakan untuk transaksi setor sampah!
                    </div>
                </div>

                <!-- Q2 -->
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleFaq('faq-2')" class="w-full p-5 text-left font-bold text-slate-900 text-sm sm:text-base flex justify-between items-center hover:text-emerald-600 transition">
                        <span>2. Kapan jadwal & di mana lokasi penimbangan Bank Sampah?</span>
                        <i id="faq-icon-faq-2" class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                    </button>
                    <div id="faq-2" class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Penimbangan dilaksanakan setiap <strong>Senin & Sabtu Pukul 08:00 - 14:00 WIB</strong> bertempat di <strong>Pos Bank Sampah Balai Desa Mekarmaya</strong>. Petugas siap melayani penimbangan dengan timbangan digital transparan.
                    </div>
                </div>

                <!-- Q3 -->
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleFaq('faq-3')" class="w-full p-5 text-left font-bold text-slate-900 text-sm sm:text-base flex justify-between items-center hover:text-emerald-600 transition">
                        <span>3. Bagaimana cara mencairkan saldo tabungan saya?</span>
                        <i id="faq-icon-faq-3" class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                    </button>
                    <div id="faq-3" class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Login ke akun Anda, masuk ke menu <strong>Tarik Saldo</strong> pada dashboard warga, lalu ajukan nominal penarikan. Pengajuan akan diproses oleh Bendahara Desa dan uang dapat diambil tunai di kantor desa atau via transfer.
                    </div>
                </div>

                <!-- Q4 -->
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleFaq('faq-4')" class="w-full p-5 text-left font-bold text-slate-900 text-sm sm:text-base flex justify-between items-center hover:text-emerald-600 transition">
                        <span>4. Apakah ada batasan minimal berat sampah yang disetor?</span>
                        <i id="faq-icon-faq-4" class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                    </button>
                    <div id="faq-4" class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Tidak ada batas minimal berat! Walaupun Anda hanya membawa 0,5 kg botol atau 1 liter minyak jelantah, petugas tetap akan mencatat saldo Anda secara presisi.
                    </div>
                </div>

                <!-- Q5 -->
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs">
                    <button type="button" onclick="toggleFaq('faq-5')" class="w-full p-5 text-left font-bold text-slate-900 text-sm sm:text-base flex justify-between items-center hover:text-emerald-600 transition">
                        <span>5. Apakah sampah harus dibersihkan sebelum disetor?</span>
                        <i id="faq-icon-faq-5" class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
                    </button>
                    <div id="faq-5" class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Sangat disarankan agar sampah dalam kondisi kering dan tidak kotor berbau sisa makanan. Untuk botol air mineral, usahakan dikosongkan dari sisa cairan dan dipipihkan agar menghemat tempat.
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- 10. CALL TO ACTION BANNER (CTA) -->
    <section class="py-16 bg-gradient-to-r from-emerald-700 via-teal-700 to-emerald-800 text-white relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                Mari Bersama Wujudkan Desa Mekarmaya Bersih, Asri & Sejahtera!
            </h2>
            <p class="mt-3 text-sm sm:text-base text-emerald-100 max-w-2xl mx-auto">
                Bergabunglah dengan warga Mekarmaya yang telah memilah sampah dan merasakan manfaat tabungan rupiahnya.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-xl font-extrabold text-slate-900 bg-amber-400 hover:bg-amber-300 shadow-lg transition duration-200 text-base">
                    <i class="fas fa-user-plus mr-1.5"></i> Daftar Sekarang - Gratis!
                </a>
                <a href="{{ route('login') }}" class="px-8 py-3.5 rounded-xl font-bold text-white bg-emerald-900/60 hover:bg-emerald-900 border border-emerald-500/50 transition duration-200 text-base">
                    <i class="fas fa-sign-in-alt mr-1.5"></i> Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </section>

    <!-- 11. FOOTER MODERN -->
    <footer class="bg-slate-950 text-slate-400 py-12 border-t border-slate-800 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10 pb-10 border-b border-slate-800/80">
                
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-1 space-y-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold">
                            <i class="fas fa-leaf text-sm"></i>
                        </div>
                        <span class="font-extrabold text-white text-sm">Sobat Peduli Sampah</span>
                    </div>
                    <p class="text-slate-400 leading-relaxed">
                        Platform digital resmi pengelolaan & Bank Sampah Desa Mekarmaya demi mewujudkan lingkungan asri dan mendukung ekonomi warga.
                    </p>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="font-bold text-white uppercase text-[11px] tracking-wider mb-3">Navigasi Utama</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li><a href="#beranda" class="hover:text-emerald-400 transition">Beranda</a></li>
                        <li><a href="#simulasi" class="hover:text-emerald-400 transition">Simulasi Tabungan</a></li>
                        <li><a href="#harga" class="hover:text-emerald-400 transition">Katalog Harga Sampah</a></li>
                        <li><a href="{{ route('edukasi') }}" class="hover:text-emerald-400 transition">Artikel Edukasi</a></li>
                    </ul>
                </div>

                <!-- Col 3: Operational Hours -->
                <div>
                    <h4 class="font-bold text-white uppercase text-[11px] tracking-wider mb-3">Jadwal Operasional</h4>
                    <ul class="space-y-2 text-slate-400">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-emerald-500"></i> Sabtu & Minggu
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-clock text-emerald-500"></i> 08:00 - 12:00 WIB
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-emerald-500"></i> Pos Balai Desa Mekarmaya
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Support -->
                <div>
                    <h4 class="font-bold text-white uppercase text-[11px] tracking-wider mb-3">Pengembang & Support</h4>
                    <p class="text-slate-400 leading-relaxed mb-2">
                        Dikembangkan oleh Tim KKN Desa Mekarmaya 2026 demi transparansi tata kelola lingkungan desa.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="{{ route('login') }}" class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-300 hover:text-white hover:bg-emerald-600 transition">
                            <i class="fas fa-user-shield"></i>
                        </a>
                        <span class="text-[11px] text-slate-500">Akses Khusus Admin Pos</span>
                    </div>
                </div>

            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-slate-500">
                <p>&copy; 2026 Bank Sampah Desa Mekarmaya. All Rights Reserved.</p>
                <p class="text-[11px]">Dibuat dengan <i class="fas fa-heart text-rose-500"></i> untuk Desa Mekarmaya Bersih & Hijau.</p>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT LOGIC (100% REAL DB CALCULATION) -->
    <script>
        // 1. Mobile Menu Toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            const icon = this.querySelector('i');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                menu.classList.add('hidden');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // 2. Adjust Quantity (+ / -)
        function adjustWeight(inputId, delta) {
            const input = document.getElementById(inputId);
            if (!input) return;
            let val = parseFloat(input.value) || 0;
            val = Math.max(0, val + delta);
            input.value = val;
            calculateTotalSimulasi();
        }

        // 3. Real-time Multi-Item Calculator using DB Prices
        function calculateTotalSimulasi() {
            const inputs = document.querySelectorAll('.simulasi-qty-input');
            let grandTotal = 0;
            let totalKg = 0;
            let activeItemsCount = 0;
            let breakdownHtml = '';

            inputs.forEach(input => {
                const qty = parseFloat(input.value) || 0;
                const price = parseFloat(input.getAttribute('data-price')) || 0;
                const name = input.getAttribute('data-name') || 'Sampah';

                if (qty > 0) {
                    activeItemsCount++;
                    const subtotal = qty * price;
                    grandTotal += subtotal;
                    totalKg += qty;

                    const formattedSubtotal = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0
                    }).format(subtotal);

                    breakdownHtml += `
                        <div class="flex items-center justify-between text-xs text-slate-200">
                            <span>${qty} kg x ${name}</span>
                            <span class="font-bold text-amber-300">${formattedSubtotal}</span>
                        </div>
                    `;
                }
            });

            // Format Grand Total Rupiah
            const formattedGrandTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(grandTotal);

            document.getElementById('grandTotalRupiah').innerText = formattedGrandTotal;
            document.getElementById('totalWeightSummary').innerText = `Total Berat: ${totalKg} Kg (${activeItemsCount} Jenis Sampah)`;

            const breakdownContainer = document.getElementById('breakdownList');
            if (activeItemsCount > 0) {
                breakdownContainer.innerHTML = breakdownHtml;
            } else {
                breakdownContainer.innerHTML = `<p class="text-[11px] text-slate-500 italic">Masukkan jumlah berat pada daftar di samping untuk memulai simulasi.</p>`;
            }

            // Ecological Impact
            const co2Saved = (totalKg * 1.8).toFixed(1);
            const waterSaved = Math.round(totalKg * 6);

            document.getElementById('co2Saved').innerText = `~ ${co2Saved} kg CO₂`;
            document.getElementById('waterSaved').innerText = `~ ${waterSaved} Liter`;
        }

        function resetSimulasiInputs() {
            const inputs = document.querySelectorAll('.simulasi-qty-input');
            inputs.forEach(input => {
                input.value = 0;
            });
            calculateTotalSimulasi();
        }

        // 4. Interactive FAQ Accordion
        function toggleFaq(id) {
            const faqContent = document.getElementById(id);
            const icon = document.getElementById(`faq-icon-${id}`);
            
            if (faqContent.classList.contains('hidden')) {
                faqContent.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                faqContent.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Initialize calculation on load
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotalSimulasi();
        });
    </script>
</body>
</html>