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
        'category_id',
        'row_id',
        'row_index',
        'sor_item_number',
        'rate_no',
        'item_name',
        'other_name',
        'qty',
        'rate',
        'total_amount',
        'operation',
        'created_by',
        'comments'
    ];
}
