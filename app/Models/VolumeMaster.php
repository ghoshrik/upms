<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolumeMaster extends Model
{
    use HasFactory;
    protected $table = "master.volume_masters";
    protected $fillable = ["volume_name", "status"];


    public function categories()
    {
        return $this->belongsTo(SorCategoryType::class, 'id');
    }
}