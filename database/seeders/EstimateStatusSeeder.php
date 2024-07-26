<?php

namespace Database\Seeders;

use App\Models\EstimateStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EstimateStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$status = [
            [
                'status'=>'New',
                'slug'=>'new',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'status'=>'Pending For ER Approval',
                'slug'=>'send_to_er',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'status'=>'Revert to EP',
                'slug'=>'revert_to_ep',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'status'=>'Modified Estimate by ER',
                'slug'=>'modify_by_er',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'status'=>'Modified Estimate',
                'slug'=>'modifieds_by_ep',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'status'=>'Approved By ER',
                'slug'=>'approved_by_er',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'status'=>'Revert to ER',
                'slug'=>'revert_by_ef',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'status'=>'Verified By EF',
                'slug'=>'verified_by_ef',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
            [
                'status'=>'Pending For EF Approval',
                'slug'=>'forward_to_ef',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],

        ];*/
        $status = [
            [
                'status' => 'New',
                'slug' => 'new',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Draft',
                'slug' => 'draft',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Checking',
                'slug' => 'fwd-to-checker',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Modified',
                'slug' => 'modify-by-checker',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Verified',
                'slug' => 'verify-by-checker',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Reverted',
                'slug' => 'revert',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Approved',
                'slug' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Drafted by Checker',
                'slug' => 'draft-by-checker',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        foreach ($status as $list) {
            EstimateStatus::create($list);
        }
    }
}
