<?php

namespace App\Http\Controllers;

use App\Models\SorMaster;
use App\Models\TaxMaster;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Abstracts;
use App\Models\SorCategoryType;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommonApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function department(Request $request)
    {
        $department = [];

        if ($request->has('q')) {
            $search = $request->q;
            $department = Department::select("id", "department_name")
                ->Where('department_name', 'ilike', "%$search%")
                ->get();
        } else {
            $department = Department::select('id', 'department_name')->get();
        }
        return response()->json($department);
    }
    public function deptCategory(Request $request)
    {
        // return dd($request->all());
        $category = [];
        $departmentID = $request->departmentID;
        if ($request->has('q')) {
            $search = $request->q;
            $category = SorCategoryType::select("id", "dept_category_name")
                ->where('department_id', $departmentID)
                ->Where('dept_category_name', 'ilike', "%$search%")
                ->get();
        } else {
            $category = SorCategoryType::where('department_id', $departmentID)->limit(10)->get();
        }
        return response()->json($category);
    }
    public function deptEstimates(Request $request)
    {
        $category = [];
        $estimates = $request->deptId;
        if ($request->has('q')) {
            $search = $request->q;
            $category = SorMaster::select("id", "sorMasterDesc")
                ->where('dept_id', $estimates)
                ->Where('sorMasterDesc', 'ilike', "%$search%")
                ->get();
        } else {
            $category = SorMaster::select('estimate_id', 'sorMasterDesc')->where('dept_id', $estimates)->get();
        }
        // dd($category);

        return response()->json($category);
    }
    public function estimateList(Request $request)
    {
        $data = [];
        $estimateItemDtls = [];

        if ($request->departmentID) {
            $data = SorMaster::select('id', 'estimate_id', 'dept_id', 'sorMasterDesc as description')
                ->where('dept_id', $request->departmentID)
                ->where('created_by', Auth::user()->id)
                ->get();
        } elseif ($request->itemsID) {
            $estimateItemDtls['estimateProject'] = DB::table('sor_masters')
                ->select('sor_masters.sorMasterDesc', 'estimate_prepares.estimate_id', 'estimate_prepares.operation', 'estimate_prepares.total_amount')
                ->join('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
                ->where('sor_masters.id', $request->itemsID)
                // ->where('estimate_prepares.operation', '=', 'Total')
                ->get();
            // dd($estimateItemDtls['estimateProject']);
        } elseif ($request->deptCategoryId && $request->departmentId) {
            $data = DynamicSorHeader::selectRaw("id,CONCAT(title,' Table No :' ,table_no ,' Page No : ', page_no) AS description")
                ->where('department_id', $request->departmentId)
                ->where('dept_category_id', $request->deptCategoryId)
                ->orderBy('page_no_int', 'asc')
                ->get();
        } elseif ($request->estimateId) {
            $estimateItemDtls['estimateProjectDtls'] = DB::table('estimate_prepares')
                ->leftJoin('sor_masters', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
                ->leftJoin('departments', 'estimate_prepares.dept_id', '=', 'departments.id')
                ->leftJoin('sor_category_types', 'estimate_prepares.category_id', '=', 'sor_category_types.id')
                ->leftJoin('dynamic_table_header', 'estimate_prepares.sor_id', '=', 'dynamic_table_header.id')
                ->where('estimate_prepares.estimate_id', $request->estimateId)
                ->orderBy('estimate_prepares.id', 'asc')
                ->get();
        }
        //sor section
        elseif ($request->sorDeptCategoryId) {
            // dd($request->sorDeptCategoryId);
            $data = SorMaster::select('sor_masters.id as id', 'sor_masters.estimate_id as estimate_id', 'sor_masters.dept_id as dept_id', 'sor_masters.sorMasterDesc as sorMasterDesc')
                ->join('users', 'users.id', '=', 'sor_masters.created_by')
                ->where('users.department_id', $request->sorDeptCategoryId)
                ->where('users.dept_category_id', $request->cateID)
                ->get();
        }
        //Estimate section
        elseif ($request->deptID && $request->deptCateID) {
            $data = SorMaster::select('sor_masters.id as id', 'sor_masters.estimate_id as estimate_id', 'sor_masters.dept_id as dept_id', 'sor_masters.sorMasterDesc as description')
                ->join('users', 'users.id', '=', 'sor_masters.created_by')
                ->where('users.department_id', $request->deptID)
                ->where('users.dept_category_id', $request->deptCateID)
                ->get();
        } elseif ($request->estimateIdDtls) {
            $estimateItemDtls['estimateDtls'] = DB::table('sor_masters')
                ->select('sor_masters.sorMasterDesc', 'estimate_prepares.estimate_id', 'estimate_prepares.operation', 'estimate_prepares.total_amount')
                ->join('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
                ->where('sor_masters.estimate_id', $request->estimateIdDtls)
                // ->where('sor_masters.id', $request->estimateIdDtls)
                ->where('estimate_prepares.operation', '=', 'Total')
                ->get();
        } elseif ($request->sorId) {
            $estimateItemDtls['SOR'] =  DynamicSorHeader::select('dynamic_table_header.title as title', 'dynamic_table_header.table_no as table_no', 'dynamic_table_header.page_no as page_no', 'dynamic_table_header.header_data as header_data', 'row_data', 'departments.department_name as department_name', 'sor_category_types.dept_category_name as category_name')
                ->join('departments', 'dynamic_table_header.department_id', '=', 'departments.id')
                ->join('sor_category_types', 'sor_category_types.id', '=', 'dynamic_table_header.dept_category_id')
                ->where('dynamic_table_header.id', $request->sorId)
                ->first();
        } else {
            $data = [];
            $estimateItemDtls = [];
        }
        return response()->json(['data' => $data, 'estimateItemDtls' => $estimateItemDtls]);
    }

    public function getTaxData()
    {
        // dd(Auth::user()->id);
        $data = TaxMaster::select('tax_name', 'tax_percentage', 'category_id')
            ->where('department_id', Auth::user()->department_id)
            ->where('category_id', Auth::user()->dept_category_id)
            ->where('status', 'active')
            ->orderBy('id', 'asc')
            ->get();
        return response()->json($data);
    }
    public function CostsLists(Request $request)
    {
        $data = Abstracts::select('tableHeader', 'tableData', 'project_desc')
            ->where('id', $request->costsId)
            ->orderBy('id', 'asc')
            ->get();
        foreach ($data as $key => $value) {
            $headerData = json_decode($value['tableHeader'], true);
            $TableData = json_decode($value['tableData'], true);
            $project_desc = $value['project_desc'];
        }
        return response()->json(['headerData' => $headerData, 'TableData' => $TableData, 'project_desc' => $project_desc]);
    }
}
