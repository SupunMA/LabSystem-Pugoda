<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class patientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $userId = 8; // Start from 8

        return [
            'mobile' => $this->faker->unique()->numerify('##########'),
            'dob' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'address' => $this->faker->address(),
            'userID' => $userId++,
        ];
    }
}
