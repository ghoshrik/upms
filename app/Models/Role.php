<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "roles";
    // protected $fillable = ["user_id","user_type","office_id","dist_id","In_rural","user_type","office_id","dept_id","rural_block_code","gp_code","urban_code","ward_code"];

    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
    public function getUserType()
    {
        return $this->belongsTo(UserType::class, 'user_type');
    }
    public function getUsername()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function getOfficeName()
    {
        return $this->belongsTo(Office::class,"office_id");
    }
    public function getDistrictName()
    {
        return $this->belongsTo(District::class,"dist_code","dist_id");
    }
    public function parentRole()
    {
        return $this->belongsTo(Role::class, 'role_parent');
    }

    public function childRoles()
    {
        return $this->hasMany(Role::class, 'role_parent');
    }
}
