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
        return [
            'user_id' => \App\Models\User::inRandomOrder()->value('id') ?? \App\Models\User::factory(),
            'regency_id' => \App\Models\Regency::inRandomOrder()->value('id') ?? 1,
            'category_id' => \App\Models\Category::inRandomOrder()->value('id') ?? 1,
            'title' => $this->faker->unique()->sentence(4),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraphs(4, true),
            'address' => $this->faker->address(),
            'maps_url' => 'https://maps.google.com/?q=' . $this->faker->latitude() . ',' . $this->faker->longitude(),
            'open_time' => '0' . $this->faker->numberBetween(6, 9) . ':00:00',
            'close_time' => $this->faker->numberBetween(16, 22) . ':00:00',
            'status' => 'approved',
            'was_approved' => true,
            'view_count' => $this->faker->numberBetween(100, 20000),
        ];
    }
}
