<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Warga - Sobat Sampah Desa Mekarmaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- FontAwesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col justify-center items-center px-4">

    <!-- WRAPPER UTAMA -->
    <div class="w-full max-w-sm">
        
        <!-- TOMBOL KEMBALI KE HALAMAN SEBELUMNYA (LOG IN / BERANDA) -->
        <div class="mb-4 flex justify-between items-center px-1">
            <a href="javascript:history.back()" class="inline-flex items-center text-xs font-semibold text-emerald-700 hover:text-emerald-800 tracking-wide uppercase transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <!-- Indikator Langkah (Step Indicator) -->
            <span id="stepBadge" class="text-[11px] font-bold text-gray-400 bg-gray-200/60 px-2 py-0.5 rounded-md">
                STEP 1 DARI 3
            </span>
        </div>

        <!-- CONTAINER UTAMA (KARTU REGISTRASI) -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
            
            <!-- LOGO UTAMA BANK SAMPAH (Sesuai Gambar 4, 5, 6) -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo-login.png') }}" alt="Logo Bank Sampah Desa Mekarmaya" class="w-48 h-auto object-contain fallback-image">
            </div>

            <!-- FORM PENDAFTARAN 3 STEP -->
            <form action="#" method="POST" id="regForm">
                @csrf
                
                <!-- ================= STEP 1 (Referensi Gambar 4.jpg) ================= -->
                <div id="step1" class="space-y-4">
                    <div>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    <div>
                        <input type="text" name="nik" id="nik" placeholder="Masukkan NIK" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    <div>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    
                    <div class="pt-2">
                        <button type="button" onclick="nextStep(2)"
                            class="w-full py-2.5 bg-[#238000] hover:bg-emerald-800 text-white font-semibold text-sm rounded-full tracking-wide shadow-sm uppercase transition duration-200 cursor-pointer">
                            LANJUT
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 2 (Referensi Gambar 5.jpg) ================= -->
                <div id="step2" class="space-y-4 hidden">
                    <div>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    <div>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200 appearance-none cursor-pointer">
                            <option value="" disabled selected class="text-gray-400">Jenis Kelamin</option>
                            <option value="Laki-laki" class="text-gray-800">Laki-laki</option>
                            <option value="Perempuan" class="text-gray-800">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <input type="text" name="alamat" id="alamat" placeholder="Alamat Lengkap" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    
                    <div class="pt-2 flex gap-3">
                        <button type="button" onclick="prevStep(1)"
                            class="w-1/3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm rounded-full tracking-wide transition duration-200 cursor-pointer">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" onclick="nextStep(3)"
                            class="w-2/3 py-2.5 bg-[#238000] hover:bg-emerald-800 text-white font-semibold text-sm rounded-full tracking-wide shadow-sm uppercase transition duration-200 cursor-pointer">
                            LANJUT
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 3 (Referensi Gambar 6.jpg) ================= -->
                <div id="step3" class="space-y-4 hidden">
                    <div>
                        <input type="text" name="whatsapp" id="whatsapp" placeholder="Nomor WhatsApp" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    <div>
                        <input type="password" name="password" id="password" placeholder="Masukkan Password" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required
                            class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    
                    <div class="pt-2 flex gap-3">
                        <button type="button" onclick="prevStep(2)"
                            class="w-1/3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold text-sm rounded-full tracking-wide transition duration-200 cursor-pointer">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="submit"
                            class="w-2/3 py-2.5 bg-[#238000] hover:bg-emerald-800 text-white font-semibold text-sm rounded-full tracking-wide shadow-sm uppercase transition duration-200 cursor-pointer">
                            DAFTAR
                        </button>
                    </div>
                </div>
            </form>

            <!-- KATA-KATA LINK LOGIN -->
            <div class="mt-6 text-xs font-medium text-gray-500 tracking-wide">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-[#238000] hover:underline font-semibold ml-0.5">Login Sekarang</a>
            </div>

        </div>
    </div>

    <!-- JAVASCRIPT LOGIC PENGATUR STEP & FALLBACK IMAGE -->
    <script>
        function nextStep(step) {
            // Validasi dasar sebelum pindah ke step berikutnya
            if (step === 2) {
                if (!document.getElementById('nama_lengkap').value || !document.getElementById('nik').value || !document.getElementById('tempat_lahir').value) {
                    alert('Mohon isi semua data di langkah ini.');
                    return;
                }
                document.getElementById('step1').classList.add('hidden');
                document.getElementById('step2').classList.remove('hidden');
                document.getElementById('stepBadge').innerText = "STEP 2 DARI 3";
            } else if (step === 3) {
                if (!document.getElementById('tanggal_lahir').value || !document.getElementById('jenis_kelamin').value || !document.getElementById('alamat').value) {
                    alert('Mohon isi semua data di langkah ini.');
                    return;
                }
                document.getElementById('step2').classList.add('hidden');
                document.getElementById('step3').classList.remove('hidden');
                document.getElementById('stepBadge').innerText = "STEP 3 DARI 3";
            }
        }

        function prevStep(step) {
            if (step === 1) {
                document.getElementById('step2').classList.add('hidden');
                document.getElementById('step1').classList.remove('hidden');
                document.getElementById('stepBadge').innerText = "STEP 1 DARI 3";
            } else if (step === 2) {
                document.getElementById('step3').classList.add('hidden');
                document.getElementById('step2').classList.remove('hidden');
                document.getElementById('stepBadge').innerText = "STEP 2 DARI 3";
            }
        }

        // Penanganan warna teks bawaan untuk tag select (Dropdown)
        const selectEl = document.getElementById('jenis_kelamin');
        selectEl.addEventListener('change', function() {
            if(this.value !== "") {
                this.classList.remove('text-gray-400');
                this.classList.add('text-gray-800');
            }
        });

        // Fallback jika file gambar logo belum tersedia di folder public
        document.addEventListener("DOMContentLoaded", function() {
            const img = document.querySelector('.fallback-image');
            img.onerror = function() {
                this.style.display = 'none';
                const placeholder = document.createElement('div');
                placeholder.className = "bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-dashed border-emerald-200 font-medium text-xs max-w-xs mx-auto";
                placeholder.innerHTML = "<i class='fas fa-image text-xl block mb-1 text-emerald-600'></i> Logo Bank Sampah<br><span class='text-[10px] font-normal text-gray-400'>(Simpan di: public/images/logo-login.png)</span>";
                img.parentNode.appendChild(placeholder);
            };
        });
    </script>

</body>
</html>