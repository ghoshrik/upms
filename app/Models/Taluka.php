<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taluka extends Model
{
    protected $table = 'm_block';


    protected $guarded = [];
    protected $fillable = [
        'district_code'
      ,'sub_division_code'
      ,'block_code'
      ,'block_name'
      ,'status'
      ,'district_id'
      ,'sub_division_id'
      ,'ds_block_name'
    ];

    public function block()
    {
        return $this->belongsTo(District::class,'district_code','district_code');
    }
}
