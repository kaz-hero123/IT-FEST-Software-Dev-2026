<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegencySeeder extends Seeder
{
    public function run(): void
    {
        $regencies = [
            ['name' => 'Bangkalan',  'slug' => 'bangkalan'],
            ['name' => 'Sampang',    'slug' => 'sampang'],
            ['name' => 'Pamekasan',  'slug' => 'pamekasan'],
            ['name' => 'Sumenep',    'slug' => 'sumenep'],
        ];

        DB::table('regencies')->insert($regencies);
    }
}
