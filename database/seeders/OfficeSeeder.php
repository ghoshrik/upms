<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;

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
                'office_name' => 'Head Office',
                'office_code' => 'OFF001',
                'office_address' => '123 Main Street, City A',
                'dist_code' => '101',
                'level_no' => 1,
                'in_area' => 'Area A',
                'rural_block_code' => 'RB101',
                'gp_code' => 'GP101',
                'urban_code' => 'UR101',
                'ward_code' => 'WARD01',
                'department_id' => 1,
                'group_id' => 1,
            ],
            [
                'office_name' => 'Branch Office 1',
                'office_code' => 'OFF002',
                'office_address' => '456 Elm Street, City B',
                'dist_code' => '102',
                'level_no' => 2,
                'in_area' => 'Area B',
                'rural_block_code' => 'RB102',
                'gp_code' => 'GP102',
                'urban_code' => 'UR102',
                'ward_code' => 'WARD02',
                'department_id' => 2,
                'group_id' => 1,
            ],
            // Add 8 more office entries
            [
                'office_name' => 'Branch Office 2',
                'office_code' => 'OFF003',
                'office_address' => '789 Oak Street, City C',
                'dist_code' => '103',
                'level_no' => 3,
                'in_area' => 'Area C',
                'rural_block_code' => 'RB103',
                'gp_code' => 'GP103',
                'urban_code' => 'UR103',
                'ward_code' => 'WARD03',
                'department_id' => 3,
                'group_id' => 2,
            ],
            [
                'office_name' => 'Branch Office 3',
                'office_code' => 'OFF004',
                'office_address' => '101 Pine Street, City D',
                'dist_code' => '104',
                'level_no' => 2,
                'in_area' => 'Area D',
                'rural_block_code' => 'RB104',
                'gp_code' => 'GP104',
                'urban_code' => 'UR104',
                'ward_code' => 'WARD04',
                'department_id' => 4,
                'group_id' => 2,
            ],
            [
                'office_name' => 'Branch Office 4',
                'office_code' => 'OFF005',
                'office_address' => '202 Maple Street, City E',
                'dist_code' => '105',
                'level_no' => 1,
                'in_area' => 'Area E',
                'rural_block_code' => 'RB105',
                'gp_code' => 'GP105',
                'urban_code' => 'UR105',
                'ward_code' => 'WARD05',
                'department_id' => 1,
                'group_id' => 3,
            ],
            [
                'office_name' => 'Branch Office 5',
                'office_code' => 'OFF006',
                'office_address' => '303 Cedar Street, City F',
                'dist_code' => '106',
                'level_no' => 3,
                'in_area' => 'Area F',
                'rural_block_code' => 'RB106',
                'gp_code' => 'GP106',
                'urban_code' => 'UR106',
                'ward_code' => 'WARD06',
                'department_id' => 2,
                'group_id' => 3,
            ],
            [
                'office_name' => 'Branch Office 6',
                'office_code' => 'OFF007',
                'office_address' => '404 Birch Street, City G',
                'dist_code' => '107',
                'level_no' => 2,
                'in_area' => 'Area G',
                'rural_block_code' => 'RB107',
                'gp_code' => 'GP107',
                'urban_code' => 'UR107',
                'ward_code' => 'WARD07',
                'department_id' => 3,
                'group_id' => 4,
            ],
            [
                'office_name' => 'Branch Office 7',
                'office_code' => 'OFF008',
                'office_address' => '505 Willow Street, City H',
                'dist_code' => '108',
                'level_no' => 1,
                'in_area' => 'Area H',
                'rural_block_code' => 'RB108',
                'gp_code' => 'GP108',
                'urban_code' => 'UR108',
                'ward_code' => 'WARD08',
                'department_id' => 4,
                'group_id' => 4,
            ],
            [
                'office_name' => 'Branch Office 8',
                'office_code' => 'OFF009',
                'office_address' => '606 Poplar Street, City I',
                'dist_code' => '109',
                'level_no' => 2,
                'in_area' => 'Area I',
                'rural_block_code' => 'RB109',
                'gp_code' => 'GP109',
                'urban_code' => 'UR109',
                'ward_code' => 'WARD09',
                'department_id' => 1,
                'group_id' => 5,
            ],
            [
                'office_name' => 'Branch Office 9',
                'office_code' => 'OFF010',
                'office_address' => '707 Aspen Street, City J',
                'dist_code' => '110',
                'level_no' => 3,
                'in_area' => 'Area J',
                'rural_block_code' => 'RB110',
                'gp_code' => 'GP110',
                'urban_code' => 'UR110',
                'ward_code' => 'WARD10',
                'department_id' => 2,
                'group_id' => 5,
            ],
        ];

        foreach ($offices as $office) {
            Office::create($office);
        }
    }
}
