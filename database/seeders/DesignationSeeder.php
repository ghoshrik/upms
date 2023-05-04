<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            [
                'designation_name'=>'Chief Engineers'
            ],
            [
                'designation_name'=>'Zonal Chief Engineer'
            ],
            [
                'designation_name'=>'Superintending Engineering'
            ],
            [
                'designation_name'=>'Executive Engineer'
            ],
            [
                'designation_name'=>'Assistant Engineer'
            ],
            [
                'designation_name'=>'Sub Assistant Engineer / Estimator'
            ],

        ];
        foreach($designations as $designation)
        {
            Designation::create($designation);
        }
    }
}
