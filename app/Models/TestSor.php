<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestSor extends Model
{
    use HasFactory;
    protected $table = "test_sors";
    protected $fillable = ['Item_details','department_id','dept_category_id','unit','unit_id','description','cost','version','effect_form','effect_to','is_active','is_approved'
    ];
    protected $dates = ['effect_from', 'effect_to'];

    public function getMyDateAttribute($value)
    {
        $carbonDate = Carbon::createFromFormat('d/m/Y', $value); // Create a Carbon instance from the input date
        $this->attributes['effect_from'] = $carbonDate->format('Y-m-d'); // Convert the date to the desired format and set the attribute// Convert the date to the desired format
        $this->attributes['effect_to'] = $carbonDate->format('Y-m-d');
    }
}
