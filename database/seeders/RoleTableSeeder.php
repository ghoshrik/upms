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
                'name' => 'state',
                'guard_name' => 'admin',

            ],
            [
                'name' => 'State Admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Estimate Recommender (ER)',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Estimate Preparer (EP)',
                'guard_name' => 'web',
            ],[
                'name' => 'Project Estimate(EP)',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Department Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Office Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'SOR Approver',
                'guard_name' => 'web',
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
