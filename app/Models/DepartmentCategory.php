<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepartmentCategory extends Model
{
    use HasFactory;
    protected $table = "department_categories";
    protected $fillable = ['department_id', 'volume_id', 'dept_category_name', 'target_pages'];

    public function departmentCategories() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function volume() : BelongsTo
    {
        return $this->belongsTo(VolumeMaster::class);
    }
}
