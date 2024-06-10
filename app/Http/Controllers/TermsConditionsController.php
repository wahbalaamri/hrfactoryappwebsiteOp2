<?php

namespace App\Http\Controllers;

use App\Models\TermsConditions;
use App\Http\Requests\StoreTermsConditionsRequest;
use App\Http\Requests\UpdateTermsConditionsRequest;
use App\Models\Countries;

class TermsConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get current user id
        $user_id = auth()->user()->id;
        //get current user type
        $user_type = auth()->user()->user_type;
        //check if current user is admin
        if (auth()->user()->isAdmin) {
            //get all terms
            $terms = TermsConditions::all();
        } elseif($user_type=="partner") {
            //get all terms where plan is null
            $terms = TermsConditions::where('plan', null)->get();
        }
        else
        {
            //abort not autherized
            abort(403);
        }
        //get all terms where plan is null

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
    public function store(StoreTermsConditionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TermsConditions $termsConditions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TermsConditions $termsConditions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTermsConditionsRequest $request, TermsConditions $termsConditions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TermsConditions $termsConditions)
    {
        //
    }
}
