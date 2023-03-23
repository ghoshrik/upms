<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory;
    protected $table ="tenders";
    protected $fillable = [
        'project_no','tender_id','tender_title','publish_date','close_date','bidder_name','tender_category'
    ];

    protected $dates = ['publish_date','close_date'];

    public function getMyDateAttribute($value)
    {
        $carbonDate = Carbon::createFromFormat('d/m/Y', $value); // Create a Carbon instance from the input date
        $this->attributes['publish_date'] = $carbonDate->format('Y-m-d H:i'); // Convert the date to the desired format and set the attribute// Convert the date to the desired format
        $this->attributes['close_date'] = $carbonDate->format('Y-m-d H:i');
    }
}
