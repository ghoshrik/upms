<?php

namespace App\Http\Controllers;

use App\Models\DynamicSorHeader;
use App\Models\SorDocument;
use App\Models\SorPrevRecors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function storeTableHeader(Request $request)
    {
        try {
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
                'table_no' => base64_decode($data['table_no']),
                'page_no' => $data['page_no'],
                'page_no_int' => $data['page_no'],
                'header_data' => base64_decode($data['header_data']),
                'note' => $data['note'] ? base64_decode($data['note']) : '',
                'title' => base64_decode($data['title']),
                'volume_no' => $data['volume_no'] ?? '',
                'effective_date' => $request->input('effective_date') ? $request->input('effective_date') : $request->input('effective_to'),
                'department_id' => Auth::user()->department_id,
                'dept_category_id' => (int) $data['dept_category_id'],
                'created_by' => Auth::user()->id,
                'row_data_base_64' => $data['row_data'],
                'corrigenda_name' => $request->input('corrigenda_name') ? base64_decode($request->input('corrigenda_name')) : '',
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
            // dd($data);
            if (Gate::allows('view sor-book')) {
                DynamicSorHeader::where('id', $data['tableId'])->update(['row_data_base_64' => $data['row_data'], 'note' => base64_decode($data['note']), 'updated_by' => Auth::user()->id]);
            } else if (Auth::user()->department_id === 57) {
                DynamicSorHeader::where('id', $data['tableId'])
                    ->update(['row_data_base_64' => $data['row_data'], 'note' => base64_decode($data['note']), 'subtitle' => base64_decode($data['subtitle'])]);
            } else {
                DynamicSorHeader::where('id', $data['tableId'])
                    ->update(['row_data_base_64' => $data['row_data'], 'note' => base64_decode($data['note']), 'table_no' => base64_decode($data['tbl_no']), 'title' => base64_decode($data['tbl_title'])]);
            }
            DynamicSorHeader::where('id', $data['tableId'])
                ->update(['table_no' => base64_decode($data['tbl_no']), 'title' => base64_decode($data['tbl_title'])]);
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
    public function sorDelete(Request $request)
    {
        try {
            // if (Auth::user()->hasPermissionTo('delete dynamic-sor')) {
            $sorData = DynamicSorHeader::where('id', $request->input('id'))->first();
            //DynamicSorHeader::where('id', $request->input('id'))->withTrashed()->restore();
            $sorData->delete();
            // }
            return response()->json(['message' => 'SOR deleted', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Try Again:' . $e], 500);
        }
    }
    public function SORApprover(Request $request)
    {
        try {
            if (Auth::user()->dept_category_id != '') {
                $sorData = DynamicSorHeader::select('is_approve')
                    ->where('id', $request->input('id'))
                    ->where('dept_category_id', '=', Auth::user()->dept_category_id)
                    ->first();
                if ($sorData->is_approve === "555") {

                    DynamicSorHeader::where('id', $request->input('id'))->update(['is_approve' => "-11"]);
                    return response()->json(['message' => 'Successfully Submitted SOR', 'status' => true]);
                } else {
                    return response()->json(['message' => 'Already SOR Submitted', 'status' => false]);
                }
            } else {
                $sorData = DynamicSorHeader::select('is_approve')->where('id', $request->input('id'))->first();
                // dd($sorData->is_approve);
                if ($sorData->is_approve === "555") {
                    DynamicSorHeader::where('id', $request->input('id'))->update(['is_approve' => "-11"]);
                    return response()->json(['message' => 'Successfully Submitted SOR', 'status' => true]);
                } else {
                    return response()->json(['message' => 'Already SOR Submitted', 'status' => false]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Try Again:' . $e], 500);
        }
    }
    public function sorVerify(Request $request)
    {
        // dd($request->all());
        try {
            $sorData = DynamicSorHeader::select('is_approve', 'dept_category_id', 'row_data')->where('id', $request->input('id'))->first();
            if ($sorData->is_approve === '-11' && Auth::user()->user_type === 3 && $request->input('approveValue') === '-11') {
                // dd($request->input('is_update') === 2);
                if ($request->input('is_update') === 2) {
                    SorPrevRecors::create(
                        [
                            'dynamic_sor_id' => $request->input('id'),
                            'department_id' => Auth::user()->department_id,
                            'dept_category_id' => $sorData->dept_category_id ?? '',
                            'row_data' => $sorData->row_data,
                            'created_by' => Auth::user()->id,
                        ]
                    );
                    DynamicSorHeader::where('id', $request->input('id'))
                        ->update([
                            'row_data_base_64' => $request->input('row_data'),
                            'is_approve' => '-11',
                            'is_verified' => '-09',
                            'verify_date' => Carbon::now(),
                        ]);
                    return response()->json(['message' => 'SOR Update and Verified', 'status' => true]);
                } else {
                    DynamicSorHeader::where('id', $request->input('id'))
                        ->update(['is_approve' => "-11", "is_verified" => "-09", "verify_date" => Carbon::now()]);
                    return response()->json(['message' => 'SOR Verified', 'status' => true]);
                }
            } else {
                return response()->json(['message' => 'Already Verified', 'status' => false]);
            }

            /*// if (Auth::user()->user_type == 3) {
            $sorData = DynamicSorHeader::select('is_approve')->where('id', $request->input('id'))->first();
            //dd($sorData);
            if ($sorData->is_approve === "-11") {
            DynamicSorHeader::where('id', $request->input('id'))->update(['is_approve' => "-11", "is_verified" => "-09", "verify_date" => Carbon::now()]);
            return response()->json(['message' => 'SOR Verified complete', 'status' => true]);
            } else {
            return response()->json(['message' => 'Already Verified', 'status' => false]);
            }*/
            // }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Try Again:' . $e], 500);
        }
    }

    public function deleteUnitRow(Request $request)
    {
        //dd($request);
        try {
            $updateId = $request->rowId;
            $parentId = $request->parent_id;
            $Estimate_id = $request->editEstimate_id;
            $EditRate_id = $request->editRate_id;
            $featureType = $request->featureType;
            $modalName = ($featureType == "RateAnalysis" && $EditRate_id === null) ? "RateAnalysisModal" :
            (($featureType == "RateAnalysis" && $EditRate_id !== null) ? "RateAnalysisEditModal" :
                (($featureType === null && $Estimate_id === null) ? "modalData" :
                    (($featureType === null && $Estimate_id !== null) ? "editModalData" : "modalData")));
            $sessionData = Session()->get($modalName);
            // dd($sessionData);
            if (!is_array($sessionData)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Session data is not an array.',
                ], 400);
            }
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
                Session()->put($modalName, $sessionData);
                $sessionData = Session()->get($modalName);
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
            // dd($data);
            if (isset($data['input_values'])) {
                $input_values = $data['input_values'];
                $parentId = isset($input_values['parent_id']) ? $input_values['parent_id'] : null;
                $overalltotal = isset($input_values['overallTotal']) ? $input_values['overallTotal'] : null;
                $type = isset($input_values['type']) ? $input_values['type'] : null;
                $unit = isset($input_values['unit']) ? $input_values['unit'] : 5;
                $updateId = isset($input_values['currentId']) ? $input_values['currentId'] : null;
                $Estimate_id = isset($input_values['editEstimate_id']) ? $input_values['editEstimate_id'] : null;
                $EditRate_id = isset($input_values['editRate_id']) ? $input_values['editRate_id'] : null;
                $featuretype = isset($input_values['featureType']) ? $input_values['featureType'] : null;

            } else {
                $overalltotal = isset($data[0]['overallTotal']) ? $data[0]['overallTotal'] : null;
                $parentId = isset($data[0]['parent_id']) ? $data[0]['parent_id'] : null;
                $type = isset($data[0]['type']) ? $data[0]['type'] : null;
                $unit = isset($data[0]['unit']) ? $data[0]['unit'] : 5;
                $updateId = isset($data[0]['currentId']) ? $data[0]['currentId'] : null;
                $Estimate_id = isset($data[0]['editEstimate_id']) ? $data[0]['editEstimate_id'] : null;
                $EditRate_id = isset($data[0]['editRate_id']) ? $data[0]['editRate_id'] : null;
                $featuretype = isset($data[0]['featureType']) ? $data[0]['featureType'] : null;
            }
            $modalName = ($featuretype == "RateAnalysis" && $EditRate_id === null) ? "RateAnalysisModal" :
            (($featuretype == "RateAnalysis" && $EditRate_id !== null) ? "RateAnalysisEditModal" :
                (($featuretype === null && $Estimate_id === null) ? "modalData" :
                    (($featuretype === null && $Estimate_id !== null) ? "editModalData" : "modalData")));

            // dd($modalName);
            $sessionData = Session()->get($modalName);
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
                if (!empty($sessionData[$parentId]['metadata'][0]['unit'])) {
                    $new_unit = $sessionData[$parentId]['metadata'][0]['unit'];
                    $metadata['unit'] = $new_unit;
                }

                $sessionData[$parentId]['metadata'][] = $metadata;
            } else {
                unset($sessionData[$parentId]['metadata']);
                if (isset($sessionData[$parentId][$updateId])) {
                    $sessionData[$parentId][$updateId] = $data;
                    $metadataArray = [];
                    $updateTotalOverallTotal = 0;
                    foreach ($sessionData[$parentId] as $index => $data) {
                        if (isset($data[0])) {
                            $metadata = $data[0];
                        } else {
                            $metadata = $data['input_values'];
                        }
                        if (!isset($metadata['expcalculate'])) {
                            $updateTotalOverallTotal += floatval($metadata['overallTotal']);

                        }
                        $metadataArray[$index] = $metadata;
                    }
                    foreach ($metadataArray as $index => &$data) {
                        if (isset($data['expcalculate']) && $data['expcalculate'] === 'Sumtotal') {
                            $data['overallTotal'] = $updateTotalOverallTotal;
                            $data['grandTotal'] = $updateTotalOverallTotal;
                            $data['unit'] = $unit;

                        }
                        $data['currentId'] = $index;
                    }
                    $sessionData[$parentId]['metadata'] = $metadataArray;
                }
            }

            $grandTotalOverallTotal = 0;
            foreach ($sessionData[$parentId]['metadata'] as $metadata) {
                $overallTotal = floatval($metadata['overallTotal']);
                $grandTotalOverallTotal += $overallTotal;
            }

            Session()->put($modalName, $sessionData);
            $sessionData = Session()->get($modalName);
            $this->rateAnalysisArray = $sessionData;
            return response()->json([
                'message' => 'Data updated successfully',
                'status' => true,
                'rateAnalysisArray' => $this->rateAnalysisArray,
            ], 200);
        } catch (\Exception $e) {
            //dd($e);

        }
    }

    public function updatePreviousDataToSession(Request $request)
    {
        //dd($request);
        try {
            $previousData = $request->data;
            // dd($previousData);
            $parentId = $request->parent_id;
            $Estimate_id = $request->editEstimate_id;
            $EditRate_id = $request->editRate_id;
            $featuretype = $request->featureType;
            $part_no = $request->part_no;

            $modalName = ($featuretype == "RateAnalysis" && $EditRate_id === null) ? "RateAnalysisModal" :
            (($featuretype == "RateAnalysis" && $EditRate_id !== null) ? "RateAnalysisEditModal" :
                (($featuretype === null && $Estimate_id === null) ? "modalData" :
                    (($featuretype === null && $Estimate_id !== null) ? "editModalData" : "modalData")));
            $sessionData = Session()->get($modalName);
            if (!is_array($sessionData)) {
                $sessionData = [];
            }
            if (!isset($sessionData[$parentId])) {
                $sessionData[$parentId] = [];
            }

            $sessionData[$parentId] = $previousData;
            foreach ($sessionData[$parentId] as &$data) {
                if (is_array($data)) {
                    foreach ($data as &$nestedData) {
                        if (isset($nestedData['parent_id'])) {
                            $nestedData['parent_id'] = $parentId;
                        }
                        if (isset($nestedData['type'])) {
                            $nestedData['type'] = preg_replace_callback(
                                '/[A-Za-z]\d+/',
                                function ($matches) use ($parentId) {
                                    return substr($parentId, 0, 1) . substr($matches[0], 1);
                                },
                                $nestedData['type']
                            );
                        }

                    }
                }
            }

            // dd($sessionData);
            $modalName = ($featuretype == "RateAnalysis" && $Estimate_id === null) ? "RateAnalysisModal" :
            (($featuretype == "RateAnalysis" && $Estimate_id !== null) ? "RateAnalysisEditModal" :
                (($featuretype === null && $Estimate_id === null) ? "modalData" :
                    (($featuretype === null && $Estimate_id !== null) ? "editModalData" : "modalData")));

            Session()->put($modalName, $sessionData);
            $sessionresData = Session()->get($modalName);

            return response()->json([
                'status' => true,
                'rateAnalysisArray' => $sessionresData,
            ], 200);
        } catch (\Exception $e) {
        }
    }

    public function getRuleData(Request $request)
    {
        //dd($request);
        $Estimate_id = $request->editEstimate_id;
        $EditRate_id = $request->editRate_id;
        $featuretype = $request->featureType;
        $modalName = ($featuretype == "RateAnalysis" && $EditRate_id === null) ? "RateAnalysisModal" :
        (($featuretype == "RateAnalysis" && $EditRate_id !== null) ? "RateAnalysisEditModal" :
            (($featuretype === null && $Estimate_id === null) ? "modalData" :
                (($featuretype === null && $Estimate_id !== null) ? "editModalData" : "modalData")));
        $sessionData = Session()->get($modalName);
        $rowdata = $sessionData[$request->unitId][$request->ruleId];
        $rowdata['input_values']['currentId'] = $request->ruleId;
        return response()->json([
            'status' => true,
            'rateAnalysisArray' => $rowdata,
        ], 200);

    }

    public function getunitQtyAdded(Request $request)
    {
        // dd($request->featureType);
        $Estimate_id = $request->editEstimate_id;
        $EditRate_id = $request->editRate_id;
        $featuretype = $request->featureType;

        $modalName = ($featuretype == "RateAnalysis" && $EditRate_id === null) ? "RateAnalysisModal" :
        (($featuretype == "RateAnalysis" && $EditRate_id !== null) ? "RateAnalysisEditModal" :
            (($featuretype === null && $Estimate_id === null) ? "modalData" :
                (($featuretype === null && $Estimate_id !== null) ? "editModalData" : "modalData")));
        $sessionData = Session()->get($modalName);
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
            // dd($data);
            if (isset($data['input_values'])) {
                $input_values = $data['input_values'];
                $parentId = isset($input_values['parent_id']) ? $input_values['parent_id'] : null;
                $overallTotal = isset($input_values['overallTotal']) ? $input_values['overallTotal'] : null;
                $overallTotal = $stringCalc->calculate($overallTotal);
                $type = isset($input_values['type']) ? $input_values['type'] : null;
                $unit = isset($input_values['unit']) ? $input_values['unit'] : 5;
                $updateId = isset($input_values['currentId']) ? $input_values['currentId'] : null;
                $Estimate_id = isset($input_values['editEstimate_id']) ? $input_values['editEstimate_id'] : null;
                $EditRate_id = isset($input_values['editRate_id']) ? $input_values['editRate_id'] : null;
                $featuretype = isset($input_values['featureType']) ? $input_values['featureType'] : null;
                $remarks = isset($input_values['remarks']) ? $input_values['remarks'] : null;
                $data['input_values']['overallTotal'] = $overallTotal;
            }

            $modalName = ($featuretype == "RateAnalysis" && $EditRate_id === null) ? "RateAnalysisModal" :
            (($featuretype == "RateAnalysis" && $EditRate_id !== null) ? "RateAnalysisEditModal" :
                (($featuretype === null && $Estimate_id === null) ? "modalData" :
                    (($featuretype === null && $Estimate_id !== null) ? "editModalData" : "modalData")));
            $sessionData = Session()->get($modalName);

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

            if (!empty($sessionData[$parentId]['metadata'][0]['unit'])) {
                $new_unit = $sessionData[$parentId]['metadata'][0]['unit'];
                $metadata['unit'] = $new_unit;
            }

            $sessionData[$parentId]['metadata'][] = $metadata;
            Session()->put($modalName, $sessionData);
            $sessionresData = Session()->get($modalName);
            $this->rateAnalysisArray = $sessionresData;
            return response()->json([
                'message' => 'Data updated successfully',
                'status' => true,
                'remarks' => $remarks,
                'rateAnalysisArray' => $this->rateAnalysisArray,
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}
