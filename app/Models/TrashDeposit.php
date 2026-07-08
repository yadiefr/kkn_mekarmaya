<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashDeposit extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'trash_deposits';

    // Kolom yang diizinkan untuk pengisian massal (Mass Assignment)
    protected $fillable = [
        'user_id',
        'trash_price_id',
        'weight',
        'price_per_kg',
        'earning',
        'withdrawal_status', // <-- Tambahkan kolom baru ini di sini
        'note',
    ];

    // Mengonversi tipe data otomatis saat diakses oleh Eloquent ORM
    protected $casts = [
        'weight' => 'float',
        'price_per_kg' => 'float',
        'earning' => 'float',
    ];

    /**
     * Relasi ke model User (Satu transaksi setor dimiliki oleh satu warga)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model TrashPrice (Satu transaksi setor merujuk ke satu aturan harga barang)
     */
    public function trashPrice()
    {
        return $this->belongsTo(TrashPrice::class, 'trash_price_id');
    }
}