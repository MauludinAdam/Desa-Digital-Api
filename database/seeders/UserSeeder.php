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
        ['email' => 'admin@gmail.com'],
        [
            'role_id' => 1,
            'name' => 'Admin',
            'password' => bcrypt('admin123'),
        ]
    );

    User::updateOrCreate(
        ['email' => 'operator@gmail.com'],
        [
            'role_id' => 2,
            'name' => 'Operator',
            'password' => bcrypt('operator'),
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

    User::where('email', 'admin@gmail.com')->first()->assignRole('Admin');
    User::where('email', 'operator@gmail.com')->first()->assignRole('Operator');
    User::where('email', 'kades@gmail.com')->first()->assignRole('Kepala Desa');
}
}
