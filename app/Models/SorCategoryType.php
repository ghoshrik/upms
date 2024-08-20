<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SorCategoryType extends Model
{
    use HasFactory;
    protected $table = "sor_category_types";
    protected $fillable = [
        'department_id', 'dept_category_name', 'target_pages', 'volume_id'
    ];
    public function departmentCategories() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function volume() : BelongsTo
    {
        return $this->belongsTo(VolumeMaster::class);
    }
    public function department()
    {
        return  $this->belongsTo(Department::class, 'department_id');
    }
    public function volumes()
    {
        return $this->hasMany(VolumeMaster::class, 'volume_id');
    }
}