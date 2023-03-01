<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aoc extends Model
{
    use HasFactory;
    protected $table = "aocs";
    protected $fillable =['project_no','go_id','vendor_id','approved_date','amount',
      'status'];
}
