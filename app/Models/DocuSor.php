<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocuSor extends Model
{
    use HasFactory;
    protected $connection = "pgsql_docu_External";
    protected $table = "docu_sors";
    protected $fillable = [
        "sor_docu_id","document_type","document_mime","document_size","docufile"
    ];
}
