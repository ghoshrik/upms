<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\SORCategory;
use App\Models\DepartmentCategories;
use Illuminate\Database\Seeder;

class SorCategoriesSeeder extends Seeder
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
                'item_name'=>'SOR',
                'status'=>'inactive',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'item_name'=>'Other',
                'status'=>'inactive',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
        ];
        foreach($types as $type)
        {
            SORCategory::create($type);
        }
    }
}
