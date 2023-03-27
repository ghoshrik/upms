<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = "departments";
    protected $fillable = [
        'dept_code', 'department_name', 'status'
    ];
    public function SORCategory()
    {
        return $this->hasOne(SorCategoryType::class);
    }
}
