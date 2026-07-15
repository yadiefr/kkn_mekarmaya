@extends('layouts.admin')

@section('title', 'Rekap Setor Sampah - Sobat Sampah')
@section('header_title', 'Loket Timbangan & Pencatatan Digital')
@section('x-data-extra', "editModalOpen: false, editData: {}")

@section('content')
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium shadow-xs"><i class="fas fa-circle-check mr-2"></i>{{ session('success') }}</div>
    @endif

    <div class="w-full">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Rekap Seluruh Data Setoran</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                                <th class="p-4">Tanggal</th>
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
                            @forelse($deposits as $deposit)
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($deposit->created_at)->translatedFormat('d M Y') }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($deposit->created_at)->format('H:i') }} WIB</p>
                                    </td>
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
                                        <button @click="editData = { id: {{ $deposit->id }}, user_id: {{ $deposit->user_id }}, trash_price_id: {{ $deposit->trash_price_id }}, weight: {{ $deposit->weight }}, note: '{{ addslashes($deposit->note ?? '') }}' }; editModalOpen = true" class="text-blue-500 hover:text-blue-700 mx-1 cursor-pointer" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.setor.destroy', $deposit->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus setoran ini? Saldo warga akan ikut terkurangi (jika belum ditarik).');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 mx-1 cursor-pointer" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-12 text-gray-400">
                                        <i class="fas fa-boxes-stacked text-xl mb-2 text-gray-300 block"></i>
                                        Belum ada catatan aktivitas timbangan masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $deposits->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Setoran -->
    <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div x-show="editModalOpen" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-xs transition-opacity" @click="editModalOpen = false" aria-hidden="true"></div>

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
@endsection
