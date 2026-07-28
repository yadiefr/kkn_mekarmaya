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
                'username' => 'adminmekarmaya', // Gunakan Username ini untuk login admin
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'jenis_kelamin' => null,
                'alamat' => null,
                'whatsapp' => null,
                'password' => Hash::make('MekarmayaTerusMaju'), // Password untuk login admin
                'role' => 'admin',
                'status_akses' => 'on', // Admin otomatis aktif ('on')
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::updateOrCreate(
                ['username' => $userData['username']], // Kunci unik
                $userData // Data yang diupdate/dibuat
            );
        }
    }
}