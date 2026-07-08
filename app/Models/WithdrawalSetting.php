<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalSetting extends Model
{
    use HasFactory;

    // Nama tabel di database (opsional, pastikan sesuai)
    protected $table = 'withdrawal_settings';

    // Daftarkan seluruh kolom agar diizinkan untuk pengisian massal
    protected $fillable = [
        'event_name', // <-- Kolom yang menyebabkan error sudah terdaftar di sini
        'start_date',
        'end_date',
        'is_active',
    ];

    // Mengonversi string date dari database menjadi objek Carbon otomatis di Laravel
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
}