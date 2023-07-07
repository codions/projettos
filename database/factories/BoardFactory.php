<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->randomElement(['Under review', 'Planned', 'In progress', 'Live', 'Closed']);

        return [
            'title' => $name,
            'slug' => Str::slug($name),
            'can_users_create' => true,
        ];
    }
}
