<?php

namespace Database\Factories;

use App\Models\Webhook;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'name'       => $this->faker->unique()->userName,
            'user_id'    => $this->faker->numberBetween($min = 1, $max = 50),
            'product_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'token'      => Str::uuid(),
            'type'       => 'web',
            'created_at' => $this->faker->dateTimeBetween($startDate = '-600 days', $endDate = 'now'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
        ];
    }
}
