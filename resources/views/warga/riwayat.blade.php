@extends('layouts.warga')

@section('title', 'Riwayat Transaksi - Sobat Sampah Desa Mekarmaya')
@section('header_title', 'Riwayat Pembukuan')

@section('header_right')
    <a href="{{ route('warga.dashboard') }}" class="text-emerald-700 text-xs font-bold"><i class="fas fa-arrow-left mr-1"></i> Dashboard</a>
@endsection

@section('content')
    <!-- Judul Halaman & Tab Kontrol -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4 gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Buku Rekening Tabungan</h2>
            <p class="text-xs text-gray-500 mt-0.5">Pantau semua catatan mutasi masuk dan pencairan dana Anda secara transparan.</p>
        </div>
        
        <!-- Navigasi Tab Alternatif -->
        <div class="flex bg-gray-200/70 p-1 rounded-xl text-xs font-semibold w-full sm:w-auto">
            <button onclick="switchTab('setor')" id="tabSetor" class="flex-1 sm:flex-initial px-4 py-2 rounded-lg bg-white text-emerald-800 shadow-xs transition cursor-pointer">
                <i class="fas fa-arrow-down-long mr-1.5 text-[10px] text-emerald-600"></i>Riwayat Setor
            </button>
            <button onclick="switchTab('tarik')" id="tabTarik" class="flex-1 sm:flex-initial px-4 py-2 rounded-lg text-gray-500 hover:text-gray-800 transition cursor-pointer">
                <i class="fas fa-arrow-up-long mr-1.5 text-[10px] text-red-500"></i>Riwayat Pencairan
            </button>
        </div>
    </div>

    <!-- TAB 1: RIWAYAT SETOR SAMPAH -->
    <div id="contentSetor" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden block">
        <div class="p-4 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Daftar Setor Sampah (Mutasi Masuk)</span>
            <span class="text-[10px] bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 rounded border border-emerald-100">{{ count($setorHistory) }} Transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                        <th class="p-4">Waktu Transaksi</th>
                        <th class="p-4">Nama Barang</th>
                        <th class="p-4 text-center">Timbangan (Kg)</th>
                        <th class="p-4 text-center">Harga / Kg</th>
                        <th class="p-4 text-center">Status Pencairan</th>
                        <th class="p-4 text-right">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-600">
                    @forelse($setorHistory as $item)
                        <tr class="hover:bg-gray-50/40 transition">
                            <td class="p-4 font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y - H:i') }} WIB
                            </td>
                            <td class="p-4 capitalize font-semibold text-gray-800">{{ $item->item_name }}</td>
                            <td class="p-4 text-center">{{ number_format($item->weight, 2, ',', '.') }} Kg</td>
                            <td class="p-4 text-center text-gray-400">Rp {{ number_format($item->price_per_kg, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                @if($item->withdrawal_status === 'belum_ditarik')
                                    <span class="px-2 py-0.5 text-[10px] bg-amber-50 text-amber-700 font-medium rounded border border-amber-100">Belum Diambil</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] bg-emerald-50 text-emerald-700 font-medium rounded border border-emerald-100">Sudah Tunai</span>
                                @endif
                            </td>
                            <td class="p-4 text-right font-bold text-emerald-600">+ Rp {{ number_format($item->earning, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-gray-400">
                                <i class="fas fa-receipt text-2xl block mb-2 text-gray-300"></i>
                                Belum ditemukan adanya catatan riwayat setoran sampah Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB 2: RIWAYAT PENARIKAN SALDO -->
    <div id="contentTarik" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hidden">
        <div class="p-4 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Daftar Pencairan Dana (Mutasi Keluar)</span>
            <span class="text-[10px] bg-red-50 text-red-700 font-bold px-2 py-0.5 rounded border border-red-100">{{ count($tarikHistory) }} Transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                        <th class="p-4">Waktu Penarikan</th>
                        <th class="p-4">Metode Penarikan</th>
                        <th class="p-4">Keterangan Nota</th>
                        <th class="p-4 text-center">Status Keuangan</th>
                        <th class="p-4 text-right">Jumlah Dicairkan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-600">
                    @forelse($tarikHistory as $item)
                        <tr class="hover:bg-gray-50/40 transition">
                            <td class="p-4 font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y - H:i') }} WIB
                            </td>
                            <td class="p-4 font-medium"><span class="bg-blue-50 text-blue-700 border border-blue-100 px-2 py-0.5 rounded text-[10px]">Tunai di Pos</span></td>
                            <td class="p-4 text-gray-400">Pencairan untuk setoran jenis {{ $item->item_name }} ({{ $item->weight }} Kg)</td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-0.5 text-[10px] bg-gray-100 text-gray-600 font-medium rounded border border-gray-200">Selesai (Success)</span>
                            </td>
                            <td class="p-4 text-right font-bold text-red-600">- Rp {{ number_format($item->earning, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-400">
                                <i class="fas fa-hand-holding-dollar text-2xl block mb-2 text-gray-300"></i>
                                Anda belum pernah mencairkan saldo tabungan sampah sejauh ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function switchTab(type) {
            let tabSetor = document.getElementById('tabSetor');
            let tabTarik = document.getElementById('tabTarik');
            let contentSetor = document.getElementById('contentSetor');
            let contentTarik = document.getElementById('contentTarik');

            if (type === 'setor') {
                // Aktifkan Tab Setor
                tabSetor.className = "flex-1 sm:flex-initial px-4 py-2 rounded-lg bg-white text-emerald-800 shadow-xs transition cursor-pointer";
                tabTarik.className = "flex-1 sm:flex-initial px-4 py-2 rounded-lg text-gray-500 hover:text-gray-800 transition cursor-pointer";
                // Tampilkan Konten Setor
                contentSetor.classList.replace('hidden', 'block');
                contentTarik.classList.replace('block', 'hidden');
            } else {
                // Aktifkan Tab Tarik
                tabTarik.className = "flex-1 sm:flex-initial px-4 py-2 rounded-lg bg-white text-emerald-800 shadow-xs transition cursor-pointer";
                tabSetor.className = "flex-1 sm:flex-initial px-4 py-2 rounded-lg text-gray-500 hover:text-gray-800 transition cursor-pointer";
                // Tampilkan Konten Tarik
                contentTarik.classList.replace('hidden', 'block');
                contentSetor.classList.replace('block', 'hidden');
            }
        }
    </script>
@endpush