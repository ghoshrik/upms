<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AAFS extends Model
{
    use HasFactory;
    protected $table = "aafs";
    protected $fillable = ["project_id","Go_id","support_data","status","go_date"];

    protected $dates = ['go_date'];

    public function getMyDateAttribute($value)
    {
        $carbonDate = Carbon::createFromFormat('d/m/Y', $value); // Create a Carbon instance from the input date
        $this->attributes['go_date'] = $carbonDate->format('Y-m-d'); // Convert the date to the desired format and set the attribute// Convert the date to the desired format

    }
}
