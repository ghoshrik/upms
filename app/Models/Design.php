<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Design extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function documentType() : BelongsTo
    {
        return $this->BelongsTo(DocumentType::class);
    }

    public function project() : BelongsTo
    {
        return $this->BelongsTo(ProjectCreation::class);
    }
}
