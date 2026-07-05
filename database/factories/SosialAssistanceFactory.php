<?php

namespace Database\Factories;

use App\Models\SosialAssistance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
// use Illuminate\Database\Seeder;
/**
 * @extends Factory<Model>
 */
class SosialAssistanceFactory extends Factory
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
            'thumbnail'     => $this->faker->imageUrl(),
            'name'          => $this->faker->randomElement(['Bantuan Pangan', 'Bantuan Tunai', 'Bantuan Bahan Bakar Bersubsidi', 'Bantuan Kesehatan']),
            'category'      => $this->faker->randomElement(['staple','cash','subsidized fuel','health']),
            'amount'        => $this->faker->randomFloat(2, 10000, 100000),
            'provider'      => $this->faker->company,
            'description'   => $this->faker->sentence,
            'is_available'  => $this->faker->boolean(),
        ];
    }
}
