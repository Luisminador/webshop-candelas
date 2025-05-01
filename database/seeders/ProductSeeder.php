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
        Product::insert([
            ['name' => 'Vaniljljus', 'price' => 99, 'category_id' => 1],
            ['name' => 'Lavendeldoft', 'price' => 109, 'category_id' => 1],
            ['name' => 'Doftljus i glasburk', 'price' => 149, 'category_id' => 1],
        ]);
    }
}
