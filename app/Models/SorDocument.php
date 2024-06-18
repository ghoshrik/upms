<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorDocument extends Model
{
    use HasFactory;
    protected $connection = "pgsql_docu_external";
    protected $table = "sors_docu";
    protected $fillable = [
        "department_id", "dept_category_id", "volume_no", "docu_file", "upload_at","desc"
    ];

    public function deptCategories()
    {
        return $this->belongsTo(DepartmentCategories::class, 'dept_category_id');
    }
    public function scopeSearch($query, $value)
    {
        $query->where('upload_at', 'like', '%{$value}%');
    }
}