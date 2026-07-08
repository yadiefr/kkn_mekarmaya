<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warga - Sobat Sampah Desa Mekarmaya</title>
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
            <!-- Menu Utama Warga -->
            <nav class="p-4 space-y-1 text-xs">
                <!-- Dashboard Utama -->
                <a href="#" class="flex items-center space-x-3 bg-emerald-900 text-white px-4 py-2.5 rounded-lg font-semibold transition duration-200">
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Dashboard Utama</span>
                </a>
                
                <!-- Riwayat Transaksi (Ditambahkan kembali sesuai permintaan) -->
                <a href="{{ route('warga.riwayat') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-2.5 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-history text-emerald-300 w-5 text-center text-sm"></i>
                    <span>Riwayat Transaksi</span>
                </a>

               <!-- Cek di file dashboardwarga dan riwayat, pastikan sudah ada route('banksampah') -->
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
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex md:hidden items-center justify-between px-4 z-10">
            <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Sobat Sampah Warga</h2>
            <div class="flex items-center space-x-3">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-500 hover:text-red-600 text-sm">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </header>

        <main class="flex-grow p-4 sm:p-6 lg:p-8 space-y-6 overflow-y-auto">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded uppercase tracking-wider">Akun Warga Aktif</span>
                    <h2 class="text-lg font-bold text-gray-900 mt-2">Selamat Datang, {{ $user->name }}</h2>
                    <p class="text-xs text-gray-500 mt-0.5">NIK: {{ $user->nik }} | Alamat: {{ $user->alamat }}</p>
                </div>
                <div class="bg-emerald-50 border border-emerald-100 px-6 py-4 rounded-xl text-right w-full sm:w-auto">
                    <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Total Saldo Tabungan</p>
                    <p class="text-2xl font-black text-emerald-700 mt-1">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm lg:col-span-2 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Riwayat Setoran Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                                    <th class="p-4">Tanggal</th>
                                    <th class="p-4">Jenis Sampah</th>
                                    <th class="p-4 text-center">Berat (Kg)</th>
                                    <th class="p-4 text-center">Status Pembukuan</th>
                                    <th class="p-4 text-right">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-600">
                                @forelse($deposits as $deposit)
                                    <tr>
                                        <td class="p-4 font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($deposit->created_at)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="p-4 capitalize">{{ $deposit->item_name }}</td>
                                        <td class="p-4 text-center font-semibold">{{ number_format($deposit->weight, 2, ',', '.') }} Kg</td>
                                        <td class="p-4 text-center">
                                            @if($deposit->withdrawal_status === 'belum_ditarik')
                                                <span class="px-2 py-0.5 text-[10px] bg-amber-50 text-amber-700 font-medium rounded border border-amber-100/70">Dapat Ditarik</span>
                                            @else
                                                <span class="px-2 py-0.5 text-[10px] bg-gray-100 text-gray-500 font-medium rounded border border-gray-200">Sudah Dicairkan</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-right font-bold text-emerald-600">
                                            + Rp {{ number_format($deposit->earning, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-8 text-center text-gray-400">
                                            <i class="fas fa-receipt text-xl block mb-2 text-gray-300"></i>
                                            Belum ada riwayat menabung sampah. Mari pilah sampahmu hari ini!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">Kontribusi Lingkungan Anda</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm"><i class="fas fa-scale-balanced"></i></div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-800">Total Sampah Terolah</h4>
                                        <p class="text-[10px] text-gray-400">Akumulasi seluruh setoran</p>
                                    </div>
                                </div>
                                <span class="text-sm font-black text-gray-900">
                                    {{ number_format($totalBerat, 1, ',', '.') }} <span class="text-[10px] font-normal text-gray-400">Kg</span>
                                </span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-sm"><i class="fas fa-hand-holding-dollar"></i></div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-800">Total Pencairan</h4>
                                        <p class="text-[10px] text-gray-400">Penarikan tunai sukses</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-red-600">Rp {{ number_format($totalDicairkan, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            <i class="fas fa-leaf text-emerald-600 mr-1"></i> Dengan menyetor sampah, Anda telah membantu menyelamatkan Desa Mekarmaya dari penumpukan limbah anorganik berbahaya. Terima kasih!
                        </p>
                    </div>
                </div>

            </div>

        </main>

        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400 shrink-0">
            &copy; 2026 Panel Warga Sobat Sampah Desa Mekarmaya. All Rights Reserved.
        </footer>
    </div>

</body>
</html>