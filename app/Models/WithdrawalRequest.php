<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Impor kelas BelongsTo

class WithdrawalRequest extends Model
{
    use HasFactory;

    // Daftarkan kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'admin_note',
    ];

    /**
     * Relasi Balik ke Model User (Setiap pengajuan dimiliki oleh satu warga)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}