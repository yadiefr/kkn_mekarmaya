<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobat Sampah Desa Mekarmaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <!-- Google Font Inter untuk Tampilan Premium -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-emerald-100 selection:text-emerald-900">

    <!-- NAVBAR (Ref: Gambar 2.jpg dengan polesan profesional) -->
    <nav class="bg-emerald-800 text-white shadow-sm sticky top-0 z-50 border-b border-emerald-900/20 backdrop-blur-md bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Judul / Logo Website -->
                <div class="flex-shrink-0">
                    <h1 class="font-bold text-sm leading-tight uppercase tracking-wider">
                        SOBAT SAMPAH<br>
                        <span class="text-emerald-300 text-xs font-normal normal-case tracking-normal">Desa Mekarmaya</span>
                    </h1>
                </div>
                <!-- Menu Navigasi (Desktop) -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-1 text-xs font-semibold tracking-wide uppercase">
                        <a href="#" class="bg-emerald-900 text-emerald-200 px-3 py-2 rounded-lg">Beranda</a>
                        <a href="{{ route('edukasi') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-3 py-2 rounded-lg transition duration-200">Edukasi</a>
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
                <a href="#" class="bg-emerald-900 text-emerald-200 px-4 py-3 rounded-lg block">Beranda</a>
                <a href="{{ route('edukasi') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-3 rounded-lg block transition duration-200">Edukasi</a>
                <a href="{{ route('banksampah') }}" class="text-emerald-100 hover:bg-emerald-700 hover:text-white px-4 py-3 rounded-lg block transition duration-200">Bank Sampah</a>
                <div class="pt-2 mt-2 border-t border-emerald-700">
                    <a href="{{ route('login') }}" class="bg-white text-emerald-800 hover:bg-emerald-50 px-4 py-3 rounded-lg transition duration-200 font-bold normal-case shadow-sm block text-center mt-2">Masuk / Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="bg-gradient-to-b from-emerald-50/50 to-white py-20 px-4 border-b border-gray-100">
        <div class="max-w-3xl mx-auto text-center">
            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                Mekarmaya Bersih & Hijau
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-4 tracking-tight leading-tight">
                Ubah Sampah Jadi Berkah <br>
                <span class="text-emerald-600">Untuk Lingkungan Desa Kita</span>
            </h2>
            <p class="mt-4 text-sm text-gray-500 max-w-xl mx-auto leading-relaxed">
                Selamat datang di platform digital Sobat Sampah Desa Mekarmaya. Mari bersama-sama belajar mengelola lingkungan dan tabung sampahmu menjadi investasi masa depan.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-3 max-w-xs sm:max-w-none mx-auto">
                <a href="{{ route('register') }}" class="bg-emerald-700 hover:bg-emerald-800 text-white font-medium text-sm py-3 sm:py-2.5 px-5 rounded-lg shadow-sm transition duration-200 block sm:inline-block w-full sm:w-auto text-center">
                    <i class="fas fa-recycle mr-1.5 text-xs"></i> Mulai Menabung
                </a>
                <a href="{{ route('edukasi') }}" class="bg-white hover:bg-gray-50 text-gray-700 font-medium text-sm py-3 sm:py-2.5 px-5 rounded-lg shadow-sm border border-gray-200 transition duration-200 block sm:inline-block w-full sm:w-auto text-center">
                    Pelajari Edukasi
                </a>
            </div>
        </div>
    </header>

    <!-- FITUR UTAMA LINGKUNGAN DAN BANK SAMPAH -->
    <section class="py-16 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Layanan & Fitur Warga</h3>
            <p class="text-xs text-gray-400 mt-1.5">Segala kemudahan dalam satu genggaman demi kenyamanan desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <!-- Kartu 1: Edukasi -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-xs hover:shadow-sm transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-700 rounded-lg flex items-center justify-center text-base font-bold mb-4 border border-emerald-100/50">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h4 class="text-base font-bold text-gray-900 mb-2">Edukasi Sampah</h4>
                    <p class="text-xs text-gray-500 leading-relaxed mb-4">
                        Pelajari artikel menarik mengenai pengelolaan sampah organik, anorganik, serta tips menjaga kelestarian lingkungan Desa Mekarmaya.
                    </p>
                </div>
                <div>
                    <a href="{{ route('edukasi') }}" class="text-xs font-semibold text-emerald-700 inline-flex items-center hover:text-emerald-800 group">
                        Baca Artikel <i class="fas fa-arrow-right ml-1.5 text-[10px] transform group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Kartu 2: Bank Sampah -->
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-xs hover:shadow-sm transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-700 rounded-lg flex items-center justify-center text-base font-bold mb-4 border border-emerald-100/50">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h4 class="text-base font-bold text-gray-900 mb-2">Tabungan Bank Sampah</h4>
                    <p class="text-xs text-gray-500 leading-relaxed mb-4">
                        Setorkan sampah anorganik Anda yang bernilai ekonomis kepada petugas desa, cek saldo tabungan, dan pantau mutasi secara realtime.
                    </p>
                </div>
                <div>
                    <a href="{{ route('banksampah') }}" class="text-xs font-semibold text-emerald-700 inline-flex items-center hover:text-emerald-800 group">
                        Cek Harga Sampah <i class="fas fa-arrow-right ml-1.5 text-[10px] transform group-hover:translate-x-0.5 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ALUR PENDAFTARAN WARGA -->
    <section class="bg-gray-100/60 py-16 px-4 border-t border-b border-gray-200/30">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Cara Bergabung Jadi Sobat Sampah</h3>
                <p class="text-xs text-gray-400 mt-1.5">Ikuti 3 langkah mudah berikut untuk mulai berkontribusi</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative text-center">
                <div class="flex flex-col items-center bg-white p-6 rounded-xl border border-gray-200/40">
                    <div class="w-8 h-8 bg-emerald-700 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-xs">1</div>
                    <h5 class="font-bold text-sm mt-3 text-gray-800">Daftar Akun</h5>
                    <p class="text-xs text-gray-400 mt-2 px-2 leading-relaxed">Buat akun warga secara online melalui tombol daftar yang tersedia.</p>
                </div>
                <div class="flex flex-col items-center bg-white p-6 rounded-xl border border-gray-200/40">
                    <div class="w-8 h-8 bg-emerald-700 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-xs">2</div>
                    <h5 class="font-bold text-sm mt-3 text-gray-800">Aktivasi oleh Admin</h5>
                    <p class="text-xs text-gray-400 mt-2 px-2 leading-relaxed">Admin desa akan meninjau dan mengaktifkan akun Anda agar siap digunakan.</p>
                </div>
                <div class="flex flex-col items-center bg-white p-6 rounded-xl border border-gray-200/40">
                    <div class="w-8 h-8 bg-emerald-700 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-xs">3</div>
                    <h5 class="font-bold text-sm mt-3 text-gray-800">Setor & Cuan!</h5>
                    <p class="text-xs text-gray-400 mt-2 px-2 leading-relaxed">Mulai kumpulkan sampah, bawa ke bank sampah desa, dan kumpulkan saldomu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-xs border-t border-gray-800">
        <p>&copy; 2026 Sobat Sampah Desa Mekarmaya. All Rights Reserved.</p>
        <p class="mt-1 text-[11px] text-gray-500 px-4">Dibuat demi kelestarian lingkungan dan transparansi tata kelola desa.</p>
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