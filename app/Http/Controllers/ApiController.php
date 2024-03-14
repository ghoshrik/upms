<?php

namespace App\Http\Controllers;

use App\Models\DynamicSorHeader;
use App\Models\SorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use ChrisKonnertz\StringCalc\StringCalc;

class ApiController extends Controller
{
    public function storeTableHeader(Request $request)
    {
        try {

            /*DB::beginTransaction();
            $base64Data = $request->input('base64Data');
            //dd($base64Data);
            $decodedString = base64_decode($base64Data);
            $dataArray = json_decode($decodedString, true);
            $insert = [
            'table_no' => $dataArray['table_no'],
            'page_no' => $dataArray['page_no'],
            'header_data' => json_encode($dataArray['header_data']),
            'row_data' => json_encode($dataArray['row_data']),
            'note'=>$dataArray['note'] ?? '',
            'title'=>$dataArray['title'],
            'volume_no'=>$dataArray['volume_no'] ?? '',
            'effective_date'=>$dataArray['effective_date'],
            'department_id'=> Auth::user()->department_id,
            'dept_category_id'=>(int)$dataArray['dept_category_id'],
            'created_by' => Auth::user()->id
            ];
            DynamicSorHeader::create($insert);
            DB::commit();*/

            $data = $request->all();
            //dd($data);

            if (($data['volume_no'] == "Volume II") || ($data['volume_no'] == 2)) {
                $data['volume_no'] = 2;
            } elseif (($data['volume_no'] == "Volume I") || ($data['volume_no'] == 1)) {
                $data['volume_no'] = 1;
            } else {
                $data['volume_no'] = 3;
            }
            $insert = [
                'table_no' => $data['table_no'],
                'page_no' => $data['page_no'],
                'page_no_int' => $data['page_no'],
                'header_data' => json_encode($data['header_data']),
                'note' => $data['note'] ?? '',
                'title' => $data['title'],
                'volume_no' => $data['volume_no'] ?? '',
                'effective_date' => $request->input('effective_date') ? $request->input('effective_date') : $request->input('effective_to'),
                'department_id' => Auth::user()->department_id,
                'dept_category_id' => (int) $data['dept_category_id'],
                'created_by' => Auth::user()->id,
                'row_data_base_64' => $data['row_data'],
                'corrigenda_name' => $request->input('corrigenda_name') ? $request->input('corrigenda_name') : '',
            ];

            if (!empty($request->input('tableId') && ($request->input('effective_to')) && ($request->input('corrigenda_name')))) {
                DynamicSorHeader::where('id', $request->input('tableId'))->update(['effective_to' => date('Y-m-d', strtotime('-1 day', strtotime($request->input('effective_to'))))]);
                DynamicSorHeader::create($insert);
                return response()->json(['message' => 'Corrigenda Updated ', 'status' => true], 200);
            } else {
                DynamicSorHeader::create($insert);
                return response()->json(['message' => 'Record stored successfully', 'status' => true], 200);
            }

            return response()->json(['message' => 'Data stored successfully', 'status' => true], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error storing data:' . $e, 'status' => false], 500);
        }
    }
    public function updateTableHeader(Request $request)
    {
        try {
            $data = $request->all();

            if (Gate::allows('view sor-book')) {
                DynamicSorHeader::where('id', $data['tableId'])->update(['row_data_base_64' => $data['row_data'], 'note' => $data['note'], 'updated_by' => Auth::user()->id]);
            } else if (Auth::user()->department_id === 57) {
                DynamicSorHeader::where('id', $data['tableId'])
                    ->update(['row_data_base_64' => $data['row_data'], 'note' => $data['note'], 'subtitle' => $data['subtitle']]);
            } else {

                DynamicSorHeader::where('id', $data['tableId'])
                    ->update(['row_data_base_64' => $data['row_data'], 'note' => $data['note'], 'table_no' => $data['tbl_no'], 'title' => $data['tbl_title']]);
            }
            DynamicSorHeader::where('id', $data['tableId'])
                ->update(['table_no' => $data['tbl_no'], 'title' => $data['tbl_title']]);
            return response()->json(['message' => 'Data Updated successfully', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error storing data ', 'status' => false], 500);
        }
    }

    public function storeSorUpload(Request $request)
    {

        try {
            /*$request->validate([
            'file_upload'=>'required|file|mimes:pdf',
            ]);*/

            $base64file = $request->get('file_upload');
            $deptCategory = $request->get('dept_category_id');
            $volumeNo = $request->get('volume_no');
            $UploadAt = $request->get('upload_at');

            SorDocument::create([
                'department_id' => Auth::user()->department_id,
                'dept_category_id' => $deptCategory,
                'volume_no' => $volumeNo,
                'upload_at' => $UploadAt,
                'docu_file' => $base64file,
                'desc' => $request->get('description'),
            ]);
            return response()->json(['message' => 'File upload successfully', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'File upload failed. ', 'status' => false], 500);
        }
    }
    public function deleteUnitRow(Request $request)
    {
        //dd($request);
        try {
            $updateId = $request->rowId;
            $parentId = $request->parent_id;
            $Estimate_id = $request->editEstimate_id;

            if (empty($Estimate_id)) {
                $sessionData = Session()->get('modalData');
            } else {
                $sessionData = Session()->get('editModalData');
            }
            if (!is_array($sessionData)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Session data is not an array.',
                ], 400);
            }

            // Step 1: Check if parent ID exists in sessionData
            if (isset($sessionData[$parentId])) {
                unset($sessionData[$parentId]['metadata']);
                foreach ($sessionData[$parentId] as $index => &$data) {
                    if ($index == $updateId) {
                        unset($sessionData[$parentId][$updateId]);
                        break;
                    }
                }
                $tempArray = [];
                foreach ($sessionData[$parentId] as $index => $data) {
                    if ($index > $updateId) {
                        $tempArray[$index] = $data;
                        unset($sessionData[$parentId][$index]);
                    }
                }
                $tempArray = array_values($tempArray);
                $sessionData[$parentId] = array_merge($sessionData[$parentId], $tempArray);
                $metadataArray = [];
                foreach ($sessionData[$parentId] as $index => $data) {
                    if (isset($data[0])) {
                        $metadata = $data[0];
                    } else {
                        $metadata = $data['input_values'];
                    }
                    $metadataArray[] = $metadata;
                }
                foreach ($metadataArray as $index => &$data) {
                    $data['currentId'] = $index;
                }
                $sessionData[$parentId]['metadata'] = $metadataArray;
                if (empty($Estimate_id)) {
                    //($sessionData);
                    Session()->put('modalData', $sessionData);
                    $sessionData = Session()->get('modalData');
                } else {
                    //dd($sessionData);
                    Session()->put('editModalData', $sessionData);
                    $sessionData = Session()->get('editModalData');
                }
                return response()->json([
                    'status' => true,
                    'rateAnalysisArray' => $sessionData,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Parent ID not found in session data.',
                ], 404);
            }
        } catch (\Exception $e) {
            //dd($e);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
            ], 500);
        }
    }
    public function unitQtyAdded(Request $request)
    {

        try {
            $data = $request->data;
            //dd($data);
            if (isset($data['input_values'])) {
                $input_values = $data['input_values'];
                $parentId = isset($input_values['parent_id']) ? $input_values['parent_id'] : null;
                $overalltotal = isset($input_values['overallTotal']) ? $input_values['overallTotal'] : null;
                $type = isset($input_values['type']) ? $input_values['type'] : null;
                $unit = isset($input_values['unit']) ? $input_values['unit'] : 5;
                $updateId = isset($input_values['currentruleId']) ? $input_values['currentruleId'] : null;
                $Estimate_id = isset($input_values['editEstimate_id']) ? $input_values['editEstimate_id'] : null;
            } else {
                $overalltotal = isset($data[0]['overallTotal']) ? $data[0]['overallTotal'] : null;
                $parentId = isset($data[0]['parent_id']) ? $data[0]['parent_id'] : null;
                $type = isset($data[0]['type']) ? $data[0]['type'] : null;
                $unit = isset($data[0]['unit']) ? $data[0]['unit'] : 5;
                $updateId = isset($data[0]['currentId']) ? $data[0]['currentId'] : null;
                $Estimate_id = isset($data[0]['editEstimate_id']) ? $data[0]['editEstimate_id'] : null;
            }
            if (empty($Estimate_id)) {
                $sessionData = Session()->get('modalData');
            } else {
                $sessionData = Session()->get('editModalData');
            }
            if (!is_array($sessionData)) {
                $sessionData = [];
            }
            if (!isset($sessionData[$parentId])) {
                $sessionData[$parentId] = [];
            }
            if (!isset($sessionData[$parentId]['metadata'])) {
                $sessionData[$parentId]['metadata'] = [];
            }
            if ($updateId === '' || $updateId === null) {
                $index = array_key_exists('metadata', $sessionData[$parentId]) ? count($sessionData[$parentId]['metadata']) : 0;
                $sessionData[$parentId][] = $data;
                if (isset($data[0])) {
                    $metadata = $data[0];
                } else {
                    $metadata = $data['input_values'];
                }
                $metadata['currentId'] = $index;
                $sessionData[$parentId]['metadata'][] = $metadata;
            } else {
                unset($sessionData[$parentId]['metadata']);
                if (isset($sessionData[$parentId][$updateId])) {
                    $sessionData[$parentId][$updateId] = $data;
                    $metadataArray = [];
                    foreach ($sessionData[$parentId] as $index => $data) {
                        if (isset($data[0])) {
                            $metadata = $data[0];
                        } else {
                            $metadata = $data['input_values'];
                        }
                        $metadataArray[$index] = $metadata;
                    }
                    foreach ($metadataArray as $index => &$data) {
                        $data['currentId'] = $index;
                    }

                    $sessionData[$parentId]['metadata'] = $metadataArray;
                }
            }
            $grandTotalOverallTotal = 0;
            foreach ($sessionData[$parentId]['metadata'] as $metadata) {
                $grandTotalOverallTotal += $metadata['overallTotal'];
            }
            if (empty($Estimate_id)) {
                Session()->put('modalData', $sessionData);
            } else {
                Session()->put('editModalData', $sessionData);
            }



            $this->rateAnalysisArray = $sessionData;


           // dd($this->rateAnalysisArray);
            return response()->json([
                'message' => 'Data updated successfully',
                'status' => true,
                'rateAnalysisArray' => $this->rateAnalysisArray,
            ], 200);
        } catch (\Exception $e) {
          
        }
    }

    public function updateDataToSession(Request $request)
    {
        try {
            // dd($request);
            $previousData = $request->data;
            $parentId = $request->parent_id;
            $Estimate_id = $request->editEstimate_id;

            // dd($previousData, $parentId );
            if (empty($Estimate_id)) {
                $sessionData = Session()->get('modalData');
            } else {
                $sessionData = Session()->get('editModalData');
            }

            // Check if the session data is an array
            if (!is_array($sessionData)) {
                $sessionData = []; // Initialize sessionData as an empty array if it's not an array
            }

            // Create an empty array with the specified parentId if it doesn't exist
            if (!isset($sessionData[$parentId])) {
                $sessionData[$parentId] = [];
                // dd( $sessionData);
            }
            $sessionData[$parentId] = $previousData;
            foreach ($sessionData[$parentId] as &$data) {
                if (is_array($data)) {
                    foreach ($data as &$nestedData) {
                        if (isset($nestedData['parent_id'])) {
                            $nestedData['parent_id'] = $parentId;
                        }
                    }
                }
            }

            if (empty($Estimate_id)) {
                Session()->put('modalData', $sessionData);
                $sessionresData = Session()->get('modalData');
            } else {
                Session()->put('editModalData', $sessionData);
                $sessionresData = Session()->get('editModalData');
            }
            return response()->json([
                'status' => true,
                'rateAnalysisArray' => $sessionresData,
            ], 200);

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getRuleData(Request $request)
    {

        //dd($request);

        $Estimate_id = $request->editEstimate_id;
        if (empty($Estimate_id)) {
            $sessionData = Session()->get('modalData');
        } else {
            $sessionData = Session()->get('editModalData');
        }

        $rowdata = $sessionData[$request->unitId][$request->ruleId];
        return response()->json([
            'status' => true,
            'rateAnalysisArray' => $rowdata,
        ], 200);

    }

    public function getunitQtyAdded(Request $request)
    {
        $Estimate_id = $request->editEstimate_id;
        //dd($Estimate_id);
        if (empty($Estimate_id)) {
            $sessionData = Session()->get('modalData');
        } else {
            $sessionData = Session()->get('editModalData');
            // dd($sesssionData);
        }

        $data = $sessionData[$request->parent_id][$request->rowId];
        return response()->json([
            'status' => true,
            'rateAnalysisArray' => $data,
        ], 200);

    }

    public function expCalculater(Request $request)
{
    $overallTotal = 0;
    $stringCalc = new StringCalc();
    try {
        $data = $request->data;
      
        if (isset($data['input_values'])) {
            $input_values = $data['input_values'];
            $parentId = isset($input_values['parent_id']) ? $input_values['parent_id'] : null;
            $overallTotal = isset($input_values['overallTotal']) ? $input_values['overallTotal'] : null;
            $overallTotal = $stringCalc->calculate($overallTotal); // Calculate overallTotal
            $type = isset($input_values['type']) ? $input_values['type'] : null;
            $unit = isset($input_values['unit']) ? $input_values['unit'] : 5;
            $updateId = isset($input_values['currentruleId']) ? $input_values['currentruleId'] : null;
            $Estimate_id = isset($input_values['editEstimate_id']) ? $input_values['editEstimate_id'] : null;
            $remarks = isset($input_values['remarks']) ? $input_values['remarks'] : null;
            $data['input_values']['overallTotal'] = $overallTotal;
        }
       
        if (empty($Estimate_id)) {
            $sessionData = Session()->get('modalData');
        } else {
            $sessionData = Session()->get('editModalData');
        }
        if (!is_array($sessionData)) {
            $sessionData = [];
        }
        if (!isset($sessionData[$parentId])) {
            $sessionData[$parentId] = [];
        }
        if (!isset($sessionData[$parentId]['metadata'])) {
            $sessionData[$parentId]['metadata'] = [];
        }
            $index = array_key_exists('metadata', $sessionData[$parentId]) ? count($sessionData[$parentId]['metadata']) : 0;

            $sessionData[$parentId][] = $data;
            $metadata = $data['input_values'];
            $metadata['currentId'] = $index;
            $metadata['overallTotal'] = $overallTotal; 
            $sessionData[$parentId]['metadata'][] = $metadata;
        
           if (empty($Estimate_id)) {
            Session()->put('modalData', $sessionData);
            $sessionresData = Session()->get('modalData');
        } else {
            Session()->put('editModalData', $sessionData);
            $sessionresData = Session()->get('editModalData');
        }

        $this->rateAnalysisArray = $sessionresData;

        //dd($this->rateAnalysisArray);
        return response()->json([
            'message' => 'Data updated successfully',
            'status' => true,
            'remarks' =>  $remarks,
            'rateAnalysisArray' => $this->rateAnalysisArray,
        ], 200);

    } catch (\Exception $exception) {
        return response()->json([
            'status' => false,
            'error' => $exception->getMessage(), 
        ], 500);
    }
}

    

    

    public function expcheckCalculater(Request $request)
    {
        try {
        $Estimate_id = $request->editEstimate_Id;
        if (empty($Estimate_id)) {
            $sessionData = Session()->get('modalData');
        } else {
            $sessionData = Session()->get('editModalData');
            // dd($sesssionData);
        }

          //dd($sessionData);
       
            $total =$request->data;
            $expression = $request->expression;
            //dd($result);
            return response()->json([
                'status' => true,
                'result' => $total,
                'exp' => $expression
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'error' => $exception->getMessage(), 
            ], 500);
        }

        // if (empty($Estimate_id)) {
        //     Session()->put('modalData', $sessionData);
        //     $sessionresData = Session()->get('modalData');
        // } else {
        //     Session()->put('editModalData', $sessionData);
        //     $sessionresData = Session()->get('editModalData');
        // }

    }

}
