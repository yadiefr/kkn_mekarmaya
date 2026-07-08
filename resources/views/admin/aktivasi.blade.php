<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun Warga - Sobat Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-800 antialiased min-h-screen flex">

    <!-- Overlay Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-20 bg-black/50 md:hidden"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-900 text-white flex flex-col justify-between shrink-0 transition-transform duration-300 md:relative md:translate-x-0 md:flex shadow-xl">
        <div>
            <div class="p-6 border-b border-emerald-800">
                <h1 class="font-bold text-base leading-tight uppercase tracking-wider">Sobat Sampah<br><span class="text-emerald-300 text-xs font-medium normal-case">Panel Admin Mekarmaya</span></h1>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center"></i><span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-user-check text-emerald-300 w-5 text-center"></i><span>Aktivasi Warga</span>
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
                <a href="{{ route('admin.jurnal') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-book text-emerald-300 w-5 text-center"></i>
                    <span>Jurnal & Kas</span>
                </a>
                <a href="{{ route('admin.edukasi') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-graduation-cap text-emerald-300 w-5 text-center"></i>
                    <span>Kelola Edukasi</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-emerald-800">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center space-x-3 text-red-300 hover:bg-red-900/30 hover:text-red-200 px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-sign-out-alt w-5 text-center"></i><span>Keluar Sistem</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex items-center justify-between px-6 z-10">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-600 focus:outline-none text-lg cursor-pointer hover:text-emerald-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider hidden sm:block">Manajemen Akses Akun Warga</h2>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-400 capitalize">Role: {{ Auth::user()->role }}</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm uppercase">{{ Str::substr(Auth::user()->name, 0, 1) }}</div>
            </div>
        </header>

        <main class="flex-grow p-6 space-y-6 overflow-y-auto">
            
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium shadow-sm"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
            @endif

            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                <form action="{{ route('admin.aktivasi') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <i class="fas fa-search absolute left-4 top-3.5 text-gray-400 text-xs"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari warga berdasarkan Nama Lengkap atau NIK..." 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition">
                    </div>
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold px-6 py-2.5 rounded-xl transition cursor-pointer">Cari Data</button>
                    @if(!empty($search))
                        <a href="{{ route('admin.aktivasi') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold px-4 py-2.5 rounded-xl transition flex items-center justify-center">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 bg-amber-50/60 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider flex items-center"><i class="fas fa-user-clock mr-2 text-amber-600 text-sm"></i>Menunggu Aktivasi Akses (OFF)</h3>
                    <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">{{ $wargaOff->count() }} Pendaftar</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50/70 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                                <th class="p-4">Nama Lengkap / NIK</th>
                                <th class="p-4">Kontak WhatsApp</th>
                                <th class="p-4">TTL & Gender</th>
                                <th class="p-4">Alamat Rumah</th>
                                <th class="p-4 text-center">Aksi Persetujuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($wargaOff as $w)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-gray-900">{{ $w->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">NIK: {{ $w->nik }}</p>
                                    </td>
                                    <td class="p-4 text-gray-600 font-medium"><i class="fab fa-whatsapp text-emerald-600 mr-1"></i>{{ $w->whatsapp }}</td>
                                    <td class="p-4 text-gray-500 leading-relaxed">{{ $w->tempat_lahir }}, {{ \Carbon\Carbon::parse($w->tanggal_lahir)->translatedFormat('d M Y') }}<br><span class="text-[10px] text-gray-400">{{ $w->jenis_kelamin }}</span></td>
                                    <td class="p-4 text-gray-500 max-w-xs truncate">{{ $w->alamat }}</td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <form action="{{ route('admin.aktivasi.toggle', $w->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold px-4 py-1.5 rounded-lg shadow-sm transition cursor-pointer"><i class="fas fa-user-check mr-1.5"></i>Aktifkan (ON)</button>
                                            </form>
                                            <form action="{{ route('admin.aktivasi.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun warga ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition cursor-pointer" title="Hapus Akun">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-gray-400 py-8">Tidak ada warga baru dengan akses nonaktif (OFF).</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 bg-emerald-50/60 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xs font-bold text-emerald-900 uppercase tracking-wider flex items-center"><i class="fas fa-user-shield mr-2 text-emerald-600 text-sm"></i>Akun Warga Aktif (ON)</h3>
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">{{ $wargaOn->count() }} Anggota</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50/70 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                                <th class="p-4">Nama Lengkap / NIK</th>
                                <th class="p-4">Kontak WhatsApp</th>
                                <th class="p-4">TTL & Gender</th>
                                <th class="p-4">Alamat Rumah</th>
                                <th class="p-4 text-center">Aksi Penangguhan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($wargaOn as $w)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-gray-900">{{ $w->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">NIK: {{ $w->nik }}</p>
                                    </td>
                                    <td class="p-4 text-gray-600 font-medium"><i class="fab fa-whatsapp text-emerald-600 mr-1"></i>{{ $w->whatsapp }}</td>
                                    <td class="p-4 text-gray-500 leading-relaxed">{{ $w->tempat_lahir }}, {{ \Carbon\Carbon::parse($w->tanggal_lahir)->translatedFormat('d M Y') }}<br><span class="text-[10px] text-gray-400">{{ $w->jenis_kelamin }}</span></td>
                                    <td class="p-4 text-gray-500 max-w-xs truncate">{{ $w->alamat }}</td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <form action="{{ route('admin.aktivasi.toggle', $w->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-700 text-[11px] font-bold px-3 py-1.5 rounded-lg border border-red-200 transition cursor-pointer"><i class="fas fa-user-slash mr-1.5"></i>Nonaktifkan (OFF)</button>
                                            </form>
                                            <form action="{{ route('admin.aktivasi.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun warga ini secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition cursor-pointer" title="Hapus Akun">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-gray-400 py-8">Belum ada data warga aktif atau hasil pencarian tidak ditemukan.</td></tr>
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