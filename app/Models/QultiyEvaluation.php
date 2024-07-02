<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QultiyEvaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'rate_id','dept_id','row_id','row_index','label','unit','value','operation','created_by','remarks'
    ];
    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}
