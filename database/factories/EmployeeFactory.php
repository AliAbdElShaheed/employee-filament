<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Employee;

class EmployeeFactory extends Factory
{

    protected $model = Employee::class;


    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'date_of_birth' => fake()->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'date_hired' => fake()->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'department_id' => Department::factory(),

            'country_id' => Country::factory(),
            'state_id' => State::factory(),
            'city_id' => City::factory(),

        ];
    }
}
