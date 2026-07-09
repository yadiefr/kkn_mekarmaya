<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Harga Sampah - Panel Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-100 text-gray-800 antialiased min-h-screen flex">

    <!-- Overlay Mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-20 bg-black/50 md:hidden"></div>

    <!-- SIDEBAR NAVIGASI -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-900 text-white flex flex-col justify-between shrink-0 transition-transform duration-300 md:relative md:translate-x-0 md:flex shadow-xl">
        <div>
            <div class="p-6 border-b border-emerald-800">
                <h1 class="font-bold text-base leading-tight uppercase tracking-wider">Sobat Sampah<br><span class="text-emerald-300 text-xs font-medium normal-case">Panel Admin Mekarmaya</span></h1>
            </div>
            <nav class="p-4 space-y-1">
                <a href="#" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-th-large text-emerald-300 w-5 text-center"></i><span>Dashboard</span></a>
                <a href="{{ route('admin.aktivasi') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-user-check text-emerald-300 w-5 text-center"></i><span>Aktivasi Warga</span></a>
                <a href="{{ route('admin.setor') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-hand-holding-heart text-emerald-300 w-5 text-center"></i><span>Setor Sampah</span></a>
                <a href="{{ route('admin.pembayaran') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-file-invoice-dollar text-emerald-300 w-5 text-center"></i><span>Pembayaran Dana Nasabah</span></a>
                <a href="{{ route('admin.harga.index') }}" class="flex items-center space-x-3 bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200"><i class="fas fa-tags text-emerald-300 w-5 text-center"></i><span>Setting Harga Sampah</span></a>
                <a href="{{ route('admin.kas') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-book text-emerald-300 w-5 text-center"></i>
                    <span>Kas Desa</span>
                </a>
                <a href="{{ route('admin.edukasi') }}" class="flex items-center space-x-3 text-emerald-100 hover:bg-emerald-800 hover:text-white px-4 py-2.5 rounded-lg text-sm font-medium transition duration-200">
                    <i class="fas fa-graduation-cap text-emerald-300 w-5 text-center"></i>
                    <span>Kelola Edukasi</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-emerald-800">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-300 text-xs font-semibold px-4 py-2 block">Keluar Sistem</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <!-- CONTENT WRAPPER -->
    <div class="flex-grow flex flex-col min-w-0">
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex items-center justify-between px-6 z-10">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-600 focus:outline-none text-lg cursor-pointer hover:text-emerald-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider hidden sm:block">Pengaturan Katalog Komoditas Sampah</h2>
            </div>
            <span class="text-xs text-gray-400 font-medium">Manajemen Harga Jual & Beli</span>
        </header>

        <main class="flex-grow p-6 space-y-6 overflow-y-auto">
            
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- FORM TAMBAH KATEGORI BARU -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 h-fit space-y-4">
                    <div class="border-b border-gray-100 pb-2">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider"><i class="fas fa-plus-circle mr-2 text-emerald-600"></i>Tambah Komoditas</h3>
                    </div>
                    <form action="{{ route('admin.harga.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nama Barang / Sampah</label>
                            <input type="text" name="item_name" required placeholder="Contoh: Botol Kaca Bening" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-emerald-600">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label class="block font-bold text-gray-700">Harga Beli Warga (/kg)</label>
                                <input type="number" name="buy_price" required placeholder="e.g. 2000" class="w-full p-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-emerald-600">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block font-bold text-gray-700">Harga Jual Pengepul (/kg)</label>
                                <input type="number" name="sell_price" required placeholder="e.g. 3500" class="w-full p-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-emerald-600">
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Foto Ilustrasi Produk</label>
                            <input type="file" name="image" class="w-full p-2 border border-gray-200 rounded-xl bg-gray-50 focus:outline-none">
                        </div>
                        <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 rounded-xl shadow-md cursor-pointer"><i class="fas fa-save mr-2"></i>Simpan ke Katalog</button>
                    </form>
                </div>

                <!-- TABEL DATA MASTER PRICING -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm xl:col-span-2 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50/50 text-xs font-bold text-gray-700 uppercase">Daftar Harga Berjalan</div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 uppercase font-semibold border-b border-gray-100">
                                    <th class="p-4 w-20">Gambar</th>
                                    <th class="p-4">Jenis Sampah</th>
                                    <th class="p-4">Harga Beli (Warga)</th>
                                    <th class="p-4">Harga Jual (Pengepul)</th>
                                    <th class="p-4 text-center">Status / Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-600">
                                @forelse($trashPrices as $trash)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="p-4">
                                            <div class="w-12 h-12 rounded-lg border border-gray-100 bg-gray-50 flex items-center justify-center overflow-hidden">
                                                @if($trash->image_path && file_exists(public_path($trash->image_path)))
                                                    <img src="{{ asset($trash->image_path) }}" class="w-full h-full object-cover">
                                                @else
                                                    <i class="fas fa-box text-gray-300 text-base"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-4 font-bold text-gray-900">{{ $trash->item_name }}</td>
                                        <td class="p-4 text-emerald-700 font-bold">Rp {{ number_format($trash->buy_price, 0, ',', '.') }}/kg</td>
                                        <td class="p-4 text-blue-700 font-bold">Rp {{ number_format($trash->sell_price, 0, ',', '.') }}/kg</td>
                                        <td class="p-4">
                                            <div class="flex items-center justify-center space-x-2">
                                                <!-- Toggle Aktif/Mati -->
                                                <form action="{{ route('admin.harga.toggle', $trash->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 text-[10px] font-bold rounded {{ $trash->is_active ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-400' }} cursor-pointer">
                                                        {{ $trash->is_active ? 'Aktif' : 'Off' }}
                                                    </button>
                                                </form>

                                                <!-- Tombol Edit Modal -->
                                                <button onclick="openEditModal('{{ $trash->id }}', '{{ $trash->item_name }}', '{{ $trash->buy_price }}', '{{ $trash->sell_price }}')" class="text-amber-600 hover:text-amber-700 font-bold cursor-pointer"><i class="fas fa-edit"></i></button>

                                                <!-- Hapus Data -->
                                                <form action="{{ route('admin.harga.destroy', $trash->id) }}" method="POST" onsubmit="return confirm('Hapus komoditas ini dari sistem?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-600 cursor-pointer"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-gray-400 py-10">Katalog komoditas pricing masih kosong.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ================= MODAL WINDOW UNTUK EDIT DATA ================= -->
    <div id="editModal" class="fixed inset-0 bg-black/40 backdrop-blur-xs flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl border border-gray-100 space-y-4">
            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Ubah Parameter Kategori</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-sm"><i class="fas fa-times"></i></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1.5">
                    <label class="block font-bold text-gray-700">Nama Barang</label>
                    <input type="text" name="item_name" id="edit_item_name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block font-bold text-gray-700">Harga Beli Warga</label>
                        <input type="number" name="buy_price" id="edit_buy_price" required class="w-full p-2.5 border border-gray-200 rounded-xl focus:outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block font-bold text-gray-700">Harga Jual Pengepul</label>
                        <input type="number" name="sell_price" id="edit_sell_price" required class="w-full p-2.5 border border-gray-200 rounded-xl focus:outline-none">
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block font-bold text-gray-700">Ganti Foto Ilustrasi (Opsional)</label>
                    <input type="file" name="image" class="w-full p-2 border border-gray-200 rounded-xl bg-gray-50">
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl font-bold cursor-pointer">Batal</button>
                    <button type="submit" class="bg-emerald-700 text-white px-5 py-2 rounded-xl font-bold shadow-md cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT MODAL HANDLER -->
    <script>
        function openEditModal(id, name, buyPrice, sellPrice) {
            document.getElementById('editForm').action = "/admin/setting-harga/update/" + id;
            document.getElementById('edit_item_name').value = name;
            document.getElementById('edit_buy_price').value = Math.round(buyPrice);
            document.getElementById('edit_sell_price').value = Math.round(sellPrice);
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>
