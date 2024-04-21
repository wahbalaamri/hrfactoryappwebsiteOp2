<?php

namespace App\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\{Clients, Functions, Services, FunctionPractices, Industry, Plans, PracticeQuestions, Sectors, Surveys,Companies,Departments};

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
    function createFunction(Request $request, $service_type)
    {
        $data = [
            'function' => null,
            'service_type' => $service_type
        ];
        //return view to create function
        return view('dashboard.ManageHrDiagnosis.edit')->with($data);
    }
    //storeFunction
    function storeFunction(Request $request, $service_type)
    {

        try {
            //store function
            $function = new Functions();
            $function->title = $request->title;
            $function->title_ar = $request->title_ar;
            $function->description = $request->description;
            $function->description_ar = $request->description_ar;
            $function->respondent = $request->respondent;
            if ($service_type == 3) {
                $function->IsDriver = $request->IsDriver != null;
            }
            $function->status = $request->status != null;
            $function->service_id = Services::select('id')->where('service_type', $service_type)->first()->id;
            $function->save();
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function created successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.index')->with('success', 'Function created successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.index')->with('success', 'Function created successfully');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //showPractices function
    function showPractices($id, $service_type)
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
    function createPractice($id, $service_type)
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
    function storePractice(Request $request, $id, $service_type)
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
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.showPractices', $id)->with('success', 'Practice created successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.showPractices', $id)->with('success', 'Practice created successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.showPractices', $id)->with('success', 'Practice created successfully');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //showQuestions function
    function showQuestions($id, $service_type)
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
    function createQuestion($id, $service_type)
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
    function storeQuestion(Request $request, $id, $service_type)
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
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.showQuestions', $id)->with('success', 'Question created successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.showQuestions', $id)->with('success', 'Question created successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.showQuestions', $id)->with('success', 'Question created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //editQuestion function
    function editQuestion($id, $service_type)
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
    function updateQuestion(Request $request, $id, $service_type)
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
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.showQuestions', $question->practice_id)->with('success', 'Question updated successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.showQuestions', $question->practice_id)->with('success', 'Question updated successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.showQuestions', $question->practice_id)->with('success', 'Question updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //deleteQuestion function
    function deleteQuestion(Request $request, $id, $service_type)
    {
        try {
            //delete question
            $question = PracticeQuestions::find($id);
            $practice_id = $question->practice_id;
            $question->delete();
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.showQuestions', $practice_id)->with('success', 'Question deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //editPractice function
    function editPractice($id, $service_type)
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
    function updatePractice(Request $request, $id, $service_type)
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
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.showPractices', $practice->function_id)->with('success', 'Practice updated successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.showPractices', $practice->function_id)->with('success', 'Practice updated successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.showPractices', $practice->function_id)->with('success', 'Practice updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //destroyPractice function
    function destroyPractice(Request $request, $id, $service_type)
    {
        try {
            //delete practice
            $practice = FunctionPractices::find($id);
            $function_id = $practice->function_id;
            //delete all questions of the practice
            $practice->questions()->delete();
            $practice->delete();
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.showPractices', $function_id)->with('success', 'Practice deleted successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.showPractices', $function_id)->with('success', 'Practice deleted successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.showPractices', $function_id)->with('success', 'Practice deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //editFunction function
    function editFunction($id, $service_type)
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
    function updateFunction(Request $request, $id, $service_type)
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
            if ($service_type == 3) {
                $function->IsDriver = $request->IsDriver != null;
            }
            $function->save();
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function updated successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.index')->with('success', 'Function updated successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.index')->with('success', 'Function updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //destroyFunction function
    function destroyFunction(Request $request, $id, $service_type)
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
            if ($service_type == 4)
                return redirect()->route('ManageHrDiagnosis.index')->with('success', 'Function deleted successfully');
            else if ($service_type == 3)
                return redirect()->route('EmployeeEngagment.index')->with('success', 'Function deleted successfully');
            else if ($service_type == 5)
                return redirect()->route('Leader360Review.index')->with('success', 'Function deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //add new survey function
    function editSurvey($id, $type, $survey = null)
    {
        $client = Clients::find($id);
        $service_id = Services::select('id')->where('service_type', $type)->first()->id;
        $plan = Plans::where("service", $service_id)->get();
        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'plans' => $plan,
            'survey' => $survey
        ];
        return view('dashboard.client.editSurvey')->with($data);
    }
    function CreateOrUpdateSurvey(Request $request, $user_id, $service_type, $by_admin = false, $survey = null)
    {
        try {
            if ($survey == null) {
                $survey = new Surveys();
            }
            $survey->client_id = $user_id;
            $survey->plan_id = $request->plan_id;
            $survey->survey_title = $request->survey_title;
            $survey->survey_des = $request->survey_des;
            $survey->survey_stat = $request->survey_stat != null;
            $survey->save();
            if ($by_admin)
                return redirect()->route('clients.ShowSurveys', [$user_id, $service_type])->with('success', 'Survey created successfully');
            else
                return redirect()->route('clients.ShowSurveys', [$user_id, $service_type])->with('success', 'Survey created successfully');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    function changeSurveyStat(Request $request, $user_id, $service_type, $survey_id, $by_admin = false)
    {
        try {
            $survey = Surveys::find($survey_id);
            $survey->survey_stat = $request->status == '1';
            $survey->save();
            //json response with status
            return response()->json(['status' => true, 'message' => 'Survey status changed successfully']);

        } catch (\Exception $e) {

            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    function surveyDetails($id, $type, $survey_id, $by_admin = false)
    {
        $survey = Surveys::find($survey_id);
        $data = [
            'id' => $id,
            'type' => $type,
            'survey' => $survey,
        ];
        return view('dashboard.client.surveyDetails')->with($data);
    }
    function deleteSurvey($id, $type, $survey_id, $by_admin = false)
    {
        try {
            $survey = Surveys::find($survey_id);
            $survey->delete();
            return redirect()->route('clients.ShowSurveys', [$id, $type])->with('success', 'Survey deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //respondents function
    function respondents($id, $type, $survey_id)
    {
        $survey = Surveys::find($survey_id);
        $client = Clients::find($id);
        $data = [
            'id' => $id,
            'type' => $type,
            'survey' => $survey,
            'client' => $client
        ];
        return view('dashboard.client.respondents')->with($data);
    }
    //saveSCDS function
    function saveSCD(Request $request, $by_admin = false)
    {
        
        try{
            if($request->type=="sector")
            {
                //if sector id = other
                if($request->_id == "other")
                {
                    //create new sector
                    $Industry = new Industry();
                    $Industry->name = $request->name_en;
                    $Industry->name_ar = $request->name_ar;
                    $Industry->system_create = false;
                    $Industry->client_id = $request->client_id;
                    $Industry->save();
                    //create new sctore
                    $sector = new Sectors();
                    $sector->client_id = $request->client_id;
                    $sector->name_en = $request->name_en;
                    $sector->name_ar = $request->name_ar;
                    $sector->save();
                    //json response with status
                    return response()->json(['status' => true, 'message' => 'Sector created successfully', 'sector' => $sector]);
                }
                else
                {
                    //find the industry
                    $Industry = Industry::find($request->_id);
                    //create new sector
                    $sector = new Sectors();
                    $sector->client_id = $request->client_id;
                    $sector->name_en = $Industry->name;
                    $sector->name_ar = $Industry->name_ar;
                    $sector->save();                   
                    //json response with status
                    return response()->json(['status' => true, 'message' => 'Sector created successfully', 'sector' => $sector]);
                }
            }
            //type = comp
            else if($request->type=="comp")
            {
                //create new company
                $company = new Companies();
                $company->client_id = $request->client_id;
                $company->sector_id = $request->_id;
                $company->name_en = $request->name_en;
                $company->name_ar = $request->name_ar;
                $company->save();
                //json response with status
                return response()->json(['status' => true, 'message' => 'Company created successfully', 'company' => $company]);
            }
            //type = dep
            else if($request->type=="dep")
            {
                //create new department
                $department = new Departments();
                $department->company_id = $request->_id;
                $department->name_en = $request->name_en;
                $department->name_ar = $request->name_ar;
                $department->dep_level = 0;
                $department->save();
                //json response with status
                return response()->json(['status' => true, 'message' => 'Department created successfully', 'department' => $department]);
            }
            // type = sub-dep
            else if($request->type=="sub-dep")
            {
                //find the department
                $p_department = Departments::find($request->_id);
                //create new department
                $department = new Departments();
                $department->company_id = $p_department->company_id;
                $department->parent_id = $request->_id;
                $department->name_en = $request->name_en;
                $department->name_ar = $request->name_ar;
                $department->parent_id = $p_department->id;
                $department->dep_level = $p_department->dep_level + 1;
                $department->save();
                //json response with status
                return response()->json(['status' => true, 'message' => 'Department created successfully', 'department' => $department]);
            }
        }
        catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
