<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AOC extends Model
{
    use HasFactory;
    protected $table = "a_o_c_s";
    protected $fillable = [
        'tender_id','tender_title','refc_no','tender_category'
    ];
}
