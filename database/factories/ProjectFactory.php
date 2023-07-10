<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
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
        $title = rtrim($this->faker->text(20), '.');

        return [
            'user_id' => User::whereIn('role', [UserRole::Admin, UserRole::Employee])->inRandomOrder()->first()->id,
            'title' => $title,
            'description' => $this->faker->text(200),
            'slug' => Str::slug($title),
            'private' => (bool) mt_rand(0, 1),
            'pinned' => (bool) mt_rand(0, 1),
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
