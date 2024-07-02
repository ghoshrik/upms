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
        "department_id", "dept_category_id", "volume_no", "docu_file", "upload_at"
    ];

    public function deptCategories()
    {
        return $this->belongsTo(SorCategoryType::class, 'dept_category_id');
    }
    public function scopeVolumeNo($query, $id)
    {
        return $query->select('volume_no')->where('id', $id)->first();
    }
    public function scopeUploadType($query, $id)
    {
        return $query->select('upload_at')->where('id', $id)->first();
    }
    public function scopeDescription($query, $id)
    {
        return $query->select('desc')->where('id', $id)->first();
    }
    public function scopeSelectAllRecords($query, $id)
    {
        return $query->select('dept_category_id', 'volume_no', 'upload_at', 'desc')->where('id', $id)->first();
    }
}
