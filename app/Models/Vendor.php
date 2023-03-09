<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table = "vendors";
    protected $fillable = [
        'comp_name','tin_number','pan_number','mobile','address',"gstn_no",'class_vendor'
    ];
}
