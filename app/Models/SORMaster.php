<?php

namespace App\Models;

use App\Models\EstimatePrepare;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class SorMaster extends Model
{
    use HasFactory;
    protected $table = "sor_masters";
    protected $fillable = [
        'estimate_id',
        'sorMasterDesc',
        'status',
        'is_verified',
        'dept_id',
        'part_no',
        'created_by',
        'associated_with',
        'approved_at',
        'project_type_id',
        'project_creation_id'
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


    public function estimatePrepare()
    {
        return $this->hasOne(EstimatePrepare::class, 'estimate_id', 'estimate_id');
    }

    public function estimateFlow()
    {
        return $this->hasOne(EstimateFlow::class, 'estimate_id', 'estimate_id');
    }

    public function estimateStatus()
    {
        return $this->belongsTo(EstimateStatus::class, 'status', 'id');
    }

    public function permission()
    {
        return $this->hasOneThrough(Permission::class, EstimateFlow::class, 'estimate_id', 'id', 'estimate_id', 'permission_id');
    }

    public function project()
    {
        return $this->belongsTo(ProjectCreation::class);
    }
}
