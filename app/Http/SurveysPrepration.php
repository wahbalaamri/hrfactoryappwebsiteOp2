<?php

namespace App\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\{Clients, ClientSubscriptions, Functions, Services, FunctionPractices, Industry, Plans, PracticeQuestions, Sectors, Surveys, Companies, Departments, EmailContents, Employees, PrioritiesAnswers, Respondents, SurveyAnswers};
use Yajra\DataTables\Facades\DataTables;

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
    function respondents(Request $request, $id, $type, $survey_id)
    {
        $survey = Surveys::find($survey_id);
        $client = Clients::find($id);
        $survey_type = $survey->plans->service_->service_type;
        $data = [
            'id' => $id,
            'type' => $type,
            'survey' => $survey,
            'client' => $client,
            'survey_type' => $survey_type,
            'survey_id' => $survey_id
        ];
        //if request is ajax
        if ($request->ajax()) {
            $respondents_ids = $survey->respondents->pluck('employee_id')->toArray();
            //setup yajra datatable
            $employees = $client->employeesData()->get();
            // $employees = Employees::where('client_id', $id)->get();
            //log employees as an array
            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('action', function ($employee) {

                    $action = '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="deleteEmp(\'' . $employee->id . '\')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></div></div>';
                    return $action;
                })
                //hr
                ->addColumn('hr', function ($employee) {
                    return $employee->is_hr_manager ? '<span class="badge bg-success">' . __('HR Manager') . '</span>' : '<span class="badge bg-danger">' . __('Not HR Manager') . '</span>';
                })
                ->addColumn('raters', function ($employee) {
                    return "-";
                })
                ->addColumn('service_type', function ($employee) use ($survey_type) {
                    return $survey_type;
                })
                ->addColumn('isAddAsRespondent', function ($employee) use ($respondents_ids) {
                    return in_array($employee->id, $respondents_ids) ? true : false;
                })
                ->addColumn('SendSurvey', function ($employee) use ($respondents_ids, $survey_id) {
                    return in_array($employee->id, $respondents_ids) ? '<a href="javascript:void(0);" onclick="SendSurvey(\'' . $employee->id . '\',\'' . $survey_id . '\')" class="btn btn-info btn-xs"><i class="fa fa-paper-plane"></i></a>' : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->addColumn('SendReminder', function ($employee) use ($respondents_ids, $survey_id) {
                    return in_array($employee->id, $respondents_ids) ? '<a href="javascript:void(0);" onclick="SendReminder(\'' . $employee->id . '\',\'' . $survey_id . '\')" class="btn btn-warning btn-xs"><i class="fa fa-paper-plane"></i></a>' : '<span class="badge bg-danger">' . __('Not Added') . '</span>';
                })
                ->rawColumns(['action', 'hr', 'SendSurvey', 'SendReminder'])
                ->make(true);
        }
        return view('dashboard.client.respondents')->with($data);
    }
    //saveSCDS function
    function saveSCD(Request $request, $by_admin = false)
    {

        try {
            if ($request->type == "sector") {
                //if sector id = other
                if ($request->_id == "other") {
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
                } else {
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
            else if ($request->type == "comp") {
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
            else if ($request->type == "dep") {
                $is_hr = false;
                if (
                    $request->is_hr == 1 || $request->is_hr == true || $request->is_hr == "true" || $request->is_hr == "1"
                    || $request->is_hr == "on" || $request->is_hr == "yes" || $request->is_hr == "checked" || $request->is_hr == "selected"
                ) {
                    $is_hr = true;
                }
                //create new department
                $department = new Departments();
                $department->company_id = $request->_id;
                $department->name_en = $request->name_en;
                $department->name_ar = $request->name_ar;
                //is hr
                $department->is_hr = $is_hr;
                $department->dep_level = 0;
                $department->save();
                //json response with status
                return response()->json(['status' => true, 'message' => 'Department created successfully', 'department' => $department]);
            }
            // type = sub-dep

            else if ($request->type == "sub-dep") {

                $is_hr = false;
                if (
                    $request->is_hr == 1 || $request->is_hr == true || $request->is_hr == "true" || $request->is_hr == "1"
                    || $request->is_hr == "on" || $request->is_hr == "yes" || $request->is_hr == "checked" || $request->is_hr == "selected"
                    || $request->is_hr != false || $request->is_hr != "false"
                ) {
                    $is_hr = true;
                }
                if ($request->is_hr == false || $request->is_hr == "false")
                    $is_hr = false;
                //find the department
                if ($request->_id != null)
                    $p_department = Departments::find($request->_id);
                else
                    $p_department = null;
                //if dep_id is null
                if ($request->dep_id == null) {
                    //create new department
                    $department = new Departments();
                } else {
                    //find the department
                    $department = Departments::find($request->dep_id);
                }
                if ($p_department != null)
                    $department->company_id = $p_department->company_id;
                if ($request->_id != null)
                    $department->parent_id = $request->_id;
                $department->name_en = $request->name_en;
                $department->name_ar = $request->name_ar;
                if ($p_department != null) {
                    $department->parent_id = $p_department->id;
                    $department->dep_level = $p_department->dep_level + 1;
                }
                //is hr
                $department->is_hr = $is_hr;
                $department->save();
                //json response with status
                return response()->json(['status' => true, 'message' => 'Department created successfully', 'department' => $department]);
            }
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    //ShowCreateEmail function
    function ShowCreateEmail($id, $type, $survey_id, $by_admin = false)
    {
        $survey = Surveys::find($survey_id);
        $client = Clients::find($id);
        $emailContet = EmailContents::where([['survey_id', $survey_id], ['client_id', $id]])->first();
        $data = [
            'id' => $id,
            'type' => $type,
            'survey' => $survey,
            'client' => $client,
            'emailContet' => $emailContet
        ];
        return view('dashboard.client.createEmail')->with($data);
    }
    //getClientLogo function
    function getClientLogo($id, $by_admin = false)
    {
        try {
            $client = Clients::find($id);
            return response()->json(['logo' => $client->logo_path]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }
    //storeSurveyEmail function
    function storeSurveyEmail(Request $request, $id, $type, $survey_id, $emailid = null, $by_admin = false)
    {
        try {
            //find client
            $client = Clients::find($id);

            //if Client_logo_status not null and client_logo has file
            if ($request->Client_logo_status != null && $request->hasFile('client_logo')) {
                $file = $request->file('client_logo');
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/companies/logos'), $file_name);
                $client->logo_path = $file_name;
                $client->save();
            }

            //find email content

            if ($emailid == null) {
                $email = new EmailContents();
            } else {
                $email = EmailContents::find($emailid);
            }

            //check if survey_logo
            if ($request->hasFile('survey_logo')) {

                $file = $request->file('survey_logo');
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/emails'), $file_name);
                $email->logo = $file_name;
            }
            $email->email_type = 'survey';
            $email->client_id = $id;
            $email->survey_id = $survey_id;
            $email->subject = $request->subject;
            $email->subject_ar = $request->subject_ar;
            $email->body_header = $request->email_body;
            $email->body_footer = $request->email_footer;
            $email->body_header_ar = $request->email_body_ar;
            $email->body_footer_ar = $request->email_footer_ar;
            $email->status = $request->status != null;
            $email->use_client_logo = $request->Client_logo_status != null;
            $email->save();
            if ($by_admin)
                return redirect()->route('clients.ShowSurveys', [$id, $type])->with('success', 'Email created successfully');
            else
                return redirect()->route('clients.ShowSurveys', [$id, $type])->with('success', 'Email created successfully');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info(print_r($e));
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //orgChart function
    function orgChart(Request $request, $id, $by_admin = false)
    {
        $client = Clients::find($id);
        $data = [
            'id' => $id,
            'client' => $client
        ];
        if ($request->ajax()) {
            //setup yajra datatable
            $departments = $client->departments();
            return DataTables::of($departments)
                ->addIndexColumn()
                ->addColumn('action', function ($department) {
                    $action = '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="EditDep(\'' . $department->id . '\',\'' . $department->parent_id . '\',\'' . $department->company->client_id . '\',\'sub-dep\')" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a></div>';
                    $action .= '<div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="EditDep(\'' . $department->id . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div></div>';
                    return $action;
                })
                ->addColumn('super_department', function ($department) {
                    return $department->parent_id == null ? 'No Super Parent' : (App()->getLocale() == 'en' ? $department->parent->name_en : $department->parent->name_ar);
                })
                ->addColumn('name', function ($department) {
                    return App()->getLocale() == 'en' ? $department->name_en : $department->name_ar;
                })
                ->addColumn('level', function ($department) {
                    return 'c-' . $department->dep_level;
                })
                ->addColumn('company', function ($department) {
                    return App()->getLocale() == 'en' ? $department->company->name_en : $department->company->name_ar;
                })
                ->addColumn('sector', function ($department) {
                    return App()->getLocale() == 'en' ? $department->company->sector->name_en : $department->company->sector->name_ar;
                })
                ->editColumn('is_hr', function ($department) {
                    return $department->is_hr ? '<span class="badge bg-success">' . __('HR Department') . '</span>' : '<span class="badge bg-danger">' . __('Not HR Department') . '</span>';
                })
                ->rawColumns(['action', 'is_hr'])
                ->make(true);
        }
        return view('dashboard.client.orgChart.orgChart')->with($data);
    }
    // Employees function
    function Employees(Request $request, $id, $by_admin = false)
    {
        try {
            $client = Clients::find($id);
            $data = [
                'id' => $id,
                'client' => $client
            ];
            if ($request->ajax()) {
                //setup yajra datatable
                $employees = $client->employeesData()->get();
                Log::info(json_encode($employees));
                $employees = Employees::where('client_id', $id)->get();
                //log employees as an array
                return DataTables::of($employees)
                    ->addIndexColumn()
                    ->addColumn('action', function ($employee) {
                        $action = '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="editEmp(\'' . $employee->id . '\')" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a></div>';
                        $action .= '<div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="deleteEmp(\'' . $employee->id . '\')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></div></div>';
                        return $action;
                    })
                    ->addColumn('type', function ($employee) {
                        return $employee->employee_type == 1 ? __('HR Manager') : __('Normal Employee');
                    })
                    ->addColumn('sector', function ($employee) {
                        return $employee->sector != null ? ($employee->sector->Name) : '-';
                    })
                    //hr
                    ->addColumn('hr', function ($employee) {
                        return $employee->is_hr_manager ? '<span class="badge bg-success">' . __('HR Manager') . '</span>' : '<span class="badge bg-danger">' . __('Not HR Manager') . '</span>';
                    })
                    ->addColumn('company', function ($employee) {
                        return $employee->company != null ? (App()->getLocale() == 'en' ? $employee->company->name_en : $employee->company->name_ar) : '-';
                    })
                    ->editColumn('department', function ($employee) {
                        return $employee->department != null ? (App()->getLocale() == 'en' ? $employee->department->name_en : $employee->department->name_ar) : '-';
                    })
                    ->addColumn('active', function ($employee) {
                        return $employee->active ? '<span class="badge bg-success">' . __('Active') . '</span>' : '<span class="badge bg-danger">' . __('Not Active') . '</span>';
                    })
                    ->rawColumns(['action', 'hr', 'active'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return view('dashboard.client.Employees.showAll')->with($data);
    }
    //companies function
    function companies(Request $request, $id, $by_admin = false)
    {
        return Companies::where('sector_id', $id)->get()->append('name');
    }
    //departments function
    function departments(Request $request, $id, $by_admin = false)
    {
        return Departments::where('company_id', $id)->get()->append('name');
    }
    //storeEmployee function
    function storeEmployee(Request $request,  $by_admin = false)
    {
        try {
            Log::info($request->all());
            //create new employee
            if ($request->id == null) {
                $employee = new Employees();
            } else {
                $employee = Employees::find($request->id);
            }
            //find department
            $department = Departments::find($request->department);

            $employee->client_id = $request->client_id;
            $employee->sector_id = $request->sector;
            $employee->comp_id = $request->company;
            $employee->dep_id = $request->department;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->mobile = $request->mobile;
            $employee->employee_type = $request->type;
            $employee->position = $request->position;
            if ($department->is_hr && $request->type == 1) {
                $employee->is_hr_manager = true;
            } else {
                $employee->is_hr_manager = false;
            }
            $employee->added_by = 0;
            //save employee
            $employee->save();
            Log::info("ssss");
            Log::info($employee->id);
            Log::info($employee);
            //json response with status
            return response()->json(['status' => true, 'message' => 'Employee created successfully', 'employee' => $employee]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    //getEmployee function
    function getEmployee(Request $request, $id, $by_admin = false)
    {
        try {
            //find employee
            $employee = Employees::find($id);
            //json response with status
            return response()->json(['status' => true, 'employee' => $employee]);
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    //getDepartment function
    function getDepartment(Request $request, $id, $by_admin = false)
    {
        try {
            //find department
            $department = Departments::find($id);
            //json response with status
            return response()->json(['status' => true, 'department' => $department]);
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    //ShowSurveys function
    function ShowSurveys($id, $type, $by_admin = false)
    {
        $client = Clients::find($id);
        $departments = $client->departments();
        $service_id = Services::select('id')->where('service_type', $type)->first();
        //check if service_id is null
        if ($service_id == null) {
            return redirect()->route('services.index')->with('error', 'Service not found');
        }
        $service_id = $service_id->id;
        $plan_id = Plans::where("service", $service_id)->pluck('id')->toArray();
        $client_survyes = Surveys::where('client_id', $client->id)->whereIn('plan_id', $plan_id)->get();

        $data = [
            'id' => $id,
            'type' => $type,
            'client' => $client,
            'departments' => $departments,
            'client_survyes' => $client_survyes
        ];
        return view('dashboard.client.Surveys')->with($data);
    }
    //saveSurveyRespondents function
    function saveSurveyRespondents(Request $request, $by_admin)
    {
        try {
            //check if ID from IDs is not added
            foreach ($request->ids as $idr) {
                $respondent = Respondents::where('employee_id', $idr)->where([['survey_id', $request->survey], ['client_id', $request->client], ['survey_type', $request->type]])->first();
                if ($respondent == null) {
                    $respondent1 = new Respondents();
                    $respondent1->employee_id = str($idr);
                    $respondent1->survey_id = $request->survey;
                    $respondent1->client_id = $request->client;
                    $respondent1->survey_type = $request->type;
                    $respondent1->save();
                }
            }
            //get all respondents of the survey and client and type not in IDs
            $respondents = Respondents::where('survey_id', $request->survey)->where('client_id', $request->client)->where('survey_type', $request->type)->whereNotIn('employee_id', $request->ids)->get();
            $ready_to_delete = false;
            //delete all answers of each respondent in respondents
            if (($respondents->count() > 0) && $ready_to_delete) {
                foreach ($respondents as $respondent) {
                    //delete all answers of the respondent
                    if ($request->type == 3 || $request->type == 4) {
                        $answers = SurveyAnswers::where('answered_by', $respondent->id)->get();
                        foreach ($answers as $answer) {
                            $answer->delete();
                        }
                        if ($request->type == 4) {
                            $Panswers = PrioritiesAnswers::where('answered_by', $respondent->id)->get();
                            foreach ($Panswers as $answer) {
                                $answer->delete();
                            }
                        }
                    }
                    if ($request->type == 5) {
                        $answers = SurveyAnswers::where('candidate', $respondent->id)->where('survey_id', $request->survey)->where('client_id', $request->client)->where('survey_type', $request->type)->get();
                        foreach ($answers as $answer) {
                            $answer->delete();
                        }
                    }
                    //delete the respondent
                    $respondent->delete();
                }
            }
            //json response with status
            return response()->json(['status' => true, 'message' => 'Respondents added successfully']);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            //return json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    //manage function
    function manage($id, $by_admin = false)
    {
        $data = [
            'id' => $id
        ];
        return view('dashboard.client.manage')->with($data);
    }
    //viewSubscriptions function
    function viewSubscriptions($id, $by_admin = false)
    {
        $client = Clients::find($id);
        $data = [
            'id' => $id,
            'client' => $client
        ];
        //if request is ajax
        if (request()->ajax()) {
            //setup yajra datatable
            $subscriptions = $client->subscriptions();
            return DataTables::of($subscriptions)
                ->addIndexColumn()
                ->addColumn('action', function ($subscription) {
                    $action = '<div class="row"><div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="editSub(\'' . $subscription->id . '\')" class="btn btn-primary btn-sm"><i class="fa fa-edit
                    "></i></a></div>';
                    $action .= '<div class="col-md-6 col-sm-12 text-center"><a href="javascript:void(0);" onclick="deleteSub(\'' . $subscription->id . '\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div></div>';
                    return $action;
                })
                ->addColumn('service', function ($subscription) {
                    return "55";
                })
                ->addColumn('plan', function ($subscription) {
                    return "--";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.client.subscrip')->with($data);
    }
    //saveSubscription function
    function saveSubscription(Request $request, $id, $by_admin = false)
    {
        try {
            //create new subscription
            if ($request->id == null) {
                $subscription = new ClientSubscriptions();
            } else {
                $subscription = ClientSubscriptions::find($request->id);
            }
            //find client
            $client = Clients::find($request->client_id);
            //find service
            $service = Services::find($request->service);
            //find plan
            $plan = Plans::find($request->plan);
            $subscription->client_id = $id;
            $subscription->service_id = $request->service;
            $subscription->plan_id = $request->plan;
            $subscription->start_date = $request->start_date;
            $subscription->end_date = $request->end_date;
            $subscription->is_active = $request->status != null;
            $subscription->save();
            //json response with status
            return response()->json(['status' => true, 'message' => 'Subscription created successfully', 'subscription' => $subscription]);
        } catch (\Exception $e) {
            //json response with status
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
