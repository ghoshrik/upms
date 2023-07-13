<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicSorHeader extends Model
{
    use HasFactory;
    protected $table = "dynamic_sor_header";
    protected $fillable = ['table_no','page_no','header_data'];
}
