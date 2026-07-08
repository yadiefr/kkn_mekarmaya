<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashPrice extends Model
{
    use HasFactory;

    // 1. Deklarasikan nama tabel secara eksplisit (opsional, tapi disarankan)
    protected $table = 'trash_prices';

    // 2. Daftarkan kolom yang boleh diisi secara massal (Mass Assignment) oleh Admin
    protected $fillable = [
        'item_name',
        'image_path',
        'buy_price',
        'sell_price',
        'is_active',
    ];

    // 3. Konversi tipe data otomatis (Casting) saat dipanggil oleh Eloquent
    protected $casts = [
        'buy_price' => 'float',
        'sell_price' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * RELASI: Satu jenis harga sampah bisa memiliki banyak riwayat transaksi setoran warga.
     * Hubungan ke tabel 'trash_deposits' yang baru saja kita buat sebelumnya.
     */
    public function deposits()
    {
        return $this->hasMany(TrashDeposit::class, 'trash_price_id');
    }
}