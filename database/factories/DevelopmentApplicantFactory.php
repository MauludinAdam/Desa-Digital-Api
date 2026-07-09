<?php

namespace Database\Factories;

use App\Models\DevelopmentApplicant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<DevelopmentApplicant>
 */
class DevelopmentApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'            => Str::uuid(),
            'status'        => $this->faker->randomElement(['pending','approved','rejected']),
        ];
    }
}
