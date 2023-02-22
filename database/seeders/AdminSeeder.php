<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Role
        $user_role = Role::where('slug','super-admin')->first();
        //permission
        $user_permission = Permission::where('slug','create-menu')->first();
        //user menu
        $user_menu = Menu::where('slug','menu-manager')->first();
        // dd($user_menu);

        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@admin.com";
        $user->username= "admin";
        $user->emp_id = 1025;
        $user->emp_name="admin";
        $user->user_type=1;
        $user->email_verified_at = now();
        $user->password=Hash::make('password');
        // dd($user->menus()->attach($user_menu));
        $user->save();
        $user->roles()->attach($user_role);
        $user->permissions()->attach($user_permission);
        // $user->menuRoles()->attach($user_role);
        // $user_role->menuRoles()->
        $user->menus()->attach($user_menu);


        // User::create([
        //     'name'=> 'Admin',
        //     'email'=> 'admin@admin.com',
        //     'username'=>'admin',
        //     'emp_id'=>1025,
        //     'emp_name'=>'Admin',
        //     // 'designation_id'=>1,
        //     // 'department_id'=>1,
        //     'user_type'=>1,
        //     //'menu_access'=>'1,2,3,4,5,6,7,8,9,10,11,12',
        //     //'email_verified_at'=>now(),
        //     'password'=>Hash::make('password'),
        //     //'remember_token'=>Str::random(10),
        //     // 'status'=>0,
        //     //'created_at'=>now(),
        //     //'updated_at'=>now(),
        // ]);
    }
}
