<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name'=> 'Admin',
            'email'=> 'admin@admin.com',
            'username'=>'admin',
            'emp_id'=>1025,
            'emp_name'=>'Admin',
            // 'designation_id'=>1,
            // 'department_id'=>1,
            'user_type'=>1,
            //'menu_access'=>'1,2,3,4,5,6,7,8,9,10,11,12',
            //'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            //'remember_token'=>Str::random(10),
            // 'status'=>0,
            //'created_at'=>now(),
            //'updated_at'=>now(),
        ]);
    }
}
