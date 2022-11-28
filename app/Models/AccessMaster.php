<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessMaster extends Model
{
    use HasFactory;
    protected $fillable =[
        'department_id',
        'designation_id',
        'access_type_id',
        'office_id',
        'user_id'
    ];
    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function getDesignationName()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
    public function getOfficeName()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
    public function getUserName()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function getAccessTypeName()
    {
        return $this->belongsTo(AccessType::class, 'access_type_id');
    }
}
