<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
    */

    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                // 'status' => 1,
                // 'permissions' => ['role','role-add', 'role-list', 'permission', 'permission-add', 'permission-list']
            ],
            [
                'name' => 'State Admin',
                'slug' => 'state-admin',
                // 'status' => 1,
                // 'permissions' => []
            ],
            [
                'name' => 'Dept Admin',
                'slug' => 'dept-admin',
                // 'status' => 1,
                // 'permissions' => []
            ],
            [
                'name'=>'Office Admin',
                'slug'=>'office-admin',
            ],[
                'name'=>'Office User',
                'slug'=>'office-user'
            ]

        ];

        foreach ($roles as $key => $value) {
            // $permission = '';
            // unset($value['permissions']);
            $role = Role::create($value);
            // $role->
            // $role->givePermissionsTo('all-permission');
        }
    }
}
