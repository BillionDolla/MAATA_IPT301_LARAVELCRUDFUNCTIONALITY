<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => $this->faker->unique()->numerify('########'),
            'name' => $this->faker->name(),
            'course' => $this->faker->randomElement([
                'BS Computer Science',
                'BS Information Technology',
                'BS Software Engineering',
                'BS Information Systems'
            ]),
            'year_level' => $this->faker->randomElement([1, 2, 3, 4])
        ];
    }
}