<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trash_deposits', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (Warga yang menabung)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke tabel trash_prices (Jenis barang/sampah yang disetor)
            $table->foreignId('trash_price_id')->constrained('trash_prices')->onDelete('cascade');
            
            // Berat sampah yang disetorkan (menggunakan decimal, contoh: 2.50 kg)
            $table->decimal('weight', 8, 2); 
            
            // Harga beli per kg pada SAAT TRANSAKSI (Penting dicatat jika di kemudian hari harga naik/turun)
            $table->decimal('price_per_kg', 10, 2);
            
            // Pendapatan yang didapat warga (Hasil dari: weight * price_per_kg)
            $table->decimal('earning', 10, 2);

            // Menggunakan Enum agar statusnya lebih jelas
            $table->enum('withdrawal_status', ['belum_ditarik', 'sudah_ditarik'])->default('belum_ditarik');
            
            // Catatan tambahan (opsional, misal: "Kondisi bersih")
            $table->text('note')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trash_deposits');
    }
};