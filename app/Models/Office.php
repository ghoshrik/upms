<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $table = "offices";
    protected $fillable = [
        'office_name', 'department_id', 'dist_code', 'in_area', 'rural_block_code', 'gp_code', 'urban_code', 'ward_code', 'office_address', 'level_no', 'office_code', 'office_parent', 'created_by'
    ];
    public function getDepartmentName()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function getDistrictName()
    {
        return $this->belongsTo(District::class, 'dist_code', 'district_code');
    }
    public function getUrban()
    {
        return $this->belongsTo(Urban_body::class, 'urban_code', 'urban_body_code');
    }
    // public function generatePDF($data,$title)
    // {
    //     $pdf = app('dompdf.wrapper');
    //     $pdf->loadView('pdfView', ['data' => $data, 'title' =>$title]);
    //     $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isPhpEnabled' => true]);
    //     $pdf->setPaper('A4', 'landscape');
    //     $filename = $title . '.pdf';
    //     $file = $pdf->stream();
    //     $canvas = $pdf->get_canvas();
    //     // $font = Font_Metrics::get_font("helvetica", "bold");
    //     // $canvas->page_text(512, 10, "Página: {PAGE_NUM} de {PAGE_COUNT}",$font, 8, array(0,0,0));
    //     file_put_contents($filename, $file);
    //     return response()->download($filename)->deleteFileAfterSend(true);
    //     // $this->reset('Items');
    // }

    // Define the parent relationship
    public function officeParent()
    {
        return $this->belongsTo(Office::class, 'office_parent');
    }

    // Define the children relationship
    public function officeChildren()
    {
        return $this->hasMany(Office::class, 'office_parent');
    }
}