<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocVersion>
 */
class DocVersionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->randomElement(['1.x', '2.x', '3.x', '1.x-alpha', '1.x-beta']),
            'description' => $this->faker->paragraph(),
        ];
    }
}
