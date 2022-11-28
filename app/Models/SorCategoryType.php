<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorCategoryType extends Model
{
    use HasFactory;
    protected $table = "sor_category_types";
    protected $fillable = [
        'department_id','dept_category_name'
    ];
    public function GetDepartmentName()
    {
        return  $this->belongsTo(Department::class,'department_id');
    }
}
