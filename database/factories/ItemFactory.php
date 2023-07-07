<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_id' => \App\Models\Project::inRandomOrder()->first()->id,
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'title' => ucfirst($this->faker->domainWord),
            'content' => $this->faker->text(500),
            'slug' => $this->faker->word,
            'private' => false,
        ];
    }

    public function private()
    {
        return $this->state(function () {
            return [
                'private' => true,
            ];
        });
    }
}
