<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Setor Sampah - Sobat Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased min-h-screen flex">

    <aside class="w-64 bg-emerald-900 text-white flex flex-col justify-between shrink-0 hidden md:flex shadow-xl">
        <div>
            <div class="p-6 border-b border-emerald-800">
                <h1 class="font-bold text-base leading-tight uppercase tracking-wider">Sobat Sampah<br><span class="text-emerald-300 text-xs font-medium normal-case">Panel Admin Mekarmaya</span></h1>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('admin.aktivasi') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-user-check text-emerald-300 w-5 text-center"></i><span>Aktivasi Warga</span>
                </a>
                <a href="{{ route('admin.setor') }}" class="flex items-center space-x-3 bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-hand-holding-heart text-emerald-300 w-5 text-center"></i><span>Setor Sampah</span>
                </a>
                <a href="{{ route('admin.pembayaran') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-file-invoice-dollar text-emerald-300 w-5 text-center"></i>
                    <span>Pembayaran Dana Nasabah</span>
                </a>
                <a href="{{ route('admin.harga.index') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-tags text-emerald-300 w-5 text-center"></i>
                    <span>Setting Harga Sampah</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-emerald-800">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-300 hover:text-red-200 text-xs font-semibold px-4 py-2 block">Keluar Sistem</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex items-center justify-between px-6 z-10">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Loket Timbangan & Pencatatan Digital</h2>
            <span class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        </header>

        <main class="flex-grow p-6 space-y-6 overflow-y-auto">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium shadow-xs"><i class="fas fa-circle-check mr-2"></i>{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 space-y-4 h-fit">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Form Nota Setoran</h3>
                    </div>

                    <form action="{{ route('admin.setor.simpan') }}" method="POST" class="space-y-4 text-xs">
                        @csrf
                        
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nama Warga Penabung</label>
                            <select name="user_id" required class="w-full p-2.5 border border-gray-200 bg-white rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                <option value="" disabled selected>-- Pilih Warga Mekarmaya --</option>
                                @foreach($wargaList as $warga)
                                    <option value="{{ $warga->id }}">{{ $warga->name }} (NIK: {{ $warga->nik }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Jenis Sampah Anorganik</label>
                            <select name="trash_price_id" id="trash_price_id" required class="w-full p-2.5 border border-gray-200 bg-white rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                <option value="" disabled selected>-- Kategori & Harga Beli --</option>
                                @foreach($sampahList as $sampah)
                                    <option value="{{ $sampah->id }}">
                                        {{ $sampah->item_name }} (Rp {{ number_format($sampah->buy_price, 0, ',', '.') }}/Kg)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Berat Hasil Timbangan (Kg)</label>
                            <div class="relative">
                                <input type="number" step="0.01" min="0.01" name="weight" required placeholder="0.00" 
                                    class="w-full pl-4 pr-12 py-2.5 border border-gray-200 rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none font-semibold text-gray-900">
                                <span class="absolute right-4 top-3 text-gray-400 font-bold text-[11px]">KG</span>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Catatan Kondisi (Opsional)</label>
                            <input type="text" name="note" placeholder="Misal: Sudah bersih dari label kemasan" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 rounded-xl shadow-md transition duration-150 mt-2 cursor-pointer">
                            <i class="fas fa-file-invoice mr-2"></i>Cetak & Bukukan Setoran
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm lg:col-span-2 overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">10 Transaksi Terakhir Hari Ini</h3>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                                        <th class="p-4">Warga</th>
                                        <th class="p-4">Jenis Sampah</th>
                                        <th class="p-4 text-center">Timbangan</th>
                                        <th class="p-4 text-right">Tabungan Masuk</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-600">
                                    @forelse($recentDeposits as $deposit)
                                        <tr class="hover:bg-gray-50/40 transition">
                                            <td class="p-4">
                                                <p class="font-bold text-gray-900">{{ $deposit->user->name }}</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($deposit->created_at)->diffForHumans() }}</p>
                                            </td>
                                            <td class="p-4">
                                                <p class="font-medium text-gray-800 capitalize">{{ $deposit->trashPrice->item_name }}</p>
                                                <p class="text-[10px] text-gray-400">@ Rp {{ number_format($deposit->price_per_kg, 0, ',', '.') }}/kg</p>
                                            </td>
                                            <td class="p-4 text-center font-bold text-gray-800">{{ number_format($deposit->weight, 2, ',', '.') }} Kg</td>
                                            <td class="p-4 text-right font-bold text-emerald-600">+ Rp {{ number_format($deposit->earning, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-12 text-gray-400">
                                                <i class="fas fa-boxes-stacked text-xl mb-2 text-gray-300 block"></i>
                                                Belum ada catatan aktivitas timbangan masuk untuk hari ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400">&copy; 2026 Admin Sobat Sampah Desa Mekarmaya. All Rights Reserved.</footer>
    </div>

</body>
</html>