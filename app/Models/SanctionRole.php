<?php

namespace App\Models;

use App\Models\Role;
use App\Models\SanctionLimitMaster;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanctionRole extends Model
{
    use HasFactory;
    protected $table = "sanction_roles";
    protected $fillable = ['sanction_limit_master_id','sequence_no','role_id','permission_id'];
    public function sanctionLimitMaster() : BelongsTo
    {
        return $this->belongsTo(SanctionLimitMaster::class);
    }
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    public function permission() : BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
