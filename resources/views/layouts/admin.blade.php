<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - Sobat Sampah')</title>
    
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

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-900 text-white flex flex-col justify-between shrink-0 transition-transform duration-300 md:relative md:translate-x-0 md:flex shadow-xl">
        <div>
            <div class="p-6 border-b border-emerald-800">
                <h1 class="font-bold text-base leading-tight uppercase tracking-wider">Bank Sampah<br><span class="text-emerald-300 text-xs font-medium normal-case">Desa Mekarmaya</span></h1>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 {{ Route::is('admin.dashboard') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('admin.datawarga') }}" class="flex items-center space-x-3 {{ Route::is('admin.datawarga') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-user-check text-emerald-300 w-5 text-center"></i><span>Data Warga</span>
                </a>
                <a href="{{ route('admin.setor') }}" class="flex items-center space-x-3 {{ Route::is('admin.setor') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-hand-holding-heart text-emerald-300 w-5 text-center"></i><span>Setor Sampah</span>
                </a>
                <a href="{{ route('admin.setor.rekap') }}" class="flex items-center space-x-3 {{ Route::is('admin.setor.rekap') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-list-check text-emerald-300 w-5 text-center"></i><span>Rekap Setoran</span>
                </a>
                <a href="{{ route('admin.pembayaran') }}" class="flex items-center space-x-3 {{ Route::is('admin.pembayaran') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-file-invoice-dollar text-emerald-300 w-5 text-center"></i>
                    <span>Pembayaran Dana Warga</span>
                </a>
                <a href="{{ route('admin.harga.index') }}" class="flex items-center space-x-3 {{ Route::is('admin.harga.index') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-tags text-emerald-300 w-5 text-center"></i>
                    <span>Setting Harga Sampah</span>
                </a>
                <a href="{{ route('admin.kas') }}" class="flex items-center space-x-3 {{ Route::is('admin.kas') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-book text-emerald-300 w-5 text-center"></i>
                    <span>Kas Desa</span>
                </a>
                <a href="{{ route('admin.edukasi') }}" class="flex items-center space-x-3 {{ Route::is('admin.edukasi') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }} px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-graduation-cap text-emerald-300 w-5 text-center"></i>
                    <span>Kelola Edukasi</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-emerald-800 flex justify-between items-center">
            <a href="{{ route('admin.pengaturan') }}" class="text-emerald-300 hover:text-emerald-100 text-xs font-semibold px-2 py-2 flex items-center">
                <i class="fas fa-cog mr-1.5"></i>Pengaturan
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-300 hover:text-red-200 text-xs font-semibold px-2 py-2 flex items-center">
                <i class="fas fa-sign-out-alt mr-1.5"></i>Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Header -->
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex items-center justify-between px-6 z-10">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-600 focus:outline-none text-lg cursor-pointer hover:text-emerald-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider hidden sm:block">@yield('header_title', 'Loket Timbangan & Pencatatan Digital')</h2>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-400 capitalize">Role: {{ Auth::user()->role }}</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm uppercase">{{ Str::substr(Auth::user()->name, 0, 1) }}</div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-grow p-6 space-y-6 overflow-y-auto">
            @yield('content')
        </main>
        
        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400">
            &copy; 2026 Admin Bank Sampah Desa Mekarmaya. All Rights Reserved.
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
