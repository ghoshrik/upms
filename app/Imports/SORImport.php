<?php

namespace App\Imports;

use App\Models\SOR;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SORImport implements ToModel ,WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // private $departments;
    // public function __construct()
    // {
    //     $this->departments = Department::all(['id','department_name'])->pluck('id','department_name');
    // }
    public function model(array $row)
    {
        return new SOR([
            'Item_details'=>$row['Item_Details'],
            'department_id'=>$row['department _id'],
            'dept_category_id'=>$row['dept_categoy_id'],
            'unit'=>$row['unit'],
            'unit_id'=>$row['unit_id'],
            'description'=>$row['description'],
            'cost'=>$row['cost'],
            'version'=>$row['version'],
            'effect_from'=>$row['effect_form'],
            'effect_to'=>$row['effect_to'],
            'is_active'=>$row['is_active'],
            'created_by'=>$row['created_by'],
            'is_approved'=>$row['is_approved']
        ]);
    }
    public function chunkSize(): int
    {
        return 5000;
    }
}
