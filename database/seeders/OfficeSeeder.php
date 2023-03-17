<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = [
            [
                'office_name'=>'PWD Office',
                'office_address'=>'address',
                'department_id'=>1,
                'dist_code'=>315,
                'In_area'=>2,
                'rural_block_code'=>NULL,
                'gp_code'=>NULL,
                'urban_code'=>250299,
                'ward_code'=>17241,
                'level'=>1,
            ],
            [
                'office_name'=>'PWD Office 2',
                'office_address'=>'address',
                'department_id'=>1,
                'dist_code'=>315,
                'In_area'=>2,
                'rural_block_code'=>NULL,
                'gp_code'=>NULL,
                'urban_code'=>250299,
                'ward_code'=>17300,
                'level'=>1,
            ],
            [
                'office_name'=>'PWD Office 3',
                'office_address'=>'address',
                'department_id'=>1,
                'dist_code'=>315,
                'In_area'=>2,
                'rural_block_code'=>NULL,
                'gp_code'=>NULL,
                'urban_code'=>250299,
                'ward_code'=>17283,
                'level'=>2,
            ],
            [
                'office_name'=>'IWD Office A',
                'office_address'=>'Siliguri,Darjeeling',
                'department_id'=>2,
                'dist_code'=>309,
                'In_area'=>2,
                'rural_block_code'=>NULL,
                'gp_code'=>NULL,
                'urban_code'=>249957,
                'ward_code'=>9999383,
                'level'=>2,
            ],
            [
                'office_name'=>'IWD Office KMC',
                'office_address'=>'Kolkata',
                'department_id'=>2,
                'dist_code'=>315,
                'In_area'=>2,
                'rural_block_code'=>NULL,
                'gp_code'=>NULL,
                'urban_code'=>250299,
                'ward_code'=>17266,
                'level'=>3,
            ],
        ];

        foreach($offices as $office)
        {
            Office::create($office);
        }
    }
}
