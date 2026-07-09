<?php

namespace Database\Factories;

use App\Models\SosialAssistanceRecipient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<SosialAssistanceRecipient>
 */
class SosialAssistanceRecipientFactory extends Factory
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
            'amount'        => $this->faker->randomFloat(2, 10000, 100000),
            'reason'        => $this->faker->sentence(),
            'bank'          => $this->faker->randomElement(['bri','bni','bca','mandiri']),
            'account_number' => $this->faker->unique()->numberBetween(10000, 99999),
            'proof'          => $this->faker->url(),
            'status'        => $this->faker->randomElement(['pending','approved','rejected']),
        ];
    }
}
