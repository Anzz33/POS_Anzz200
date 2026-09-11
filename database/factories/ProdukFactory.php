<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    public function definition(): array
    {
        $daftarProduk = [
            // Minuman Kafe
            'Espresso', 
            'Americano', 
            'Caramel Macchiato', 
            'Hazelnut Latte',
            'Matcha Green Tea', 
            'Vanilla Milkshake', 
            'Ice Lemon Tea', 
            'Avocado Coffee',
            'Taro Latte', 
            'Ice Chocolate',
            
            // Makanan & Camilan Kafe
            'Croissant Cheese', 
            'French Fries', 
            'Chicken Wings', 
            'Waffle Ice Cream',
            'Club Sandwich', 
            'Spaghetti Carbonara', 
            'Beef Burger', 
            'Beef Nachos',
            'Roti Bakar Kaya', 
            'Pancake Maple'
        ];

        $variasi = ['Original', 'Large', 'Extra Cheese', 'Hot', 'Ice', 'Crispy'];

        $hargaBeli = fake()->numberBetween(8, 25) * 1000;
        $hargaJual = $hargaBeli + (fake()->numberBetween(5, 15) * 1000);

        return [
            'user_id'     => User::inRandomOrder()->value('id') ?? 1,
            'nama_produk' => fake()->randomElement($daftarProduk) . ' ' . fake()->randomElement($variasi),
            'harga_beli'  => $hargaBeli,
            'harga_jual'  => $hargaJual,
            'stok'        => fake()->numberBetween(0, 50),
        ];
    }
}