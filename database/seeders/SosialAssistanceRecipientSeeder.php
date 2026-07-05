<?php

namespace Database\Seeders;

use App\Models\HeadOfFamily;
use App\Models\SosialAssistance;
use App\Models\SosialAssistanceRecipient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SosialAssistanceRecipientSeeder extends Seeder
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
                SosialAssistanceRecipient::factory()->create([
                    'head_Of_Family_id'      => $headOfFamily->id,
                    'sosial_assistance_id'  => $sosialAssistance->id,
                ]);
            }
        }
    }
}
