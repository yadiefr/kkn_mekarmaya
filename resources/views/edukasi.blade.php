<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi - Sobat Peduli Sampah Desa Mekarmaya</title>
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
        .modal-active { overflow: hidden; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-emerald-100 selection:text-emerald-900">

    <!-- NAVBAR -->
    <nav class="bg-emerald-800 text-white shadow-sm sticky top-0 z-50 border-b border-emerald-900/20 backdrop-blur-md bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <h1 class="font-bold text-sm leading-tight uppercase tracking-wider">
                        SOBAT PEDULI SAMPAH<br>
                        <span class="text-emerald-300 text-xs font-normal normal-case tracking-normal">Desa Mekarmaya</span>
                    </h1>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-1 text-xs font-semibold tracking-wide uppercase">
                        <a href="{{ route('beranda') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-3 py-2 rounded-lg transition duration-200">Beranda</a>
                        <a href="#" class="bg-emerald-900 text-emerald-200 px-3 py-2 rounded-lg">Edukasi</a>
                        <a href="{{ route('banksampah') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-3 py-2 rounded-lg transition duration-200">Bank Sampah</a>
                        <div class="pl-4 ml-2 border-l border-emerald-700">
                            <a href="{{ route('login') }}" class="bg-white text-emerald-800 hover:bg-emerald-50 px-4 py-2 rounded-lg transition duration-200 font-bold normal-case shadow-sm inline-block">Masuk / Daftar</a>
                        </div>
                    </div>
                </div>

                <!-- Hamburger Button (Mobile) -->
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuBtn" class="text-emerald-100 hover:text-white focus:outline-none p-2 cursor-pointer">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-emerald-900 bg-emerald-800 absolute w-full left-0 shadow-lg">
            <div class="px-4 pt-2 pb-4 flex flex-col space-y-2 text-sm font-semibold tracking-wide uppercase">
                <a href="{{ route('beranda') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-3 rounded-lg block transition duration-200">Beranda</a>
                <a href="#" class="bg-emerald-900 text-emerald-200 px-4 py-3 rounded-lg block">Edukasi</a>
                <a href="{{ route('banksampah') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-3 rounded-lg block transition duration-200">Bank Sampah</a>
                <div class="pt-2 mt-2 border-t border-emerald-700">
                    <a href="{{ route('login') }}" class="bg-white text-emerald-800 hover:bg-emerald-50 px-4 py-3 rounded-lg transition duration-200 font-bold normal-case shadow-sm block text-center mt-2">Masuk / Daftar</a>
                </div>
            </div>
        </div>
    </nav>




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