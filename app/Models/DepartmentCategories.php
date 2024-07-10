<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCategories extends Model
{
    use HasFactory;
    protected $table = "department_categories";
    protected $fillable = [
        'department_id','dept_category_name','status'
    ];
    public function department()
    {
        return  $this->belongsTo(Department::class,'department_id');
    }
}
