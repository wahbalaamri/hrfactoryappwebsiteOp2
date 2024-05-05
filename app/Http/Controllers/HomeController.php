<?php

namespace App\Http\Controllers;

use App\Http\SurveysPrepration;
use App\Jobs\SetupUsersIdInUsersOldSections;
use App\Models\Content;
use App\Models\Services;
use App\Models\User;
use App\Models\UserPlans;
use App\Models\UserSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contents = Content::where('page', '=', 'home')->get();
        $data = [
            'contents' => $contents,
            'services' => Services::all()
        ];
        return view('home.index')->with($data);
    }
    public function aboutus()
    {
        //aboutus
        $contents = Content::where('page', '=', 'aboutus')->get();
        $data = [
            'contents' => $contents
        ];
        return view('home.about-us')->with($data);
    }

    function CheckUser()
    {
        if (Auth()->check()); {
            //redirect to some route
            return Auth()->user()->isAdmin == 1 ? redirect()->route('admin.dashboard') : redirect()->route('client.dashboard');
        }
    }
    function dashboard()
    {
        if (Auth()->user()->user_type == 'client') {
            return redirect()->route('client.dashboard');
        }
        $contents = Content::where('page', '=', 'login')->get();
        $data = [
            'contents' => $contents
        ];
        return view('dashboard.admin.index')->with($data);
    }
    function client()
    {
        if (Auth()->user()->user_type != 'client') {
            return redirect()->route('admin.dashboard');
        }
        //get active userplans subscriptions
        $active_sub = UserPlans::where([['IsActive', true], ['UserId', Auth()->user()->id]])->get();
        //get notactive userplans subscriptions
        $notactive_sub = UserPlans::where([['IsActive', false], ['UserId', Auth()->user()->id]])->get();
        $data = [
            'active_sub' => $active_sub,
            'notactive_sub' => $notactive_sub
        ];
        return view('dashboard.client.index')->with($data);
    }
    function setupUsrPlans()
    {
        //call SetupUsersIdInUsersOldSections
        $job = new SetupUsersIdInUsersOldSections();
        dispatch($job);
        return "Done";
    }
    function viewTool($id)
    {
        //get a service
        $service = Services::find($id);
        $data = [
            'service' => $service
        ];
        return view('home.view-tool')->with($data);
    }
    //manage function
    public function manage(SurveysPrepration $surveysPrepration)
    {
        //get all surveys
        return $surveysPrepration->manage(Auth()->user()->client_id);
    }
}
