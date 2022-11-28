<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SORCategory extends Model
{
    use HasFactory;
    protected $table = "s_o_r_categories";

    protected $fillable = [
        'item_name',
        'status'
    ];
}
