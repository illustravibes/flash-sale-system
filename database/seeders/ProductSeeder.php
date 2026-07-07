<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Macbook M1 Pro 2021',
            'description' => 'Macbook with M1 Pro chip',
            'price' => 150000000,
            'stock' => 10,
        ]);

        Product::create([
            'name' => 'Macbook M2 Pro 2022',
            'description' => 'Macbook with M2 Pro chip',
            'price' => 180000000,
            'stock' => 10,
        ]);

        Product::create([
            'name' => 'Macbook M3 Pro 2023',
            'description' => 'Macbook with M3 Pro chip',
            'price' => 210000000,
            'stock' => 10,
        ]);

        Product::create([
            'name' => 'Macbook M4 Pro 2024',
            'description' => 'Macbook with M4 Pro chip',
            'price' => 240000000,
            'stock' => 10,
        ]);
    }
}
