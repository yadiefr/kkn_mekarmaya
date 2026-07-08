<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi & Kamus Sampah - Desa Mekarmaya</title>
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
                        SOBAT SAMPAH<br>
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
            </div>
        </div>
    </nav>

    <!-- HEADER & PENCARIAN INTERAKTIF -->
    <header class="bg-gradient-to-b from-emerald-50/50 to-white py-16 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Fitur Pintar Warga</span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mt-3 tracking-tight">Kamus Sampah Interaktif</h2>
            <p class="mt-2 text-xs text-gray-500 max-w-md mx-auto leading-relaxed">Bingung jenis sampah Anda masuk kategori apa dan harus diapakan? Temukan jawabannya secara instan di bawah ini.</p>
            
            <!-- Kolom Pencarian -->
            <div class="mt-6 relative max-w-xl mx-auto">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 text-sm">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" id="searchInput" onkeyup="searchTrash()" placeholder="Cari misal: Styrofoam, Plastik, Daun, Baterai..." 
                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-full bg-white shadow-xs focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 outline-none text-sm transition duration-200 placeholder-gray-400">
            </div>
        </div>
    </header>

    <!-- HASIL PENCARIAN KAMUS -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="text-left mb-4 hidden px-2" id="searchTitle">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Hasil Filter Kamus:</h4>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="trashGrid">
            
            @forelse($trashDictionaries as $item)
                <!-- Kartu Sampah Dinamis -->
                <!-- Menambahkan kelas 'hidden-trash' dan 'hidden' untuk data urutan ke-5 ke atas -->
                <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden trash-card flex flex-col justify-between {{ $loop->iteration > 4 ? 'hidden-trash hidden' : '' }}" 
                     data-name="{{ Str::lower($item->item_name) }}">
                    
                    <div class="h-32 bg-gray-100 relative flex items-center justify-center text-gray-400 text-3xl">
                        <!-- Menampilkan Gambar dari Database jika ada, jika tidak pakai icon default -->
                        @if($item->image_path && file_exists(public_path($item->image_path)))
                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->item_name }}" class="w-full h-full object-contain p-4">
                        @else
                            @if(Str::lower($item->category_name) == 'organik')
                                <i class="fas fa-leaf text-green-300"></i>
                            @elseif(Str::lower($item->category_name) == 'anorganik')
                                <i class="fas fa-box-open text-emerald-300"></i>
                            @elseif(Str::contains(Str::lower($item->category_name), 'b3'))
                                <i class="fas fa-battery-quarter text-yellow-400"></i>
                            @else
                                <i class="fas fa-trash-can text-gray-300"></i>
                            @endif
                        @endif
                        
                        <!-- Badge Kategori Menggunakan Gaya Dinamis Dari Database (color_code) -->
                        <span class="absolute top-3 right-3 text-[10px] font-bold px-2 py-0.5 rounded border {{ $item->category_color ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                            {{ $item->category_name }}
                        </span>
                    </div>

                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <h5 class="font-bold text-sm text-gray-900 capitalize">{{ $item->item_name }}</h5>
                        
                        <!-- Box Catatan Tindakan (Menyesuaikan warna tema kategori secara otomatis) -->
                        @php
                            $alertClass = 'bg-gray-50 text-gray-700 border-gray-100';
                            $iconClass = 'fa-circle-info';
                            
                            if (Str::lower($item->category_name) == 'organik') {
                                $alertClass = 'bg-green-50/50 text-green-700 border-green-100/50';
                                $iconClass = 'fa-check-circle';
                            } elseif (Str::lower($item->category_name) == 'anorganik') {
                                $alertClass = 'bg-emerald-50/50 text-emerald-700 border-emerald-100/50';
                                $iconClass = 'fa-exclamation-triangle';
                            } elseif (Str::contains(Str::lower($item->category_name), 'b3')) {
                                $alertClass = 'bg-yellow-50/50 text-yellow-700 border-yellow-100/50';
                                $iconClass = 'fa-biohazard';
                            }
                        @endphp

                        <p class="text-xs {{ $alertClass }} p-2.5 rounded-lg border mt-2 leading-relaxed">
                            <i class="fas {{ $iconClass }} mr-1 text-[10px]"></i> 
                            <strong>Tindakan:</strong> {{ $item->action_note }}
                        </p>
                    </div>
                </div>
            @empty
                <!-- Tampilan Jika Dataset Kosong di Database -->
                <div class="col-span-full text-center py-12 text-gray-400 border border-dashed border-gray-200 rounded-xl bg-white">
                    <i class="fas fa-database text-2xl mb-2 text-gray-300"></i>
                    <p class="text-xs">Data kamus sampah belum diisi oleh Admin.</p>
                </div>
            @endforelse

        </div>
        
        <!-- Pesan Kosong Hasil Pencarian JavaScript (Tetap Dipertahankan) -->
        <div id="noResult" class="text-center py-12 text-gray-400 hidden border border-dashed border-gray-200 rounded-xl bg-white">
            <i class="fas fa-folder-open text-2xl mb-2 text-gray-300"></i>
            <p class="text-xs">Barang tidak ditemukan. Coba gunakan kata kunci lain.</p>
        </div>

        <!-- BUTTON LIHAT SEMUA DATA (Hanya Muncul Jika Data Lebih Dari 4) -->
       <!-- BUTTON KONTROL TAMPILAN DATA (Hanya Muncul Jika Data Lebih Dari 4) -->
       @if(count($trashDictionaries) > 4)
            <div class="text-center mt-8" id="loadMoreContainer">
                <button type="button" onclick="toggleTrashData()" id="btnToggleTrash" data-status="collapsed"
                    class="inline-flex items-center space-x-2 bg-white hover:bg-gray-50 text-emerald-700 border border-gray-200 font-medium text-xs py-2 px-4 rounded-lg shadow-2xs transition duration-200 cursor-pointer">
                    <span id="textToggleTrash">Lihat Semua Data</span>
                    <i id="iconToggleTrash" class="fas fa-chevron-down text-[10px]"></i>
                </button>
            </div>
        @endif
    </section>

    <!-- JAVASCRIPT UNTUK MENAMPILKAN DATA SISA -->
    <script>
        // Logika Pengontrol Buka-Tutup Sisa Data Kamus
        function toggleTrashData() {
            let btn = document.getElementById('btnToggleTrash');
            let text = document.getElementById('textToggleTrash');
            let icon = document.getElementById('iconToggleTrash');
            let hiddenCards = document.getElementsByClassName('hidden-trash');
            let currentStatus = btn.getAttribute('data-status');

            if (currentStatus === 'collapsed') {
                // PROSES MEMBUKA: Tampilkan semua data ke-5 ke atas
                for (let i = 0; i < hiddenCards.length; i++) {
                    hiddenCards[i].classList.remove('hidden');
                }
                // Ubah status dan tampilan tombol
                text.innerText = "Tutup Data";
                icon.className = "fas fa-chevron-up text-[10px]";
                btn.setAttribute('data-status', 'expanded');
            } else {
                // PROSES MENUTUP: Sembunyikan kembali data ke-5 ke atas
                for (let i = 0; i < hiddenCards.length; i++) {
                    hiddenCards[i].classList.add('hidden');
                }
                // Kembalikan status dan tampilan tombol ke awal
                text.innerText = "Lihat Semua Data";
                icon.className = "fas fa-chevron-down text-[10px]";
                btn.setAttribute('data-status', 'collapsed');
                
                // Otomatis scroll halus kembali ke atas grid agar warga tidak kebingungan
                document.getElementById('trashGrid').scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Modifikasi fungsi pencarian agar sinkron dengan tombol buka-tutup
        function searchTrash() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let cards = document.getElementsByClassName('trash-card');
            let hasResult = false;
            let title = document.getElementById('searchTitle');
            let loadMoreContainer = document.getElementById('loadMoreContainer');
            let btn = document.getElementById('btnToggleTrash');

            if(input.trim() !== "") {
                title.classList.remove('hidden');
                if(loadMoreContainer) loadMoreContainer.classList.add('hidden'); 
            } else {
                title.classList.add('hidden');
                if(loadMoreContainer) {
                    loadMoreContainer.classList.remove('hidden');
                    // Jika kolom pencarian dihapus, kembalikan teks tombol sesuai status aslinya
                    if(btn && btn.getAttribute('data-status') === 'expanded') {
                        document.getElementById('textToggleTrash').innerText = "Tutup Data";
                        document.getElementById('iconToggleTrash').className = "fas fa-chevron-up text-[10px]";
                    } else if (btn) {
                        document.getElementById('textToggleTrash').innerText = "Lihat Semua Data";
                        document.getElementById('iconToggleTrash').className = "fas fa-chevron-down text-[10px]";
                    }
                }
            }

            for (let i = 0; i < cards.length; i++) {
                let name = cards[i].getAttribute('data-name');
                
                if (name.includes(input)) {
                    if (input.trim() === "" && cards[i].classList.contains('hidden-trash') && (!btn || btn.getAttribute('data-status') === 'collapsed')) {
                        cards[i].style.display = "none";
                    } else {
                        cards[i].style.display = "flex";
                        hasResult = true;
                    }
                } else {
                    cards[i].style.display = "none";
                }
            }

            let noResult = document.getElementById('noResult');
            if (hasResult || input.trim() === "") {
                noResult.classList.add('hidden');
            } else {
                noResult.classList.remove('hidden');
            }
        }
    </script>
    <!-- GRID PROGRAM EDUKASI UTAMA -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div class="text-center mb-10">
            <h3 class="text-xl font-bold text-gray-900 tracking-tight">Katalog Panduan & Wawasan Hijau</h3>
            <p class="text-xs text-gray-400 mt-1">Pilih kategori edukasi di bawah untuk membuka panduan langkah demi langkah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 0: Resep Kompos -->
            <div onclick="openModal('modalKompos')" class="bg-white p-5 rounded-xl border border-gray-100 shadow-xs hover:shadow-md transition duration-200 cursor-pointer flex flex-col justify-between group">
                <div>
                    <div class="w-9 h-9 bg-emerald-50 text-emerald-700 rounded-lg flex items-center justify-center text-sm mb-4"><i class="fas fa-mortar-pestle"></i></div>
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-emerald-700 transition">Membuat Pupuk Kompos</h4>
                    <p class="text-xs text-gray-400 mt-1.5 leading-relaxed">Resep mengolah limbah basah sisa makanan dapur menjadi pupuk organik penyubur tanah.</p>
                </div>
                <span class="text-[11px] font-semibold text-emerald-700 mt-4 inline-block">Buka Panduan <i class="fas fa-arrow-right ml-1 text-[9px]"></i></span>
            </div>

            <!-- Card 1: Hemat Energi -->
            <div onclick="openModal('modalEnergi')" class="bg-white p-5 rounded-xl border border-gray-100 shadow-xs hover:shadow-md transition duration-200 cursor-pointer flex flex-col justify-between group">
                <div>
                    <div class="w-9 h-9 bg-amber-50 text-amber-700 rounded-lg flex items-center justify-center text-sm mb-4"><i class="fas fa-lightbulb"></i></div>
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-amber-700 transition">Efisiensi & Hemat Energi</h4>
                    <p class="text-xs text-gray-400 mt-1.5 leading-relaxed">Strategi jitu mengurangi emisi karbon lewat kebiasaan penggunaan listrik harian.</p>
                </div>
                <span class="text-[11px] font-semibold text-amber-700 mt-4 inline-block">Buka Panduan <i class="fas fa-arrow-right ml-1 text-[9px]"></i></span>
            </div>

            <!-- Card 2: Keanekaragaman Hayati -->
            <div onclick="openModal('modalAlam')" class="bg-white p-5 rounded-xl border border-gray-100 shadow-xs hover:shadow-md transition duration-200 cursor-pointer flex flex-col justify-between group">
                <div>
                    <div class="w-9 h-9 bg-blue-50 text-blue-700 rounded-lg flex items-center justify-center text-sm mb-4"><i class="fas fa-tree"></i></div>
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-blue-700 transition">Pelestarian Ekosistem Alam</h4>
                    <p class="text-xs text-gray-400 mt-1.5 leading-relaxed">Langkah taktis menjaga keseimbangan flora, fauna, dan rantai ekologi lokal desa.</p>
                </div>
                <span class="text-[11px] font-semibold text-blue-700 mt-4 inline-block">Buka Panduan <i class="fas fa-arrow-right ml-1 text-[9px]"></i></span>
            </div>

            <!-- Card 3: Bijak Plastik -->
            <div onclick="openModal('modalPlastik')" class="bg-white p-5 rounded-xl border border-gray-100 shadow-xs hover:shadow-md transition duration-200 cursor-pointer flex flex-col justify-between group">
                <div>
                    <div class="w-9 h-9 bg-purple-50 text-purple-700 rounded-lg flex items-center justify-center text-sm mb-4"><i class="fas fa-recycle"></i></div>
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-purple-700 transition">Pengelolaan Sampah Plastik</h4>
                    <p class="text-xs text-gray-400 mt-1.5 leading-relaxed">Gerakan zero-waste melalui metode reduksi, pemilahan sumber, dan ekonomi sirkular.</p>
                </div>
                <span class="text-[11px] font-semibold text-purple-700 mt-4 inline-block">Buka Panduan <i class="fas fa-arrow-right ml-1 text-[9px]"></i></span>
            </div>

            <!-- Card 4: Konservasi Air -->
            <div onclick="openModal('modalAir')" class="bg-white p-5 rounded-xl border border-gray-100 shadow-xs hover:shadow-md transition duration-200 cursor-pointer flex flex-col justify-between group">
                <div>
                    <div class="w-9 h-9 bg-cyan-50 text-cyan-700 rounded-lg flex items-center justify-center text-sm mb-4"><i class="fas fa-droplet"></i></div>
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-cyan-700 transition">Konservasi & Perlindungan Air</h4>
                    <p class="text-xs text-gray-400 mt-1.5 leading-relaxed">Cara cerdas menghemat air higienis dan memaksimalkan penyerapan air tanah kedaerahan.</p>
                </div>
                <span class="text-[11px] font-semibold text-cyan-700 mt-4 inline-block">Buka Panduan <i class="fas fa-arrow-right ml-1 text-[9px]"></i></span>
            </div>
        </div>
    </section>

    <!-- ========================================== JENDELA MODAL BOX DATA ========================================== -->

    <!-- MODAL 0: RESEP KOMPOS -->
    <div id="modalKompos" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full overflow-hidden max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-emerald-800 text-white">
                <h4 class="font-bold text-sm tracking-tight inline-flex items-center"><i class="fas fa-mortar-pestle mr-2"></i> Resep Membuat Pupuk Kompos</h4>
                <button onclick="closeModal('modalKompos')" class="text-white/70 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto space-y-4 text-xs text-gray-600 leading-relaxed">
                <div>
                    <h5 class="font-bold text-gray-900 mb-1">Bahan & Alat Pokok:</h5>
                    <p>Sampah basah (sisa sayur, buah, kopi), sampah kering (daun gugur, serbuk kayu), wadah ember berlubang bawah, tanah, dan cairan bio-aktivator EM4.</p>
                </div>
                <div class="space-y-2">
                    <h5 class="font-bold text-gray-900">Alur Eksekusi:</h5>
                    <p><strong>1.</strong> Lubangi dasar ember komposter untuk jalur pembuangan sisa rembesan air lindi agar tidak membusuk anaerob.</p>
                    <p><strong>2.</strong> Cacah sampah hijau berukuran kecil (1-2 cm) guna mempercepat luas bidang kontak mikroorganisme pengurai.</p>
                    <p><strong>3.</strong> Tumpuk berlapis: sampah kering paling dasar, sampah basah di tengah, dan lapisan tanah penutup di atas setebal 3cm.</p>
                    <p><strong>4.</strong> Siram berkala dengan larutan EM4 untuk kelembaban ideal. Aduk merata seminggu sekali. Kompos matang siap panen dalam 4-6 minggu.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 1: HEMAT ENERGI -->
    <div id="modalEnergi" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full overflow-hidden max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-amber-700 text-white">
                <h4 class="font-bold text-sm tracking-tight inline-flex items-center"><i class="fas fa-lightbulb mr-2"></i> Edukasi Hemat Energi</h4>
                <button onclick="closeModal('modalEnergi')" class="text-white/70 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto space-y-4 text-xs text-gray-600 leading-relaxed">
                <div class="border-l-2 border-amber-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 1: Kesadaran Dasar (Awareness)</h5>
                    <p class="mt-1 text-gray-500">Memahami konversi daya listrik yang dominan bersumber dari fosil batu bara. Galakkan gerakan disiplin mencabut kepala stopkontak elektronik dari saklar saat kondisi standby.</p>
                </div>
                <div class="border-l-2 border-amber-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 2: Pembiasaan Perilaku (Action)</h5>
                    <p class="mt-1 text-gray-500">Maksimalkan bukaan jendela untuk pencahayaan alami siang hari, konversi ke lampu berbasis LED hemat daya, dan setel pendingin ruangan ruangan (AC) konstan pada suhu optimal 24–25°C.</p>
                </div>
                <div class="border-l-2 border-amber-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 3: Investasi Hijau (Sustaining)</h5>
                    <p class="mt-1 text-gray-500">Prioritaskan pembelian perangkat bersertifikasi bintang hemat energi, beralih ke moda transportasi publik, serta pelopori efisiensi lampu fasilitas komunal masyarakat luar.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 2: PELESTARIAN ALAM -->
    <div id="modalAlam" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full overflow-hidden max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-blue-700 text-white">
                <h4 class="font-bold text-sm tracking-tight inline-flex items-center"><i class="fas fa-tree mr-2"></i> Pelestarian Ekosistem Alam</h4>
                <button onclick="closeModal('modalAlam')" class="text-white/70 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto space-y-4 text-xs text-gray-600 leading-relaxed">
                <div class="border-l-2 border-blue-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 1: Pengenalan & Empati</h5>
                    <p class="mt-1 text-gray-500">Membangun kepekaan sosial terhadap biodiversitas fauna-flora lokal di sekeliling wilayah pemukiman warga serta melarang keras tindakan perburuan satwa liar dilindungi.</p>
                </div>
                <div class="border-l-2 border-blue-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 2: Penghidupan Rumahtangga</h5>
                    <p class="mt-1 text-gray-500">Pemanfaatan pekarangan terbatas via taman vertikal hidroponik dan menanam jenis vegetasi bunga lokal penarik agen polinator alami seperti lebah dan kupu-kupu.</p>
                </div>
                <div class="border-l-2 border-blue-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 3: Konservasi Aktif</h5>
                    <p class="mt-1 text-gray-500">Turut berkontribusi langsung dalam program penanaman bibit pohon penghijauan, restorasi kawasan bakau (mangrove), serta menolak keras komoditas perdagangan satwa eksotis.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 3: BIJAK PLASTIK -->
    <div id="modalPlastik" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full overflow-hidden max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-purple-700 text-white">
                <h4 class="font-bold text-sm tracking-tight inline-flex items-center"><i class="fas fa-recycle mr-2"></i> Pengelolaan Sampah & Zero Waste</h4>
                <button onclick="closeModal('modalPlastik')" class="text-white/70 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto space-y-4 text-xs text-gray-600 leading-relaxed">
                <div class="border-l-2 border-purple-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 1: Reduksi Sumber (Reduce)</h5>
                    <p class="mt-1 text-gray-500">Membudayakan penggunaan kantong belanja kain mandiri, wadah makan guna ulang, serta membawa tumbler pribadi demi menekan akumulasi wadah kemasan plastik sekali pakai.</p>
                </div>
                <div class="border-l-2 border-purple-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 2: Pemilahan Terstruktur</h5>
                    <p class="mt-1 text-gray-500">Klasifikasikan limbah minimal ke dalam dua wadah penampung primer terpisah: Sampah Organik (sisa konsumsi) dan Sampah Anorganik (plastik, kertas, kaca, alumunium).</p>
                </div>
                <div class="border-l-2 border-purple-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 3: Sirkular Ekonomi</h5>
                    <p class="mt-1 text-gray-500">Kembangkan kreativitas pengolahan limbah minyak jelantah sisa dapur menjadi lilin penerangan, pembuatan larutan pembersih alami eco-enzyme, atau penyetoran berkala ke unit Bank Sampah.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 4: KONSERVASI AIR -->
    <div id="modalAir" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full overflow-hidden max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-cyan-700 text-white">
                <h4 class="font-bold text-sm tracking-tight inline-flex items-center"><i class="fas fa-droplet mr-2"></i> Konservasi Keberlanjutan Air</h4>
                <button onclick="closeModal('modalAir')" class="text-white/70 hover:text-white cursor-pointer"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto space-y-4 text-xs text-gray-600 leading-relaxed">
                <div class="border-l-2 border-cyan-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 1: Efisiensi Keran Kontrol</h5>
                    <p class="mt-1 text-gray-500">Disiplin menutup laju air keran saat membersihkan sikat gigi atau pengaplikasian sabun cuci tangan, serta menyegerakan rekonstruksi teknis pipa instalasi air yang terindikasi bocor.</p>
                </div>
                <div class="border-l-2 border-cyan-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 2: Daur Ulang Domestik (Greywater)</h5>
                    <p class="mt-1 text-gray-500">Manfaatkan limbah air bilasan sisa cucian beras atau sayur-mayur untuk irigasi tanaman pot, dan alokasikan air bilasan akhir cucian pakaian guna membersihkan lantai garasi atau toilet.</p>
                </div>
                <div class="border-l-2 border-cyan-500 pl-3">
                    <h5 class="font-bold text-gray-900">Tahap 3: Retensi Air Tanah</h5>
                    <p class="mt-1 text-gray-500">Aktif mengimplementasikan cetakan silinder lubang biopori bioretensi atau instalasi sumur resapan dangkal di area pekarangan rumah demi menjaga pasokan cadangan air tanah lokal.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-xs border-t border-gray-800">
        <p>&copy; 2026 Sobat Sampah Desa Mekarmaya. All Rights Reserved.</p>
    </footer>

    <!-- INTERACTIVE SCRIPT CONTROL -->
    <script>
        // Logika Kamus Filter Interaktif
        function searchTrash() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let cards = document.getElementsByClassName('trash-card');
            let hasResult = false;
            let title = document.getElementById('searchTitle');

            if(input.trim() !== "") {
                title.classList.remove('hidden');
            } else {
                title.classList.add('hidden');
            }

            for (let i = 0; i < cards.length; i++) {
                let name = cards[i].getAttribute('data-name');
                if (name.includes(input)) {
                    cards[i].style.display = "flex";
                    hasResult = true;
                } else {
                    cards[i].style.display = "none";
                }
            }

            let noResult = document.getElementById('noResult');
            if (hasResult) {
                noResult.classList.add('hidden');
            } else {
                noResult.classList.remove('hidden');
            }
        }

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