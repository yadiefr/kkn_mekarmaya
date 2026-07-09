<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Warga - Sobat Sampah Desa Mekarmaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
    <!-- FontAwesome untuk ikon jika diperlukan -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <!-- Google Font Inter agar tipografi lebih elegan & profesional -->
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
        
        <!-- TOMBOL KEMBALI DI ATAS KARTU LOGIN -->
        <div class="mb-4 text-left">
            <a href="javascript:history.back()" class="inline-flex items-center text-xs font-semibold text-emerald-700 hover:text-emerald-800 tracking-wide uppercase transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <!-- CONTAINER UTAMA LOGIN (KARTU) -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
            
            <!-- TEMPAT UNTUK MEMASUKKAN IMG (LOGO LOG IN) -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo-login.png') }}" alt="Logo Bank Sampah Desa Mekarmaya" class="w-48 h-auto object-contain fallback-image">
            </div>



            @if($errors->has('auth_error'))
                <div class="mb-4 text-xs font-medium text-red-700 bg-red-50 border border-red-100 p-3 rounded-xl text-left">
                    <i class="fas fa-circle-exclamation mr-1"></i> {{ $errors->first('auth_error') }}
                </div>
            @endif

            <!-- FORM LOGIN (HREF SUDAH DIBETULKAN KE ROUTE) -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- INPUT NIK -->
                <div>
                    <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK" required
                        class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                </div>

                <!-- INPUT PASSWORD -->
                <div>
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-center text-sm font-medium text-gray-800 placeholder-gray-400 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition duration-200">
                </div>

                <!-- TOMBOL LOGIN -->
                <div class="pt-1">
                    <button type="submit" 
                        class="w-full py-2.5 bg-[#238000] hover:bg-emerald-800 text-white font-semibold text-sm rounded-full tracking-wide shadow-sm uppercase transition duration-200 cursor-pointer">
                        LOGIN
                    </button>
                </div>
            </form>

            <!-- KATA-KATA LINK DAFTAR -->
            <div class="mt-6 text-xs font-medium text-gray-500 tracking-wide">
                Belum punya akun? <a href="{{ route('register') }}" class="text-[#238000] hover:underline font-semibold ml-0.5">Daftar Sekarang</a>
            </div>

        </div>
    </div>

    <!-- SCRIPT TAMBAHAN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const img = document.querySelector('.fallback-image');
            img.onerror = function() {
                this.style.display = 'none';
                const placeholder = document.createElement('div');
                placeholder.className = "bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-dashed border-emerald-200 font-medium text-xs max-w-xs mx-auto";
                placeholder.innerHTML = "<i class='fas fa-image text-xl block mb-1 text-emerald-600'></i> Logo Bank Sampah<br><span class='text-[10px] font-normal text-gray-400'>(Simpan di: public/images/logo-login.png)</span>";
                img.parentNode.appendChild(placeholder);
            };

            // Meminta Izin Notifikasi Browser untuk Jadwal Penarikan
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
    
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Pendaftaran Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Siap Menunggu',
                confirmButtonColor: '#059669', // Emerald 600
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    title: 'text-lg font-bold text-gray-900',
                    confirmButton: 'rounded-full font-semibold px-6 py-2 shadow-sm text-sm'
                }
            });
        });
    </script>
    @endif

</body>
</html>