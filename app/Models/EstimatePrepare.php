<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimatePrepare extends Model
{
    use HasFactory;
    protected $table = "estimate_prepares";
    protected $fillable = [
        'estimate_id',
        'dept_id',
        'category_id',
        'row_id',
        'row_index',
        'sor_item_number',
        'estimate_no',
        'rate_id',
        'volume_no',
        'page_no',
        'table_no',
        'sor_id',
        'item_index',
        'item_name',
        'other_name',
        'qty',
        'rate',
        'total_amount',
        'operation',
        'created_by',
        'comments',
        'col_position',
        'unit_id',
        'qty_analysis_data'
    ];
    //currently not in use
    protected static function boot()
    {
        parent::boot();

        // Store old data as log after updating
        static::updated(function ($model) {
            $originalData = $model->getOriginal();
            // $user_id = Auth::id(); // Get current user ID
            
            EstimateLog::create([
                'estimate_id' => $model->estimate_id,
                'old_data' => json_encode($originalData),
                'created_by' => $model->created_by,
                'updated_by' => Auth::user()->id,
            ]);
        });
    }
    //----------------------------//
    public function sorNumber()
    {
        return $this->belongsTo(SOR::class,'sor_item_number','id');
    }
    public function SOR()
    {
       return $this->hasOne(SorMaster::class,'estimate_id','estimate_id');
    }
    public function assigningUserRemarks()
    {
        return $this->belongsTo(EstimateUserAssignRecord::class,'created_by','user_id');
    }
}
