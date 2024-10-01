<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectCreation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plans() : HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}