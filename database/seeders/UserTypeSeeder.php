<?php

namespace Database\Seeders;

use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'id'=>1,
                'type'=>'Super Admin',
                'parent_id'=>0,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'id'=>2,
                'type'=>'State Admin',
                'parent_id'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'id'=>3,
                'type'=>'Department Admin',
                'parent_id'=>2,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'id'=>4,
                'type'=>'Office Admin',
                'parent_id'=>3,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'id'=>5,
                'type'=>'Office User',
                'parent_id'=>4,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],

        ];
        foreach($types as $type)
        {
            UserType::create($type);
        }
    }
}
