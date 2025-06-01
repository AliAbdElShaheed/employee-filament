<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\City;
use App\Models\State;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = City::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'state_id' => $this->faker->randomElement(State::all()->pluck('id')->toArray()),
            'name' => fake()->city(),
            'zip_code' => fake()->postcode(),
        ];
    }
}
