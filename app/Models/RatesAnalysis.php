<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatesAnalysis extends Model
{
    use HasFactory;
    protected $fillable = [
        'rate_id',
        'dept_id',
        'description',
        'category_id',
        'row_id',
        'row_index',
        'sor_item_number',
        'rate_no',
        'item_name',
        'page_no',
        'table_no',
        'sor_id',
        'volume_no',
        'item_index',
        'other_name',
        'qty',
        'rate',
        'total_amount',
        'operation',
        'created_by',
        'comments',
        'col_position',
        'unit_id'
    ];
}
