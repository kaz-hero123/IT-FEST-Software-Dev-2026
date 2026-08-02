<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakerID = \Faker\Factory::create('id_ID');
        
        $title = 'Temp Title ' . $fakerID->numberBetween(1, 9999);

        $deskripsiAcak = [
            'Tempat ini sangat direkomendasikan untuk dikunjungi bersama keluarga tercinta saat liburan.',
            'Menawarkan pengalaman yang tak terlupakan dengan pemandangan yang memukau dan suasana asri.',
            'Salah satu destinasi paling populer di daerah ini, selalu ramai dikunjungi pada akhir pekan.',
            'Harga yang ditawarkan sangat terjangkau dengan kualitas pelayanan yang memuaskan.',
            'Cocok untuk Anda yang ingin melepas penat dari hiruk pikuk perkotaan dan mencari ketenangan.',
            'Banyak spot foto menarik yang sangat cocok untuk diunggah ke media sosial Anda.',
            'Cita rasa khas yang disajikan akan membuat Anda ingin kembali lagi ke tempat ini.'
        ];

        // Gabungkan 3-4 kalimat acak untuk jadi deskripsi
        $description = implode(' ', $fakerID->randomElements($deskripsiAcak, 3));

        return [
            'user_id' => \App\Models\User::inRandomOrder()->value('id') ?? \App\Models\User::factory(),
            'regency_id' => \App\Models\Regency::inRandomOrder()->value('id') ?? 1,
            'category_id' => \App\Models\Category::inRandomOrder()->value('id') ?? 1,
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title) . '-' . $fakerID->unique()->numberBetween(100, 9999),
            'description' => $description,
            'address' => $fakerID->address(),
            'maps_url' => 'https://maps.google.com/?q=' . $fakerID->latitude() . ',' . $fakerID->longitude(),
            'open_time' => '0' . $fakerID->numberBetween(6, 9) . ':00:00',
            'close_time' => $fakerID->numberBetween(16, 22) . ':00:00',
            'status' => 'approved',
            'was_approved' => true,
            'view_count' => $fakerID->numberBetween(100, 20000),
        ];
    }
}
