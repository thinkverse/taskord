<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feature::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'staff'       => true,
            'beta'        => true,
            'contributor' => true,
            'public'      => true,
        ];
    }
}
