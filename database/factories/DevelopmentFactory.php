<?php

namespace Database\Factories;

use App\Models\Development;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends Factory<Development>
 */
class DevelopmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'                => Str::uuid(),
            'thumbnail'         => $this->faker->imageUrl(),
            'name'              => $this->faker->randomElement(['Pembangunan Jalan','Perbaikan Jalan','Pembuatan Jembatang']),
            'description'       => $this->faker->paragraph(),
            'person_in_charge'  => $this->faker->name(),
            'start_date'        => $this->faker->dateTimeBetween(),
            'end_date'          => $this->faker->dateTimeBetween(),
            'amount'            => $this->faker->randomFloat(2, 10000, 100000),
            'status'            => $this->faker->randomElement(['on going','completed']),
        ];
    }
}
