<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakerContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regencies = \App\Models\Regency::all();
        $categories = \App\Models\Category::all();
        $users = \App\Models\User::all();

        if ($regencies->isEmpty() || $categories->isEmpty() || $users->isEmpty()) {
            $this->command->info('Please run RegencySeeder, CategorySeeder, and UserSeeder first.');
            return;
        }

        foreach ($regencies as $regency) {
            foreach ($categories as $category) {
                // Buat 4 konten per kombinasi kabupaten x kategori
                $contents = \App\Models\Content::factory(4)->create([
                    'regency_id' => $regency->id,
                    'category_id' => $category->id,
                    'user_id' => $users->random()->id,
                ]);

                // Buat 3 foto untuk setiap konten
                foreach ($contents as $content) {
                    // Foto utama
                    \App\Models\Photo::factory()->create([
                        'content_id' => $content->id,
                        'is_primary' => true,
                    ]);
                    
                    // Foto tambahan
                    \App\Models\Photo::factory(2)->create([
                        'content_id' => $content->id,
                        'is_primary' => false,
                    ]);
                }
            }
        }
    }
}
