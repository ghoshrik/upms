<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateFlow extends Model
{
    use HasFactory;
    protected $table = "estimate_flows";
    protected $fillable = ['estimate_id','slm_id','sequence_no','role_id','permission_id','user_id','associated_at'];



}
