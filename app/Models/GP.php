<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GP extends Model
{
    protected $table='m_gp';
    protected $fillable = ['district_code'
      ,'sub_division_code'
      ,'block_code'
      ,'gram_panchyat_code'
      ,'gram_panchyat_name'
      ,'status'
      ,'dist_id'
      ,'sub_division_id'
      ,'block_id'
      ,'gram_panchyat_id'
      ,'ds_gp'];

    public function gpBame()
    {
        return $this->belongsTo(Taluka::class,'block_code','block_code');
    }
}
