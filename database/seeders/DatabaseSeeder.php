<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\DevelopmentApplicantSeeder;
use Database\Seeders\DevelopmentSeeder;
use Database\Seeders\EventParticipantSeeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\HeadOfFamilySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SosialAssistanceRecipientSeeder;
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
            UserSeeder::class,
            RoleSeeder::class,
            HeadOfFamilySeeder::class,
            SosialAssistanceSeeder::class,
            SosialAssistanceRecipientSeeder::class,
            EventSeeder::class,
            EventParticipantSeeder::class,
            DevelopmentSeeder::class,
            DevelopmentApplicantSeeder::class,
        ]);
    }
}
