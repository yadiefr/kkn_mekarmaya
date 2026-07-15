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
        Schema::table('trash_deposits', function (Blueprint $table) {
            $table->boolean('is_reset')->default(false)->after('withdrawal_status');
        });

        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->boolean('is_reset')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trash_deposits', function (Blueprint $table) {
            $table->dropColumn('is_reset');
        });

        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropColumn('is_reset');
        });
    }
};
