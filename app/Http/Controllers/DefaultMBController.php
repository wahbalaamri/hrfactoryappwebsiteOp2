<?php

namespace App\Http\Controllers;

use App\Models\DefaultMB;
use App\Http\Requests\StoreDefaultMBRequest;
use App\Http\Requests\UpdateDefaultMBRequest;
use App\Models\Countries;
use App\Models\Partnerships;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DefaultMBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $country = null)
    {
        $user_id = auth()->user()->id;
        //get current user type
        $user_type = auth()->user()->user_type;
        //
        if (auth()->user()->isAdmin) {
            //get all terms
            //get all countries
            $countries = Countries::all()->groupBy('IsArabCountry');
        } elseif ($user_type == "partner") {
            //get all partnerships
            $partnerships_countries = Partnerships::where('partner_id', auth()->user()->partner_id)->get()->pluck('country_id')->toArray();
            //get all terms where plan is null
            //get countries
            $countries = Countries::whereIn('id', $partnerships_countries)->get();
        } else {
            //abort not autherized
            abort(403);
        }
        $sections = DefaultMB::where('country_id', 155)->whereNull('paren_id')->where('language', app()->isLocale('en') ? 'en' : 'ar')->orderBy('ordering')->get();
        $data = [
            'sections' => $sections,
            'countries' => $countries
        ];
        return view('dashboard.admin.ManualBuilder.index', $data);
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
    public function store(StoreDefaultMBRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DefaultMB $defaultMB)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DefaultMB $defaultMB)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDefaultMBRequest $request, DefaultMB $defaultMB)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DefaultMB $defaultMB)
    {
        //
    }
    public function reorder(Request $request)
    {
        $orderData = $request->orderData;
        foreach ($orderData as $key => $value) {
            $section = DefaultMB::find($value['id']);
            $section->ordering = $value['ordering'];
            $section->save();
        }
        return response()->json(['message' => 'Sections reordered successfully']);
    }
}
