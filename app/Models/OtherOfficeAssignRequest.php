<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherOfficeAssignRequest extends Model
{
    use HasFactory;
    protected $fillable = ["request_from","user_id","office_id","roles","status","remarks"];

}
