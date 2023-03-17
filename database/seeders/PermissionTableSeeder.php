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
            [
                'name' => 'All Permission',
                'slug' => 'all-permission',
                // 'parent_id' => 1,
            ],
            [
                'name' => 'Create Sor',
                'slug' => 'create-sor',
            ],
            [
                'name' => 'Edit Sor',
                'slug' => 'edit-sor',
                // 'parent_id' => 4,
            ],
            [
                'name' => 'Delete Sor',
                'slug' => 'delete-sor',
                // 'parent_id' => 4,
            ]
        ];

        foreach ($permissions as $value) {
            Permission::create($value);
        }
    }
}
