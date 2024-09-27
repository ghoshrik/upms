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
            'title' => 'Public Works', // Change 'name' to 'title'
        ],
        [
            'department_id' => 47,
            'title' => 'Road & Bridge Projects',
        ],
        [
            'department_id' => 47,
            'title' => 'IT Projects',
        ],
        [
            'department_id' => 47,
            'title' => 'Electrical Projects',
        ],
        [
            'department_id' => 47,
            'title' => 'Building And S & P Projects',
        ],
        [
            'department_id' => 26,
            'title' => 'Irrigation & Waterways Development Projects',
        ],
        [
            'department_id' => 38,
            'title' => 'Panchayats & Rural Development Projects',
        ],
        [
            'department_id' => 46,
            'title' => 'Public Health Engineering',
        ],
        [
            'department_id' => 57,
            'title' => 'Water Resources Investigation & Development Projects',
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