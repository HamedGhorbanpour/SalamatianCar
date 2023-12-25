<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => 'MVM' ,
            'user_id' => 1 ,
        ]);
        Brand::create([
            'name' => 'Fownix' ,
            'user_id' => 1 ,
        ]);

    }
}
