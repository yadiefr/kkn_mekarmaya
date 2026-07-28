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
        // 1. Tambahkan kolom username nullable terlebih dahulu
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
        });

        // 2. Salin data nik yang sudah ada ke kolom username agar tidak ada yang kosong/duplikat
        \Illuminate\Support\Facades\DB::table('users')->update(['username' => \Illuminate\Support\Facades\DB::raw('nik')]);

        // 3. Tambahkan unique constraint dan hapus kolom lama
        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
            $table->dropColumn(['nik', 'no_kk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_kk')->nullable();
            $table->string('nik')->nullable();
        });

        \Illuminate\Support\Facades\DB::table('users')->update(['nik' => \Illuminate\Support\Facades\DB::raw('username')]);

        Schema::table('users', function (Blueprint $table) {
            $table->unique('nik');
            $table->dropColumn('username');
        });
    }
};
