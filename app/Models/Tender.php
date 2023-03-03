<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;
    protected $table ="tenders";
    protected $fillable = [
        'project_no','tender_id','tender_title','publish_date','close_date','bidder_name','tender_category'
    ];
}
