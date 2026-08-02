<?php

namespace Database\Seeders;

use App\Models\Citizen;
use App\Models\CitizenDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitizenDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citizens = Citizen::inRandomOrder()->take(5)->get();

        foreach ($citizens as $citizen) {
            CitizenDocument::create([
                'citizen_id'    => $citizen->id,
                'document_type' => fake()->randomElement(['ktp','kk','akte_kelahiran','kia']),
                'file'          => fake()->lexify('documents/?????.pdf'),
            ]);
        }
        
    }
}
