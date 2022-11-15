<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['role' => 'customer']),
            'first_name' => $this->faker->name,
            'middle_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'contact_number' => $this->faker->numerify,
            'verified' => 1,
            'verify_code' => '000000',
        ];
    }
}
