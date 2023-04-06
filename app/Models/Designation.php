<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory;
    protected $fillable = [
        'designation_name'
    ];
    public function fetchDesignationName()
    {
        return $this->belongsTo(User::class, 'designation_id','id');
    }

    function user()
    {
        $this->hasMany(User::class,'designation_id');
    }
}
