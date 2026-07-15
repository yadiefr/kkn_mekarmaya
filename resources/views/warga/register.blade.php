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
<body class="bg-gray-50 min-h-screen flex flex-col justify-center items-center py-8 px-4">

    <!-- WRAPPER UTAMA -->
    <div class="w-full max-w-md">
        
        <!-- TOMBOL KEMBALI KE HALAMAN SEBELUMNYA (LOG IN / BERANDA) -->
        <div class="mb-4 flex justify-between items-center px-1">
            <a href="javascript:history.back()" class="inline-flex items-center text-xs font-semibold text-emerald-700 hover:text-emerald-800 tracking-wide uppercase transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <!-- CONTAINER UTAMA (KARTU REGISTRASI) -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
            
            <!-- LOGO UTAMA BANK SAMPAH (Sesuai Gambar 4, 5, 6) -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo-login.png') }}" alt="Logo Bank Sampah Desa Mekarmaya" class="w-48 h-auto object-contain fallback-image">
            </div>

            @if($errors->any())
                <div class="mb-4 text-xs font-medium text-red-700 bg-red-50 border border-red-100 p-3 rounded-xl text-left">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM PENDAFTARAN (1 HALAMAN) -->
            <form action="{{ route('register') }}" method="POST" id="regForm" class="space-y-4">
                @csrf
                
                <div>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap" required
                        class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                </div>
                <div>
                    <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk') }}" placeholder="Nomor Kartu Keluarga" required
                        class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                </div>
                <div>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" placeholder="Nomor NIK" required
                        class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    <div>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                </div>

                <div>
                    <select name="jenis_kelamin" id="jenis_kelamin" required
                        class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200 appearance-none cursor-pointer">
                        <option value="" disabled selected class="text-gray-400">Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }} class="text-gray-800">Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }} class="text-gray-800">Perempuan</option>
                    </select>
                </div>

                <div>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" placeholder="Alamat Lengkap" required
                        class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                </div>

                <div>
                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" placeholder="Nomor WhatsApp" required
                        class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="password" name="password" id="password" placeholder="Password" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi Password" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-2.5 bg-[#238000] hover:bg-emerald-800 text-white font-semibold text-sm rounded-full tracking-wide shadow-sm uppercase transition duration-200 cursor-pointer">
                        DAFTAR
                    </button>
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
        // Penanganan warna teks bawaan untuk tag select (Dropdown)
        const selectEl = document.getElementById('jenis_kelamin');
        if (selectEl.value !== "") {
            selectEl.classList.remove('text-gray-400');
            selectEl.classList.add('text-gray-800');
        }
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