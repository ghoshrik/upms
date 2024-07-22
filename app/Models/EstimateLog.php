<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateLog extends Model
{
    use HasFactory;
    protected $table = 'estimate_logs';
    protected $fillable = [
        'estimate_id','old_data','created_by','updated_by'
    ];
}
