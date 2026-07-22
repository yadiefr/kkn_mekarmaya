<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Desa Mekarmaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <!-- Google Fonts Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white flex flex-col min-h-screen">

    <!-- NAVBAR MODERN (GLASSMORPHISM STICKY) -->
    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/80 shadow-xs transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                @php
                    $currentLogoUrl = null;
                    $logoExtensions = ['png', 'jpg', 'jpeg', 'webp', 'svg', 'PNG', 'JPG', 'WEBP', 'SVG'];
                    foreach ($logoExtensions as $ext) {
                        if (file_exists(public_path('uploads/logo/site_logo.' . $ext)) || file_exists(base_path('../public_html/uploads/logo/site_logo.' . $ext))) {
                            $currentLogoUrl = asset('uploads/logo/site_logo.' . $ext);
                            break;
                        }
                    }
                @endphp
                <!-- Logo & Name -->
                <a href="{{ route('beranda') }}" class="flex items-center space-x-3 group">
                    @if($currentLogoUrl)
                        <div class="w-11 h-11 rounded-xl bg-white p-1.5 border border-slate-200 shadow-sm flex items-center justify-center overflow-hidden group-hover:scale-105 transition-transform">
                            <img src="{{ $currentLogoUrl }}?v={{ time() }}" alt="Logo Bank Sampah" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-11 h-11 bg-gradient-to-tr from-emerald-600 to-teal-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-emerald-600/20 group-hover:scale-105 transition-transform">
                            <i class="fas fa-leaf text-xl text-emerald-100 group-hover:rotate-12 transition-transform"></i>
                        </div>
                    @endif
                    <div>
                        <span class="font-extrabold text-lg text-slate-900 tracking-tight leading-none block">
                            BANK SAMPAH
                        </span>
                        <span class="text-xs font-semibold text-emerald-600 tracking-wide flex items-center gap-1 mt-0.5">
                            Desa Mekarmaya <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('beranda') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Beranda</a>
                    <a href="{{ route('beranda') }}#simulasi" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Simulasi Tabungan</a>
                    <a href="{{ route('banksampah') }}" class="px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 rounded-xl transition">Harga Sampah</a>
                    <a href="{{ route('beranda') }}#cara-kerja" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Cara Kerja</a>
                    <a href="{{ route('edukasi') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Edukasi</a>
                    <a href="{{ route('beranda') }}#faq" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">FAQ</a>
                </div>

                <!-- Desktop Action Buttons -->
                <div class="hidden lg:flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-emerald-600 hover:bg-slate-100 transition duration-200">
                        <i class="fas fa-sign-in-alt mr-1.5 text-xs text-emerald-600"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 shadow-md shadow-emerald-600/25 hover:shadow-lg hover:shadow-emerald-600/35 transition duration-200 transform hover:-translate-y-0.5">
                        <i class="fas fa-user-plus mr-1.5 text-xs"></i> Daftar Warga
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="lg:hidden flex items-center">
                    <button id="mobileMenuBtn" aria-label="Menu Mobile" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 hover:text-emerald-600 focus:outline-none cursor-pointer">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-200 bg-white/95 backdrop-blur-xl px-4 pt-3 pb-6 shadow-xl">
            <div class="flex flex-col space-y-2 text-sm font-semibold">
                <a href="{{ route('beranda') }}" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Beranda</a>
                <a href="{{ route('beranda') }}#simulasi" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Simulasi Tabungan</a>
                <a href="{{ route('banksampah') }}" class="px-4 py-3 bg-emerald-50 text-emerald-700 rounded-xl">Harga Sampah</a>
                <a href="{{ route('beranda') }}#cara-kerja" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Cara Kerja</a>
                <a href="{{ route('edukasi') }}" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Edukasi</a>
                <a href="{{ route('beranda') }}#faq" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">FAQ</a>
                
                <div class="pt-4 mt-2 border-t border-slate-100 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-3 rounded-xl border border-slate-200 font-bold text-slate-800 hover:bg-slate-50">
                        Masuk Akun
                    </a>
                    <a href="{{ route('register') }}" class="w-full text-center py-3 rounded-xl font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md">
                        Daftar Warga Baru
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
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
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-500 text-emerald-950 font-bold px-5 py-3 sm:py-2.5 rounded-lg shadow-sm transition duration-200 text-xs uppercase tracking-wide block sm:inline-block">
                        <i class="fas fa-user-plus mr-1.5 text-[11px]"></i> Daftar Akun Warga
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent hover:bg-white/5 text-white border border-white/20 font-medium px-5 py-3 sm:py-2.5 rounded-lg transition duration-200 text-xs block sm:inline-block">
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
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-xs border-t border-gray-800">
        <p>&copy; 2026 Sobat Peduli Sampah Desa Mekarmaya. All Rights Reserved.</p>
    </footer>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        // Toggle mobile menu
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            var menu = document.getElementById('mobileMenu');
            var icon = this.querySelector('i');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                menu.classList.add('hidden');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    </script>
</body>
</html>