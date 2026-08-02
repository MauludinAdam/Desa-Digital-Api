<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name'      => 'admin',
            'guard_name'    => 'web',
        ]);

        Role::firstOrCreate([
            'name'  => 'user',
            'guard_name'  =>  'web',
        ]);

        Role::firstOrCreate([
            'name'      => 'head-of-family',
            'guard_name'    => 'web',
        ]);

        Role::firstOrCreate([
            'name'          => 'family-member',
            'guard_name'    => 'web',
        ]);

        Role::firstOrCreate([
            'name'          => 'headman',
            'guard_name'    => 'web',
        ]);     
    }
}
