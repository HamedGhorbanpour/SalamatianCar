<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SoroushGhazavi',
            'email' => 'soroush.ghazavi@gmail.com',
            'password' => Hash::make('admin123456'),
        ]);
        User::create([
            'name' => 'HamedGhorbanpour',
            'email' => 'hamedgh3285@gmail.com',
            'password' => Hash::make('admin123456'),
        ]);
        User::create([
            'name' => 'SajadPourajam',
            'email' => 'admin@demo.com',
            'password' => Hash::make('11111111'),
        ]);
    }
}
