<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Pembayaran & Tarik Saldo - Sobat Sampah</title>
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-th-large text-emerald-300 w-5 text-center"></i><span>Dashboard</span></a>
                <a href="{{ route('admin.aktivasi') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-user-check text-emerald-300 w-5 text-center"></i><span>Aktivasi Warga</span></a>
                <a href="{{ route('admin.setor') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-hand-holding-heart text-emerald-300 w-5 text-center"></i><span>Setor Sampah</span></a>
                <a href="#" class="flex items-center space-x-3 bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-file-invoice-dollar text-emerald-300 w-5 text-center"></i><span>Pembayaran Dana Nasabah</span></a>
                <a href="{{ route('admin.harga.index') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-tags text-emerald-300 w-5 text-center"></i>
                    <span>Setting Harga Sampah</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-emerald-800">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-300 text-xs font-semibold px-4 py-2 block">Keluar Sistem</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex items-center justify-between px-6 z-10">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Konfigurasi Pembayaran & Kasir Nasabah</h2>
            <span class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
        </header>

        <main class="flex-grow p-6 space-y-6 overflow-y-auto">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 space-y-4 h-fit">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider"><i class="fas fa-calendar-alt mr-2 text-emerald-600"></i>Buka Jadwal Penarikan</h3>
                    </div>
                    
                    @if(session('success_setting'))
                        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] rounded-lg font-medium shadow-xs">{{ session('success_setting') }}</div>
                    @endif

                    <form action="{{ route('admin.pembayaran.jadwal') }}" method="POST" class="space-y-4 text-xs">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nama Event / Periode Klaim</label>
                            <input type="text" name="event_name" required placeholder="Contoh: Pencairan Tabungan Idul Adha 2026" 
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label class="block font-bold text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="start_date" required class="w-full p-2.5 border border-gray-200 rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none bg-white">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block font-bold text-gray-700">Tanggal Selesai</label>
                                <input type="date" name="end_date" required class="w-full p-2.5 border border-gray-200 rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none bg-white">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 rounded-xl shadow-md transition cursor-pointer">
                            <i class="fas fa-lock-open mr-1.5"></i>Aktifkan Rentang Tanggal
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm lg:col-span-2 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50/50 text-xs font-bold text-gray-700 uppercase tracking-wider">Riwayat Konfigurasi Jadwal</div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 uppercase font-semibold border-b border-gray-100">
                                    <th class="p-4">Nama Event Pencairan</th>
                                    <th class="p-4">Rentang Waktu Akses</th>
                                    <th class="p-4 text-center">Status Gerbang</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-600">
                                @forelse($settings as $sett)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="p-4 font-bold text-gray-900">{{ $sett->event_name }}</td>
                                        <td class="p-4 font-medium">{{ \Carbon\Carbon::parse($sett->start_date)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($sett->end_date)->translatedFormat('d M Y') }}</td>
                                        <td class="p-4 text-center">
                                            @if($sett->is_active)
                                                <span class="px-2.5 py-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full"><i class="fas fa-circle-check mr-1"></i>Terbuka (Menerima Klaim)</span>
                                            @else
                                                <span class="px-2.5 py-1 text-[10px] font-bold text-gray-400 bg-gray-100 rounded-full">Selesai/Tutup</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-gray-400 py-6">Belum ada rentang tanggal pembayaran yang di-setting.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(session('success_request'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium shadow-xs"><i class="fas fa-check-circle mr-2"></i>{{ session('success_request') }}</div>
            @endif

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 bg-amber-50/60 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider flex items-center"><i class="fas fa-wallet mr-2 text-amber-600 text-sm"></i>Antrean Pengajuan Tarik Saldo (PENDING)</h3>
                    <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">{{ $requestsPending->count() }} Permohonan</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 uppercase font-semibold border-b border-gray-100">
                                <th class="p-4">Nama Warga / NIK</th>
                                <th class="p-4">Tanggal Pengajuan</th>
                                <th class="p-4 text-right">Nominal Diajukan</th>
                                <th class="p-4 text-center">Keputusan Admin (Aksi Kasir)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($requestsPending as $req)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-gray-900">{{ $req->user->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">NIK: {{ $req->user->nik }}</p>
                                    </td>
                                    <td class="p-4 text-gray-500 font-medium">{{ \Carbon\Carbon::parse($req->created_at)->translatedFormat('d M Y, H:i') }} WIB</td>
                                    <td class="p-4 text-right font-bold text-emerald-700 text-sm">Rp {{ number_format($req->total_amount, 0, ',', '.') }}</td>
                                    <td class="p-4">
                                        <form action="{{ route('admin.pembayaran.proses', $req->id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                            @csrf
                                            <input type="text" name="admin_note" placeholder="Catatan/No. Kwitansi (Opsional)" 
                                                class="px-3 py-1.5 border border-gray-200 rounded-lg text-[11px] focus:outline-none focus:ring-1 focus:ring-emerald-600 w-44">
                                            
                                            <button type="submit" name="action" value="approved" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition cursor-pointer">
                                                Setujui (Cair)
                                            </button>
                                            <button type="submit" name="action" value="rejected" class="bg-red-50 hover:bg-red-100 text-red-700 text-[11px] font-bold px-3 py-1.5 rounded-lg border border-red-200 transition cursor-pointer">
                                                Tolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-gray-400 py-10">Tidak ada permohonan penarikan saldo dalam antrean.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center"><i class="fas fa-history mr-2 text-gray-500 text-sm"></i>Riwayat Penyelesaian Transaksi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 uppercase font-semibold border-b border-gray-100">
                                <th class="p-4">Nama Warga / NIK</th>
                                <th class="p-4">Nominal</th>
                                <th class="p-4">Status Akhir</th>
                                <th class="p-4">Catatan / Alasan Admin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse($requestsHistory as $history)
                                <tr class="hover:bg-gray-50/30 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-gray-900">{{ $history->user->name }}</p>
                                        <p class="text-[10px] text-gray-400">NIK: {{ $history->user->nik }}</p>
                                    </td>
                                    <td class="p-4 font-bold text-gray-800">Rp {{ number_format($history->total_amount, 0, ',', '.') }}</td>
                                    <td class="p-4">
                                        @if($history->status === 'approved')
                                            <span class="px-2 py-0.5 text-[10px] font-semibold bg-green-50 text-green-700 border border-green-200 rounded-md">Berhasil Dicairkan</span>
                                        @else
                                            <span class="px-2 py-0.5 text-[10px] font-semibold bg-red-50 text-red-700 border border-red-200 rounded-md">Pengajuan Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-gray-500 italic">{{ $history->admin_note ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-gray-400 py-10">Belum ada rekam jejak riwayat transaksi penarikan saldo.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400">&copy; 2026 Admin Sobat Sampah Desa Mekarmaya. All Rights Reserved.</footer>
    </div>

</body>
</html>