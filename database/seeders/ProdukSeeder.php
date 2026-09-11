<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()->id ?? 1;

        $daftarProduk = [
            ['nama' => 'Kopi Susu Gula Aren', 'harga_beli' => 10000, 'harga_jual' => 18000, 'stok' => 25, 'foto' => 'default.png'],
            ['nama' => 'Es Teh Manis', 'harga_beli' => 2000, 'harga_jual' => 5000, 'stok' => 50, 'foto' => 'default.png'],
            ['nama' => 'Roti Bakar Cokelat Keju', 'harga_beli' => 7000, 'harga_jual' => 15000, 'stok' => 15, 'foto' => 'default.png'],
            ['nama' => 'Donat Kentang Glaze', 'harga_beli' => 4000, 'harga_jual' => 8000, 'stok' => 3, 'foto' => 'default.png'],
            ['nama' => 'Nasi Goreng Spesial', 'harga_beli' => 12000, 'harga_jual' => 22000, 'stok' => 30, 'foto' => 'default.png'],
            ['nama' => 'Ayam Geprek Sambal Korek', 'harga_beli' => 11000, 'harga_jual' => 20000, 'stok' => 20, 'foto' => 'default.png'],
            ['nama' => 'Air Mineral 600ml', 'harga_beli' => 2000, 'harga_jual' => 4000, 'stok' => 100, 'foto' => 'default.png'],
            ['nama' => 'Matcha Ice Latte', 'harga_beli' => 12000, 'harga_jual' => 24000, 'stok' => 5, 'foto' => 'default.png'],
            ['nama' => 'Kentang Goreng Original', 'harga_beli' => 6000, 'harga_jual' => 14000, 'stok' => 2, 'foto' => 'default.png'],
            ['nama' => 'Kopi Americano Hot', 'harga_beli' => 8000, 'harga_jual' => 16000, 'stok' => 0, 'foto' => 'default.png'],
        ];

        foreach ($daftarProduk as $item) {
            Produk::create(array_merge($item, [
                'user_id' => $userId,
            ]));
        }
    }
}