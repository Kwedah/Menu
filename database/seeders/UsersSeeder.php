<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'kwedah',
            'email' => 'kwedah@yahoo.com',
            'password' => Hash::make('11111111'),
            'phone' => 011000000001,
            'address' => 'mahalla',
        ]);
        
        User::create([
            'name' => 'adel',
            'email' => 'adel@yahoo.com',
            'password' => Hash::make('11111111'),
            'phone' => 011000000002,
            'address' => 'mahalla',
        ]);

        User::create([
            'name' => 'azmy',
            'email' => 'azmy@yahoo.com',
            'password' => Hash::make('11111111'),
            'phone' => 011000000003,
            'address' => 'mahalla',
        ]);
    }
}
