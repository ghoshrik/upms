<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carriagesor extends Model
{
    use HasFactory;
    protected $table = "carriagesors";
    protected $fillable = [
        // "dept_id",
        "dept_category_id",
        "sor_parent_id",
        "child_Item_no",
        // "start_sor_item_no",
        "description",
        "start_distance",
        "upto_distance",
        "cost"
    ];

}
