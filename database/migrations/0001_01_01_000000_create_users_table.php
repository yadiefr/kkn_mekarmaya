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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Data Step 1
            $table->string('name'); // Nama Lengkap
            $table->string('no_kk')->nullable(); // Nomor Kartu Keluarga
            $table->string('nik')->unique(); // Nomor Induk Kependudukan (Unik)
            $table->string('tempat_lahir')->nullable();

            // Data Step 2
            $table->date('tanggal_lahir')->nullable(); // Menggunakan tipe DATE agar rapi di database
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('alamat')->nullable();

            // Data Step 3 & Sistem Keamanan
            $table->string('whatsapp')->nullable(); // Nomor WhatsApp warga
            $table->string('password');
            
            // Kolom Tambahan Sistem (Role & Akses)
            $table->enum('role', ['admin', 'warga'])->default('warga'); // Pilihan: admin atau warga
            $table->enum('status_akses', ['on', 'off'])->default('off'); // Default 'off' sebelum diaktivasi admin
            
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

