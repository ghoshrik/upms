<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SorCategoryType;
use Illuminate\Database\Eloquent\SoftDeletes;

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
            ->count();
	}
	//Product::make()->getFillable();
	public function scopeDynamicSorDataList($query, $id)
	{
		return $query->select('table_no', 'page_no', 'header_data', 'note', 'title', 'effective_date', 'volume_no')
			->where('id', $id)->first();
	}
}
