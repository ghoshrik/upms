<?php

namespace App\Http\Controllers;

use App\Models\SorDocument;
use Illuminate\Http\Request;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
                'dept_category_id' => (int)$data['dept_category_id'],
                'created_by' => Auth::user()->id,
                'row_data_base_64' => $data['row_data'],
                'corrigenda_name' => $request->input('corrigenda_name') ? $request->input('corrigenda_name') : ''
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
                'desc' => $request->get('description')
            ]);
            return response()->json(['message' => 'File upload successfully', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'File upload failed. ', 'status' => false], 500);
        }
    }
}
