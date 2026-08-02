<?php

namespace Database\Seeders;

use App\Models\HeadOfFamily;
use App\Models\SosialAssistance;
use App\Models\SosialAssistanceApplicant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SosialAssistanceApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sosialAssistances = SosialAssistance::all();
        $headOfFamilies     = HeadOfFamily::all();
    

        foreach($sosialAssistances as $sosialAssistance){
            foreach($headOfFamilies as $headOfFamily){
                SosialAssistanceApplicant::factory()->create([
                    'head_Of_Family_id'      => $headOfFamily->id,
                    'sosial_assistance_id'  => $sosialAssistance->id,
                ]);
            }
        }
    }
}
