<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    User::updateOrCreate(
        ['email' => 'mauludin@gmail.com'],
        [
            'role_id' => 1,
            'name' => 'Mauludin',
            'password' => bcrypt('admin123'),
        ]
    );

    User::updateOrCreate(
        ['email' => 'fajar@gmail.com'],
        [
            'role_id' => 2,
            'name' => 'Fajar Ghozali',
            'password' => bcrypt('fajar123'),
        ]
    );

    User::updateOrCreate(
        ['email' => 'kades@gmail.com'],
        [
            'role_id' => 3,
            'name' => 'Kepala Desa',
            'password' => bcrypt('kades123'),
        ]
    );

    User::where('email', 'mauludin@gmail.com')->first()->assignRole('Admin');
    User::where('email', 'fajar@gmail.com')->first()->assignRole('Operator');
    User::where('email', 'kades@gmail.com')->first()->assignRole('Kepala Desa');
}
}
