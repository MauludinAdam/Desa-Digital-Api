<?php

namespace Database\Seeders;

use Database\Factories\HeadOfFamilyFactory;
use Database\Factories\UserFactory;
use Database\Factories\FamilyMemberFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadOfFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->count(10)->create()->each(function ($user){
            $headOfFamily = HeadOfFamilyFactory::new()->create([
                'user_id'   => $user->id]);

                FamilymemberFactory::new()->count(10)->create(['head_of_family_id' => $headOfFamily->id, 'user_id' => UserFactory::new()->create()->id]);
        });
    }
}
