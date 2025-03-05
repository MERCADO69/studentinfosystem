<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "student_id" => fake()->randomNumber(9),
            "last_name" => fake()->name(),
            "first_name" => fake()->name(),
            "course" => fake()->randomElement(["BSIT", "BSEMC"]),
            "year_level" => fake()->numberBetween(1, 4),
            "email" => fake()->safeEmail()

        ];
    }
}
