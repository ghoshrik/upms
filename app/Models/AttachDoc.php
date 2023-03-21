<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachDoc extends Model
{
    use HasFactory;
    protected $table = "attach_docs";
    protected $fillable = [
        'sor_docu_id','document_type','document_mime','document_size','attach_doc'
    ];
}
