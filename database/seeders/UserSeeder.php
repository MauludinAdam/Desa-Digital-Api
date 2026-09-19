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
        User::create([
            'role_id'   => '1',
            'name'  => 'Mauludin',
            'email' => 'mauludin@gmail.com',
            'password'  => bcrypt('admin123')
        ])->assignRole('Admin');

        User::create([
            'role_id'   => '2',
            'name'      => 'Fajar Ghozali',
            'email'     => 'fajar@gmail.com',
            'password'  => bcrypt('fajar123')
        ])->assignRole('Operator');

        User::create([
            'role_id'   => '3',
            'name'      => 'Kepala Desa',
            'email'     => 'kades@gmail.com',
            'password'  => bcrypt('kades123')
        ])->assignRole('Kepala Desa');
        
    }
}
