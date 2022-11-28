<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorMaster extends Model
{
    use HasFactory;
    protected $table = "sor_masters";
    protected $fillable = [
        'estimate_id','sorMasterDesc','status','is_verified'
    ];
    
}
