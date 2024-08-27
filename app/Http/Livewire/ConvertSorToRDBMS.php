<?php

namespace App\Http\Livewire;

use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ConvertSorToRDBMS extends Component
{
    public function mount()
    {
        $sors = DynamicSorHeader::all();
        $datas = [];
        foreach ($sors as $sor) {
            $commonData = [
                'dept_id' => $sor['department_id'],
                'dept_name' => getDepartmentName($sor['department_id']),
                'table' => $sor['table_no'],
                'page' => $sor['page_no'],
                'effective_from' => $sor['effective_date'],
                'effective_to' => $sor['effective_to'],
                'volume' => $sor['volume_no'],
            ];
            // $data['header'] = json_decode($sor[header_data]);
            $data['rows'] = json_decode($sor->row_data);

            $this->processRows($data['rows'], $datas, $commonData);
            // foreach ($datas as $key => $data) {
            //     // Check if 'rate' is an array
            //     if (is_array($data['rate'])) {
            //         // Initialize a flag to check if a non-array rate has been found
            //         $found = false;

            //         // Loop through the 'rate' array
            //         foreach ($data['rate'] as $rate) {
            //             // Check if $rate is not an array
            //             if (!is_array($rate)) {
            //                 // Replace 'rate' with the non-array value
            //                 $datas[$key]['rate'] = $rate;
            //                 // Set flag to true and break the loop
            //                 $found = true;
            //                 break;
            //             }
            //         }

            //         // If a non-array rate was found, continue with the next iteration
            //         if ($found) {
            //             continue;
            //         }
            //     }
            // }
        }
        foreach ($datas as $key => $data) {
            while (is_array($data['rate'])) {
                foreach ($data['rate'] as $rate) {
                    if (!is_array($rate)) {
                        $datas[$key]['rate'] = $rate;
                        break 2;
                    }
                }
                break;
            }
            // dd($data)
        }
        // foreach ($datas as $data) {
        //     if (is_array($data['rate'])) {
        //         dd($data);
        //     }
        // }
        // dd($datas);
        foreach ($datas as $sorData) {
            $insert = [
                'dept_id' => $sorData['dept_id'],
                'dept_name' => $sorData['dept_name'],
                'zone' => $sorData['zone'],
                'rate' => json_encode($sorData['rate']),
                'table_name' => $sorData['table'],
                'page' => $sorData['page'],
                'unit' => $sorData['unit'],
                'desc_of_item' => $sorData['desc_of_item'],
                'effective_from' => $sorData['effective_from'],
                'effective_to' => $sorData['effective_to'],
                'volume' => $sorData['volume'],
            ];
            DB::table('scheduleofrates')->insert($insert);
        }
        // foreach ($data['rows'] as $key => $rowData) {
        //     if (isset($rowData->_subrow)) {
        //         foreach ($rowData->_subrow as $k => $row) {
        //             $commonData['id'] = $row->id;
        //             $convertArr = json_decode(json_encode($row), true);
        //             foreach ($convertArr as $arrkey => $arr) {
        //                 if (is_array($arr)) {
        //                     $commonData['zone'] = $arrkey;
        //                     if ($arrkey == '_subrow') {

        //                     } else {
        //                         foreach ($arr as $ar) {
        //                             $commonData['rate'] = $arr;
        //                             $datas[] = $commonData;
        //                             break;
        //                         }
        //                     }

        //                 }
        //             }
        //         }
        //     } else {
        //         $commonData['id'] = $rowData->id;
        //         $datas[] = $commonData;
        //     }
        // }

    }
    public function processRows($rows, &$datas, $commonData)
    {
        foreach ($rows as $key => $rowData) {
            $currentData = $commonData;
            if (isset($rowData->_subrow)) {
                foreach ($rowData->_subrow as $k => $row) {
                    // $currentData['id'] = $row->id;
                    $convertArr = json_decode(json_encode($row), true);
                    foreach ($convertArr as $arrkey => $arr) {
                        $currentData['id'] = $row->id;
                        $currentData['desc_of_item'] = (isset($row->desc_of_item)) ? $row->desc_of_item : '';
                        $currentData['unit'] = (isset($row->unit)) ? $row->unit : '';
                        if (is_array($arr)) {
                            if ($arrkey == '_subrow') {
                                // Recursive call to handle nested subrows
                                $this->processRows($arr, $datas, $currentData);
                            } else {
                                $currentData['zone'] = $arrkey;
                                foreach ($arr as $ar) {
                                    $currentData['rate'] = $ar;
                                    $datas[] = $currentData;
                                    break; // Assuming you only want the first item
                                }
                            }
                        }
                    }
                }
            } else {
                $convertArr = json_decode(json_encode($rowData), true);
                $currentData['id'] = $convertArr['id'];
                $currentData['unit'] = (isset($convertArr['unit'])) ? $convertArr['unit'] : '';
                $currentData['desc_of_item'] = (isset($convertArr['desc_of_item'])) ? $convertArr['desc_of_item'] : '';
                foreach ($convertArr as $arrkey => $arr) {
                    if (is_array($arr)) {
                        $currentData['zone'] = $arrkey;
                        foreach ($arr as $ar) {
                            $currentData['rate'] = $ar;
                            $datas[] = $currentData;
                            break; // Assuming you only want the first item
                        }
                    }
                }
                // $datas[] = $currentData;
            }
        }
    }
    public function render()
    {
        return view('livewire.convert-sor-to-r-d-b-m-s');
    }
}
