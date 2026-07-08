<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Harga Sampah - Sobat Sampah Desa Mekarmaya</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased min-h-screen flex">

    <aside class="w-64 bg-emerald-800 text-white flex flex-col justify-between shrink-0 hidden md:flex shadow-xl">
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
                
                <a href="{{ route('warga.riwayat') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-2.5 rounded-lg font-medium transition duration-200">
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

    <div class="flex-grow flex flex-col min-w-0">
        
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex md:hidden items-center justify-between px-4 z-10">
            <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Katalog Harga Beli</h2>
            <a href="{{ route('warga.dashboard') }}" class="text-emerald-700 text-xs font-bold"><i class="fas fa-arrow-left mr-1"></i> Dashboard</a>
        </header>

        <main class="flex-grow p-4 sm:p-6 lg:p-8 space-y-6 overflow-y-auto">
            
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-lg font-bold text-gray-900">Katalog Harga Beli Sampah Terupdate</h2>
                <p class="text-xs text-gray-500 mt-0.5">Nilai nominal Rupiah di bawah dihitung per kilogram (kg) yang akan langsung dibukukan ke saldo tabungan warga.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                
                @forelse($trashPrices as $trash)
                    <div class="bg-white rounded-xl shadow-xs border border-gray-200/60 overflow-hidden text-center hover:shadow-md transition duration-200 flex flex-col justify-between">
                        
                        <div class="h-32 bg-gray-50 text-gray-400 flex items-center justify-center text-3xl border-b border-gray-100 relative">
                            @if($trash->image_path && file_exists(public_path($trash->image_path)))
                                <img src="{{ asset($trash->image_path) }}" alt="{{ $trash->item_name }}" class="w-full h-full object-contain p-3">
                            @else
                                @if(Str::contains(Str::lower($trash->item_name), 'botol'))
                                    <i class="fas fa-glass-water text-gray-300"></i>
                                @elseif(Str::contains(Str::lower($trash->item_name), 'gelas'))
                                    <i class="fas fa-cup-straw text-gray-300"></i>
                                @else
                                    <i class="fas fa-box text-gray-300"></i>
                                @endif
                            @endif
                        </div>

                        <div class="p-3.5">
                            <h4 class="font-bold text-gray-800 text-xs truncate" title="{{ $trash->item_name }}">
                                {{ $trash->item_name }}
                            </h4>
                            
                            <div class="mt-2.5 bg-emerald-50/60 p-2 rounded-lg border border-emerald-100/50">
                                <span class="text-[9px] uppercase block text-emerald-700 font-bold tracking-wider">Harga Beli Warga</span>
                                <span class="text-sm font-black text-emerald-800 block mt-0.5">
                                    Rp {{ number_format($trash->buy_price, 0, ',', '.') }} 
                                    <span class="text-[10px] font-normal text-gray-400">/kg</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-400 border border-dashed border-gray-200 bg-white rounded-2xl">
                        <i class="fas fa-tags text-2xl mb-2 text-gray-300"></i>
                        <p class="text-xs">Maaf, daftar katalog harga sampah saat ini belum tersedia.</p>
                    </div>
                @endforelse

            </div>
        </main>

        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400 shrink-0">
            &copy; 2026 Panel Warga Sobat Sampah Desa Mekarmaya. All Rights Reserved.
        </footer>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
</body>
</html>