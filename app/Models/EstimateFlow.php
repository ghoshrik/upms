<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission;

class EstimateFlow extends Model
{
    use HasFactory;
    protected $table = "estimate_flows";
    protected $fillable = ['estimate_id','slm_id','sequence_no','role_id','permission_id','user_id','associated_at','dispatch_at'];

    public function permission() : BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

}
