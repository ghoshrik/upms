<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urban_body extends Model
{
    use HasFactory;
    protected $table = "m_urban_body";
    protected $fillable = [
        "district_code","urban_body_code","urban_body_name","sub_district_code","urban_body_status","ds_urban_body_name"
    ];

    public function urban()
    {
        return $this->belongsTo(District::class,'district_code','district_code');
    }
}
