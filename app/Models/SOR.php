<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SOR extends Model
{
    use HasFactory;
    protected $table = "s_o_r_s";
    protected $fillable = [
        'item_details',
        'department_id',
        'dept_category_id',
        'description',
        'unit',
        'cost',
        'version',
        'effect_from',
        'effect_to',
        'IsActive'
    ];

    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['version_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
    }
    public function getDeptCategoryName()
    {
        return $this->belongsTo(SorCategoryType::class,'dept_category_id');
    }
}
