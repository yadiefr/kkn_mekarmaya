@extends('layouts.admin')

@section('title', 'Pengaturan Sistem - Panel Admin')
@section('header_title', 'Pengaturan Aplikasi')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        
        <div>
            <h2 class="text-lg font-bold text-gray-900">Pengaturan Sistem Utama</h2>
            <p class="text-xs text-gray-500 mt-0.5">Kelola dan atur data dasar aplikasi Bank Sampah Desa Mekarmaya.</p>
        </div>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium shadow-xs flex items-center">
                <i class="fas fa-check-circle mr-2.5 text-emerald-600 text-sm"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs rounded-xl font-medium shadow-xs flex items-center">
                <i class="fas fa-exclamation-circle mr-2.5 text-red-600 text-sm"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- DAFTAR WARGA DENGAN SALDO AKTIF -->
        <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-users text-amber-500 mr-2.5 text-sm"></i>
                    <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Warga dengan Saldo Belum Dicairkan</h3>
                </div>
                <span class="text-[10px] font-semibold {{ $activeWarga->isEmpty() ? 'text-emerald-700 bg-emerald-50' : 'text-amber-700 bg-amber-50' }} px-2 py-0.5 rounded">
                    {{ $activeWarga->count() }} Warga
                </span>
            </div>
            
            <div class="p-0 text-xs">
                @if($activeWarga->isEmpty())
                    <div class="p-8 text-center text-gray-400 space-y-2">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-base"><i class="fas fa-circle-check"></i></div>
                        <p class="font-medium text-gray-500">Semua warga telah melakukan pencairan saldo.</p>
                        <p class="text-[10px] text-gray-400">Tidak ada saldo aktif yang tersisa di sistem. Basis data aman untuk di-reset.</p>
                    </div>
                @else
                    <div class="p-4 bg-amber-50/50 border-b border-gray-100 text-[11px] text-amber-850 flex items-start">
                        <i class="fas fa-circle-info text-amber-500 text-sm mr-2 shrink-0 mt-0.5"></i>
                        <span>Admin tidak dapat melakukan reset data transaksi selama daftar warga di bawah ini masih memiliki saldo aktif (belum ditarik). Harap proses pencairan saldo mereka terlebih dahulu di halaman Pembayaran.</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                                    <th class="p-4">Nama Warga / NIK</th>
                                    <th class="p-4">WhatsApp</th>
                                    <th class="p-4 text-right">Sampah Aktif</th>
                                    <th class="p-4 text-right">Saldo Aktif</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($activeWarga as $w)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="p-4">
                                            <p class="font-bold text-gray-900">{{ $w->name }}</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">NIK: {{ Str::mask($w->nik, 'X', 4, 8) }}</p>
                                        </td>
                                        <td class="p-4 text-gray-600 font-medium"><i class="fab fa-whatsapp text-emerald-600 mr-1"></i>{{ $w->whatsapp ?? '-' }}</td>
                                        <td class="p-4 text-right font-medium text-gray-700">{{ number_format($w->total_berat, 2, ',', '.') }} kg</td>
                                        <td class="p-4 text-right font-black text-amber-700">Rp {{ number_format($w->total_saldo, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- PANEL RESET DATA -->
        <div class="bg-white rounded-2xl border border-gray-150 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex items-center">
                <i class="fas fa-database text-red-500 mr-2.5 text-sm"></i>
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Reset Basis Data Transaksi</h3>
            </div>
            
            <div class="p-6 space-y-5 text-xs">
                <div class="bg-red-50/60 border border-red-200/50 rounded-xl p-4 flex items-start space-x-3 text-red-905">
                    <i class="fas fa-triangle-exclamation text-red-500 text-lg mt-0.5 shrink-0"></i>
                    <div class="space-y-1">
                        <h4 class="font-bold text-red-900">PENTING & DIBACA TERLEBIH DAHULU:</h4>
                        <p class="text-[11px] text-gray-600 leading-relaxed">Tindakan reset ini bersifat <strong>permanen</strong> dan akan menghapus seluruh data transaksi berikut dari database:</p>
                        <ul class="list-disc pl-5 mt-1 text-[11px] text-gray-500 space-y-0.5">
                            <li>Seluruh riwayat <strong>timbangan/setoran sampah</strong> warga (menyebabkan total timbangan warga kembali ke <strong>0 kg</strong>).</li>
                            <li>Seluruh nilai <strong>pendapatan saldo nasabah</strong> (menyebabkan saldo aktif warga kembali ke <strong>Rp 0</strong>).</li>
                            <li>Seluruh riwayat <strong>pengajuan penarikan dana</strong> warga (baik pending, approved, maupun rejected).</li>
                            <li>Seluruh statistik data keuangan <strong>kas masuk, kas keluar, dan saldo kas desa</strong>.</li>
                        </ul>
                        <p class="text-[11px] text-red-800 font-semibold mt-1">Catatan: Akun login admin, akun login warga, dan katalog master harga sampah tidak akan dihapus.</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h4 class="font-bold text-gray-800">Apakah Anda Yakin?</h4>
                        <p class="text-[11px] text-gray-400 mt-0.5">Semua data transaksi yang dihapus tidak dapat dipulihkan kembali.</p>
                    </div>
                    
                    <form action="{{ route('admin.pengaturan.reset') }}" method="POST" onsubmit="return confirm('APAKAH ANDA YAKIN?\n\nTindakan ini akan menghapus semua riwayat sampah, saldo warga, dan kas desa secara PERMANEN dari sistem!');" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-750 text-white text-xs font-bold px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-200 cursor-pointer flex items-center justify-center">
                            <i class="fas fa-trash-can mr-2"></i>Reset Semua Data Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
