<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'user_id',
        'total_pembayaran',
        'pelanggan_nama',
        'metode_pembayaran',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan relasi ke tabel item_penjualan
    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class);
    }
}