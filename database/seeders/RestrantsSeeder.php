<?php

namespace Database\Seeders;

use App\Models\Restrant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RestrantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restrant::create([
            'name' => 'El-Helw',
            'email' => 'elhelw@yahoo.com',
            'password' => Hash::make('11111111'),
            'phone' => 011000000001,
            'address' => 'mahalla',
        ]);

        Restrant::create([
            'name' => 'El-JooW',
            'email' => 'eljow@yahoo.com',
            'password' => Hash::make('11111111'),
            'phone' => 011000000002,
            'address' => 'mahalla',
        ]);
    }
}
