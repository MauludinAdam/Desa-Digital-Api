<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'            =>  Str::uuid(),
            'thumbnail'     => $this->faker->imageUrl(),
            'name'          => $this->faker->randomElement(['Belajar Bahasa Ingris','Jalan Sehat','Kerja Bakti']),
            'description'   => $this->faker->sentence(),
            'price'         => $this->faker->randomFloat(2, 10000, 100000),
            'date'          => $this->faker->dateTimeBetween('-1 year', 'now'),
            'time'          => $this->faker->time(),
            'is_active'     => $this->faker->boolean()
        ];
    }
}
