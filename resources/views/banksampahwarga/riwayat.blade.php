<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Sobat Sampah Desa Mekarmaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <!-- Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-800 antialiased min-h-screen flex">

    <!-- Overlay Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-20 bg-black/50 md:hidden"></div>

    <!-- SIDEBAR NAVIGASI WARGA -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-800 text-white flex flex-col justify-between shrink-0 transition-transform duration-300 md:relative md:translate-x-0 md:flex shadow-xl">
        <div>
            <div class="p-6 border-b border-emerald-700">
                <h1 class="font-bold text-sm leading-tight uppercase tracking-wider">
                    SOBAT SAMPAH<br>
                    <span class="text-emerald-300 text-xs font-medium normal-case">Tabungan Warga Mekarmaya</span>
                </h1>
            </div>
            <nav class="p-4 space-y-1 text-xs">
                <a href="{{ route('warga.dashboard') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-2.5 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Dashboard Utama</span>
                </a>
                <!-- Riwayat Transaksi Aktif -->
                <a href="#" class="flex items-center space-x-3 bg-emerald-900 text-white px-4 py-2.5 rounded-lg font-semibold transition duration-200">
                    <i class="fas fa-history text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Riwayat Transaksi</span>
                </a>
                <!-- Cari menu Harga Sampah di sidebar dashboardwarga dan riwayat, lalu ubah route-nya -->
                <a href="{{ route('warga.harga') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-2.5 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-tags text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Harga Sampah</span>
                </a>
                <a href="{{ route('warga.tarik') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-2.5 rounded-lg font-medium transition duration-200">
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
                <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Riwayat Pembukuan</h2>
            </div>
            <a href="{{ route('warga.dashboard') }}" class="text-emerald-700 text-xs font-bold"><i class="fas fa-arrow-left mr-1"></i> Dashboard</a>
        </header>

        <!-- MAIN CONTENT CONTAINER -->
        <main class="flex-grow p-4 sm:p-6 lg:p-8 space-y-6 overflow-y-auto">
            
            <!-- Judul Halaman & Tab Kontrol -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4 gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Buku Rekening Tabungan</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pantau semua catatan mutasi masuk dan pencairan dana Anda secara transparan.</p>
                </div>
                
                <!-- Navigasi Tab Alternatif -->
                <div class="flex bg-gray-200/70 p-1 rounded-xl text-xs font-semibold w-full sm:w-auto">
                    <button onclick="switchTab('setor')" id="tabSetor" class="flex-1 sm:flex-initial px-4 py-2 rounded-lg bg-white text-emerald-800 shadow-xs transition cursor-pointer">
                        <i class="fas fa-arrow-down-long mr-1.5 text-[10px] text-emerald-600"></i>Riwayat Setor
                    </button>
                    <button onclick="switchTab('tarik')" id="tabTarik" class="flex-1 sm:flex-initial px-4 py-2 rounded-lg text-gray-500 hover:text-gray-800 transition cursor-pointer">
                        <i class="fas fa-arrow-up-long mr-1.5 text-[10px] text-red-500"></i>Riwayat Pencairan
                    </button>
                </div>
            </div>

            <!-- TAB 1: RIWAYAT SETOR SAMPAH -->
            <div id="contentSetor" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden block">
                <div class="p-4 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Daftar Setor Sampah (Mutasi Masuk)</span>
                    <span class="text-[10px] bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded border border-emerald-100">{{ count($setorHistory) }} Transaksi</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                                <th class="p-4">Waktu Transaksi</th>
                                <th class="p-4">Nama Barang</th>
                                <th class="p-4 text-center">Timbangan (Kg)</th>
                                <th class="p-4 text-center">Harga / Kg</th>
                                <th class="p-4 text-center">Status Pencairan</th>
                                <th class="p-4 text-right">Earning</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse($setorHistory as $item)
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="p-4 font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y - H:i') }} WIB
                                    </td>
                                    <td class="p-4 capitalize font-semibold text-gray-800">{{ $item->item_name }}</td>
                                    <td class="p-4 text-center">{{ number_format($item->weight, 2, ',', '.') }} Kg</td>
                                    <td class="p-4 text-center text-gray-400">Rp {{ number_format($item->price_per_kg, 0, ',', '.') }}</td>
                                    <td class="p-4 text-center">
                                        @if($item->withdrawal_status === 'belum_ditarik')
                                            <span class="px-2 py-0.5 text-[10px] bg-amber-50 text-amber-700 font-medium rounded border border-amber-100">Belum Diambil</span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] bg-emerald-50 text-emerald-700 font-medium rounded border border-emerald-100">Sudah Tunai</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right font-bold text-emerald-600">+ Rp {{ number_format($item->earning, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-gray-400">
                                        <i class="fas fa-receipt text-2xl block mb-2 text-gray-300"></i>
                                        Belum ditemukan adanya catatan riwayat setoran sampah Anda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: RIWAYAT PENARIKAN SALDO -->
            <div id="contentTarik" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hidden">
                <div class="p-4 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Daftar Pencairan Dana (Mutasi Keluar)</span>
                    <span class="text-[10px] bg-red-50 text-red-700 font-bold px-2 py-0.5 rounded border border-red-100">{{ count($tarikHistory) }} Transaksi</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                                <th class="p-4">Waktu Penarikan</th>
                                <th class="p-4">Metode Penarikan</th>
                                <th class="p-4">Keterangan Nota</th>
                                <th class="p-4 text-center">Status Keuangan</th>
                                <th class="p-4 text-right">Jumlah Dicairkan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse($tarikHistory as $item)
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="p-4 font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y - H:i') }} WIB
                                    </td>
                                    <td class="p-4 font-medium"><span class="bg-blue-50 text-blue-700 border border-blue-100 px-2 py-0.5 rounded text-[10px]">Tunai di Pos</span></td>
                                    <td class="p-4 text-gray-400">Pencairan untuk setoran jenis {{ $item->item_name }} ({{ $item->weight }} Kg)</td>
                                    <td class="p-4 text-center">
                                        <span class="px-2 py-0.5 text-[10px] bg-gray-100 text-gray-600 font-medium rounded border border-gray-200">Selesai (Success)</span>
                                    </td>
                                    <td class="p-4 text-right font-bold text-red-600">- Rp {{ number_format($item->earning, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-gray-400">
                                        <i class="fas fa-hand-holding-dollar text-2xl block mb-2 text-gray-300"></i>
                                        Anda belum pernah mencairkan saldo tabungan sampah sejauh ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <!-- FOOTER PANEL -->
        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400 shrink-0">
            &copy; 2026 Panel Warga Sobat Sampah Desa Mekarmaya. All Rights Reserved.
        </footer>
    </div>

    <!-- JAVASCRIPT UNTUK SWITCHER TAB TANPA RELOAD -->
    <script>
        function switchTab(type) {
            let tabSetor = document.getElementById('tabSetor');
            let tabTarik = document.getElementById('tabTarik');
            let contentSetor = document.getElementById('contentSetor');
            let contentTarik = document.getElementById('contentTarik');

            if (type === 'setor') {
                // Aktifkan Tab Setor
                tabSetor.className = "flex-1 sm:flex-initial px-4 py-2 rounded-lg bg-white text-emerald-800 shadow-xs transition cursor-pointer";
                tabTarik.className = "flex-1 sm:flex-initial px-4 py-2 rounded-lg text-gray-500 hover:text-gray-800 transition cursor-pointer";
                // Tampilkan Konten Setor
                contentSetor.classList.replace('hidden', 'block');
                contentTarik.classList.replace('block', 'hidden');
            } else {
                // Aktifkan Tab Tarik
                tabTarik.className = "flex-1 sm:flex-initial px-4 py-2 rounded-lg bg-white text-emerald-800 shadow-xs transition cursor-pointer";
                tabSetor.className = "flex-1 sm:flex-initial px-4 py-2 rounded-lg text-gray-500 hover:text-gray-800 transition cursor-pointer";
                // Tampilkan Konten Tarik
                contentTarik.classList.replace('hidden', 'block');
                contentSetor.classList.replace('block', 'hidden');
            }
        }
    </script>

    <!-- FORM LOGOUT SINKRONISASI -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
</body>
</html>