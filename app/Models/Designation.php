<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory;
    protected $table = 'designations';
    protected $fillable = [
        'designation_name',
        // 'level_no'
    ];
    // public function fetchDesignationName()
    // {
    //     return $this->belongsTo(User::class, 'designation_id','id');
    // }

    public function user()
    {
        $this->hasMany(User::class,'designation_id');
    }
    // public function levels()
    // {
    //     return $this->belongsTo(Levels::class,'level_no');
    // }
}
