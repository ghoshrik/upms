<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
    use HasFactory;
    protected $table = "menu_permissions";
    protected $fillable = [
        'userType_id','menu_id',
    ];

    public function getUserType()
    {
        return $this->belongsTo(UserType::class, 'userType_id');
    }
    public function getMenuName()
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }
}
