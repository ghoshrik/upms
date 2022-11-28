<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PowerComponents\LivewirePowerGrid\Actions\FillableTable;

class Estimate extends Model
{
    use HasFactory;
    protected $table = "estimates";
    protected $fillable = [
        'estimate_id',
        'row_id',
        'row_index',
        'sor_item_number',
        'estimate_no',
        'item_name',
        'other_name',
        'qty',
        'rate',
        'total_amount',
        'percentage_rate',
        'operation',
        'created_by',
        'comments'
    ];
    public function sorNumber()
    {
        return $this->belongsTo(SOR::class,'sor_item_number');
    }
}
