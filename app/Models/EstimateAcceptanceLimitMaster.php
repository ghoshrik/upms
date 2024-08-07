<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateAcceptanceLimitMaster extends Model
{
    use HasFactory;
    protected $table = "estimate_acceptance_limit_masters";
    protected $fillable = ["department_id","level_id", "min_amount", "max_amount"];

    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function getLevelName(){
        return $this->belongsTo(Levels::class,'level_id');
    }
    public function getLevelWiseRoleName(){
        return $this->belongsTo(Role::class,'level_id','has_level_no');
    }
}
