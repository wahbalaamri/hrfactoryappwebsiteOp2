<?php

namespace App\Http\Controllers;

use App\Models\Surveys;
use App\Http\Requests\StoreSurveysRequest;
use App\Http\Requests\UpdateSurveysRequest;
use App\Models\ClientSubscriptions;
use App\Models\Functions;
use App\Models\Respondents;
use App\Models\SurveyAnswers;

class SurveysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreSurveysRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Surveys $surveys)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surveys $surveys)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveysRequest $request, Surveys $surveys)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surveys $surveys)
    {
        //
    }
    //takeSurvey function the id is the respondent id
    public function takeSurvey($id)
    {
        //from the id get the survey id
        $respondent = Respondents::find($id);
        //if not found return 404
        if(!$respondent)
        {
            return abort(404);
        }
        //get the survey
        $survey = Surveys::find($respondent->survey_id);
        //if not found return 404
        if(!$survey)
        {
            return abort(404);
        }
        //get the plan of this survey
        $plan = $survey->plans;
        //get client subscription
        $subscription = ClientSubscriptions::select('is_active')->where('client_id',$survey->client_id)->where('plan_id',$plan->id)->first()->is_active;
        if(!$subscription)
        {
            return abort(404);
        }
        //check if the respondent has already taken the survey
        $surveyAnswers= SurveyAnswers::where('answered_by',$id)->get();
        if($surveyAnswers->count() > 0)
        {
            return abort(404);
        }
        if(!$survey->survey_stat)
        {
            return abort(404);
        }
        if($plan->service_->service_type == 3)
        {
            //get servcie id
            $service_id = $plan->service_->id;
            //create empty array
            $open_end_q= array();
            $functions = Functions::where('service_id',$service_id)->get();
            $data = [
                'functions' => $functions,
                // 'user_type' => $user_type,
                'can_ansewer_to_priorities' => false,
                'SurveyId' => $survey->id,
                'email_id' => $id,
                'plan_id' => $plan->id,
                'open_end_q' => $open_end_q
            ];
            return view('surveys.employeeEngagment')->with($data);
        }

    }
}
