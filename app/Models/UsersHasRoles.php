<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsersHasRoles extends Model
{
    use HasFactory;
    protected $table="users_has_roles";
    protected $fillable = [
        'user_id',
        'role_id'
    ];
    public $incrementing = false;

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class,'role_id');
    }
}
