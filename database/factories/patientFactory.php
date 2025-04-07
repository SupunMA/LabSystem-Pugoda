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
        return [
            // Generate a 10-digit mobile number
            'mobile' => $this->faker->unique()->numerify('##########'),

            // Generate a unique date of birth (random past date)
            'dob' => $this->faker->date($format = 'Y-m-d', $max = 'now'),

            // Random gender: 'M' or 'F'
            'gender' => $this->faker->randomElement(['M', 'F']),

            // Generate a random address
            'address' => $this->faker->address(),

            // Starting from userID 3 and incrementing
            'userID' => $this->faker->unique()->numberBetween(3, 2002), // You can adjust the range
        ];
    }
}
