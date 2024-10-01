<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $table = "departments";
    protected $fillable = [
        'department_name','department_code'
    ];
    public function SORCategory()
    {
        return $this->hasOne(SorCategoryType::class);
    }
    public function department() : HasMany
    {
        return $this->hasMany(DepartmentCategory::class);
    }
    public function groups() : HasMany
    {
        return $this->hasMany(Group::class);
    }
    public function projectTypes() : HasMany
    {
        return $this->hasMany(ProjectType::class);
    }

    public function createProjects() : HasMany
    {
        return $this->hasMany(ProjectCreation::class);
    }
}
