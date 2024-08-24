<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Designation extends Model
{
    use HasFactory;
    protected $table = 'designations';
    protected $fillable = [
        'designation_name'
    ];
    // public function fetchDesignationName()
    // {
    //     return $this->belongsTo(User::class, 'designation_id','id');
    // }

    public function user():HasMany
    {
        $this->hasMany(User::class,'designation_id');
    }
}
