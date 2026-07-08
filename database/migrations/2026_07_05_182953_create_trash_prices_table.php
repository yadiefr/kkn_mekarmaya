<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trash_prices', function (Blueprint $table) {
            $table->id();
            $table->string('item_name'); // Contoh: Tutup Botol, Botol Bening
            $table->string('image_path')->nullable(); // Path gambar produk sampah
            $table->decimal('buy_price', 10, 2); // Harga beli dari warga (e.g., 2000)
            $table->decimal('sell_price', 10, 2); // Harga jual ke pengepul (e.g., 3000) - Hanya dilihat admin
            $table->boolean('is_active')->default(true); // Status keaktifan jenis barang
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_prices');
    }
};
