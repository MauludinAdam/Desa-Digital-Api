<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\SosialAssistanceFactory;
use Illuminate\Database\Seeder;
use App\Models\SosialAssistance;

class SosialAssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SosialAssistanceFactory::new()->count(15)->create();
        // SosialAssistance::factory()->count(5)->create();
    }
}
