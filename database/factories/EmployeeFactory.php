<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Employee::class;

    public function definition(): array
    {
        $departmentId = Department::inRandomOrder()->first()->id ?? null;

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'position'=> fake()->jobTitle(),
            'department_id' => $departmentId,
            'user_id' => null
        ];
    }
}