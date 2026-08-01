@extends('layouts.admin')

@section('title', 'Setting Pembayaran')
@section('header_title', 'Konfigurasi Pembayaran & Kasir Nasabah')
@section('x-data-extra', "")

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Form Pengaturan Jadwal Tunggal -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 space-y-4 h-fit">
            <div class="border-b border-gray-100 pb-2">
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">
                    <i class="fas fa-calendar-alt mr-2 text-emerald-600"></i>{{ $setting ? 'Update' : 'Buka' }} Jadwal Penarikan
                </h3>
            </div>
            
            @if(session('success_setting'))
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] rounded-lg font-medium shadow-xs">{{ session('success_setting') }}</div>
            @endif

            <form action="{{ route('admin.pembayaran.jadwal') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1.5">
                    <label class="block font-bold text-gray-700">Nama Event / Periode Klaim</label>
                    <input type="text" name="event_name" value="{{ $setting->event_name ?? '' }}" required placeholder="Contoh: Pencairan Akhir Bulan" 
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block font-bold text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $setting ? \Carbon\Carbon::parse($setting->start_date)->format('Y-m-d') : '' }}" required class="w-full p-2.5 border border-gray-200 rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none bg-white">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block font-bold text-gray-700">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ $setting ? \Carbon\Carbon::parse($setting->end_date)->format('Y-m-d') : '' }}" required class="w-full p-2.5 border border-gray-200 rounded-xl focus:ring-1 focus:ring-emerald-600 focus:outline-none bg-white">
                    </div>
                </div>
                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 rounded-xl shadow-md transition cursor-pointer">
                    <i class="fas fa-save mr-1.5"></i>Simpan Konfigurasi
                </button>
            </form>
            
            @if($setting)
            <form action="{{ route('admin.pembayaran.jadwal.destroy', $setting->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Yakin ingin menutup dan menghapus jadwal penarikan ini? Warga tidak akan bisa mengajukan penarikan lagi.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold py-2.5 rounded-xl transition cursor-pointer text-xs">
                    <i class="fas fa-times-circle mr-1.5"></i>Tutup & Hapus Jadwal
                </button>
            </form>
            @endif
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm lg:col-span-2 overflow-hidden h-fit">
            <div class="p-4 border-b border-gray-100 bg-gray-50/50 text-xs font-bold text-gray-700 uppercase tracking-wider">Status Jadwal Penarikan Saat Ini</div>
            <div class="p-8 flex items-center justify-center">
                @if($setting)
                    <div class="w-full max-w-md text-center space-y-4">
                        <div class="inline-block p-4 rounded-full bg-emerald-50 mb-2 border border-emerald-100">
                            <i class="fas fa-wallet text-4xl text-emerald-500"></i>
                        </div>
                        <h4 class="font-black text-gray-900 text-xl">{{ $setting->event_name }}</h4>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 inline-block font-medium text-gray-600 text-sm">
                            <i class="fas fa-calendar-day mr-2 text-emerald-600"></i>
                            {{ \Carbon\Carbon::parse($setting->start_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($setting->end_date)->translatedFormat('d M Y') }}
                        </div>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-4 py-1.5 bg-emerald-600 text-white font-bold rounded-full text-xs shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-white animate-pulse mr-2"></span> SEDANG AKTIF
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Warga dapat mengajukan penarikan saldo selama periode ini.</p>
                    </div>
                @else
                    <div class="w-full max-w-md text-center space-y-3 py-6">
                        <div class="inline-block p-4 rounded-full bg-gray-50 mb-2 border border-gray-100">
                            <i class="fas fa-calendar-times text-4xl text-gray-300"></i>
                        </div>
                        <h4 class="font-bold text-gray-600 text-lg">Belum Ada Jadwal Aktif</h4>
                        <p class="text-sm text-gray-400">Saat ini tidak ada jadwal penarikan yang terbuka. Warga tidak dapat melakukan pengajuan penarikan saldo.</p>
                        <p class="text-xs text-emerald-600 font-semibold mt-4">Gunakan form di sebelah kiri untuk membuka jadwal baru.</p>
                    </div>
                @endif
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
                                <p class="font-bold text-gray-900">{{ $req->user->name ?? 'Warga (Terhapus)' }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Username: {{ $req->user->username ?? '-' }}</p>
                            </td>
                            <td class="p-4 text-gray-500 font-medium">{{ \Carbon\Carbon::parse($req->created_at)->translatedFormat('d M Y, H:i') }} WIB</td>
                            <td class="p-4 text-right font-bold text-emerald-700 text-sm">Rp {{ number_format($req->total_amount, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <form action="{{ route('admin.pembayaran.proses', $req->id) }}" method="POST" class="flex items-center justify-center space-x-2">
                                    @csrf
                                    <input type="text" name="admin_note" placeholder="Catatan/No. Kwitansi (Opsional)" 
                                        class="px-3 py-1.5 border border-gray-200 rounded-lg text-[11px] focus:outline-none focus:ring-1 focus:ring-emerald-600 w-44">
                                    
                                    <button type="submit" name="action" value="approved" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition cursor-pointer">
                                        Setujui (Cairkan)
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
                                <p class="font-bold text-gray-900">{{ $history->user->name ?? 'Warga (Terhapus)' }}</p>
                                <p class="text-[10px] text-gray-400">Username: {{ $history->user->username ?? '-' }}</p>
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

@endsection
