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
    public function subscriptions($id)
    {
        $data = [
            'id' => $id
        ];
        return view('dashboard.client.subscriptions')->with($data);
    }
    //ShowEmployeeEngagment function
    public function ShowSurveys($id, $type)
    {
        $client = Clients::find($id);
        $departments = $client->departments();
        $service_id = Services::select('id')->where('service_type', $type)->first()->id;
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
    public function Respondents(SurveysPrepration $surveysPrepration, $id, $type, $survey_id)
    {
        return $surveysPrepration->Respondents($id, $type, $survey_id);
    }
    //saveSCD function
    public function saveSCD(Request $request, SurveysPrepration $surveysPrepration)
    {
        try {
            Log::info($request->type);
            return $surveysPrepration->saveSCD($request, true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            //     return response()->json(['message' => 'Error'], 500);
        }
    }
}
