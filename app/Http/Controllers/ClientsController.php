<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Http\Requests\StoreClientsRequest;
use App\Http\Requests\UpdateClientsRequest;
use App\Http\SurveysPrepration;
use App\Models\Departments;
use App\Models\Plans;
use App\Models\Services;
use App\Models\Surveys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // get all clients
        // $clients = Clients::all();
        // //update client status based on delete_at
        // foreach ($clients as $client) {
        //     if ($client->deleted_at != null) {
        //         $client->Status = false;
        //     } else {
        //         $client->Status = true;
        //     }
        // }
        //get all undeleted clients
        $clients = Clients::all();
        $data = [
            'clients' => $clients
        ];
        return view('dashboard.client.allClients')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientsRequest $request, Clients $clients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $clients)
    {
        //
    }

    //subscriptions function
    public function manage(SurveysPrepration $surveysPrepration,$id)
    {
       return $surveysPrepration->manage($id);
    }
    //viewSubscriptions function
    public function viewSubscriptions(SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->viewSubscriptions($id,true);
    }
    //saveSubscription function
    public function saveSubscription(Request $request, SurveysPrepration $surveysPrepration,$id)
    {
        return $surveysPrepration->saveSubscription($request,$id, true);
    }
    //ShowEmployeeEngagment function
    public function ShowSurveys(SurveysPrepration $surveysPrepration, $id, $type)
    {
        return $surveysPrepration->ShowSurveys($id, $type);
    }
    //createSurvey function
    public function createSurvey(SurveysPrepration $surveysPrepration, $id, $type)
    {
        return $surveysPrepration->editSurvey($id, $type);
    }
    //storeSurvey function
    public function storeSurvey(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id = null)
    {

        if ($survey_id != null) {
            $survey = Surveys::find($survey_id);
            return $surveysPrepration->CreateOrUpdateSurvey($request, $id, $type, true, $survey);
        }
        return $surveysPrepration->CreateOrUpdateSurvey($request, $id, $type, true);
    }
    //changeSurveyStatus function
    public function changeSurveyStat(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->changeSurveyStat($request, $id, $type, $survey_id, true);
    }
    //surveyDetails function
    public function surveyDetails(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->surveyDetails($id, $type, $survey_id, true);
    }
    //deleteSurvey function
    public function deleteSurvey(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->deleteSurvey($id, $type, $survey_id, true);
    }
    //editSurvey function
    public function editSurvey(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->editSurvey($id, $type, $survey_id);
    }
    //Respondents function
    public function Respondents(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->Respondents($request, $id, $type, $survey_id);
    }
    //saveSCD function
    public function saveSCD(Request $request, SurveysPrepration $surveysPrepration)
    {
        try {
            return $surveysPrepration->saveSCD($request, true);
        } catch (\Exception $e) {
            //     return response()->json(['message' => 'Error'], 500);
        }
    }
    //ShowCreateEmail function
    public function ShowCreateEmail(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->ShowCreateEmail($id, $type, $survey_id, true);
    }
    //getClientLogo function
    public function getClientLogo(SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->getClientLogo($id, true);
    }
    //storeSurveyEmail function
    public function storeSurveyEmail(Request $request, SurveysPrepration $surveysPrepration, $id, $type, $survey_id,$emailid=null)
    {
        return $surveysPrepration->storeSurveyEmail($request, $id, $type, $survey_id,$emailid, true);
    }
    //orgChart function
    public function orgChart(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->orgChart($request, $id, true);
    }
    //Employees function
    public function Employees(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->Employees($request, $id, true);
    }
    //companies function
    public function companies(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->companies($request, $id, true);
    }
    //departments function
    public function departments(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->departments($request, $id, true);
    }
    //storeEmployee function
    public function storeEmployee(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->storeEmployee($request, true);
    }
    //getEmployee function
    public function getEmployee(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->getEmployee($request, $id, true);
    }
    //getDepartment function
    public function getDepartment(Request $request, SurveysPrepration $surveysPrepration, $id)
    {
        return $surveysPrepration->getDepartment($request, $id, true);
    }
    //saveSurveyRespondents function
    public function saveSurveyRespondents(Request $request, SurveysPrepration $surveysPrepration)
    {
        return $surveysPrepration->saveSurveyRespondents($request, true);
    }
}
