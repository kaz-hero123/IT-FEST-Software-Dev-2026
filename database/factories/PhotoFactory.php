<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dummyImages = [
            'images/culture/culture01.jpg',
            'images/culture/culture02.jpg',
            'images/culture/culture03.jpg',
            'images/culture/culture04.jpg',
            'images/culture/culture05.jpg',
            'images/culture/culture06.jpg',
            'images/culture/culture07.jpg',
            'images/culture/culture08.jpg',
            'images/culture/culture09.jpg',
            'images/culture/culture10.jpg',
            'images/culture/culture11.jpg',
            'images/culture/culture12.jpg',
            'images/culture/culture13.jpg',
            'images/culture/culture14.jpg',
            'images/culture/culture15.jpg',
            'images/culture/culture16.jpg',
            'images/culture/culture17.jpg',
            'images/culture/culture18.jpg',
            'images/pantai.png',
            'images/food.png',
        ];

        return [
            'content_id' => \App\Models\Content::factory(),
            'file_path' => $this->faker->randomElement($dummyImages),
            'is_primary' => false,
        ];
    }
}
