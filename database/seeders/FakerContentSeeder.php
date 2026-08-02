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

        $districts = [
            'bangkalan' => ['Arosbaya','Bangkalan','Blega','Burneh','Galis','Geger','Kamal','Klampis','Kokop','Konang','Kwanyar','Labang','Modung','Sepulu','Socah','Tanah Merah','Tanjung Bumi','Tragah'],
            'sampang'   => ['Banyuates','Camplong','Jrengik','Karangpenang','Kedungdung','Ketapang','Omben','Pangarengan','Robatal','Sampang'],
            'pamekasan' => ['Batumarmar', 'Galis', 'Kadur', 'Larangan', 'Pademawu', 'Pakong', 'Palengaan', 'Pamekasan', 'Pasean', 'Pegantenan', 'Proppo', 'Tlanakan', 'Waru'],
            'sumenep'   => ['Ambunten', 'Arjasa', 'Batang-Batang', 'Batuan', 'Batuputih', 'Bluto', 'Dasuk', 'Dungkek', 'Ganding', 'Gapura', 'Gayam', 'Giligenteng', 'Guluk-Guluk', 'Kalianget', 'Kangayan', 'Kota Sumenep', 'Lenteng', 'Manding', 'Masalembu', 'Nonggunong', 'Pasongsongan', 'Pragaan', 'Raas', 'Rubaru', 'Sapeken', 'Saronggi', 'Talango'],
        ];

        $kataDepan = ['Wisata', 'Pesona', 'Keindahan', 'Taman', 'Pantai', 'Bukit', 'Kuliner', 'Warung', 'Sate', 'Soto', 'Kerajinan', 'Sentra'];
        $kataBelakang = ['Indah', 'Asri', 'Nusantara', 'Jaya', 'Sejahtera', 'Madura', 'Utama', 'Khas', 'Tradisional', 'Modern'];
        $fakerID = \Faker\Factory::create('id_ID');

        foreach ($regencies as $regency) {
            foreach ($categories as $category) {
                // Buat 4 konten per kombinasi kabupaten x kategori
                $contents = [];
                for ($i = 0; $i < 4; $i++) {
                    $availableDistricts = $districts[$regency->slug] ?? ['Madura'];
                    $chosenDistrict = $fakerID->randomElement($availableDistricts);
                    $title = $fakerID->randomElement($kataDepan) . ' ' . $chosenDistrict . ' ' . $fakerID->randomElement($kataBelakang);
                    $slug = \Illuminate\Support\Str::slug($title) . '-' . $fakerID->unique()->numberBetween(100, 9999);

                    $contents[] = \App\Models\Content::factory()->create([
                        'regency_id' => $regency->id,
                        'category_id' => $category->id,
                        'user_id' => $users->random()->id,
                        'title' => $title,
                        'slug' => $slug,
                    ]);
                }
                
                $contents = collect($contents);

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
