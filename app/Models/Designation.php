<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory;
    protected $fillable = [
        'designation_name'
    ];
    // public function sluggable(): array
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'designation_name'
    //         ]
    //     ];
    // }
}
