<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EstimatePrepare;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SorMaster extends Model
{
    use HasFactory;
    protected $table = "sor_masters";
    protected $fillable = [
        'estimate_id','sorMasterDesc','status','is_verified'
    ];
    public function estimate()
    {
        return $this->belongsTo(EstimatePrepare::class,'estimate_id','estimate_id');
    }
    public function userAR()
    {
        return $this->belongsTo(EstimateUserAssignRecord::class,'estimate_id','estimate_id');
    }
}
