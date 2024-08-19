<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Model
{
    use HasFactory;
    protected $table = "user_resources";
    protected $fillable = ['user_id','resource_id','resource_type'];

    public function resource()
    {
        return $this->morphTo();
    }
}
