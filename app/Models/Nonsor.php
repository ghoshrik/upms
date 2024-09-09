<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nonsor extends Model
{
    use HasFactory;
    protected $table = "nonsors";
    protected $fillable = ["item_name",'unit_id','price','created_by','approved_at','approved_by','associated_at','associated_with','expired_at'];

    public $timestamps = false;

    public function units()
    {
        return $this->belongsTo(UnitMaster::class,'unit_id');
    }
}
