<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aoc extends Model
{
    use HasFactory;
    protected $table = "aocs";
    protected $fillable = [
        'project_no', 'go_id', 'vendor_id', 'approved_date', 'amount',
        'status'
    ];

    protected $dates = ['approved_date'];

    public function getMyDateAttribute($value)
    {
        $carbonDate = Carbon::createFromFormat('d/m/Y', $value); // Create a Carbon instance from the input date
        $this->attributes['approved_date'] = $carbonDate->format('Y-m-d'); // Convert the date to the desired format and set the attribute// Convert the date to the desired format
    }
}