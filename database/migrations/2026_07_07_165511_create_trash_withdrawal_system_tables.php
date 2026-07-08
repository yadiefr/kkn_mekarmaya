<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL PENGATURAN RENTANG TANGGAL (Diisi oleh Admin)
        Schema::create('withdrawal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('event_name'); // Contoh: "Pencairan Idul Adha 2026"
            $table->date('start_date');   // Contoh: 2026-07-01
            $table->date('end_date');     // Contoh: 2026-07-07
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. TABEL PENGAJUAN TARIK SALDO WARGA
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2); // Nominal total saldo saat diajukan
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable(); // Alasan jika ditolak atau catatan admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
        Schema::dropIfExists('withdrawal_settings');
    }
};