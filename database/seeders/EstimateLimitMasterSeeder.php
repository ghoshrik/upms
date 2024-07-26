<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstimateLimitMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master.estimate_acceptance_limit_masters')->insert([
            [
                'department_id' => 1,
                'min_amount' => 0,
                'max_amount' => 10000000, // 1 crore in paise
                'checking_levels' => '5',
                'approving_level' => 4,
            ],
            [
                'department_id' => 1,
                'min_amount' => 10000001, // 1 crore in paise + 1
                'max_amount' => 25000000, // 2.5 crore in paise
                'checking_levels' => '5,4',
                'approving_level' => 5,
            ],
            [
                'department_id' => 1,
                'min_amount' => 25000001, // 2.5 crore in paise + 1
                'max_amount' => 100000000, // 10 crore in paise
                'checking_levels' => '5,4,3',
                'approving_level' => 2,
            ],
            [
                'department_id' => 1,
                'min_amount' => 100000001, // 10 crore in paise + 1
                'max_amount' => null, // Open-ended range
                'checking_levels' => '5,4,3,2',
                'approving_level' => 1,
            ],
        ]);
    }
}
