<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\TaskStatus>
 */
class TaskStatusFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => fake()->unique()->words(2, true)];
    }
}
