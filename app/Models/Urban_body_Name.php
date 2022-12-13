<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urban_body_Name extends Model
{
    use HasFactory;
    protected $table= "m_urban_body_ward";
    protected $fillable = [
        'id'
      ,'urban_body_id'
      ,'urban_body_code'
      ,'urban_body_ward_code'
      ,'urban_body_ward_no'
      ,'urban_body_ward_name'
      ,'ward_status'
      ,'ds_ward'
    ];
    public function ward()
    {
        return $this->belongsTo(Urban_body::class,'urban_body_code','urban_body_code');
    }
}
