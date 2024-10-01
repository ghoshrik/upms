<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanDocument extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function plan() : BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function documentType() : BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
