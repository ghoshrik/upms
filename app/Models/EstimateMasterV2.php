<?php

namespace App\Models;

use App\Models\EstimateStatus;
use App\Models\EstimatePrepareV2;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimateMasterV2 extends Model
{
    use HasFactory;
    protected $table = "estimate_master_v2";
    protected $fillable = [
        'estimate_id', 'estimate_master_desc', 'status', 'is_verified', 'dept_id', 'part_no','total_amount','created_by'
    ];
    public function estimate()
    {
        return $this->belongsTo(EstimatePrepareV2::class, 'estimate_id', 'estimate_id');
    }
    public function getEstimateStatus()
    {
        return $this->hasOne(EstimateStatus::class, 'id', 'status');
    }
}
