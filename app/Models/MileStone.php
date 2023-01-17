<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MileStone extends Model
{
    use HasFactory;
    protected $table = 'mile_stones';
    protected $fillable = ['index','parent_id','project_id','m1','m2','m3','m4'];

    public function parent()
    {
        return $this->belongsTo(MileStone::class, 'parent_id');
    }

    public function parent_info(){
        return $this->hasOne(MileStone::class,'id','parent_id');
    }

    public function project_list()
    {
        return $this->belongsTo(MileStone::class,'project_id');
    }
    public function child_cat(){
        return $this->hasMany(MileStone::class,'parent_id','id');
    }
    public function children()
    {
        return $this->hasMany(MileStone::class, 'parent_id');
    }
}
