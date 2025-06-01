<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\State;

class StateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = State::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'country_id' => $this->faker->randomElement(Country::all()->pluck('id')->toArray()),
            'name' => fake()->city(),
            'code' => fake()->citySuffix(),
            'phone_code' => fake()->randomElement(['+1', '+44', '+33', '+49', '+81', '+61', '+91', '+86', '+7', '+55']),
        ];
    }
}
