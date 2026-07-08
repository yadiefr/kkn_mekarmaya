<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // 1. DATA AKUN ADMIN DESA
            [
                'name' => 'Admin Desa Mekarmaya',
                'nik' => '1234567890123456', // Gunakan NIK ini untuk login admin
                'tempat_lahir' => 'Mekarmaya',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Kantor Kepala Desa Mekarmaya, No. 01',
                'whatsapp' => '081122334455',
                'password' => Hash::make('admin123'), // Password untuk login admin
                'role' => 'admin',
                'status_akses' => 'on', // Admin otomatis aktif ('on')
            ],
            // 2. DATA AKUN WARGA (CONTOH)
            [
                'name' => 'Budi Setiawan',
                'nik' => '3214010203040002', // Gunakan NIK ini untuk pancingan login warga
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1995-08-17',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Kampung Durian Runtuh, RT 03 / RW 01',
                'whatsapp' => '085712345678',
                'password' => Hash::make('warga123'), // Password untuk login warga
                'role' => 'warga',
                'status_akses' => 'on', // Kita set 'on' dulu agar bisa langsung ditransfer ke dashboard warga saat diuji coba
            ]
        ];

        foreach ($users as $userData) {
            \App\Models\User::updateOrCreate(
                ['nik' => $userData['nik']], // Kunci unik
                $userData // Data yang diupdate/dibuat
            );
        }
    }
}