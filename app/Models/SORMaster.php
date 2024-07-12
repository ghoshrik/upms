<?php

namespace App\Models;

use App\Models\EstimatePrepare;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorMaster extends Model
{
    use HasFactory;
    protected $table = "estimate_masters";
    protected $fillable = [
        'estimate_id', 'sorMasterDesc', 'status', 'is_verified', 'dept_id', 'part_no','created_by'
    ];
    public function estimate()
    {
        return $this->belongsTo(EstimatePrepare::class, 'estimate_id', 'estimate_id');
    }
    public function estimateRecomender()
    {
        return $this->belongsTo(Esrecommender::class, 'estimate_id', 'estimate_id');
    }
    public function userAR()
    {
        return $this->belongsTo(EstimateUserAssignRecord::class, 'estimate_id', 'estimate_id');
    }
    public function getEstimateStatus()
    {
        return $this->hasOne(EstimateStatus::class, 'id', 'status');
    }
}
