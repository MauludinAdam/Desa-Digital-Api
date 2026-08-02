<?php

namespace Database\Seeders;

use App\Models\SosialAssistanceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SosialAssistanceCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SosialAssistanceCategory::create([
            'name' => 'Sembako',
            'description'   => 'Bantuan kebutuhan pokok untuk masyarakat',
        ]);

        SosialAssistanceCategory::create([
            'name'          => 'Bantuan Tunai',
            'description'   => 'Bantuan uang tunai untuk masyarakat',
        ]);

        SosialAssistanceCategory::create([
            'name'          => 'Kesehatan',
            'description'   => 'Bantuan layanan kesehatan',
        ]);

        SosialAssistanceCategory::create([
            'name'          => 'Pendidikan',
            'description'   => 'Bantuan biaya pendidikan',
        ]);
    }
}
