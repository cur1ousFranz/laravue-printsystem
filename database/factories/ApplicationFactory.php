<?php

namespace Database\Factories;

use App\Models\BusinessOwner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'business_owner_id' => BusinessOwner::factory()->create(),
            'status' => 'pending',
            'permit_image' => '',
            'valid_id_image' => '',
            'face_image' => '',
            'shop_name' => $this->faker->name,
            'address' => $this->faker->sentence(),
            'barangay' => $this->faker->sentence(),
            'city' => $this->faker->city(),
            'zipcode' => $this->faker->postcode(),
        ];
    }
}
