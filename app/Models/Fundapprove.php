<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundapprove extends Model
{
    use HasFactory;
    protected $table = "fundapproves";
    protected $fillable = ['project_id','go_id','vendor_id','approved_date','amount','status'];


    public function getProjectDetails()
    {
        return $this->belongsTo(SorMaster::class,'project_id');
    }
    public function getVendorDetails()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
