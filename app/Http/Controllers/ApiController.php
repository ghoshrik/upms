<?php

namespace App\Http\Controllers;

use App\Models\DynamicSorHeader;
use App\Models\SorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
        // dd($request);
        try {
            $updateId = $request->rowId;
            $parentId = $request->parent_id;

            $sessionData = session('modalData');
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
                Session()->put('modalData', $sessionData);
                $sessionresData = session('modalData');
                return response()->json([
                    'status' => true,
                    'rateAnalysisArray' => $sessionresData,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Parent ID not found in session data.',
                ], 404);
            }
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing the request.',
            ], 500);
        }
    }
    public function unitQtyAdded(Request $request)
    {
        try {
            $sessionData = session('modalData');
            if (!is_array($sessionData)) {
                $sessionData = [];
            }

            $data = $request->data;
            if (isset($data['input_values'])) {
                $input_values = $data['input_values'];
                $parentId = isset($input_values['parent_id']) ? $input_values['parent_id'] : null;
                $overalltotal = isset($input_values['overallTotal']) ? $input_values['overallTotal'] : null;
                $type = isset($input_values['type']) ? $input_values['type'] : null;
                $unit = isset($input_values['unit']) ? $input_values['unit'] : 5;
                $updateId = isset($input_values['currentruleId']) ? $input_values['currentruleId'] : null;
            } else {
                $overalltotal = isset($data[0]['overallTotal']) ? $data[0]['overallTotal'] : null;
                $parentId = isset($data[0]['parent_id']) ? $data[0]['parent_id'] : null;
                $type = isset($data[0]['type']) ? $data[0]['type'] : null;
                $unit = isset($data[0]['unit']) ? $data[0]['unit'] : 5;
                $updateId = isset($data[0]['currentId']) ? $data[0]['currentId'] : null;
            }

            if (!isset($sessionData[$parentId])) {
                $sessionData[$parentId] = [];
            }

            // Step 1: Check if parent ID exists in sessionData
            if (!isset($sessionData[$parentId]['metadata'])) {
                $sessionData[$parentId]['metadata'] = [];
            }

            // Step 2: Check if updateId is empty or null
            if ($updateId === '' || $updateId === null) {
                // Calculate index for new data
                $index = array_key_exists('metadata', $sessionData[$parentId]) ? count($sessionData[$parentId]['metadata']) : 0;
                $sessionData[$parentId][] = $data;
                // Assign currentId to each data and append to metadata array

                if (isset($data[0])) {
                    $metadata = $data[0];
                } else {
                    $metadata = $data['input_values'];
                }
                $metadata['currentId'] = $index;
                $sessionData[$parentId]['metadata'][] = $metadata;
            } else {
                unset($sessionData[$parentId]['metadata']);
                // Step 3: Update existing data
                if (isset($sessionData[$parentId][$updateId])) {

                    // Overwrite the existing data with new data
                    $sessionData[$parentId][$updateId] = $data;

                    // Recreate the metadata array
                    $metadataArray = [];
                    foreach ($sessionData[$parentId] as $index => $data) {
                        if (isset($data[0])) {
                            $metadata = $data[0];
                        } else {
                            $metadata = $data['input_values'];
                        }
                        $metadataArray[$index] = $metadata;
                    }

                    // Assign the new metadata array with currentIds
                    foreach ($metadataArray as $index => &$data) {
                        $data['currentId'] = $index;
                    }

                    $sessionData[$parentId]['metadata'] = $metadataArray;
                }
            }

            // Calculate grand total overall total
            $grandTotalOverallTotal = 0;
            foreach ($sessionData[$parentId]['metadata'] as $metadata) {
                $grandTotalOverallTotal += $metadata['overallTotal'];
            }

            // Update session data and return response
            Session()->put('modalData', $sessionData);
            $this->rateAnalysisArray = $sessionData;

            return response()->json([
                'message' => 'Data updated successfully',
                'status' => true,
                'rateAnalysisArray' => $this->rateAnalysisArray,
            ], 200);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function updateDataToSession(Request $request)
    {
        try {
            // dd($request);
            $previousData = $request->data;
            $parentId = $request->parent_id;

            // dd($previousData, $parentId );
            $sessionData = session('modalData');

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

            Session()->put('modalData', $sessionData);
            $sessionresData = session('modalData');
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

        // dd($request);
        $sessionData = session('modalData');

        $rowdata = $sessionData[$request->unitId][$request->ruleId];
        return response()->json([
            'status' => true,
            'rateAnalysisArray' => $rowdata,
        ], 200);

    }

    public function getunitQtyAdded(Request $request)
    {
        $sessionData = session('modalData');

        $data = $sessionData[$request->parent_id][$request->rowId];
        return response()->json([
            'status' => true,
            'rateAnalysisArray' => $data,
        ], 200);

    }
}
