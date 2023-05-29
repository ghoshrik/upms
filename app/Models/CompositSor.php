<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompositSor extends Model
{
    use HasFactory;
    protected $table = "composit_sors";
    protected $fillable =
    [
        "dept_category_id", "sor_itemno_parent_id", "sor_itemno_child", "description", "unit_id", "rate"
    ];
    public function getDeptCategoryName()
    {
        return $this->belongsTo(SorCategoryType::class, 'dept_category_id', 'id');
    }
    public function ParentSORItemNo()
    {
        return $this->belongsTo(SOR::class, 'sor_itemno_parent_id', 'id');
    }
    public function ChildSORItemNo()
    {
        return $this->belongsTo(SOR::class, 'sor_itemno_child', 'id');
    }
    public function getUnit()
    {
        return $this->belongsTo(UnitMaster::class, 'unit_id', 'id');
    }
}