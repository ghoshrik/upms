<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Design extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function designType() : BelongsTo
    {
        return $this->BelongsTo(DesignType::class);
    }
}
