<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Menu extends Model
{
    use HasRoles,HasPermissions;
    use HasFactory;
    protected $table ="menus";
    protected $guard_name = 'web';
    protected $fillable = ["title","parent_id","icon","slug","link","link_type","access_types_id","permission"];

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

    public function menus()
    {
        return $this->belongsToMany(Role::class,'menus_roles');
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'users_menus');
    }
    // public function getChield(Type $var = null)
    // {
    //     # code...
    // }

}
