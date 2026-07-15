@extends('layouts.admin')

@section('title', 'Data Warga - Sobat Sampah')
@section('header_title', 'Manajemen Akses Akun Warga')
@section('x-data-extra', "createModalOpen: false, editModalOpen: false, editData: {}")

@section('content')
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium shadow-sm"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs rounded-xl font-medium shadow-sm">
            <div class="font-bold mb-1"><i class="fas fa-exclamation-circle mr-2"></i>Gagal menyimpan data warga:</div>
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-3">
        <form action="{{ route('admin.datawarga') }}" method="GET" class="flex flex-col sm:flex-row gap-3 flex-grow w-full md:w-auto">
            <div class="relative flex-grow">
                <i class="fas fa-search absolute left-4 top-3.5 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari warga berdasarkan Nama Lengkap atau NIK..." 
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition">
            </div>
            <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold px-6 py-2.5 rounded-xl transition cursor-pointer">Cari Data</button>
            @if(!empty($search))
                <a href="{{ route('admin.datawarga') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold px-4 py-2.5 rounded-xl transition flex items-center justify-center">Reset</a>
            @endif
        </form>
        <button @click="createModalOpen = true" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-xs cursor-pointer flex items-center justify-center">
            <i class="fas fa-user-plus mr-2"></i> Daftarkan Warga Baru
        </button>
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
                                <p class="text-[10px] text-gray-400">No. KK: {{ $w->no_kk }}</p>
                            </td>
                            <td class="p-4 text-gray-600 font-medium"><i class="fab fa-whatsapp text-emerald-600 mr-1"></i>{{ $w->whatsapp }}</td>
                            <td class="p-4 text-gray-500 leading-relaxed">{{ $w->tempat_lahir }}, {{ \Carbon\Carbon::parse($w->tanggal_lahir)->translatedFormat('d M Y') }}<br><span class="text-[10px] text-gray-400">{{ $w->jenis_kelamin }}</span></td>
                            <td class="p-4 text-gray-500 max-w-xs truncate">{{ $w->alamat }}</td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <form action="{{ route('admin.datawarga.toggle', $w->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold px-4 py-1.5 rounded-lg shadow-sm transition cursor-pointer"><i class="fas fa-user-check mr-1.5"></i>Aktifkan (ON)</button>
                                    </form>
                                    <button @click="editData = { id: {{ $w->id }}, name: '{{ addslashes($w->name) }}', no_kk: '{{ $w->no_kk }}', nik: '{{ $w->nik }}', whatsapp: '{{ $w->whatsapp }}', tempat_lahir: '{{ addslashes($w->tempat_lahir) }}', tanggal_lahir: '{{ $w->tanggal_lahir }}', jenis_kelamin: '{{ $w->jenis_kelamin }}', alamat: '{{ addslashes($w->alamat) }}' }; editModalOpen = true" class="bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition cursor-pointer" title="Edit Data"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('admin.datawarga.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun warga ini?');">
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
                                <p class="text-[10px] text-gray-400">No. KK: {{ $w->no_kk }}</p>
                            </td>
                            <td class="p-4 text-gray-600 font-medium"><i class="fab fa-whatsapp text-emerald-600 mr-1"></i>{{ $w->whatsapp }}</td>
                            <td class="p-4 text-gray-500 leading-relaxed">{{ $w->tempat_lahir }}, {{ \Carbon\Carbon::parse($w->tanggal_lahir)->translatedFormat('d M Y') }}<br><span class="text-[10px] text-gray-400">{{ $w->jenis_kelamin }}</span></td>
                            <td class="p-4 text-gray-500 max-w-xs truncate">{{ $w->alamat }}</td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <form action="{{ route('admin.datawarga.toggle', $w->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-700 text-[11px] font-bold px-3 py-1.5 rounded-lg border border-red-200 transition cursor-pointer"><i class="fas fa-user-slash mr-1.5"></i>(OFF)</button>
                                    </form>
                                    <button @click="editData = { id: {{ $w->id }}, name: '{{ addslashes($w->name) }}', no_kk: '{{ $w->no_kk }}', nik: '{{ $w->nik }}', whatsapp: '{{ $w->whatsapp }}', tempat_lahir: '{{ addslashes($w->tempat_lahir) }}', tanggal_lahir: '{{ $w->tanggal_lahir }}', jenis_kelamin: '{{ $w->jenis_kelamin }}', alamat: '{{ addslashes($w->alamat) }}' }; editModalOpen = true" class="bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition cursor-pointer" title="Edit Data"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('admin.datawarga.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun warga ini secara permanen?');">
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

    <!-- Modal Daftarkan Warga Baru -->
    <div x-show="createModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <!-- Backdrop -->
            <div x-show="createModalOpen" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-xs transition-opacity" @click="createModalOpen = false" aria-hidden="true"></div>

            <!-- Modal Panel -->
            <div x-show="createModalOpen" x-transition class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl w-full">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center"><i class="fas fa-user-plus mr-2 text-emerald-600"></i>Daftarkan Akun Warga Baru</h3>
                    <button type="button" @click="createModalOpen = false" class="text-gray-400 hover:text-red-500 transition cursor-pointer text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form action="{{ route('admin.datawarga.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required placeholder="Nama lengkap warga..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nomor Kartu Keluarga</label>
                            <input type="text" name="no_kk" required placeholder="Nomor KK (16 digit)..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nomor NIK</label>
                            <input type="text" name="nik" required placeholder="Nomor NIK (16 digit)..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" required placeholder="Contoh: 08123456789..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" required placeholder="Tempat lahir..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" required 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none bg-white">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required 
                                class="w-full p-2 border border-gray-200 bg-white rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Password</label>
                            <input type="password" name="password" required placeholder="Minimal 6 karakter..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block font-bold text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" required placeholder="Ulangi password..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block font-bold text-gray-700">Alamat Lengkap Rumah</label>
                            <textarea name="alamat" required rows="3" placeholder="Nama dusun, RT/RW, nomor rumah..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none resize-none"></textarea>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                        <button type="button" @click="createModalOpen = false" 
                            class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-lg font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition cursor-pointer">
                            Simpan & Aktifkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Warga -->
    <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <!-- Backdrop -->
            <div x-show="editModalOpen" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-xs transition-opacity" @click="editModalOpen = false" aria-hidden="true"></div>

            <!-- Modal Panel -->
            <div x-show="editModalOpen" x-transition class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl w-full">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center"><i class="fas fa-user-pen mr-2 text-amber-600"></i>Ubah Data Akun Warga</h3>
                    <button type="button" @click="editModalOpen = false" class="text-gray-400 hover:text-red-500 transition cursor-pointer text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form :action="'{{ url('admin/data-warga/update') }}/' + editData.id" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required x-model="editData.name" placeholder="Nama lengkap warga..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nomor Kartu Keluarga</label>
                            <input type="text" name="no_kk" required x-model="editData.no_kk" placeholder="Nomor KK (16 digit)..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nomor NIK</label>
                            <input type="text" name="nik" required x-model="editData.nik" placeholder="Nomor NIK (16 digit)..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" required x-model="editData.whatsapp" placeholder="Contoh: 08123456789..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" required x-model="editData.tempat_lahir" placeholder="Tempat lahir..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" required x-model="editData.tanggal_lahir" 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none bg-white">
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required x-model="editData.jenis_kelamin" 
                                class="w-full p-2 border border-gray-200 bg-white rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                                <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-bold text-gray-700">Ganti Password (Opsional)</label>
                            <input type="password" name="password" placeholder="Biarkan kosong jika tidak diubah..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block font-bold text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru jika diubah..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label class="block font-bold text-gray-700">Alamat Lengkap Rumah</label>
                            <textarea name="alamat" required rows="3" x-model="editData.alamat" placeholder="Nama dusun, RT/RW, nomor rumah..." 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-600 focus:outline-none resize-none"></textarea>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                        <button type="button" @click="editModalOpen = false" 
                            class="bg-gray-100 hover:bg-gray-205 text-gray-600 px-5 py-2.5 rounded-lg font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                            class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
