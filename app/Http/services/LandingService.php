<?php

namespace App\Http\services;

use App\Models\Countries;
use App\Models\Partners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class LandingService
{
    public function __construct()
    {
        //
    }
    //get current country
    public function getCurrentCountry()
    {
        //using api detect current location
        $url = "https://extreme-ip-lookup.com/json/?key=sswCYj3OKfeIuxY1C3Bd";
        $json = file_get_contents($url);
        $data = json_decode($json);
        Log::info($data->countryCode);
        $countryCode = $data->countryCode;
        $country = Countries::where('country_code', $countryCode)->first();
        return $country->id;
    }
    //get partner
    public function getPartner()
    {
        return Partners::where('id', function ($querey) {
            $querey->select('partner_id')->from('partnerships')->where('country_id', $this->getCurrentCountry());
        })->first();
    }

}
