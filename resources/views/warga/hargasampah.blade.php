@extends('layouts.warga')

@section('title', 'Daftar Harga Sampah - Sobat Sampah Desa Mekarmaya')
@section('header_title', 'Katalog Harga Beli')

@section('header_right')
    <a href="{{ route('warga.dashboard') }}" class="text-emerald-700 text-xs font-bold"><i class="fas fa-arrow-left mr-1"></i> Dashboard</a>
@endsection

@section('content')
    <div class="border-b border-gray-200 pb-4">
        <h2 class="text-lg font-bold text-gray-900">Katalog Harga Beli Sampah Terupdate</h2>
        <p class="text-xs text-gray-500 mt-0.5">Nilai nominal Rupiah di bawah dihitung per kilogram (kg) yang akan langsung dibukukan ke saldo tabungan warga.</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        
        @forelse($trashPrices as $trash)
            <div class="bg-white rounded-xl shadow-xs border border-gray-200/60 overflow-hidden text-center hover:shadow-md transition duration-200 flex flex-col justify-between">
                
                <div class="h-32 bg-gray-50 text-gray-400 flex items-center justify-center text-3xl border-b border-gray-100 relative">
                    @if($trash->image_path && file_exists(public_path($trash->image_path)))
                        <img src="{{ asset($trash->image_path) }}" alt="{{ $trash->item_name }}" class="w-full h-full object-contain p-3">
                    @else
                        @if(Str::contains(Str::lower($trash->item_name), 'botol'))
                            <i class="fas fa-glass-water text-gray-300"></i>
                        @elseif(Str::contains(Str::lower($trash->item_name), 'gelas'))
                            <i class="fas fa-cup-straw text-gray-300"></i>
                        @else
                            <i class="fas fa-box text-gray-300"></i>
                        @endif
                    @endif
                </div>

                <div class="p-3.5">
                    <h4 class="font-bold text-gray-800 text-xs truncate" title="{{ $trash->item_name }}">
                        {{ $trash->item_name }}
                    </h4>
                    
                    <div class="mt-2.5 bg-emerald-50/60 p-2 rounded-lg border border-emerald-100/50">
                        <span class="text-[9px] uppercase block text-emerald-700 font-bold tracking-wider">Harga Beli Warga</span>
                        <span class="text-sm font-black text-emerald-800 block mt-0.5">
                            Rp {{ number_format($trash->buy_price, 0, ',', '.') }} 
                            <span class="text-[10px] font-normal text-gray-400">/kg</span>
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-400 border border-dashed border-gray-200 bg-white rounded-2xl">
                <i class="fas fa-tags text-2xl mb-2 text-gray-300"></i>
                <p class="text-xs">Maaf, daftar katalog harga sampah saat ini belum tersedia.</p>
            </div>
        @endforelse

    </div>
@endsection