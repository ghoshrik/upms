<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nonsor extends Model
{
    use HasFactory;
    protected $table = "nonsors";
    protected $fillable = ["item_name",'unit','qty','price','total_amount','created_by','approved_at','approved_by'];

    public $timestamps = false;
}
