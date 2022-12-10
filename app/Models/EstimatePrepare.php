<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'item_name',
        'other_name',
        'qty',
        'rate',
        'total_amount',
        'operation',
        'created_by',
        'comments'
    ];
    public function SOR()
    {
       return $this->belongsTo(SorMaster::class,'estimate_id','estimate_id');
    }
}
