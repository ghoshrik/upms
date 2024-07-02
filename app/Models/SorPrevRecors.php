<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorPrevRecors extends Model
{
    use HasFactory;
    protected $table = "sor_prev_records";
    protected $fillable = [
        'dynamic_sor_id',
        'department_id',
        'dept_category_id',
        'row_data',
        'created_by'
    ];
}
