<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectType extends Model
{
    use HasFactory;
    protected $table = "project_types";
    protected $fillable = ["department_id", "title"];

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function sanctionLimitMasters() : HasMany
    {
        return $this->hasMany(SanctionLimitMaster::class);
    }
}
