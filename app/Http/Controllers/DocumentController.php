<?php

namespace App\Http\Controllers;

use WireUi\Traits\Actions;
use App\Models\SorDocument;
use Illuminate\Http\Request;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    use Actions;
    protected $errorMessage;
    public function index()
    {
        $assets = ['chart', 'animation'];
        return view('documentSor.index', compact('assets'));
    }

    public function create()
    {
        $deptCategories = SorCategoryType::select('sor_category_types.id', 'sor_category_types.dept_category_name')
            ->join('users', 'users.dept_category_id', '=', 'sor_category_types.id')
            ->where('users.department_id', '=', Auth::user()->department_id)
            ->groupBy('sor_category_types.id')
            ->get();
	return view('documentSor.create',compact('deptCategories'));
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'dept_category' => 'required|integer',
            'volume_no' => 'required|integer',
            'upload_at' => 'required|integer',
            'file_upload' => 'required|mimes:pdf',
        ], [
            'dept_category.required' => 'Department category field is required',
            'dept_category.integer' => 'Mismatch select Item'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pdfFile = $request->file('file_upload');

        // dd($pdfFile);

        $base64Content = base64_encode(file_get_contents($pdfFile));
        //dd($base64Content);
        $fileSize = $request->file('file_upload')->getSize();
        $filExt = $request->file('file_upload')->getClientOriginalExtension();
        $mimeType = $request->file('file_upload')->getMimeType();


        SorDocument::create([
            'dept_category_id' => $request->input('dept_category'),
            'volume_no' => $request->input('volume_no'),
            'upload_at' => $request->input('upload_at'),
            'docu_file' => $base64Content,
            'document_type' => $filExt,
            'document_mime' => $mimeType,
            'document_size' => $fileSize,
        ]);

        return redirect()->route('sor-document.index');
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
