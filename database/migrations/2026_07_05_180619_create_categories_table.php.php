<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Organik, Anorganik, B3 (Bahan Berbahaya & Beracun)
            $table->string('slug')->unique();
            $table->text('description')->nullable(); // Deskripsi singkat kategori
            $table->string('color_code')->nullable(); // Untuk warna label di UI (misal: text-green-600)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};