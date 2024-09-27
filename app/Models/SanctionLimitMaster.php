<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanctionLimitMaster extends Model
{
    use HasFactory;
    protected $table = "sanction_limit_masters";
    protected $fillable = ["department_id", "project_type_id", "min_amount", "max_amount"];

    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    // public function getLevelName(){
    //     return $this->belongsTo(Levels::class,'level_id');
    // }
    // public function getRolesName(){
    //     return $this->belongsTo(Role::class,'role_id');
    // }
    public function roles(): HasMany
    {
        return $this->hasMany(SanctionRole::class);
    }
    public function projectType() : BelongsTo
    {
        return $this->belongsTo(ProjectType::class);
    }
}
