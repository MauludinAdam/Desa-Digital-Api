<?php

namespace Database\Factories;

use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

/**
 * @extends Factory<FamilyMember>
 */
class FamilyMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profile_picture'       => $this->faker->ImageUrl(),
            'identity_number'       => $this->faker->unique()->numberBetween(10000, 99999),
            'gender'                => $this->faker->randomElement(['male','female']),
            'date_birth'            => $this->faker->dateTimeBetween('-60 years', 'now'),
            'phone_number'          => $this->faker->unique()->phoneNumber(),
            'occupation'            => $this->faker->jobTitle(),
            'marital_status'        => $this->faker->randomElement(['married','single']),
            'relation'              => $this->faker->randomElement(['wife','child','husband']),
        ];
    }
}
