<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esrecommender extends Model
{
    use HasFactory;
    protected $table = "estimate_recomender";
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
        'verified_by',
        'comments'
    ];
    public function SOR()
    {
       return $this->hasOne(SorMaster::class,'estimate_id','estimate_id');
    }
}
