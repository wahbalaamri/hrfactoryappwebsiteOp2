<?php

namespace App\Http\Controllers;

use App\Models\Functions;
use Illuminate\Http\Request;

class ManageHrDiagnosisController extends Controller
{
    //
    function index()
    {
        try {
            //get all functions of the HR Diagnosis
            $functions = Functions::where('service_id', function ($querey) {
                $querey->select('id')->from('services')->where('service_type', 4)->first()->id;
            })->get();
            $data = [
                'functions' => $functions
            ];
            return view('dashboard.ManageHrDiagnosis.index')->with($data);
        } catch (\Exception $e) {
            return redirect('admin/dashboard')->with('error', $e->getMessage());
        }
    }
    //createFunction
    function createFunction(Request $request)
    {
        //return view to create function
        return view('dashboard.ManageHrDiagnosis.edit');
    }
    //storeFunction
    function storeFunction(Request $request)
    {
        dd($request->status != null);
        try {
            //store function
            $function = new Functions();
            $function->title = $request->title;
            $function->title_ar = $request->title_ar;
            $function->description = $request->description;
            $function->description_ar = $request->description_ar;
            $function->respondent = $request->respondent;
            $function->status = $request->status != null;
            $function->service_id = 4;
            $function->save();
            return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
