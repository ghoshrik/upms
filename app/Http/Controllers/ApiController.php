<?php

namespace App\Http\Controllers;

use App\Models\DynamicSorHeader;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function storeTableHeader(Request $request)
    {
        try {
            $data = $request->all();
            DynamicSorHeader::create([
                'table_no' => $data['table_no'],
                'page_no' => $data['page_no'],
                'header_data' => json_encode($data['header_data']),
                'row_data' => json_encode($data['row_data']),
            ]);
            return response()->json(['message' => 'Data stored successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error storing data:'.$e], 500);
        }
    }
    public function updateTableHeader(Request $request)
    {
        try{
            $data = $request->all();
            if(DynamicSorHeader::where('id',$data['tableId'])->update(['row_data'=>$data['row_data']])){
                return response()->json(['message' => 'Data Updated successfully'], 200);
            }
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error storing data:'.$e], 500);
        }
    }
}
