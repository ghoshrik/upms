<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carriagesor extends Model
{
    use HasFactory;
    protected $table = "carriagesors";
    protected $fillable = [
        "dept_id",
        "dept_category_id",
        "sor_parent_id",
        "child_sor_id",
        "description",
        "start_distance",
        "upto_distance",
        "cost",
        "total_number"
    ];
    public function getSORParentDetails()
    {
        return $this->belongsTo(SOR::class,'sor_parent_id','id');
    }
    public function getSORChildDetails()
    {
        return $this->belongsTo(SOR::class,'child_sor_id','id');
    }
}
