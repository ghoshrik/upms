<?php

namespace App\Models;

use App\Models\EstimateMasterV2;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimatePrepareV2 extends Model
{
    use HasFactory;
    protected $table = "estimate_prepares_v2";
    protected $fillable = [
        'estimate_id',
        'dept_id',
        'description',
        'category_id',
        'row_id',
        'sl_no',
        'p_id',
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
        'rate_det',
        'total_amount',
        'operation',
        'created_by',
        'comments',
        'col_position',
        'unit_id',
        'qty_analysis_data',
        'qtyUpdate'

    ];

    public function sorNumber()
    {
        return $this->belongsTo(SOR::class,'sor_item_number','id');
    }
    public function SOR()
    {
       return $this->hasOne(EstimateMasterV2::class,'estimate_id','estimate_id');
    }
    public function assigningUserRemarks()
    {
        return $this->belongsTo(EstimateUserAssignRecord::class,'created_by','user_id');
    }
}
