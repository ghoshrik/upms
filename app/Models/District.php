<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = "m_district";
    protected $fillable = ["district_code","district_name","rch_district_code","is_revenue_district","state_code","district_status","ds_district_name"];
}
