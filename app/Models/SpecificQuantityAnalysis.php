<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificQuantityAnalysis extends Model
{
    use HasFactory;
    protected $table = "specific_quantity_analysis";
    protected $fillable = [
        'estimate_id','rate_no','row_id','row_data','type','sor_id','sor_item_index','created_by','updated_by'
    ];
}
