<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Designation;
use App\Models\UsersHasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use App\Traits\HasPermissionsTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        // 'username',
        'email',
        'mobile',
        'password',
        'ehrms_id',
        'emp_name',
        'designation_id',
        'department_id',
        'office_id',
        'user_type',
        'is_active',
        'dept_category_id',
        'group_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_verified',
        'is_admin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // public function userProfile() {
    //     return $this->hasOne(UserProfile::class, 'user_id', 'id');
    // }
    // public function getDesignationName()
    // {
    //     return $this->belongsTo(Designation::class,'designation_id');
    //     // return $this->belongsTo(Designation::class,'designation_id','id');
    // }
    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function getDesignationName():BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
    public function getUserType()
    {
        return $this->belongsTo(UserType::class, 'user_type');
    }
    public function getOfficeName()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
    public function getUserTypeName()
    {
        return $this->hasMany(Role::class);
    }
    public function getAccessType()
    {
        return $this->hasMany(AccessMaster::class);
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function resources(): HasMany
    {
        return $this->hasMany(UserResource::class);
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    public function getUserRole(): HasMany
    {
        return $this->hasMany(UsersHasRoles::class, 'user_id');
    }
}
