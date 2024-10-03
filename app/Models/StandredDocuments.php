<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandredDocuments extends Model
{
    use HasFactory;
    protected $table = 'standred_documents';
    protected $fillable = ['title', 'department_id', 'upload_file', 'created_by', 'upload_file_size'];
    protected $guarded = [];

    public function formatFileSize()
    {
        $size = $this->upload_file_size;
        if ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' Bytes';
        }
    }
}
