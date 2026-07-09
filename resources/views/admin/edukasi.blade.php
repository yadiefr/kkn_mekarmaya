<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Edukasi - Panel Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
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
                    <i class="fas fa-th-large text-emerald-300 w-5 text-center"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('admin.aktivasi') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-user-check text-emerald-300 w-5 text-center"></i><span>Aktivasi Warga</span>
                </a>
                <a href="{{ route('admin.setor') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-hand-holding-heart text-emerald-300 w-5 text-center"></i><span>Setor Sampah</span>
                </a>
                <a href="{{ route('admin.pembayaran') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-file-invoice-dollar text-emerald-300 w-5 text-center"></i><span>Pembayaran Dana Nasabah</span>
                </a>
                <a href="{{ route('admin.harga.index') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-tags text-emerald-300 w-5 text-center"></i><span>Setting Harga Sampah</span>
                </a>
                <a href="{{ route('admin.kas') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-book text-emerald-300 w-5 text-center"></i><span>Kas Desa</span>
                </a>
                <a href="{{ route('admin.edukasi') }}" class="flex items-center space-x-3 bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-graduation-cap text-emerald-300 w-5 text-center"></i><span>Kelola Edukasi</span>
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
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider hidden sm:block">Manajemen Konten Edukasi</h2>
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
        <main class="flex-grow p-6 space-y-6 overflow-y-auto" x-data="{ search: '' }">
            
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs rounded-xl font-medium">
                    <div class="font-bold mb-1"><i class="fas fa-exclamation-circle mr-2"></i>Gagal menyimpan data:</div>
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- FORM TAMBAH EDUKASI BARU -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 h-fit space-y-4">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider"><i class="fas fa-pen-nib mr-2 text-emerald-600"></i>Tulis Artikel Baru</h3>
                    </div>
                    <form action="{{ route('admin.edukasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Judul Artikel</label>
                            <input type="text" name="title" required placeholder="Ketik judul edukasi..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-emerald-600">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Kategori</label>
                            <input type="text" name="category" required placeholder="Contoh: Tips Daur Ulang" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-emerald-600">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Isi Konten</label>
                            <textarea name="content" required rows="5" placeholder="Tuliskan isi edukasi di sini..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-emerald-600 resize-none"></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Gambar/Thumbnail (Opsional)</label>
                            <input type="file" name="image" accept="image/*" class="w-full p-2 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none">
                        </div>
                        <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 rounded-xl shadow-md cursor-pointer transition">
                            <i class="fas fa-paper-plane mr-2"></i>Publikasikan Artikel
                        </button>
                    </form>
                </div>

                <!-- TABEL DATA ARTIKEL -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm xl:col-span-2 overflow-hidden h-fit">
                    <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-700 uppercase">Daftar Konten Dipublikasikan</span>
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-2 text-gray-400 text-[10px]"></i>
                            <input type="text" x-model="search" placeholder="Cari artikel..." class="pl-8 pr-3 py-1.5 border border-gray-200 rounded-lg text-[10px] focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 uppercase font-semibold border-b border-gray-100">
                                    <th class="p-4 w-20">Cover</th>
                                    <th class="p-4">Judul & Kategori</th>
                                    <th class="p-4">Tanggal Rilis</th>
                                    <th class="p-4 text-center">Status / Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-600">
                                @forelse($edukasis as $item)
                                    <tr x-show="search === '' || '{{ strtolower($item->title) }}'.includes(search.toLowerCase())" class="hover:bg-gray-50/50 transition">
                                        <td class="p-4">
                                            <div class="w-14 h-10 rounded border border-gray-100 bg-emerald-50 flex items-center justify-center overflow-hidden">
                                                @if($item->image_path && file_exists(public_path($item->image_path)))
                                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <i class="fas {{ $item->icon ?? 'fa-book' }} text-emerald-500 text-lg"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <p class="font-bold text-gray-900 text-sm">{{ $item->title }}</p>
                                            <p class="text-[10px] text-emerald-600 mt-1 font-semibold">{{ $item->category }}</p>
                                        </td>
                                        <td class="p-4">
                                            <span class="block text-gray-800 font-medium">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</span>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center justify-center space-x-2" x-data="{ editModalOpen: false }">
                                                <span class="px-2 py-1 text-[10px] font-bold rounded bg-green-50 text-green-700 border border-green-200">Aktif</span>
                                                <button @click="editModalOpen = true" class="text-amber-600 hover:text-amber-700 font-bold cursor-pointer p-1"><i class="fas fa-edit"></i></button>
                                                
                                                <form action="{{ route('admin.edukasi.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten edukasi ini?');">
                                                    @csrf
                                                    <button type="submit" class="text-red-500 hover:text-red-600 cursor-pointer p-1"><i class="fas fa-trash-alt"></i></button>
                                                </form>

                                                <!-- MODAL EDIT -->
                                                <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
                                                    <div @click.away="editModalOpen = false" class="bg-white rounded-xl shadow-lg max-w-lg w-full text-left">
                                                        <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-xl">
                                                            <h3 class="font-bold text-gray-800">Edit Konten Edukasi</h3>
                                                            <button type="button" @click="editModalOpen = false" class="text-gray-400 hover:text-red-500 cursor-pointer"><i class="fas fa-times"></i></button>
                                                        </div>
                                                        <form action="{{ route('admin.edukasi.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                                                            @csrf
                                                            <div class="space-y-1.5">
                                                                <label class="block font-bold text-gray-700">Judul Artikel</label>
                                                                <input type="text" name="title" value="{{ $item->title }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500">
                                                            </div>
                                                            <div class="space-y-1.5">
                                                                <label class="block font-bold text-gray-700">Kategori</label>
                                                                <input type="text" name="category" value="{{ $item->category }}" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500">
                                                            </div>
                                                            <div class="space-y-1.5">
                                                                <label class="block font-bold text-gray-700">Isi Konten</label>
                                                                <textarea name="content" required rows="5" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 resize-none">{{ $item->content }}</textarea>
                                                            </div>
                                                            <div class="space-y-1.5">
                                                                <label class="block font-bold text-gray-700">Update Gambar (Biarkan kosong jika tidak ingin mengubah)</label>
                                                                <input type="file" name="image" accept="image/*" class="w-full p-2 border border-gray-200 rounded-lg bg-gray-50 focus:outline-none">
                                                            </div>
                                                            <div class="pt-4 flex justify-end">
                                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded-lg cursor-pointer">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-gray-400">
                                            <i class="fas fa-file-alt text-2xl block mb-2 text-gray-300"></i>
                                            Belum ada artikel edukasi yang dipublikasikan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
