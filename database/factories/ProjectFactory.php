<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'title' => ucfirst($this->faker->domainWord),
            'slug' => Str::slug(Str::random(12)),
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
