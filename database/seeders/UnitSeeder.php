<?php

namespace Database\Seeders;

use App\Models\UnitType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            [
                'type'=>'KM',
                'status'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'type'=>'CM',
                'status'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]
        ];
        foreach($units as $unit)
        {
            UnitType::create($unit);
        }
    }
}
