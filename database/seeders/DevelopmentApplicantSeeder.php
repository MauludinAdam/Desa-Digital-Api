<?php

namespace Database\Seeders;

use App\Models\Development;
use App\Models\DevelopmentApplicant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DevelopmentApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $developemnts = Development::all();
            $users        = User::all();  

        foreach($developemnts as $development){
            foreach($users as $user){
                DevelopmentApplicant::factory()->create([
                    'development_id' => $development->id,
                    'user_id'       => $user->id,
                ]);
            }
        }
    }
}
