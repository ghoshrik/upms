<?php

namespace Database\Seeders;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = [
            [
                'department_name'=>'Public Works Department',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'department_name'=>'Irrigation & Waterways Department',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'department_name'=>'Public Health Engineering Department',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
        ];
        foreach($department as $departments)
        {
            Department::create($departments);
        }
    }
}
