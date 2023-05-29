<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComposerSor extends Model
{
    use HasFactory;
    protected $table ="composer_sors";
    protected $fillable =
    [
        "dept_category_id","sor_itemno_parent_id","sor_itemno_child","description","unit_id","rate"
    ];
}
