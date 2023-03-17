<?php

namespace Database\Seeders;

use App\Models\AccessType;
use Illuminate\Database\Seeder;

class AccessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessTypes = [
            [
                'access_name'=>'Estimate Recommender (ER)',
                'access_parent_id'=>4,
            ],
            [
                'access_name'=>'Estimate Preparer (EP)',
                'access_parent_id'=>1
            ],
            [
                'access_name'=>'Project Estimate (EP)',
                'access_parent_id'=>1
            ],
            [
                'access_name'=>'Estimate Forwarder (EF)',
                'access_parent_id'=>0
            ]
        ];
        foreach($accessTypes as $access)
        {
            AccessType::create($access);
        }
    }
}
