<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Esrecommender;
use App\Models\EstimatePrepare;
use Illuminate\Support\Facades\Auth;

class CommonFunction extends Controller
{
    static function exportWord($estimate_id, $model)
    {
        if (Auth::user()->user_type == 1) {
            $exportDatas = $model::where('estimate_id', '=', $estimate_id)->get();
        } elseif (Auth::user()->user_type == 4) {
            $exportDatas = Esrecommender::where('estimate_id', '=', $estimate_id)->get();
        } else {
            $exportDatas = EstimatePrepare::where('estimate_id', '=', $estimate_id)->get();
        }
        // $exportDatas = array_values($exportDatas);
        // dd($exportDatas);
        $date = date('Y-m-d');
        $pw = new \PhpOffice\PhpWord\PhpWord();
        $section = $pw->addSection(
            array(
                'marginLeft' => 600, 'marginRight' => 200,
                'marginTop' => 600, 'marginBottom' => 200
            )
        );
        $html = "<h1 style='font-size:24px;font-weight:600;text-align: center;'>Project Estimate Preparation Details</h1>";
        $html .= "<p>Projected Estimate Details List</p>";
        $html .= "<table style='border: 1px solid black;width:auto'><tr>";
        $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
        $html .= "<th scope='col' style='text-align: center'>Item Number/<br/>Project No(Ver.)</th>";
        $html .= "<th scope='col' style='text-align: center'>Description</th>";
        $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
        $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
        $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
        foreach ($exportDatas as $key => $export) {
            $html .= "<tr><td style='text-align: center'>" . chr($export['row_id'] + 64) . "</td>&nbsp;";
            if ($export['sor_item_number']) {
                $html .= "<td style='text-align: center'>" . getSorItemNumber($export['sor_item_number']) . ' ( ' . $export['version'] . ' )' . "</td>&nbsp;";
            } elseif ($export['estimate_no']) {
                $html .= "<td style='text-align: center'>" . $export['estimate_no'] . "</td>&nbsp;";
            } else {
                $html .= "<td style='text-align: center'>--</td>&nbsp;";
            }
            if ($export['description']) {
                $html .= "<td style='text-align: center'>" . getSorItemNumberDesc($export['description']) . "</td>&nbsp;";
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
            } elseif ($export['other_name']) {
                $html .= "<td style='text-align: center'>" . $export['other_name'] . "</td>&nbsp;";
            } else {
                // $html .= "<td style='text-align: center'>" . $export['name'] . "</td>&nbsp;";
                $html .= "<td style='text-align: center'>--</td>&nbsp;";
            }
            $html .= "<td style='text-align: center'>" . $export['qty'] . "</td>&nbsp;";
            $html .= "<td style='text-align: center'>" . $export['rate'] . "</td>&nbsp;";
            $html .= "<td style=''>" . $export['total_amount'] . "</td></tr>";
        }
        $html .= "</table>";
        foreach ($exportDatas as $key => $export) {
            if ($export['estimate_no']) {
                $html .= "<p>Estimate Packege " . $export['estimate_no'] . "</p>";
                $getEstimateDetails = $model::where('estimate_id', '=', $export['estimate_no'])->get();
                $html .= "<table style='border: 1px solid black;width:auto'><tr>";
                $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
                $html .= "<th scope='col' style='text-align: center'>Item Number(Ver.)</th>";
                $html .= "<th scope='col' style='text-align: center'>Description</th>";
                $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
                $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
                $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
                if (isset($getEstimateDetails)) {
                    foreach ($getEstimateDetails as $estimateDetails) {
                        $html .= "<tr><td style='text-align: center'>" . chr($estimateDetails['row_id'] + 64) . "</td>&nbsp;";
                        if ($estimateDetails['sor_item_number']) {
                            $html .= "<td style='text-align: center'>" . getSorItemNumber($estimateDetails['sor_item_number']) . ' ( ' . $estimateDetails['version'] . ' )' . "</td>&nbsp;";
                        } else {
                            $html .= "<td style='text-align: center'>--</td>&nbsp;";
                        }
                        if ($estimateDetails['sor_item_number']) {
                            $html .= "<td style='text-align: center'>" . getSorItemNumberDesc($estimateDetails['sor_item_number']) . "</td>&nbsp;";
                        } elseif ($estimateDetails['operation']) {
                            if ($estimateDetails['operation'] == 'Total') {
                                $html .= "<td style='text-align: center'> Total of (" . $estimateDetails['row_index'] . " )</td>&nbsp;";
                            } else {
                                if ($estimateDetails['comments'] != '') {
                                    $html .= "<td style='text-align: center'> " . $estimateDetails['row_index'] . " ( " . $estimateDetails['comments'] . " )" . "</td>&nbsp;";
                                } else {
                                    $html .= "<td style='text-align: center'> " . $estimateDetails['row_index'] . "</td>&nbsp;";
                                }
                            }
                        } else {
                            $html .= "<td style='text-align: center'>" . $estimateDetails['other_name'] . "</td>&nbsp;";
                        }
                        $html .= "<td style='text-align: center'>" . $estimateDetails['qty'] . "</td>&nbsp;";
                        $html .= "<td style='text-align: center'>" . $estimateDetails['rate'] . "</td>&nbsp;";
                        $html .= "<td style=''>" . $estimateDetails['total_amount'] . "</td></tr>";
                    }
                }

                $html .= "</table>";
            }
        }

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        $pw->save($date . ".docx", "Word2007");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment;filename=\"convert.docx\"");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, "Word2007");
        // dd($objWriter);
        $objWriter->save($date . '.docx');
        return response()->download($date . '.docx')->deleteFileAfterSend(true);
        // $this->reset('exportDatas');
    }
}
