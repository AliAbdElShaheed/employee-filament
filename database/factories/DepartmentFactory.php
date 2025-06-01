<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Human Resources',
                'Finance',
                'Information Technology',
                'Marketing',
                'Sales',
                'Customer Support',
                'Research and Development',
                'Operations',
                'Legal',
                'Administration'
            ]),
            'code' => fake()->unique()->lexify('DEPT-????'),
        ];
    }
}
