<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesignDocument extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function design() : BelongsTo
    {
        return $this->belongsTo(Design::class);
    }

    public function documentType() : BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
