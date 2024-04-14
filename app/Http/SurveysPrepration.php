<?php

namespace App\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\{Functions, Services, FunctionPractices, PracticeQuestions};

class SurveysPrepration
{
    //
    function index($service_type)
    {
        try {
            //get all functions of the HR Diagnosis
            $functions = Functions::where('service_id', function ($querey) use ($service_type) {
                $querey->select('id')->from('services')->where('service_type', $service_type)->first()->id;
            })->get();
            $data = [
                'functions' => $functions,
                'service_type' => $service_type
            ];
            return view('dashboard.ManageHrDiagnosis.index')->with($data);
        } catch (\Exception $e) {
            return redirect('admin/dashboard')->with('error', $e->getMessage());
        }
    }
    //createFunction
    function createFunction(Request $request,$service_type)
    {
        $data = [
            'function' => null,
            'service_type' => $service_type
        ];
        //return view to create function
        return view('dashboard.ManageHrDiagnosis.edit')->with($data);
    }
    //storeFunction
    function storeFunction(Request $request,$service_type)
    {

        try {
            //store function
            $function = new Functions();
            $function->title = $request->title;
            $function->title_ar = $request->title_ar;
            $function->description = $request->description;
            $function->description_ar = $request->description_ar;
            $function->respondent = $request->respondent;
            $function->status = $request->status != null;
            $function->service_id = Services::select('id')->where('service_type', $service_type)->first()->id;
            $function->save();
            return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //showPractices function
    function showPractices($id,$service_type)
    {
        try {
            //get all practices of the function
            $function = Functions::find($id);

            $data = [
                'function' => $function,
                'service_type' => $service_type
            ];
            return view('dashboard.ManageHrDiagnosis.showPractices')->with($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //createPractice function
    function createPractice($id,$service_type)
    {
        try {
            //return view to create practice
            $function = Functions::find($id);
            $data = [
                'function' => $function,
                'practice' => null,
                'service_type' => $service_type
            ];
            return view('dashboard.ManageHrDiagnosis.editPractice')->with($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //storePractice function
    function storePractice(Request $request, $id,$service_type)
    {
        try {
            //store practice
            $practice = new FunctionPractices();
            $practice->title = $request->title;
            $practice->title_ar = $request->title_ar;
            $practice->description = $request->description;
            $practice->description_ar = $request->description_ar;
            $practice->status = $request->status != null;
            $practice->function_id = $id;
            $practice->save();
            return redirect()->route('ManageHrDiagnosis.showPractices', $id)->with('success', 'Practice created successfully');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //showQuestions function
    function showQuestions($id,$service_type)
    {
        try {
            //get all questions of the practice
            $practice = FunctionPractices::find($id);
            $data = [
                'practice' => $practice,
                'service_type' => $service_type
            ];
            return view('dashboard.ManageHrDiagnosis.showQuestions')->with($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //createQuestion function
    function createQuestion($id,$service_type)
    {
        try {
            //return view to create question
            $practice = FunctionPractices::find($id);
            $data = [
                'practice' => $practice,
                'question' => null,
                'service_type' => $service_type
            ];
            return view('dashboard.ManageHrDiagnosis.editQuestion')->with($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //storeQuestion function
    function storeQuestion(Request $request, $id,$service_type)
    {
        try {
            //store question
            $question = new PracticeQuestions();
            $question->question = $request->question;
            $question->question_ar = $request->question_ar;
            $question->description = $request->description;
            $question->description_ar = $request->description_ar;
            $question->respondent = $request->respondent;
            $question->status = $request->status != null;
            $question->practice_id = $id;
            $question->save();
            return redirect()->route('ManageHrDiagnosis.showQuestions', $id)->with('success', 'Question created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //editQuestion function
    function editQuestion($id,$service_type)
    {
        try {
            //return view to edit question
            $question = PracticeQuestions::find($id);
            //practice
            $practice = FunctionPractices::find($question->practice_id);
            $data = [
                'practice' => $practice,
                'question' => $question,
                'service_type' => $service_type
            ];
            return view('dashboard.ManageHrDiagnosis.editQuestion')->with($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //updateQuestion function
    function updateQuestion(Request $request, $id,$service_type)
    {
        try {
            //update question
            $question = PracticeQuestions::find($id);
            $question->question = $request->question;
            $question->question_ar = $request->question_ar;
            $question->description = $request->description;
            $question->description_ar = $request->description_ar;
            $question->respondent = $request->respondent;
            $question->status = $request->status != null;
            $question->save();
            return redirect()->route('ManageHrDiagnosis.showQuestions', $question->practice_id)->with('success', 'Question updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //deleteQuestion function
    function deleteQuestion(Request $request, $id,$service_type)
    {
        try {
            //delete question
            $question = PracticeQuestions::find($id);
            $practice_id = $question->practice_id;
            $question->delete();
            return redirect()->route('ManageHrDiagnosis.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //editPractice function
    function editPractice($id,$service_type)
    {
        try {
            //return view to edit practice
            $practice = FunctionPractices::find($id);
            //function
            $function = Functions::find($practice->function_id);
            $data = [
                'function' => $function,
                'practice' => $practice,
                'service_type' => $service_type
            ];
            return view('dashboard.ManageHrDiagnosis.editPractice')->with($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //updatePractice function
    function updatePractice(Request $request, $id,$service_type)
    {
        try {
            //update practice
            $practice = FunctionPractices::find($id);
            $practice->title = $request->title;
            $practice->title_ar = $request->title_ar;
            $practice->description = $request->description;
            $practice->description_ar = $request->description_ar;
            $practice->status = $request->status != null;
            $practice->save();
            return redirect()->route('ManageHrDiagnosis.showPractices', $practice->function_id)->with('success', 'Practice updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //destroyPractice function
    function destroyPractice(Request $request, $id,$service_type)
    {
        try {
            //delete practice
            $practice = FunctionPractices::find($id);
            $function_id = $practice->function_id;
            //delete all questions of the practice
            $practice->questions()->delete();
            $practice->delete();
            return redirect()->route('ManageHrDiagnosis.showPractices', $function_id)->with('success', 'Practice deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //editFunction function
    function editFunction($id,$service_type)
    {
        try {
            //return view to edit function
            $function = Functions::find($id);
            $data = [
                'function' => $function,
                'service_type' => $service_type
            ];
            return view('dashboard.ManageHrDiagnosis.edit')->with($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //updateFunction function
    function updateFunction(Request $request, $id,$service_type)
    {
        try {
            //update function
            $function = Functions::find($id);
            $function->title = $request->title;
            $function->title_ar = $request->title_ar;
            $function->description = $request->description;
            $function->description_ar = $request->description_ar;
            $function->respondent = $request->respondent;
            $function->status = $request->status != null;
            $function->save();
            return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //destroyFunction function
    function destroyFunction(Request $request, $id,$service_type)
    {
        try {
            //delete function
            $function = Functions::find($id);
            $service_id = $function->service_id;
            //delete all questions of the function
            $function->practices->each(function ($practice) {
                $practice->questions()->delete();
                $practice->delete();
            });
            $function->delete();
            return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
