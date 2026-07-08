<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrashDictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan Kategori Tersedia & Ambil ID-nya atau Buat Baru
        DB::table('categories')->updateOrInsert(
            ['slug' => 'organik'],
            [
                'name' => 'Organik',
                'description' => 'Sampah alami yang mudah membusuk dan terurai oleh alam.',
                'color_code' => 'bg-green-50 text-green-700 border-green-100',
                'updated_at' => now(),
            ]
        );
        $organikId = DB::table('categories')->where('slug', 'organik')->value('id');

        DB::table('categories')->updateOrInsert(
            ['slug' => 'anorganik'],
            [
                'name' => 'Anorganik',
                'description' => 'Sampah buatan manusia yang sulit terurai secara alami.',
                'color_code' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                'updated_at' => now(),
            ]
        );
        $anorganikId = DB::table('categories')->where('slug', 'anorganik')->value('id');

        DB::table('categories')->updateOrInsert(
            ['slug' => 'b3'],
            [
                'name' => 'Limbah B3',
                'description' => 'Bahan Berbahaya dan Beracun yang memerlukan penanganan khusus.',
                'color_code' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                'updated_at' => now(),
            ]
        );
        $b3Id = DB::table('categories')->where('slug', 'b3')->value('id');

        DB::table('categories')->updateOrInsert(
            ['slug' => 'residu'],
            [
                'name' => 'Residu',
                'description' => 'Sampah yang tidak bisa didaur ulang maupun dikomposkan.',
                'color_code' => 'bg-red-50 text-red-700 border-red-100',
                'updated_at' => now(),
            ]
        );
        $residuId = DB::table('categories')->where('slug', 'residu')->value('id');

        // 2. Dataset Kamus Sampah Beragam & Valid Berdasarkan Ilmu Lingkungan
        $items = [
            // --- KATEGORI ORGANIK ---
            [
                'category_id' => $organikId,
                'item_name' => 'Sisa Sayuran & Kulit Buah',
                'image_path' => 'images/kamus/sisa-sayur.png',
                'action_note' => 'Sangat bagus untuk pembuatan pupuk kompos cair/padat atau eco-enzyme di rumah.',
                'is_countable_for_bank' => false,
            ],
            [
                'category_id' => $organikId,
                'item_name' => 'Daun Kering & Ranting',
                'image_path' => 'images/kamus/daun-kering.png',
                'action_note' => 'Gunakan sebagai unsur karbon (sampah cokelat) yang seimbang untuk campuran komposter.',
                'is_countable_for_bank' => false,
            ],
            [
                'category_id' => $organikId,
                'item_name' => 'Ampas Kopi & Teh',
                'image_path' => 'images/kamus/ampas-kopi.png',
                'action_note' => 'Bisa ditaburkan langsung ke tanah tanaman sebagai pupuk alami atau dicampur ke kompos.',
                'is_countable_for_bank' => false,
            ],
            [
                'category_id' => $organikId,
                'item_name' => 'Cangkang Telur',
                'image_path' => 'images/kamus/cangkang-telur.png',
                'action_note' => 'Tumbuk sampai halus. Kandungan kalsiumnya sangat baik untuk menutrisi akar tanaman hias.',
                'is_countable_for_bank' => false,
            ],

            // --- KATEGORI ANORGANIK ---
            [
                'category_id' => $anorganikId,
                'item_name' => 'Styrofoam / Gabus Kotak',
                'image_path' => 'images/kamus/styrofoam.png',
                'action_note' => 'Jangan pernah dibakar karena menghasilkan gas beracun! Bersihkan dan bawa ke bank sampah.',
                'is_countable_for_bank' => true,
            ],
            [
                'category_id' => $anorganikId,
                'item_name' => 'Botol Plastik Air Mineral',
                'image_path' => 'images/kamus/botol-plastik.png',
                'action_note' => 'Nilai ekonomi tinggi. Kosongkan airnya, lepaskan label plastik, lalu tabung di Bank Sampah.',
                'is_countable_for_bank' => true,
            ],
            [
                'category_id' => $anorganikId,
                'item_name' => 'Kardus & Kotak Karton',
                'image_path' => 'images/kamus/kardus.png',
                'action_note' => 'Lipat rata agar tidak memakan tempat, jaga agar tetap kering, lalu setorkan ke petugas bank sampah.',
                'is_countable_for_bank' => true,
            ],
            [
                'category_id' => $anorganikId,
                'item_name' => 'Kaleng Minuman Alumunium',
                'image_path' => 'images/kamus/kaleng-alumunium.png',
                'action_note' => 'Bilas bagian dalam kaleng agar tidak dikerubungi semut, kempiskan, lalu bawa ke bank sampah.',
                'is_countable_for_bank' => true,
            ],
            [
                'category_id' => $anorganikId,
                'item_name' => 'Koran & Buku Bekas',
                'image_path' => 'images/kamus/koran-bekas.png',
                'action_note' => 'Ikat dengan tali plastik per kelompok agar rapi, siap ditimbang untuk menambah saldo tabungan Anda.',
                'is_countable_for_bank' => true,
            ],

            // --- KATEGORI LIMBAH B3 ---
            [
                'category_id' => $b3Id,
                'item_name' => 'Baterai Bekas & Aki',
                'image_path' => 'images/kamus/baterai-bekas.png',
                'action_note' => 'Sangat berbahaya! Mengandung logam berat. Pisahkan di wadah khusus, serahkan ke pos B3 desa.',
                'is_countable_for_bank' => false,
            ],
            [
                'category_id' => $b3Id,
                'item_name' => 'Lampu TL / Neon Rusak',
                'image_path' => 'images/kamus/lampu-neon.png',
                'action_note' => 'Mengandung uap merkuri. Bungkus dengan koran/kardus agar tidak pecah saat diserahkan ke petugas.',
                'is_countable_for_bank' => false,
            ],
            [
                'category_id' => $b3Id,
                'item_name' => 'Botol Semprotan Obat Nyamuk',
                'image_path' => 'images/kamus/semprotan-nyamuk.png',
                'action_note' => 'Wadah bertekanan tinggi (aerosol). Jangan dilubangi atau dibakar karena rentan meledak.',
                'is_countable_for_bank' => false,
            ],

            // --- KATEGORI RESIDU ---
            [
                'category_id' => $residuId,
                'item_name' => 'Popok Sekali Pakai & Pembalut',
                'image_path' => 'images/kamus/popok-bayi.png',
                'action_note' => 'Tidak bisa didaur ulang demi alasan higienis. Bungkus rapat dan buang ke tong sampah residu.',
                'is_countable_for_bank' => false,
            ],
            [
                'category_id' => $residuId,
                'item_name' => 'Puntung Rokok',
                'image_path' => 'images/kamus/puntung-rokok.png',
                'action_note' => 'Filternya terbuat dari selulosa asetat yang sulit hancur dan beracun bagi tanah. Buang ke pos residu.',
                'is_countable_for_bank' => false,
            ],
            [
                'category_id' => $residuId,
                'item_name' => 'Kaca Cermin Rusak / Pecah',
                'image_path' => 'images/kamus/kaca-pecah.png',
                'action_note' => 'Hati-hati tajam! Bungkus tebal dengan koran bekas agar aman bagi petugas kebersihan desa.',
                'is_countable_for_bank' => false,
            ],
        ];

        // 3. Masukkan Massal ke Database
        foreach ($items as $item) {
            $item['updated_at'] = now();
            if (!isset($item['created_at'])) {
                $item['created_at'] = now();
            }
            DB::table('trash_dictionaries')->updateOrInsert(
                ['item_name' => $item['item_name']],
                $item
            );
        }
    }
}