<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Menu extends Model
{
    use HasFactory;
    protected $table ="menus";
    protected $fillable = ["title","parent_id","icon","slug","link","link_type","access_types_id"];

    public function childs() {
        return $this->hasMany(Menu::class,'parent_id','id') ;
    }

    public function sluggable():array
    {
        return [
            'slug'=>[
                'source'=>'title'
            ]
        ];
    }

}
