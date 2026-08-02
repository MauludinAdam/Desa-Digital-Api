<?php

namespace Database\Seeders;

use App\Models\FamilyCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FamilyCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {

        FamilyCard::create([
            'id'            => Str::uuid(),
            'family_card_number' => '31212345' . str_pad($i, 8, '0', STR_PAD_LEFT),
            'head_of_family_id' => null,
            'address'           => fake()->address(),
            'rt'            => fake()->numerify('01'),
            'rw'            => fake()->numerify('02'),
            'hamlet'        => 'Dusun' . fake()->numberBetween(1, 5),
            'village'       => 'Desa'. fake()->city(),
            'district'      => 'Kecamatan'. fake()->city(),
            'regency'       => 'Kabupaten'. fake()->city(),
            'province'      => 'Jawa Barat'. fake()->state(),
            'postal_code'   => fake()->postcode(),
        ]);
        }
    }
}
