<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateUserAssignRecord extends Model
{
    use HasFactory;
    protected $table= "estimate_user_assign_records";
    protected $fillable = [
       'estimate_id','estimate_user_type','estimate_user_id','comments'
    ];
    public function SOR()
    {
        return $this->hasOne(SorMaster::class,'estimate_id','estimate_id');
    }
    // public function assigningUserRemarks()
    // {
    //     return $this->belongsTo(SorMaster::class,'estimate_id','estimate_id');
    // }
}
