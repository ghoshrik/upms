<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abstracts extends Model
{
    use HasFactory;
    protected $table = "abstruct_costs";
    protected $fillable = ["tableData", "tableHeader", "project_desc", "department_id", "category_id", 'total_amount', 'created_by'];
}
