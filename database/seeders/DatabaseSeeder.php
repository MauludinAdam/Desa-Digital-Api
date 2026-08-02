<?php

namespace Database\Seeders;

use App\Models\CitizenDocument;
use App\Models\User;
use Database\Seeders\CitizenDocumentSeeder;
use Database\Seeders\CitizenSeeder;
use Database\Seeders\FamilyCardSeeder;
use Database\Seeders\HeadOfFamilySeeder;
use Database\Seeders\LetterSeeder;
use Database\Seeders\LetterTypeSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SosialAssistanceApplicantSeeder;
use Database\Seeders\SosialAssistanceCategoriesSeeder;
use Database\Seeders\SosialAssistanceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CitizenSeeder::class,
            FamilyCardSeeder::class,
            CitizenDocumentSeeder::class,
            LetterSeeder::class,
            LetterTypeSeeder::class,
            // SosialAssistanceCategoriesSeeder::class,
            // SosialAssistanceSeeder::class,
            // SosialAssistanceApplicantSeeder::class,
            
        ]);
    }
}
