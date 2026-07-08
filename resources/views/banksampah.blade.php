<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah - Desa Mekarmaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <!-- Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-emerald-100 selection:text-emerald-900">

    <!-- NAVBAR -->
    <nav class="bg-emerald-800 text-white shadow-sm sticky top-0 z-50 border-b border-emerald-900/20 backdrop-blur-md bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('beranda') }}">
                        <h1 class="font-bold text-sm leading-tight uppercase tracking-wider">
                            SOBAT SAMPAH<br>
                            <span class="text-emerald-300 text-xs font-normal normal-case tracking-normal">Desa Mekarmaya</span>
                        </h1>
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-1 text-xs font-semibold tracking-wide uppercase">
                        <a href="{{ route('beranda') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-3 py-2 rounded-lg transition duration-200">Beranda</a>
                        <a href="{{ route('edukasi') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-3 py-2 rounded-lg transition duration-200">Edukasi</a>
                        <a href="#" class="bg-emerald-900 text-emerald-200 px-3 py-2 rounded-lg">Bank Sampah</a>
                        <div class="pl-4 ml-2 border-l border-emerald-700">
                            <a href="{{ route('login') }}" class="bg-white text-emerald-800 hover:bg-emerald-50 px-4 py-2 rounded-lg transition duration-200 font-bold normal-case shadow-sm inline-block">Masuk / Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- HEADER / HERO DENGAN KATA PEMIKAT PENDAFTARAN -->
    <header class="bg-gradient-to-r from-emerald-800 to-teal-950 text-white py-16 px-4">
        <div class="max-w-3xl mx-auto text-center">
            <span class="bg-emerald-700 text-emerald-200 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Mari Jadi Pahlawan Lingkungan</span>
            <h2 class="text-2xl md:text-3xl font-extrabold mt-4 tracking-tight leading-tight">
                Jangan Buang Sampahmu, <br><span class="text-yellow-300">Jadikan Tabungan Masa Depan!</span>
            </h2>
            <p class="mt-3 text-xs md:text-sm text-emerald-100/80 max-w-xl mx-auto leading-relaxed">
                Setiap botol dan plastik yang Anda pilah hari ini adalah rupiah yang akan menghidupi hari esok. Gabung bersama ratusan warga Desa Mekarmaya lainnya, amankan bumi, dan nikmati hasilnya langsung di dompet digital Anda!
            </p>
            
            <!-- Arahan Daftar / Masuk -->
            <div class="mt-6 bg-white/5 backdrop-blur-xs p-5 rounded-xl max-w-lg mx-auto border border-white/10 shadow-sm">
                <p class="text-xs text-yellow-200 font-medium mb-3">
                    <i class="fas fa-gift mr-1 text-[10px]"></i> Pendaftaran Gratis! Akun Anda akan langsung diaktivasi oleh Admin Desa.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <a href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-500 text-emerald-950 font-bold px-5 py-2.5 rounded-lg shadow-sm transition duration-200 text-xs uppercase tracking-wide">
                        <i class="fas fa-user-plus mr-1.5 text-[11px]"></i> Daftar Akun Warga
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent hover:bg-white/5 text-white border border-white/20 font-medium px-5 py-2.5 rounded-lg transition duration-200 text-xs">
                        Sudah Punya Akun? Masuk
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- PENJELASAN SINGKAT BANK SAMPAH -->
    <section class="py-16 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div class="space-y-3">
                <span class="text-emerald-700 font-bold text-xs uppercase tracking-wider">Mengenal Program Kami</span>
                <h3 class="text-xl font-extrabold text-gray-900 tracking-tight">Apa Itu Bank Sampah Mekarmaya?</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    <strong>Bank Sampah</strong> adalah sistem pengelolaan sampah kering secara kolektif yang mengonversi kepedulian lingkungan Anda menjadi saldo bernilai ekonomi. 
                </p>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Cara kerjanya mirip perbankan biasa: Anda memilah sampah dari rumah, membawanya ke pos Bank Sampah desa, petugas menimbang muatan Anda, dan nominal rupiahnya akan langsung dibukukan ke dalam rekening digital Anda. Saldo tersebut bisa dicairkan kapan saja untuk kebutuhan harian atau membayar iuran warga!
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-200/50 flex flex-col justify-center space-y-3 shadow-xs">
                <h4 class="font-bold text-xs text-gray-800 uppercase tracking-wider"><i class="fas fa-star mr-1.5 text-amber-500"></i> Keuntungan Menabung Sampah:</h4>
                <div class="flex items-start space-x-2.5 text-xs text-gray-500">
                    <i class="fas fa-check text-emerald-600 mt-0.5"></i>
                    <span>Lingkungan rumah jadi bersih, sehat, bebas dari sarang nyamuk dan bau tak sedap.</span>
                </div>
                <div class="flex items-start space-x-2.5 text-xs text-gray-500">
                    <i class="fas fa-check text-emerald-600 mt-0.5"></i>
                    <span>Mendapat penghasilan tambahan pasif dari barang yang biasanya dibuang sia-sia.</span>
                </div>
                <div class="flex items-start space-x-2.5 text-xs text-gray-500">
                    <i class="fas fa-check text-emerald-600 mt-0.5"></i>
                    <span>Pencatatan saldo transparan yang dikelola secara aman oleh keuangan desa.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- KATALOG DAFTAR HARGA BELI SAMPAH -->
    <section class="bg-gray-100/60 border-t border-b border-gray-200/30 py-16 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-10">
                <h3 class="text-xl font-bold text-gray-900 tracking-tight">Daftar Harga Beli Sampah Terupdate</h3>
                <p class="text-xs text-gray-400 mt-1">Harga di bawah adalah nominal Rupiah per kilogram (kg) yang akan masuk ke buku tabungan warga.</p>
            </div>

            <!-- Grid Produk Dinamis -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                
                @forelse($trashPrices as $trash)
                    <div class="bg-white rounded-xl shadow-xs border border-gray-200/40 overflow-hidden text-center hover:shadow-sm transition duration-200">
                        <!-- Tempat Gambar Dinamis -->
                        <div class="h-28 bg-gray-50 text-gray-400 flex items-center justify-center text-2xl border-b border-gray-100">
                            @if($trash->image_path && file_exists(public_path($trash->image_path)))
                                <img src="{{ asset($trash->image_path) }}" alt="{{ $trash->item_name }}" class="w-full h-full object-contain p-2">
                            @else
                                <!-- Icon Fallback jika gambar aset kosong -->
                                <i class="fas fa-box text-gray-300"></i>
                            @endif
                        </div>
                        <div class="p-3">
                            <h4 class="font-bold text-gray-800 text-xs truncate" title="{{ $trash->item_name }}">
                                {{ $trash->item_name }}
                            </h4>
                            <div class="mt-2 bg-emerald-50/60 p-1.5 rounded-lg border border-emerald-100/50">
                                <span class="text-[9px] uppercase block text-emerald-700 font-medium tracking-wide">Harga Beli</span>
                                <span class="text-sm font-bold text-emerald-800">
                                    Rp {{ number_format($trash->buy_price, 0, ',', '.') }} 
                                    <span class="text-[9px] font-normal text-gray-400">/kg</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Penanganan jika database masih kosong -->
                    <div class="col-span-full text-center py-8 text-gray-400 border border-dashed border-gray-200 bg-white rounded-xl">
                        <i class="fas fa-info-circle text-xl mb-1.5"></i>
                        <p class="text-xs">Belum ada daftar harga sampah aktif saat ini.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-xs border-t border-gray-800">
        <p>&copy; 2026 Sobat Sampah Desa Mekarmaya. All Rights Reserved.</p>
    </footer>

</body>
</html>