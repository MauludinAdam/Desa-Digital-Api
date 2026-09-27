<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard-desa'   => [
            'menu'
        ],

        'citizen'  => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'citizen-document'  => [
            'menu',
            'list',
            'create',
            'edit',
            'delete'
        ],

        'education' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'occupation' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'letter' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'letter-attachment' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'letter-type' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'family-card' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
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

        'profile-village' => [
            'list',
            'menu',
            'edit',
        ],

        'bumdes' => [
            'menu'
        ],

        'dashboard-bumdes' => [
            'menu'
        ],

        'bumdes-profile'    => [
            'list',
            'menu',
            'edit',
        ],

        'bumdes-unit' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'bumdes-product' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'bumdes-sales' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'bumdes-sales-item' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'bumdes-report' => [
            'menu',
            'list',
        ],

        'user' => [
            'menu',
            'list',
            'create',
            'edit',
            'status-update',
        ],

        'role-permission' => [
            'menu',
            'list',
            'create',
            'edit',
            'delete',
        ],

        'profile-user' => [
            'menu',
            'list',
            'update',
        ]

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
              $admin = Role::findByName('Admin', 'web');
              $admin->syncPermissions([
                // Menu
                'dashboard-desa-menu',
                'citizen-menu',
                'family-card-menu',
                'citizen-document-menu',
                'letter-menu',
                'letter-type-menu',
                'sosial-assistance-menu',
                'sosial-assistance-category-menu',
                'sosial-assistance-applicant-menu',
                'education-menu',
                'occupation-menu',
                'profile-village-menu',
                'user-menu',
                'user-status-update',
                'profile-user',

                // citizen
                'citizen-list',
                'citizen-create',
                'citizen-edit',
                'citizen-delete',

                // family card
                'family-card-list',
                'family-card-create',
                'family-card-edit',
                'family-card-delete',

                // citizen document
                'citizen-document-list',
                'citizen-document-create',
                'citizen-document-edit',
                'citizen-document-delete',

                // Letter
                'letter-list',
                'letter-create',
                'letter-edit',
                'letter-delete',

                // Letter type
                'letter-type-list',
                'letter-type-create',
                'letter-type-edit',
                'letter-type-delete',

                // sosial assistance
                'sosial-assistance-list',
                'sosial-assistance-create',
                'sosial-assistance-edit',
                'sosial-assistance-delete',

                // sosial assistance category
                'sosial-assistance-category-list',
                'sosial-assistance-category-create',
                'sosial-assistance-category-edit',
                'sosial-assistance-category-delete',

                // sosial assistance applicant
                'sosial-assistance-applicant-list',
                'sosial-assistance-applicant-create',
                'sosial-assistance-applicant-edit',
                'sosial-assistance-applicant-delete',

                // educations
                'education-list',
                'education-create',
                'education-edit',
                'education-delete',

                // Occupations
                'occupation-list',
                'occupation-create',
                'occupation-edit',
                'occupation-delete',

                // Profile desa
                'profile-village-list',
                'profile-village-edit',

                // User manajemet
                'user-list',
                'user-create',
                'user-edit',

                // Manajemen role dan permission
                'role-permission-menu',
                'role-permission-list',
                'role-permission-create',
                'role-permission-edit',
                'role-permission-delete',

              ]);

            //   Role Kepala Desa
            $headman = Role::findByName('Kepala Desa','web');
            $headman->syncPermissions([
                'dashboard-desa-menu',
                'dashboard-bumdes-menu',
                'family-card-list',
                'family-card-menu',
                'family-member-list',
                'family-member-menu',
                'sosial-assistance-list',
                'sosial-assistance-menu',
                'sosial-assistance-applicant-list',
                'sosial-assistance-applicant-menu',
                'citizen-list',
                'citizen-menu',
                'citizen-document-list',
                'citizen-document-menu',
                'letter-list',
                'letter-menu',
                'letter-type-list',
                'letter-type-menu',
                'profile-user-menu',

                'bumdes-profile-list',
                'bumdes-profile-menu',
                'bumdes-unit-list',
                'bumdes-unit-menu',
                'bumdes-product-list',
                'bumdes-product-menu',
                'bumdes-sales-item-list',
                'bumdes-sales-item-menu',
                'bumdes-sales-list',
                'bumdes-sales-menu',
                'bumdes-report-list',
                'bumdes-report-menu',
            ]);

            // Operator
            $operator = Role::findByName('Operator','web');
            $operator->syncPermissions([
                // menu
                'bumdes-menu',
                'dashboard-bumdes-menu',
                'bumdes-profile-menu',
                'bumdes-unit-menu',
                'bumdes-product-menu',
                'bumdes-sales-item-menu',
                'bumdes-sales-menu',
                'bumdes-report-menu',

                // Bumdes Profile
                'bumdes-profile-menu',
                'bumdes-profile-list',
                'bumdes-profile-edit',

                // Bumdes Unit
                'bumdes-unit-menu',
                'bumdes-unit-create',
                'bumdes-unit-edit',
                'bumdes-unit-delete',

                // Bumdes product
                'bumdes-product-menu',
                'bumdes-product-list',
                'bumdes-product-create',
                'bumdes-product-edit',
                'bumdes-product-delete',

                // Bumdes sales
                'bumdes-sales-menu',
                'bumdes-sales-list',
                'bumdes-sales-create',
                'bumdes-sales-edit',
                'bumdes-sales-delete',

                // Bumdes sales item
                'bumdes-sales-item-menu',
                'bumdes-sales-item-list',
                'bumdes-sales-item-create',
                'bumdes-sales-item-edit',
                'bumdes-sales-item-delete',

                // Report
                'bumdes-report-list',
            ]);

            // dd(Permission::pluck('name')->toArray());
        }

}
