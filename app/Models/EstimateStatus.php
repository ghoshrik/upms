<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateStatus extends Model
{
    use HasFactory;
    protected $table = "estimate_statuses";
    protected $fillable = [
        'status','slug'
    ];
    public function statusName()
    {
        return $this->belongsTo(SorMaster::class,'status');
    }
}
