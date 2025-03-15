<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subject;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'subject_name' => $this->faker->unique()->word(),
            'subject_code' => strtoupper($this->faker->unique()->bothify('SUB###')), // Ensure unique subject code
            'units' => $this->faker->numberBetween(1, 5),
        ];
    }
}


