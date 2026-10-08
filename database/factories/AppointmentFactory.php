<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()?->id ?? 1,
            'doctor_id' => \App\Models\Doctor::inRandomOrder()->first()?->id ?? 1,
            'appointment_date' => $this->faker->date(),
            'appointment_time' => $this->faker->time('H:i:s'),
            'status' => $this->faker->randomElement([
                'Scheduled',
                'Completed',
                'Cancelled',
                'Pending'
            ])
        ];
    }
}