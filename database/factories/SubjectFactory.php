<?php

namespace Database\Factories;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'semester_id' => Semester::factory(),
            'name' => fake()->words(1, true),
            'code' => fake()->words(1, true),
            'color' => fake()->words(5, true),
        ];
    }
}
