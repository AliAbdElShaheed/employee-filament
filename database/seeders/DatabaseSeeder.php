<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\State;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Ali Mohammad',
            'email' => 'admin@app.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        Country::factory(20)->create();
        State::factory(50)->create();
        City::factory(100)->create();

        Department::factory(10)->create();

        Employee::factory(20)->create();


        Task::factory(50)->create();
    }
}
