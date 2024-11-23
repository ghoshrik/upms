<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectCreation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plans() : HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_users')->withPivot('project_creation_id');
    }

    public function estimates()
    {
        return $this->hasMany(SorMaster::class);
    }

    public function documentTypes()
    {
        return $this->belongsToMany(DocumentType::class, 'project_document_type_checklist', 'project_creation_id', 'document_type_id');
    }
}
