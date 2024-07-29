<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateAcceptanceLimitMaster extends Model
{
    use HasFactory;
    protected $table = "estimate_acceptance_limit_masters";
    protected $fillable = ["department_id", "approving_level", "checking_levels", "min_amount", "max_amount"];
}
