@extends('layouts.warga')

@section('title', 'Profil Saya')
@section('header_title', 'Kelola Profil')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Form Edit Profil -->
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-100">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center text-2xl font-bold uppercase shadow-inner">
                {{ Str::substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-sm text-emerald-600 font-medium">{{ $user->username }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-100 p-4 rounded-xl">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('warga.profil.update') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->name) }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    @error('nama_lengkap')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required oninput="this.value = this.value.toLowerCase().replace(/\s/g, '')"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    @error('username')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    @error('tempat_lahir')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d') : '') }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    @error('tanggal_lahir')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition cursor-pointer">
                        <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    @error('whatsapp')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" required
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-sm uppercase tracking-wider transition duration-200 cursor-pointer">
                    <i class="fas fa-save mr-2"></i> Simpan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Form Ganti Password -->
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-100">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center text-xl shadow-inner">
                <i class="fas fa-key"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">Ganti Password</h2>
                <p class="text-xs text-gray-500">Amankan akun Anda dengan mengganti password secara berkala.</p>
            </div>
        </div>

        @if(session('password_success'))
            <div class="mb-6 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-100 p-4 rounded-xl">
                <i class="fas fa-check-circle mr-1"></i> {{ session('password_success') }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Password Saat Ini</label>
                <input type="password" name="current_password" required
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition">
                @error('current_password')
                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Password Baru</label>
                <input type="password" name="new_password" required
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition">
                @error('new_password')
                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" required
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition">
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-xl shadow-sm uppercase tracking-wider transition duration-200 cursor-pointer">
                    <i class="fas fa-lock mr-2"></i> Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
