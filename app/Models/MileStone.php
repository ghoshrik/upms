<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MileStone extends Model
{
    use HasFactory;
    protected $table = 'mile_stones';
    protected $fillable = ['index','parent_id','project_id','milestone_name','weight','unit_type','cost'];


    //one level parents
    public function parent()
    {
        return $this->belongsTo(MileStone::class, 'parent_id');
    }
    //Recursive parents
    public function parents(){
        return $this->belongsTo(MileStone::class,'parent_id')->with('parent');
    }
    public function project_list()
    {
        return $this->belongsTo(SorMaster::class,'project_id','estimate_id');
    }
    //One level child
    public function child(){
        return $this->hasMany(MileStone::class,'parent_id');
    }
    //Recursive children
    public function children()
    {
        return $this->hasMany(MileStone::class, 'parent_id')->with('children');
    }
}
