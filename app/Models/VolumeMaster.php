<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VolumeMaster extends Model
{
    use HasFactory;
    protected $table = "master.volume_masters";
    protected $fillable = ["volume_name", "status"];


    public function categories()
    {
        return $this->belongsTo(SorCategoryType::class, 'id');
    }

    public function departmentCategories() : HasMany
    {
        return $this->hasMany(DepartmentCategory::class);
    }
}
