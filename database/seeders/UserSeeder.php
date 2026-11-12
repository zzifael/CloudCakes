<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data User Admin & Kasir
        User::create([
            'name' => 'Admin CloudCakes',
            'email' => 'admin@cloudcakes.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@cloudcakes.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);

        // 2. Data Awal Kategori Roti
        $categories = [
            'Bread',
            'Cake',
            'Pastry',
            'Savory Bakery',
            'Cookies & Biscuits'
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name), // Menghasilkan: bread, cake, pastry, savory-bakery, cookies-biscuits
            ]);
        }
    }
}