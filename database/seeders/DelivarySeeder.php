<?php

namespace Database\Seeders;

use App\Models\Delivary;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DelivarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Delivary::create([
            'name' => 'fouad',
            'phone' => 01101010010,
            'id_number' => 01000000000000000000001,
            'image' => 'fouad',
            'rate' => 3,
        ]);

        Delivary::create([
            'name' => 'ali',
            'phone' => 01201010010,
            'id_number' => 01000000000000000000002,
            'image' => 'ali',
            'rate' => 2.5,
        ]);
    }
}
