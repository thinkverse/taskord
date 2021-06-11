<?php

namespace Database\Factories;

use App\Models\Webhook;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebhookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Webhook::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->userName,
            'product_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'website' => 'https://gitlab.com',
            'twitter' => $this->faker->userName,
            'repo' => 'https://github.com/taskord/taskord',
            'producthunt' => $this->faker->userName,
            'launched' => $this->faker->boolean($chanceOfGettingTrue = 50),
            'deprecated' => $this->faker->boolean($chanceOfGettingTrue = 5),
            'launched_at' => $this->faker->dateTimeBetween($startDate = '-600 days', $endDate = 'now'),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-600 days', $endDate = 'now'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
        ];
    }
}
