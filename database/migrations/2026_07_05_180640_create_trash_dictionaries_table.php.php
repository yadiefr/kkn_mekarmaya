<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trash_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relasi ke tabel kategori
            $table->string('item_name'); // Contoh: Styrofoam, Daun Kering, Botol Plastik
            $table->string('image_path')->nullable(); // Menyimpan path/nama file gambar sampah
            $table->text('action_note'); // Tindakan: "Jangan dibakar! Serahkan ke bank sampah."
            $table->boolean('is_countable_for_bank')->default(true); // Apakah bisa dijual ke bank sampah?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_dictionaries');
    }
};