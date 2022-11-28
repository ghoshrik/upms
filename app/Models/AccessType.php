<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessType extends Model
{
    use HasFactory;
    protected $fillable =[
        'access_name','access_parent_id','menu_id'
    ];
}
