<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi - Bank Sampah Desa Mekarmaya</title>
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
        .modal-active { overflow: hidden; }
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
                    <a href="{{ route('banksampah') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Harga Sampah</a>
                    <a href="{{ route('beranda') }}#cara-kerja" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 rounded-xl transition">Cara Kerja</a>
                    <a href="{{ route('edukasi') }}" class="px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 rounded-xl transition">Edukasi</a>
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
                <a href="{{ route('banksampah') }}" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Harga Sampah</a>
                <a href="{{ route('beranda') }}#cara-kerja" class="px-4 py-3 text-slate-700 hover:bg-slate-50 rounded-xl">Cara Kerja</a>
                <a href="{{ route('edukasi') }}" class="px-4 py-3 bg-emerald-50 text-emerald-700 rounded-xl">Edukasi</a>
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
    <!-- GRID PROGRAM EDUKASI UTAMA -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="text-center mb-10 mt-10">
            <h3 class="text-xl font-bold text-gray-900 tracking-tight">Katalog Panduan & Wawasan Hijau</h3>
            <p class="text-xs text-gray-400 mt-1">Pilih kategori edukasi di bawah untuk membuka panduan langkah demi langkah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($edukasis as $edukasi)
                <div onclick="openModal('modalEdukasi{{ $edukasi->id }}')" class="bg-white p-5 rounded-xl border border-gray-100 shadow-xs hover:shadow-md transition duration-200 cursor-pointer flex flex-col justify-between group">
                    <div>
                        <div class="w-full h-32 mb-4 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border border-gray-100 relative">
                            @if($edukasi->image_path && file_exists(public_path($edukasi->image_path)))
                                <img src="{{ asset($edukasi->image_path) }}" alt="{{ $edukasi->title }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas {{ $edukasi->icon ?? 'fa-book' }} text-emerald-300 text-4xl"></i>
                            @endif
                            <span class="absolute top-2 right-2 bg-white/90 backdrop-blur-xs text-emerald-800 text-[9px] font-bold px-2 py-1 rounded shadow-xs uppercase tracking-wider">
                                {{ $edukasi->category }}
                            </span>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition">{{ $edukasi->title }}</h4>
                        <p class="text-xs text-gray-400 mt-1.5 leading-relaxed line-clamp-2">{{ Str::limit($edukasi->content, 80) }}</p>
                    </div>
                    <span class="text-[11px] font-semibold text-emerald-700 mt-4 inline-block">Buka Panduan <i class="fas fa-arrow-right ml-1 text-[9px]"></i></span>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-400 border border-dashed border-gray-200 bg-white rounded-xl">
                    <i class="fas fa-book-open text-2xl mb-2 text-gray-300"></i>
                    <p class="text-xs">Belum ada konten edukasi yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ========================================== JENDELA MODAL BOX DATA ========================================== -->

    @foreach($edukasis as $edukasi)
        <div id="modalEdukasi{{ $edukasi->id }}" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-lg max-w-lg w-full overflow-hidden max-h-[90vh] flex flex-col">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-emerald-800 text-white">
                    <h4 class="font-bold text-sm tracking-tight inline-flex items-center"><i class="fas {{ $edukasi->icon ?? 'fa-book' }} mr-2"></i> {{ $edukasi->category }}</h4>
                    <button onclick="closeModal('modalEdukasi{{ $edukasi->id }}')" class="text-white/70 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-6 overflow-y-auto space-y-4 text-xs text-gray-600 leading-relaxed">
                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $edukasi->title }}</h3>
                    
                    @if($edukasi->image_path && file_exists(public_path($edukasi->image_path)))
                        <img src="{{ asset($edukasi->image_path) }}" alt="{{ $edukasi->title }}" class="w-full h-auto rounded-lg mb-4 border border-gray-100">
                    @endif

                    <div class="whitespace-pre-line text-sm text-gray-700 leading-relaxed">
                        {{ $edukasi->content }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-xs border-t border-gray-800">
        <p>&copy; 2026 Sobat Peduli Sampah Desa Mekarmaya. All Rights Reserved.</p>
    </footer>

    <!-- INTERACTIVE SCRIPT CONTROL -->
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

        // Logika Pengontrol Buka-Tutup Jendela Modal Box
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.classList.add('modal-active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('modal-active');
        }

        // Menutup modal otomatis jika area luar modal diklik oleh user
        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
                document.body.classList.remove('modal-active');
            }
        }
    </script>
</body>
</html>