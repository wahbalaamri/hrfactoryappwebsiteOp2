<?php

namespace App\Http\Controllers;

use App\Models\Functions;
use Illuminate\Http\Request;

class ManageHrDiagnosisController extends Controller
{
    //
    function index()
    {
        //get all functions of the HR Diagnosis
        $functions= Functions::where('service_id',function($querey){
            $querey->select('id')->from('services')->where('service_type',4)->first()->id;
        })->get();
        $data=[
            'functions'=>$functions
        ];
        return view('dashboard.ManageHrDiagnosis.index')->with($data);
    }
}
