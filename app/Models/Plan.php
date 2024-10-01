<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function project() : BelongsTo
    {
        return $this->BelongsTo(ProjectCreation::class);
    }

    public function planDocuments() : HasMany
    {
        return $this->hasMany(PlanDocument::class);
    }
}
