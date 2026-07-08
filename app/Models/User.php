<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Properti fillable untuk mengizinkan input data massal.
     */
    protected $fillable = [
        'name',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'whatsapp',
        'password',
        'role',
        'status_akses',
    ];

    /**
     * Properti hidden untuk menyembunyikan data sensitif.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts untuk mengubah tipe data saat diakses.
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'password' => 'hashed', // Password otomatis di-hash demi keamanan
    ];
}