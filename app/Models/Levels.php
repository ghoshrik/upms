<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Levels extends Model
{
    use HasFactory;
    // protected $connection = 'master';
    protected $table = "level_master";
    public function levelHasRoles()
    {
        return $this->hasMany(Role::class, 'has_level_no', 'level_parent');
    }
}
