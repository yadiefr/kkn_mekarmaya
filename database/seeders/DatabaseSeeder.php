<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Panggil TrashPriceSeeder di sini
        $this->call([
            UserSeeder::class,
            TrashPriceSeeder::class,
            TrashDictionarySeeder::class, // <-- Tambahkan baris ini
            WithdrawalSettingSeeder::class,
        ]);


    }
}
