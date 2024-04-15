<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Http\Requests\StoreClientsRequest;
use App\Http\Requests\UpdateClientsRequest;
use App\Models\Departments;
use App\Models\Plans;
use App\Models\Surveys;

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
        $clients = Clients::where('deleted_at', null)->get();
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
        $data=[
            'id'=>$id
        ];
        return view('dashboard.client.subscriptions')->with($data);
    }
    //ShowEmployeeEngagment function
    public function ShowEmployeeEngagment($id)
    {
        $client = Clients::find($id);
        $departments = Departments::all();
        $plan_id=Plans::where("service",3)->pluck('id')->toArray();
        $client_survyes=Surveys::where('client_id', $client->id)->whereIn('plan_id',$plan_id)->get();

        $data=[
            'id'=>$id,
            'client'=>$client,
            'departments'=>$departments,
            'client_survyes'=>$client_survyes
        ];
        return view('dashboard.client.employeeEngagment')->with($data);
    }
}
