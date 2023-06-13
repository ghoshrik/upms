<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carriagesor extends Model
{
    use HasFactory;
    protected $table = "carriagesors";
    protected $fillable = ["description","unit_id","zone","start_distance","upto_distance","cost"];

}
