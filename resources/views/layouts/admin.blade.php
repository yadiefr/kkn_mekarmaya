<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - Bank Sampah')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8fafc;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Global UI Premium Upgrades */
        .bg-white {
            transition: all 0.25s ease-in-out;
        }
        /* Input & Select fields premium design */
        input[type="text"], input[type="password"], input[type="email"], input[type="number"], input[type="date"], select, textarea {
            border-radius: 0.75rem !important;
            border-color: #e2e8f0 !important;
            padding-top: 0.625rem !important;
            padding-bottom: 0.625rem !important;
            font-size: 0.75rem !important;
            transition: all 0.2s ease-in-out !important;
        }
        input[type="text"]:focus, input[type="password"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="date"]:focus, select:focus, textarea:focus {
            border-color: #10b981 !important;
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12) !important;
        }
        /* Premium Table Design */
        table th {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-weight: 700 !important;
            color: #64748b !important;
            letter-spacing: 0.05em !important;
            padding: 0.875rem 1rem !important;
            background-color: #f8fafc !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }
        table td {
            padding: 0.875rem 1rem !important;
            vertical-align: middle !important;
        }
        table tbody tr {
            transition: background-color 0.15s ease-in-out;
        }
        table tbody tr:hover {
            background-color: rgba(241, 245, 249, 0.4) !important;
        }
        /* Cards styling consistency */
        .bg-white.rounded-xl {
            border-radius: 1rem !important;
            border-color: #f1f5f9 !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02), 0 1px 2px -1px rgba(0, 0, 0, 0.02) !important;
        }
        .bg-white.rounded-2xl {
            border-color: #f1f5f9 !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02), 0 1px 2px -1px rgba(0, 0, 0, 0.02) !important;
        }
        /* Buttons styling consistency */
        .bg-emerald-600, .bg-emerald-700, .bg-teal-600, .bg-blue-600, .bg-amber-500, .bg-red-650, .bg-red-600 {
            border-radius: 0.75rem !important;
            transition: all 0.2s ease-in-out !important;
        }
        /* Modals glassmorphic blur backdrop */
        .fixed.inset-0.bg-black\/40, .fixed.inset-0.bg-black\/50, .fixed.inset-0.bg-slate-900\/60 {
            backdrop-filter: blur(4px) !important;
            background-color: rgba(15, 23, 42, 0.4) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body x-data="{ sidebarOpen: false, @yield('x-data-extra') }" class="text-slate-800 antialiased min-h-screen flex bg-[#f8fafc]">

    <!-- Overlay Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-xs md:hidden"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 h-screen bg-slate-950 text-white flex flex-col justify-between shrink-0 transition-transform duration-300 md:sticky md:top-0 md:translate-x-0 border-r border-slate-900 shadow-xl overflow-hidden">
        <div class="flex flex-col flex-1 min-h-0 overflow-y-auto">
            <!-- Brand Header with soft emerald highlight -->
            <div class="p-6 border-b border-slate-900 flex items-center space-x-3 shrink-0">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-recycle text-white text-base"></i>
                </div>
                <div>
                    <h1 class="font-bold text-xs leading-none uppercase tracking-wider text-slate-100">Bank Sampah</h1>
                    <span class="text-[10px] text-emerald-400 font-semibold tracking-wide normal-case mt-0.5 block">Desa Mekarmaya</span>
                </div>
            </div>
            
            <!-- Menu Navigation -->
            <nav class="p-4 space-y-1.5 flex-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 {{ Route::is('admin.dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/10 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 font-semibold' }} px-4 py-2.5 rounded-xl text-xs tracking-wide transition-all duration-200">
                    <i class="fas fa-th-large w-5 text-center text-sm"></i>
                    <span>Dashboard</span>
                </a>
                
                <!-- Data Warga -->
                <a href="{{ route('admin.datawarga') }}" class="flex items-center space-x-3 {{ Route::is('admin.datawarga*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/10 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 font-semibold' }} px-4 py-2.5 rounded-xl text-xs tracking-wide transition-all duration-200">
                    <i class="fas fa-user-check w-5 text-center text-sm"></i>
                    <span>Data Warga</span>
                </a>
                
                <!-- Setor Sampah -->
                <a href="{{ route('admin.setor') }}" class="flex items-center space-x-3 {{ Route::is('admin.setor') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/10 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 font-semibold' }} px-4 py-2.5 rounded-xl text-xs tracking-wide transition-all duration-200">
                    <i class="fas fa-hand-holding-heart w-5 text-center text-sm"></i>
                    <span>Setor Sampah</span>
                </a>
                
                <!-- Rekap Setoran -->
                <a href="{{ route('admin.setor.rekap') }}" class="flex items-center space-x-3 {{ Route::is('admin.setor.rekap') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/10 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 font-semibold' }} px-4 py-2.5 rounded-xl text-xs tracking-wide transition-all duration-200">
                    <i class="fas fa-list-check w-5 text-center text-sm"></i>
                    <span>Rekap Setoran</span>
                </a>
                
                <!-- Pembayaran Dana Warga -->
                <a href="{{ route('admin.pembayaran') }}" class="flex items-center space-x-3 {{ Route::is('admin.pembayaran*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/10 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 font-semibold' }} px-4 py-2.5 rounded-xl text-xs tracking-wide transition-all duration-200">
                    <i class="fas fa-file-invoice-dollar w-5 text-center text-sm"></i>
                    <span>Pembayaran Dana Warga</span>
                </a>
                
                <!-- Setting Harga Sampah -->
                <a href="{{ route('admin.harga.index') }}" class="flex items-center space-x-3 {{ Route::is('admin.harga*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/10 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 font-semibold' }} px-4 py-2.5 rounded-xl text-xs tracking-wide transition-all duration-200">
                    <i class="fas fa-tags w-5 text-center text-sm"></i>
                    <span>Setting Harga Sampah</span>
                </a>
                
                <!-- Kas Desa -->
                <a href="{{ route('admin.kas') }}" class="flex items-center space-x-3 {{ Route::is('admin.kas*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/10 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 font-semibold' }} px-4 py-2.5 rounded-xl text-xs tracking-wide transition-all duration-200">
                    <i class="fas fa-book w-5 text-center text-sm"></i>
                    <span>Kas Desa</span>
                </a>
                
                <!-- Kelola Edukasi -->
                <a href="{{ route('admin.edukasi') }}" class="flex items-center space-x-3 {{ Route::is('admin.edukasi*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-600/10 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 font-semibold' }} px-4 py-2.5 rounded-xl text-xs tracking-wide transition-all duration-200">
                    <i class="fas fa-graduation-cap w-5 text-center text-sm"></i>
                    <span>Kelola Halaman Edukasi</span>
                </a>
            </nav>
        </div>
        
        <!-- Bottom Panel -->
        <div class="p-4 border-t border-slate-900 flex justify-between items-center bg-slate-950 shrink-0">
            <a href="{{ route('admin.pengaturan') }}" class="flex items-center space-x-1.5 text-xs {{ Route::is('admin.pengaturan*') ? 'text-emerald-400 font-bold' : 'text-slate-400 hover:text-slate-100 font-semibold' }} px-2 py-1.5 rounded-lg transition">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center space-x-1.5 text-xs text-red-400 hover:text-red-300 font-semibold px-2 py-1.5 rounded-lg transition">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-md h-16 border-b border-slate-100 flex items-center justify-between px-6 z-10 sticky top-0">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="md:hidden text-slate-500 focus:outline-none text-lg cursor-pointer hover:text-emerald-600 transition">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider hidden sm:block">@yield('header_title', 'Loket Timbangan & Pencatatan Digital')</h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] text-emerald-600 font-semibold tracking-wider uppercase mt-0.5">Admin Desa</p>
                </div>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs uppercase shadow-xs">
                    {{ Str::substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-grow p-6 space-y-6 overflow-y-auto">
            @yield('content')
        </main>
        
        <footer class="bg-white h-12 border-t border-slate-100 flex items-center justify-center text-[10px] text-slate-400">
            &copy; 2026 Admin Bank Sampah Desa Mekarmaya. All Rights Reserved.
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
