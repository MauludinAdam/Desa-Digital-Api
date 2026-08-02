<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard'   => [
            'menu'
        ],

        'head-of-family'  => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'family-member' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'sosial-assistance-category' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'sosial-assistance' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'sosial-assistance-applicant'   => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'profile' => [
            'menu',
            'create',
            'edit',
        ],

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->permissions as $key => $value) {
    
            foreach ($value as $permission){
                Permission::firstOrCreate([
                    'name'  => $key . '-' . $permission,
                    'guard_name' => 'web'
                ]);
            }
        }
            

            // Role Admin
              $admin = Role::findByName('admin', 'web');
              $admin->syncPermissions(Permission::all());

            //   Role Kepala Desa
            $headman = Role::findByName('headman','web');
            $headman->syncPermissions([
                'dashboard-menu',
                'head-of-family-list',
                'family-member-list',
                'sosial-assistance-list',
                'sosial-assistance-applicant-list',
                'sosial-assistance-applicant-edit',
            ]);

            // User
            $user = Role::findByName('user','web');
            $user->syncPermissions([
                'dashboard-menu',
                'profile-menu',
                'profile-edit',
            ]);
        }

        // dd(Permission::pluck('name')->toArray());
    
}
