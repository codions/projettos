<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use App\Settings\GeneralSettings;
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
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'project_id' => Project::inRandomOrder()->first()->id,
            'subject' => rtrim($this->faker->text(50), '.'),
            'message' => $this->faker->text(200),
            'status' => $this->faker->randomElement(array_keys(app(GeneralSettings::class)->ticket_statuses)),
        ];
    }
}
