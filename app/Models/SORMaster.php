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
    public function estimatelist()
    {
        $this->hasMany(EstimatePrepare::class,'estimate_id');
    }
}
