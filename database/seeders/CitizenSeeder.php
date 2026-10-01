<?php

namespace Database\Seeders;

use App\Models\Citizen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitizenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i<= 10; $i++ ){
 
           $nik = '32012345' .str_pad($i, 8, '0', STR_PAD_LEFT);
	  if(Citizen::where('nik', $nik)->exists()){
	  continue;
	}
           
             Citizen::create([
                'id'               => Str::uuid(),
                'full_name'        => fake()->name(),
                'nik'              => '32012345' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'gender'           => fake()->randomElement(['male','female']),
                'place_of_birth'   => fake()->city(),
                'date_of_birth'    => fake()->date(),
                'phone_number'     => fake()->phoneNumber(),
                'occupation_id'    => null,
                'religion'          => null,
                'education_id'     => null,
                'family_card_id'   => null,
                'marital_status'   => fake()->randomElement(['single','married','widower','widow']),
                'blood_type'       => fake()->randomElement(['A','B','AB','O']),
                'email'            => fake()->unique()->safeEmail(),
                'nationality'      => 'wni',
                'status'           => 'active',
            ]);
        }

       
    }
}
