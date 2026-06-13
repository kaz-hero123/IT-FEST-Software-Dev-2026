<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Wisata',    'slug' => 'wisata'],
            ['name' => 'Kuliner',   'slug' => 'kuliner'],
            ['name' => 'UMKM',      'slug' => 'umkm'],
            ['name' => 'Spot Foto', 'slug' => 'spot-foto'],
        ];

        DB::table('categories')->insert($categories);
    }
}
