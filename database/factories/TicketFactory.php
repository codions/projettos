<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-30 days', now());

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'project_id' => \App\Models\Project::inRandomOrder()->first()->id,
            'subject' => $this->faker->text(50),
            'message' => $this->faker->text(200),
            'status' => $this->faker->randomElement(array_keys(app(\App\Settings\GeneralSettings::class)->ticket_statuses)),

            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
