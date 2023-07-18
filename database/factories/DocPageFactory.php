<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocPage>
 */
class DocPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = rtrim($this->faker->text(20), '.');
        $paragraphs = implode("\n", array_map(fn ($paragraph) => "<p>$paragraph</p>", $this->faker->paragraphs(4)));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $paragraphs,
        ];
    }
}
