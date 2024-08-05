<?php

namespace Database\Seeders;

use App\Models\VolumeMaster;
use Illuminate\Database\Seeder;

class VolumeMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [
            [
                "volume_name" => 'Volume I',
                'status' => 'active'
            ],
            [
                "volume_name" => 'Volume II',
                'status' => 'active'
            ],
            [
                "volume_name" => 'Volume III',
                'status' => 'active'
            ],
        ];

        foreach ($insert as $value) {
            VolumeMaster::create($value);
        }
    }
}