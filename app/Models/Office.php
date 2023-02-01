<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $table = "offices";
    protected $fillable = [
        'office_name','department_id','dist_code','In_area','rural_block_code','gp_code','urban_code','ward_code','office_address'
    ];
    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
    public function getDistrictName()
    {
        return $this->belongsTo(District::class,'dist_code','district_code');
    }
    public function getUrban()
    {
        return $this->belongsTo(Urban_body::class,'urban_code','urban_body_code');
    }
}
