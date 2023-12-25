<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car::create([
            'model' => 'X33 CROSS MT' ,
            'price' => '800500000' ,
            'lowest_down_payment' => 50 ,
            'brand_id' => 1 ,
            'user_id' => 1
        ],[
            'model' => 'X33 CROSS CVT' ,
            'price' => '897000000' ,
            'lowest_down_payment' => 50 ,
            'brand_id' => 1 ,
            'user_id' => 1
        ],[
            'model' => 'X55 PRO IE' ,
            'price' => '1253800000' ,
            'lowest_down_payment' => 50 ,
            'brand_id' => 1 ,
            'user_id' => 1
        ],[
            'model' => 'Arrizo5 IE FL' ,
            'price' => '1091200000' ,
            'lowest_down_payment' => 50 ,
            'brand_id' => 2 ,
            'user_id' => 1
        ],[
            'model' => 'Arrizo6 PRO EXCELENT' ,
            'price' => '1242400000' ,
            'lowest_down_payment' => 50 ,
            'brand_id' => 2 ,
            'user_id' => 1
        ],[
            'model' => 'FX PREMIUM' ,
            'price' => '1730400000' ,
            'lowest_down_payment' => 40 ,
            'brand_id' => 2 ,
            'user_id' => 1
        ],[
            'model' => 'Tiggo8 PRO MAX IE' ,
            'price' => '2584400000' ,
            'lowest_down_payment' => 65 ,
            'brand_id' => 2 ,
            'user_id' => 1
        ],[
            'model' => 'Tiggo8 PRO E PLUS' ,
            'price' => '2764700000' ,
            'lowest_down_payment' => 65 ,
            'brand_id' => 2 ,
            'user_id' => 1
        ]);
    }
}
