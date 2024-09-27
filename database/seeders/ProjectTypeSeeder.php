<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypeSeeder extends Seeder
{
    /**
     * The data to be seeded.
     *
     * @var array
     */
    protected $data = [
        [
            'department_id' => 47,
            'name' => 'Public Works',
        ],
        [
            'department_id' => 47,
            'name' => 'Road & Bridge Projects',
        ],
        [
            'department_id' => 47,
            'name' => 'IT Projects',
        ],
        [
            'department_id' => 47,
            'name' => 'Electrical Projects',
        ],
        [
            'department_id' => 47,
            'name' => 'Building And S & P Projects',
        ],
        [
            'department_id' => 26,
            'name' => 'Irrigation & Waterways Development Projects',
        ],
        [
            'department_id' => 38,
            'name' => 'Panchayats & Rural Development Projects',
        ],
        [
            'department_id' => 46,
            'name' => 'Public Health Engineering',
        ],
        [
            'department_id' => 57,
            'name' => 'Water Resources Investigation & Development Projects',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Loop through the data and insert each row
        foreach ($this->data as $projectType) {
            DB::table('project_types')->insert($projectType);
        }
    }
}