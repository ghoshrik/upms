<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;
    protected $table = "milestones";
    protected $fillable = ["index","milestone_id","project_id","milestone_name","weight","unit_type","cost"];


    public function project_list()
    {
        return $this->belongsTo(SorMaster::class,'project_id','estimate_id');
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
    public function childrenMilestones()
    {
        return $this->hasMany(Milestone::class)->with('milestones');
    }
}
