<?php

namespace Database\Factories;

use App\Models\HeadOfFamily;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<HeadOfFamily>
 */
class HeadOfFamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'                => Str::uuid() ,
            // 'user_id'           => User::factory(),
            'profile_picture'   => $this->faker->imageUrl(),
            'identity_number'   => $this->faker->unique()->numberBetween(10000, 99999),
            'gender'            => $this->faker->randomElement(['male','female']),
            'date_birth'        => $this->faker->dateTimeBetween('-60 years','now'),
            'phone_number'      => $this->faker->unique()->phoneNumber(),
            'occupation'        => $this->faker->jobTitle(),
            'marital_status'    => $this->faker->randomElement(['married', 'single']),
        ];
    }
}
