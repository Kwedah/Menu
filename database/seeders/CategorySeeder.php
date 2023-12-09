<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Burger',
            'description' => 'Burger',
            'image' => 'Burger',
        ]);

        Category::create([
            'name' => 'Pizza',
            'description' => 'Pizza',
            'image' => 'Pizza',
        ]);

        Category::create([
            'name' => 'Sushi',
            'description' => 'Sushi',
            'image' => 'Sushi',
        ]);

        Category::create([
            'name' => 'Donuts',
            'description' => 'Donuts',
            'image' => 'Donuts',
        ]);

        Category::create([
            'name' => 'Drinks',
            'description' => 'Drinks',
            'image' => 'Drinks',
        ]);

        Category::create([
            'name' => 'Chickens',
            'description' => 'Chickens',
            'image' => 'Chickens',
        ]);
    }
}
