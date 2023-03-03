<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AAFS extends Model
{
    use HasFactory;
    protected $table = "a_a_f_s";
    protected $fillable = ["project_id","Go_id","support_data","status","go_date"];
}
