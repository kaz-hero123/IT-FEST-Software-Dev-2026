<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegencySeeder extends Seeder
{
    public function run(): void
    {
        $regencies = [
            ['name' => 'Bangkalan',  'slug' => 'bangkalan', 'img' => 'images/culture/culture02.jpg'],
            ['name' => 'Sampang',    'slug' => 'sampang',   'img' => 'images/food.png'],
            ['name' => 'Pamekasan',  'slug' => 'pamekasan', 'img' => 'images/culture/culture15.jpg'],
            ['name' => 'Sumenep',    'slug' => 'sumenep',   'img' => 'images/culture/culture08.jpg'],
        ];

        DB::table('regencies')->upsert($regencies, ['slug'], ['name', 'img']);
    }
}
