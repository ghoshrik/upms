<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatesMaster extends Model
{
    use HasFactory;
    protected $table = "rates_master";
    protected $fillable = [
        "rate_id","rate_description","part_no","created_by","dept_id","status"
    ];
}
