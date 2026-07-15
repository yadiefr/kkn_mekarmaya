@extends('layouts.admin')

@section('title', 'Kelola Edukasi - Panel Admin')
@section('header_title', 'Manajemen Konten Edukasi')

@section('content')
    <div x-data="{ search: '' }" class="space-y-6">
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
    </div>
@endsection
