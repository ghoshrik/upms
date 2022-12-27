<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Create Menu',
                'slug' => 'create-menu',
            ],
            [
                'name' => 'Edit Menu',
                'slug' => 'edit-menu',
                // 'parent_id' => 1,
            ],
            // [
            //     'name' => 'Menu Permission',
            //     'slug' => 'menu-permission',
            //     // 'parent_id' => 1,
            // ],
            [
                'name' => 'Create Sor',
                'slug' => 'create-sor',
            ],
            [
                'name' => 'permission-add',
                'slug' => 'Permission Add',
                // 'parent_id' => 4,
            ],
            [
                'name' => 'permission-list',
                'slug' => 'Permission List',
                // 'parent_id' => 4,
            ]
        ];

        foreach ($permissions as $value) {
            Permission::create($value);
        }
    }
}