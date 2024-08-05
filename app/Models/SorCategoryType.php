<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorCategoryType extends Model
{
    use HasFactory;
    protected $table = "sor_category_types";
    protected $fillable = [
        'department_id', 'dept_category_name', 'volume_no', 'target_page'
    ];
    public function department()
    {
        return  $this->belongsTo(Department::class, 'department_id');
    }
    public function volumes()
    {
        return $this->hasMany(VolumeMaster::class, 'volume_no');
    }
}