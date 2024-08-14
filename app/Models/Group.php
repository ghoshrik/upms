<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    protected $table = "groups";
    protected $fillable = ['department_id','dept_category_id','group_name'];

    public function groups() : HasMany
    {
        return $this->hasMany(Department::class);
    }
    public function getDeptName() : BelongsTo
    {
        return $this->belongsTo(Department::class,'department_id');
    }
    public function getDeptCategoryName() : BelongsTo
    {
        return $this->belongsTo(DepartmentCategory::class,'dept_category_id');
    }
}
