<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Setor Sampah - Sobat Sampah</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body x-data="{ sidebarOpen: false, editModalOpen: false, editData: {} }" class="bg-gray-100 text-gray-800 antialiased min-h-screen flex">

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
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-300 hover:text-red-200 text-xs font-semibold px-4 py-2 block">Keluar Sistem</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>

    <div class="flex-grow flex flex-col min-w-0">
        <header class="bg-white h-16 shadow-sm border-b border-gray-100 flex items-center justify-between px-6 z-10">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-600 focus:outline-none text-lg cursor-pointer hover:text-emerald-600">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wider hidden sm:block">Loket Timbangan & Pencatatan Digital</h2>
            </div>
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
                                        <th class="p-4 text-right">Tabungan Warga</th>
                                        <th class="p-4 text-right">Kas Masuk (Desa)</th>
                                        <th class="p-4 text-right">Total Kas Masuk</th>
                                        <th class="p-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-600">
                                    @forelse($recentDeposits as $deposit)
                                        <tr class="hover:bg-gray-50/40 transition">
                                            <td class="p-4">
                                                <p class="font-bold text-gray-900">{{ $deposit->user->name ?? 'Warga (Terhapus)' }}</p>
                                                <p class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($deposit->created_at)->diffForHumans() }}</p>
                                            </td>
                                            <td class="p-4">
                                                <p class="font-medium text-gray-800 capitalize">{{ $deposit->trashPrice->item_name ?? 'Barang (Terhapus)' }}</p>
                                                <p class="text-[10px] text-gray-400">@ Rp {{ number_format($deposit->price_per_kg, 0, ',', '.') }}/kg</p>
                                            </td>
                                            <td class="p-4 text-center font-bold text-gray-800">{{ number_format($deposit->weight, 2, ',', '.') }} Kg</td>
                                            <td class="p-4 text-right font-bold text-emerald-600">+ Rp {{ number_format($deposit->earning, 0, ',', '.') }}</td>
                                            <td class="p-4 text-right font-bold text-blue-600">+ Rp {{ number_format($deposit->weight * (($deposit->trashPrice->sell_price ?? 0) - $deposit->price_per_kg), 0, ',', '.') }}</td>
                                            <td class="p-4 text-right font-bold text-gray-900">+ Rp {{ number_format($deposit->weight * ($deposit->trashPrice->sell_price ?? 0), 0, ',', '.') }}</td>
                                            <td class="p-4 text-center">
                                                <button @click="editData = { id: {{ $deposit->id }}, user_id: {{ $deposit->user_id }}, trash_price_id: {{ $deposit->trash_price_id }}, weight: {{ $deposit->weight }}, note: '{{ addslashes($deposit->note ?? '') }}' }; editModalOpen = true" class="text-blue-500 hover:text-blue-700 mx-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.setor.destroy', $deposit->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus setoran ini? Saldo warga akan ikut terkurangi (jika belum ditarik).');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 mx-1" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-12 text-gray-400">
                                                <i class="fas fa-boxes-stacked text-xl mb-2 text-gray-300 block"></i>
                                                Belum ada catatan aktivitas timbangan masuk untuk hari ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-gray-100">
                            {{ $recentDeposits->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <footer class="bg-white h-12 border-t border-gray-100 flex items-center justify-center text-[11px] text-gray-400">&copy; 2026 Admin Sobat Sampah Desa Mekarmaya. All Rights Reserved.</footer>
    </div>

    <!-- Modal Edit Setoran -->
    <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Flex Container to center the modal -->
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <!-- Backdrop -->
            <div x-show="editModalOpen" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-xs transition-opacity" @click="editModalOpen = false" aria-hidden="true"></div>

            <!-- Modal Panel -->
            <div x-show="editModalOpen" x-transition class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">
                <form :action="'{{ url('admin/setor-sampah/update') }}/' + editData.id" method="POST" class="text-sm">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-edit text-blue-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Edit Setoran Sampah
                                </h3>
                                <div class="mt-4 space-y-3">
                                    <div>
                                        <label class="block font-bold text-gray-700 text-xs">Nama Warga</label>
                                        <select name="user_id" x-model="editData.user_id" required class="w-full p-2 border border-gray-200 bg-white rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                            @foreach($wargaList as $warga)
                                                <option value="{{ $warga->id }}">{{ $warga->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-bold text-gray-700 text-xs">Jenis Sampah</label>
                                        <select name="trash_price_id" x-model="editData.trash_price_id" required class="w-full p-2 border border-gray-200 bg-white rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                            @foreach($sampahList as $sampah)
                                                <option value="{{ $sampah->id }}">{{ $sampah->item_name }} (Rp {{ number_format($sampah->buy_price, 0, ',', '.') }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-bold text-gray-700 text-xs">Berat (Kg)</label>
                                        <input type="number" step="0.01" min="0.01" name="weight" x-model="editData.weight" required class="w-full p-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block font-bold text-gray-700 text-xs">Catatan (Opsional)</label>
                                        <input type="text" name="note" x-model="editData.note" class="w-full p-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                            Simpan Perubahan
                        </button>
                        <button type="button" @click="editModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>