<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,Sluggable;
    protected $table = 'categories';
    protected $fillable = ['cate_name','slug','status'];

    public function sluggable():array
    {
        return [
            'slug'=>[
                'source'=>'cate_name'
            ]
        ];
    }
}
