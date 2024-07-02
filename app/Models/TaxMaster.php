<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxMaster extends Model
{
    use HasFactory;
    protected $table = "master.taxmasters";
    protected $fillable = ['tax_name', 'tax_percentage', 'department_id', 'category_id', 'status'];
}
