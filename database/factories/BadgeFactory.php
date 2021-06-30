<?php

namespace Database\Factories;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BadgeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Badge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'     => $this->faker->numberBetween($min = 1, $max = 50),
            'slug'        => Str::lower(Str::random(100)),
            'title'       => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'color'        => "#6a63ec",
            'icon' => "https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg",
            'created_at'  => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            'updated_at'  => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
        ];
    }
}
