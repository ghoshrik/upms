<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocuComposerSor extends Model
{
    use HasFactory;
    protected $connection = "pgsql_docu_External";
    protected $table = 'docu_composer_sors';
    protected $fillable = [
        'composer_sor_id','document_type','document_mime','document_size','docufile'
    ];
}
