<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AOC extends Model
{
    use HasFactory;
    protected $table = "a_o_c_s";
    protected $fillable = [
        'tender_id','tender_title','project_no','tender_category',"publish_date","close_date","bidder_name"
    ];

    public function projects()
    {
        return $this->belongsTo(SorMaster::class,'project_no','id');
    }
}
