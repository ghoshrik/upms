<?php

namespace App\Models;

use App\Models\SorCategoryType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DynamicSorHeader extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "dynamic_table_header";
    protected $fillable = [
        'table_no',
        'page_no',
        'header_data',
        'row_data',
        'note',
        'title',
        'effective_date',
        'volume_no',
        'dept_category_id',
        'department_id',
        'created_by',
        'row_data_base_64',
        'effective_to',
        'corrigenda_name',
        'page_no_int',
        'subtitle',
        'is_approve',
        'is_verified',
        'verify_date',
        'verified_desc'
    ];

    public function getDeptCategoryName()
    {
        return $this->belongsTo(SorCategoryType::class, 'dept_category_id');
    }
    public function scopePendingSor($query)
    {
        return $query->where('is_approve', '=', '-11')
            ->where('is_verified', '=', '-9')
            ->where('department_id', Auth::user()->department_id)
            ->count();
    }
    public function scopeApproveSor($query)
    {
        return $query->where('is_approve', '=', '-11')
            ->where('is_verified', '=', '-09')
            ->where('department_id', Auth::user()->department_id)
            ->count();
    }
    public function scopeSorReportsDeptCategory($query)
    {
        return $query->join('sor_category_types', 'dynamic_table_header.dept_category_id', '=', 'sor_category_types.id')
            ->select(
                'dynamic_table_header.department_id',
                'sor_category_types.dept_category_name',
                'sor_category_types.target_pages',
                DB::raw('COUNT(CASE WHEN dynamic_table_header.effective_to IS NULL THEN 1 END) as category_count'),
                DB::raw('COUNT(CASE WHEN dynamic_table_header.effective_to IS NOT NULL THEN 1 END) as corrigenda_count'),
                DB::raw("COUNT(CASE WHEN dynamic_table_header.is_approve = '-11' AND dynamic_table_header.is_verified = '-9' THEN 1 END) as pending_approval_count"),
                DB::raw("COUNT(CASE WHEN dynamic_table_header.is_approve = '-11' AND dynamic_table_header.is_verified = '-09' THEN 1 END) as verified_count")
            )
            ->where('dynamic_table_header.department_id', Auth::user()->department_id)
            ->groupBy('dynamic_table_header.department_id', 'sor_category_types.dept_category_name', 'sor_category_types.target_pages');
    }

    public function scopeDepartmentWiseSorReports($query)
    {
        return $query->select(
            'departments.department_name',
            'sor_category_types.dept_category_name',
            'sor_category_types.target_pages',
            'master.volume_masters.volume_name',
            DB::raw('COUNT(CASE
                WHEN dynamic_table_header.deleted_at IS NULL
                AND dynamic_table_header.effective_to IS NULL
                THEN 1
            END) AS total_pages'),
            DB::raw('COUNT(CASE
                WHEN dynamic_table_header.deleted_at IS NULL
                AND dynamic_table_header.effective_to IS NOT NULL
                THEN 1
            END) AS total_corrigandam_pages'),
            DB::raw('COUNT(CASE
                WHEN dynamic_table_header.deleted_at IS NULL
                AND dynamic_table_header.is_approve = \'-11\'
                THEN 1
            END) AS total_approved'),
            DB::raw('COUNT(CASE
                WHEN dynamic_table_header.deleted_at IS NULL
                AND dynamic_table_header.is_verified = \'-09\'
                THEN 1
            END) AS total_verified')
        )
            ->leftJoin('sor_category_types', 'dynamic_table_header.dept_category_id', '=', 'sor_category_types.id')
            ->leftJoin('departments', 'departments.id', '=', 'sor_category_types.department_id')
            ->leftJoin(DB::raw('master.volume_masters'), DB::raw('CAST(dynamic_table_header.volume_no AS bigint)'), '=', 'master.volume_masters.id')
            ->groupBy(
                'departments.department_name',
                'sor_category_types.dept_category_name',
                'sor_category_types.target_pages',
                'dynamic_table_header.volume_no',
                'dynamic_table_header.department_id',
                'master.volume_masters.volume_name'
            )
            ->orderBy('dynamic_table_header.department_id');
    }
    //Product::make()->getFillable();
    public function scopeDynamicSorDataList($query, $id)
    {
        return $query->select('table_no', 'page_no', 'header_data', 'note', 'title', 'effective_date', 'volume_no')
            ->where('id', $id)->first();
    }
}
