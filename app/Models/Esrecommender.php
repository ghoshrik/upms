<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esrecommender extends Model
{
    use HasFactory;
    protected $table = "esrecommenders";
    protected $fillable = [
        'estimate_id','row_id','row_index','sor_item_number','estimate_no','item_name','other_name','qty','rate','total_amount','percentage_rate','operation','commends','created_by'
    ];
}
