<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory,Sluggable;
    protected $fillable = [
        'department_name','slug'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'department_name'
            ]
        ];
    }
}
