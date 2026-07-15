<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bank Sampah Desa Mekarmaya')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    
    @stack('styles')
</head>
<body x-data="{ sidebarOpen: false, @yield('x-data-extra') }" class="bg-gray-100 text-gray-800 antialiased min-h-screen flex">

    <!-- Overlay Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-20 bg-black/50 md:hidden"></div>

    <!-- SIDEBAR NAVIGASI WARGA -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-800 text-white flex flex-col justify-between shrink-0 transition-transform duration-300 md:relative md:translate-x-0 md:flex shadow-xl">
        <div>
            <div class="p-6 border-b border-emerald-700">
                <h1 class="font-bold text-sm leading-tight uppercase tracking-wider">
                    BANK SAMPAH<br>
                    <span class="text-emerald-300 text-xs font-medium normal-case">Tabungan Desa Mekarmaya</span>
                </h1>
            </div>
            <!-- Menu Utama Warga -->
            <nav class="p-4 space-y-1 text-xs">
                <!-- Dashboard Utama -->
                <a href="{{ route('warga.dashboard') }}" class="flex items-center space-x-3 {{ Route::is('warga.dashboard') ? 'bg-emerald-900 text-white font-semibold' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white font-medium' }} px-4 py-2.5 rounded-lg transition duration-200">
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Dashboard Utama</span>
                </a>
                
                <!-- Riwayat Transaksi -->
                <a href="{{ route('warga.riwayat') }}" class="flex items-center space-x-3 {{ Route::is('warga.riwayat') ? 'bg-emerald-900 text-white font-semibold' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white font-medium' }} px-4 py-2.5 rounded-lg transition duration-200">
                    <i class="fas fa-history text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Riwayat Transaksi</span>
                </a>

                <!-- Harga Sampah -->
                <a href="{{ route('warga.harga') }}" class="flex items-center space-x-3 {{ Route::is('warga.harga') ? 'bg-emerald-900 text-white font-semibold' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white font-medium' }} px-4 py-2.5 rounded-lg transition duration-200">
                    <i class="fas fa-tags text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Harga Sampah</span>
                </a>

                <!-- Tarik Saldo -->
                <a href="{{ route('warga.tarik') }}" class="flex items-center space-x-3 {{ Route::is('warga.tarik') ? 'bg-emerald-900 text-white font-semibold' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white font-medium' }} px-4 py-2.5 rounded-lg transition duration-200">
                    <i class="fas fa-money-bill-wave text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Tarik Saldo</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-emerald-700 text-xs">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center space-x-3 text-red-300 hover:bg-red-900/30 hover:text-red-200 px-4 py-2.5 rounded-lg font-semibold transition duration-200">
                <i class="fas fa-sign-out-alt w-5 text-center text-sm"></i>
                <span>Keluar Sistem</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- CONTENT AREA WRAPPER -->
    <div class="flex-grow flex flex-col min-w-0">
        
        <!-- TOPBAR MOBILE NAV -->
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex md:hidden items-center justify-between px-4 z-10">
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = true" class="text-gray-600 focus:outline-none text-lg cursor-pointer hover:text-emerald-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">@yield('header_title', 'Bank Sampah Warga')</h2>
            </div>
            <div class="flex items-center space-x-3">
                @yield('header_right')
            </div>
        </header>

        <!-- MAIN CONTENT CONTAINER -->
        <main class="flex-grow p-4 sm:p-6 lg:p-8 space-y-6 overflow-y-auto">
            @yield('content')
        </main>
        
        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400 shrink-0">
            &copy; 2026 Bank Sampah Desa Mekarmaya. All Rights Reserved.
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
