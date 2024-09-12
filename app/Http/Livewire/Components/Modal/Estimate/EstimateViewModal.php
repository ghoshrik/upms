<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use Livewire\Component;
use App\Models\SORMaster;
use App\Models\UnitMaster;
use App\Models\EstimatePrepare;
use Illuminate\Support\Facades\Cache;
use App\Models\SpecificQuantityAnalysis;

class EstimateViewModal extends Component
{
    protected $listeners = ['openModal' => 'openViewModal'];
    public $viewModal = false, $estimate_id, $viewEstimates = [], $specificQtyAnalysisData = [], $estimateDescription;

    public function openViewModal($estimate_id)
    {
        $estimate_id = is_array($estimate_id) && !empty($estimate_id) ? $estimate_id[0] : $estimate_id;
        $this->reset();
        $this->viewModal = !$this->viewModal;
        if ($estimate_id) {
            $this->estimate_id = $estimate_id;
            $this->viewEstimates = EstimatePrepare::where('estimate_id', $this->estimate_id)->orderBy('id')->get();
            $this->estimateDescription = SORMaster::where('estimate_id', $this->estimate_id)->first();
            $this->estimateDescription = $this->estimateDescription['sorMasterDesc'];
            // $cacheKey = 'projectEstimate_' . $this->estimate_id;
            // if(Cache::has($cacheKey)){
            //     $this->viewEstimates = Cache::get($cacheKey);
            // }else{
            //     $this->viewEstimates = Cache::remember($cacheKey, now()->addMinutes(720), function () {
            //         return EstimatePrepare::where('estimate_id',$this->estimate_id)->orderBy('id')->get();
            //     });
            // }
            // $this->specificQtyAnalysisData = SpecificQuantityAnalysis::where('estimate_id',$this->estimate_id)->get();
        }
        // dd($this->viewEstimates);
    }
    public function download($value)
    {
        $allEstimateDatas = EstimatePrepare::where('estimate_id', '=', $value)->get();
        // dd( $allEstimateDatas);
        $exportDatas = $allEstimateDatas;
        // dd($exportDatas);
        $date = date('Y-m-d');
        $pw = new \PhpOffice\PhpWord\PhpWord();
        $section = $pw->addSection();
        $html = "<h1 style='font-size:24px;font-weight:600;text-align: center;'>Estimate Preparation Details</h1>";
        $html .= "<p>This is for test purpose</p>";
        $html .= "<table style='border: 1px solid black;width:auto'><tr>";
        $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
        $html .= "<th scope='col' style='text-align: center'>Item Number(Ver.)</th>";
        $html .= "<th scope='col' style='text-align: center'>Description</th>";
        $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
        $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
        $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
        foreach ($exportDatas as $key => $export) {
            $html .= "<tr><td style='text-align: center'>" . chr($export['row_id'] + 64) . "</td>&nbsp;";
            if ($export['sor_item_number']) {
                $html .= "<td style='text-align: center'>" . getSorItemNumberDesc($export['sor_item_number']) . ' ( ' . $export['version'] . ' )' . "</td>&nbsp;";
            } else {
                $html .= "<td style='text-align: center'>--</td>&nbsp;";
            }
            if ($export['description']) {
                $html .= "<td style='text-align: center'>" . $export['description'] . "</td>&nbsp;";
            } elseif ($export['operation']) {
                if ($export['operation'] == 'Total') {
                    $html .= "<td style='text-align: center'> Total of (" . $export['row_index'] . " )</td>&nbsp;";
                } else {
                    if ($export['remarks'] != '') {
                        $html .= "<td style='text-align: center'> " . $export['row_index'] . " ( " . $export['remarks'] . " )" . "</td>&nbsp;";
                    } else {
                        $html .= "<td style='text-align: center'> " . $export['row_index'] . "</td>&nbsp;";
                    }
                }
            } else {
                $html .= "<td style='text-align: center'>" . $export['other_name'] . "</td>&nbsp;";
            }
            $html .= "<td style='text-align: center'>" . $export['qty'] . "</td>&nbsp;";
            $html .= "<td style='text-align: center'>" . $export['rate'] . "</td>&nbsp;";
            $html .= "<td style=''>" . $export['total_amount'] . "</td></tr>";
        }
        // $html .= "<tr align='right'><td colspan='5' align='right'>Total</td>";
        // foreach ($exportDatas as $key => $export) {
        //     if ($export['operation'] == 'Total') {
        //         $estTotal =  $export['total_amount'];
        //     } else {
        //         $estTotal = '--';
        //     }
        // }
        // $html .= "<td colspan='1' align='right'>" . $estTotal . "</td>";
        // $html .= "</tr>";
        $html .= "</table>";
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        $pw->save($date . ".docx", "Word2007");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment;filename=\"convert.docx\"");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, "Word2007");
        // dd($objWriter);
        $objWriter->save($date . '.docx');
        return response()->download($date . '.docx')->deleteFileAfterSend(true);
        $this->reset('exportDatas');
    }
    public function render()
    {
        return view('livewire.components.modal.estimate.estimate-view-modal');
    }
}
