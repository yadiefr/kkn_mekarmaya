@extends('layouts.warga')

@section('title', 'Dashboard Warga - Sobat Sampah')
@section('header_title', 'Sobat Sampah Warga')

@section('header_right')
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-500 hover:text-red-600 text-sm">
        <i class="fas fa-sign-out-alt"></i>
    </a>
@endsection

@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded uppercase tracking-wider">Akun Warga Aktif</span>
            <h2 class="text-lg font-bold text-gray-900 mt-2">Selamat Datang, {{ $user->name }}</h2>
            <p class="text-xs text-gray-500 mt-0.5">NIK: {{ $user->nik }} | Alamat: {{ $user->alamat }}</p>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 px-6 py-4 rounded-xl text-right w-full sm:w-auto">
            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Total Saldo Tabungan</p>
            <p class="text-2xl font-black text-emerald-700 mt-1">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm lg:col-span-2 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Riwayat Setoran Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-100">
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Jenis Sampah</th>
                            <th class="p-4 text-center">Timbangan</th>
                            <th class="p-4 text-right">Nilai Tabungan</th>
                            <th class="p-4 text-center">Status Nota</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-600">
                        @forelse($deposits as $deposit)
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="p-4 font-medium">{{ \Carbon\Carbon::parse($deposit->created_at)->translatedFormat('d M Y, H:i') }} WIB</td>
                                <td class="p-4">
                                    <span class="font-bold text-gray-800 capitalize">{{ $deposit->item_name }}</span>
                                    <br><span class="text-[10px] text-gray-400">@ Rp {{ number_format($deposit->price_per_kg, 0, ',', '.') }}/Kg</span>
                                </td>
                                <td class="p-4 text-center font-bold text-gray-800">{{ number_format($deposit->weight, 2, ',', '.') }} <span class="text-[10px] text-gray-400 font-normal">Kg</span></td>
                                <td class="p-4 text-right font-bold text-emerald-600">+ Rp {{ number_format($deposit->earning, 0, ',', '.') }}</td>
                                <td class="p-4 text-center">
                                    @if($deposit->withdrawal_status === 'belum_ditarik')
                                        <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 px-2.5 py-1 rounded-full"><i class="fas fa-wallet mr-1 text-[9px]"></i>Aktif</span>
                                    @else
                                        <span class="text-[10px] font-bold bg-gray-100 text-gray-400 px-2.5 py-1 rounded-full"><i class="fas fa-check-double mr-1 text-[9px]"></i>Sudah Ditarik</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-400">
                                    <i class="fas fa-clipboard-list text-xl mb-2 text-gray-300 block"></i>
                                    Belum ada riwayat menabung sampah. Mari pilah sampahmu hari ini!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">Kontribusi Lingkungan Anda</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-emerald-50/60 rounded-xl border border-emerald-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-sm"><i class="fas fa-recycle"></i></div>
                            <div>
                                <h4 class="text-xs font-bold text-emerald-950">Sampah Aktif Saat Ini</h4>
                                <p class="text-[10px] text-emerald-700">Belum dicairkan (akan menjadi 0 setelah ditarik)</p>
                            </div>
                        </div>
                        <span class="text-sm font-black text-emerald-900">
                            {{ number_format($totalBeratAktif, 1, ',', '.') }} <span class="text-[10px] font-normal text-emerald-600">Kg</span>
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm"><i class="fas fa-scale-balanced"></i></div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800">Total Sampah Terolah</h4>
                                <p class="text-[10px] text-gray-400">Akumulasi seluruh setoran</p>
                            </div>
                        </div>
                        <span class="text-sm font-black text-gray-900">
                            {{ number_format($totalBerat, 1, ',', '.') }} <span class="text-[10px] font-normal text-gray-400">Kg</span>
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-emerald-50/60 rounded-xl border border-emerald-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-700 text-white flex items-center justify-center text-sm"><i class="fas fa-wallet"></i></div>
                            <div>
                                <h4 class="text-xs font-bold text-emerald-950">Saldo Aktif Saat Ini</h4>
                                <p class="text-[10px] text-emerald-700">Dapat dicairkan (akan menjadi 0 setelah ditarik)</p>
                            </div>
                        </div>
                        <span class="text-sm font-black text-emerald-900">
                            Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-sm"><i class="fas fa-hand-holding-dollar"></i></div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800">Total Pencairan</h4>
                                <p class="text-[10px] text-gray-400">Penarikan tunai sukses</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-red-600">Rp {{ number_format($totalDicairkan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                <p class="text-[11px] text-gray-400 leading-relaxed">
                    <i class="fas fa-leaf text-emerald-600 mr-1"></i> Dengan menyetor sampah, Anda telah membantu menyelamatkan Desa Mekarmaya dari penumpukan limgah anorganik berbahaya. Terima kasih!
                </p>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if ("Notification" in window) {
                if (Notification.permission !== "granted" && Notification.permission !== "denied") {
                    Notification.requestPermission().then(function (permission) {
                        if (permission === "granted") {
                            console.log("Izin notifikasi diberikan oleh pengguna.");
                        }
                    });
                }
            }
        });
    </script>
@endpush