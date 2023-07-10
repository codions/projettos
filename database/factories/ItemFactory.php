<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = rtrim($this->faker->text(20), '.');

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'project_id' => Project::inRandomOrder()->first()->id,
            'title' => $title,
            'content' => $this->faker->text(500),
            'slug' => Str::slug($title),
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
