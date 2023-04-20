<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMaster extends Model
{
    use HasFactory;
    protected $table = "unit_masters";
    protected $fillable = ['unit_name', 'short_name', 'is_active'];
}
