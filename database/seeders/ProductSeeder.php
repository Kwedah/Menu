<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Cheese Burger',
            'description' => 'Cheese Burger',
            'image' => 'Cheese Burger',
            'price' => 100,
            'rate' => 3,
            'favorite' => 3,
            'category_id' => 1,
            'restrunt_id' => 1,
        ]);

        Product::create([
            'name' => 'Beef Burger',
            'description' => 'Beef Burger',
            'image' => 'Beef Burger',
            'price' => 120,
            'rate' => 3,
            'favorite' => 3,
            'category_id' => 1,
            'restrunt_id' => 1,
        ]);

        Product::create([
            'name' => 'Shrimp',
            'description' => 'Shrimp',
            'image' => 'Shrimp',
            'price' => 120,
            'rate' => 3,
            'favorite' => 3,
            'category_id' => 2,
            'restrunt_id' => 1,
        ]);

        Product::create([
            'name' => 'Julienne chicken',
            'description' => 'Julienne chicken',
            'image' => 'Julienne chicken',
            'price' => 120,
            'rate' => 3,
            'favorite' => 3,
            'category_id' => 2,
            'restrunt_id' => 1,
        ]);

        Product::create([
            'name' => 'Strawberry',
            'description' => 'Strawberry',
            'image' => 'Strawberry',
            'price' => 120,
            'rate' => 3,
            'favorite' => 3,
            'category_id' => 4,
            'restrunt_id' => 1,
        ]);
        
        Product::create([
            'name' => 'chocolate',
            'description' => 'chocolate',
            'image' => 'chocolate',
            'price' => 120,
            'rate' => 3,
            'favorite' => 3,
            'category_id' => 4,
            'restrunt_id' => 1,
        ]);
    }
}
