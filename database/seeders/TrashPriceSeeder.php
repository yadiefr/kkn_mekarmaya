<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrashPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'item_name'  => 'Tutup Botol',
                'image_path' => 'images/trash/tutup-botol.png',
                'buy_price'  => 2000.00,
                'sell_price' => 3000.00,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name'  => 'Botol Bening',
                'image_path' => 'images/trash/botol-bening.png',
                'buy_price'  => 2000.00,
                'sell_price' => 3000.00,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name'  => 'Botol Berwarna',
                'image_path' => 'images/trash/botol-berwarna.png',
                'buy_price'  => 1000.00,
                'sell_price' => 1500.00,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name'  => 'Botol Sampo',
                'image_path' => 'images/trash/botol-sampo.png',
                'buy_price'  => 1500.00,
                'sell_price' => 2500.00,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name'  => 'Gelas Plastik',
                'image_path' => 'images/trash/gelas-plastik.png',
                'buy_price'  => 3000.00,
                'sell_price' => 5000.00,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Memasukkan data list barang ke dalam tabel trash_prices
        foreach ($data as $item) {
            \App\Models\TrashPrice::updateOrCreate(
                ['item_name' => $item['item_name']],
                $item
            );
        }
    }
}