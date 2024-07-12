<?php

namespace App\Models;

use App\Models\DepartmentCategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DynamicSorHeader extends Model
{
    use HasFactory;
    protected $table = "dynamic_table_header";
    protected $fillable = [
        'table_no',
        'page_no',
        'header_data',
        'note',
        'title',
        'effective_date',
        'volume_no',
        'corrigenda_name',
        'dept_category_id',
        'department_id',
        'created_by',
        'row_data_base_64',
        'effective_to',
        'is_active',
        'is_approve',
        'updated_by',
        'color',
        'is_verified',
        'verified_desc',
        'verify_date', 'deleted_at'
    ];


    public function getDeptCategoryName()
    {
        return $this->belongsTo(DepartmentCategories::class, 'dept_category_id');
    }
    public function sorCategory()
    {
        return $this->belongsTo(DepartmentCategories::class, 'dept_category_id', 'id');
    }
    public function scopePendingSor($query)
    {
        return $query->where('is_approve', '=', '-11')
            ->where('is_verified', '=', '-9')->count();
    }
}
