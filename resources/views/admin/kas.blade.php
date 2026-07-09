<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kas Desa - Panel Admin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <!-- Alpine.js -->
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

    <!-- SIDEBAR NAVIGASI -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-900 text-white flex flex-col justify-between shrink-0 transition-transform duration-300 md:relative md:translate-x-0 md:flex shadow-xl">
        <div>
            <!-- Header Sidebar -->
            <div class="p-6 border-b border-emerald-800">
                <h1 class="font-bold text-base leading-tight uppercase tracking-wider">
                    Sobat Sampah<br>
                    <span class="text-emerald-300 text-xs font-medium normal-case">Panel Admin Mekarmaya</span>
                </h1>
            </div>
            <!-- Menu Utama -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.aktivasi') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-user-check text-emerald-300 w-5 text-center"></i>
                    <span>Aktivasi Warga</span>
                </a>
                <a href="{{ route('admin.setor') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-hand-holding-heart text-emerald-300 w-5 text-center"></i>
                    <span>Setor Sampah</span>
                </a>
                <a href="{{ route('admin.pembayaran') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-file-invoice-dollar text-emerald-300 w-5 text-center"></i>
                    <span>Pembayaran Dana Nasabah</span>
                </a>
                <a href="{{ route('admin.harga.index') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-tags text-emerald-300 w-5 text-center"></i>
                    <span>Setting Harga Sampah</span>
                </a>
                <a href="{{ route('admin.kas') }}" class="flex items-center space-x-3 bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-book text-emerald-300 w-5 text-center"></i>
                    <span>Kas Desa</span>
                </a>
                <a href="{{ route('admin.edukasi') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-graduation-cap text-emerald-300 w-5 text-center"></i>
                    <span>Kelola Edukasi</span>
                </a>
            </nav>
        </div>
        <!-- Footer Sidebar (Logout) -->
        <div class="p-4 border-t border-emerald-800">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center space-x-3 text-red-300 hover:bg-red-900/30 hover:text-red-200 px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span>Keluar Sistem</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- CONTENT AREA -->
    <div class="flex-grow flex flex-col min-w-0">
        
        <!-- TOPBAR -->
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex items-center justify-between px-6 z-10">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-600 focus:outline-none text-lg cursor-pointer hover:text-emerald-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider hidden sm:block">Buku Kas Desa Bank Sampah</h2>
            </div>
            <!-- Profil Singkat Admin Dinamis -->
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <!-- Mengambil nama admin dinamis -->
                    <p class="text-xs font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-400 capitalize">Hak Akses: {{ Auth::user()->role }}</p>
                </div>
                <!-- Lingkaran avatar dinamis mengambil huruf pertama nama -->
                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm uppercase">
                    {{ Str::substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="flex-grow p-6 space-y-6 overflow-y-auto">
            
            <!-- ROW 1: KARTU STATISTIK & KAS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Total Kas Masuk -->
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Kas Masuk</p>
                        <h3 class="text-lg font-bold text-gray-900 mt-1">Rp {{ number_format($kasMasuk, 0, ',', '.') }}</h3>
                        <p class="text-[10px] text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i>Penjualan ke Pengepul</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-lg"><i class="fas fa-arrow-trend-up"></i></div>
                </div>
                <!-- Total Kas Keluar -->
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Kas Keluar</p>
                        <h3 class="text-lg font-bold text-gray-900 mt-1">Rp {{ number_format($kasKeluar, 0, ',', '.') }}</h3>
                        <p class="text-[10px] text-red-500 mt-1"><i class="fas fa-arrow-down mr-1"></i>Pembayaran ke Warga</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-lg"><i class="fas fa-arrow-trend-down"></i></div>
                </div>
                <!-- Sisa Saldo Kas -->
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Saldo Kas Aktif</p>
                        <h3 class="text-xl font-bold text-emerald-700 mt-1">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
                        <p class="text-[10px] text-gray-400 mt-1">Posisi Kas Saat Ini</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg"><i class="fas fa-wallet"></i></div>
                </div>
            </div>

            <!-- ROW 2: TABEL KAS TRANSAKSI -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider"><i class="fas fa-list-ol mr-2 text-emerald-600"></i>Riwayat Kas Transaksi</h4>
                    <a href="{{ route('admin.kas.export') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-[11px] font-bold shadow-sm transition flex items-center">
                        <i class="fas fa-download mr-2"></i> Ekspor Laporan
                    </a>
                </div>
                
                <!-- Filter Section (Mockup) -->
                <div class="p-4 border-b border-gray-50 flex gap-3 flex-wrap">
                    <select class="px-3 py-2 border border-gray-200 rounded-lg text-[11px] text-gray-600 focus:outline-none focus:border-emerald-500">
                        <option>Bulan Ini (Juli 2026)</option>
                        <option>Bulan Lalu (Juni 2026)</option>
                        <option>Semua Waktu</option>
                    </select>
                    <select class="px-3 py-2 border border-gray-200 rounded-lg text-[11px] text-gray-600 focus:outline-none focus:border-emerald-500">
                        <option>Semua Transaksi</option>
                        <option>Kas Masuk</option>
                        <option>Kas Keluar</option>
                    </select>
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
                                    <td colspan="5" class="text-center py-10 text-gray-400">Belum ada riwayat transaksi kas tercatat.</td>
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

        </main>

        <!-- FOOTER PANEL -->
        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400">
            &copy; 2026 Admin Sobat Sampah Desa Mekarmaya. All Rights Reserved.
        </footer>
    </div>

</body>
</html>
