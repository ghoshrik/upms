<?php

namespace Database\Seeders;

use App\Models\DepartmentCategories;
use Illuminate\Database\Seeder;

class sorCategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            [
                'department_id'=>1,
                'dept_category_name'=>'Electric'
            ],
            [
                'department_id'=>1,
                'dept_category_name'=>'Road'
            ],
            [
                'department_id'=>2,
                'dept_category_name'=>'Electric'
            ],
            [
                'department_id'=>2,
                'dept_category_name'=>'Water'
            ],
            [
                'department_id'=>3,
                'dept_category_name'=>'Electronices'
            ]
        ];

        foreach($category as $cate)
        {
            DepartmentCategories::create($cate);
        }
    }
}
