<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawalSettingSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\WithdrawalSetting::updateOrCreate(
            ['event_name' => 'Minggu pertama'],
            [
                'start_date' => '2026-07-01',
                'end_date' => '2026-07-07',
                'is_active' => true,
            ]
        );
    }
}