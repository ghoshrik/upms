<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Carbon\Carbon;
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
        $users = [
            [
                'email'=>'admin@admin.com',
                'username'=>'admin',
                'emp_id'=>1025,
                'emp_name'=>'Admin',
                'designation_id'=>0,
                'department_id'=>0,
                'user_type'=>1,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>0,
                'mobile'=>1,
            ],
            [
                'email'=>'state_admin@gmail.com',
                'username'=>'state_admin',
                'emp_id'=>1001,
                'emp_name'=>'State Admin',
                'designation_id'=>0,
                'department_id'=>0,
                'user_type'=>2,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>0,
                'mobile'=>2,
            ],
            [
                'email'=>'pwd_dept_admin@gmail.com',
                'username'=>'pwd_dept_admin',
                'emp_id'=>1001,
                'emp_name'=>'Ashis Mukherjee',
                'designation_id'=>0,
                'department_id'=>1,
                'user_type'=>3,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>0,
                'mobile'=>3,
            ],
            [
                'email'=>'office_admin@gmail.com',
                'username'=>'office_admin',
                'emp_id'=>1002,
                'emp_name'=>'Gourav Basu',
                'designation_id'=>0,
                'department_id'=>1,
                'user_type'=>4,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>1,
                'mobile'=>4,
            ],
            [
                'email'=>'office_user@gmail.com',
                'username'=>'office_user',
                'emp_id'=>1003,
                'emp_name'=>'Bijoy Mondal',
                'designation_id'=>6,
                'department_id'=>2,
                'user_type'=>6,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>1,
                'mobile'=>5,
            ],
            [
                'email'=>'IWD_dept_admin@gmail.com',
                'username'=>'IWD_dept_admin',
                'emp_id'=>1003,
                'emp_name'=>'Mawar Hossain',
                'designation_id'=>0,
                'department_id'=>2,
                'user_type'=>3,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>0,
                'mobile'=>6,
            ],
            [
                'email'=>'iwd_office_admin@gmail.com',
                'username'=>'Kaushik Pal',
                'emp_id'=>1006,
                'emp_name'=>'Mawar Hossain',
                'designation_id'=>0,
                'department_id'=>2,
                'user_type'=>4,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>4,
                'mobile'=>7,
            ],
            [
                'email'=>'iwd_office_user@gmail.com',
                'username'=>'iwd_office_user',
                'emp_id'=>1007,
                'emp_name'=>'Tanmay Kumar',
                'designation_id'=>5,
                'department_id'=>2,
                'user_type'=>6,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>4,
                'mobile'=>8,
            ],
            [
                'email'=>'iwd_office_user1cle@gmail.com',
                'username'=>'iwd_office_user1',
                'emp_id'=>1008,
                'emp_name'=>'Suman Roy',
                'designation_id'=>6,
                'department_id'=>2,
                'user_type'=>6,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>4,
                'mobile'=>9,
            ],
            [
                'email'=>'imanwar@gmail.com',
                'username'=>'imanwar',
                'emp_id'=>147852,
                'emp_name'=>'Manwar Hossain',
                'designation_id'=>6,
                'department_id'=>3,
                'user_type'=>3,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>0,
                'mobile'=>10,
            ],
            [
                'email'=>'iwd_office_user2@gmail.com',
                'username'=>'iwd_office_user2',
                'emp_id'=>1002151,
                'emp_name'=>'Abhishek Ghosh',
                'designation_id'=>4,
                'department_id'=>2,
                'user_type'=>6,
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('password'),
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'office_id'=>4,
                'mobile'=>11,
            ],
        ];
        foreach($users as $user)
        {
            User::create($user);
        }
    }
}
