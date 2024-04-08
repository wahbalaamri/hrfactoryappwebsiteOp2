<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Countries;
use App\Models\FocalPoints;
use App\Models\Partnerships;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    //registerNewClient
    function registerNewClient(Request $request)
    {
        //validate request
        //validate company name english
        // $request->validate([
        //     'company_name_en' => 'required|string|max:255',
        //     'company_name_ar' => 'required|string|max:255',
        //     'phone' => 'required|string|max:255',
        //     'company_country' => 'required|integer',
        //     'company_sector' => 'required|integer',
        //     'company_size' => 'required|integer',
        //     'focal_name' => 'required|string|max:255',
        //     'focal_email' => 'required|string|max:255',
        //     'focal_phone' => 'required|string|max:255',
        //     'password' => 'required|string|min:8',
        // ]);
        //check if the user is already registered
        $user = User::where('email', $request->focal_email)->first();
        if ($user) {
            //return back with error message
            return back()->with('fail', 'You are already registered');
        } else {
            //check if logo_path has file
            if ($request->hasFile('logo_path')) {
                $file = $request->file('logo_path');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/companies/logos/', $filename);
            } else {
                $filename = 'default.png';
            }
            // get current client country using API https://extreme-ip-lookup.com/json/?key=sswCYj3OKfeIuxY1C3Bd
            $client_ip = request()->ip();
            $client_country = file_get_contents("https://extreme-ip-lookup.com/json/?key=sswCYj3OKfeIuxY1C3Bd");
            $client_country = json_decode($client_country);
            $countryCode = $client_country->countryCode;
            //find the country from countries table
            $country = Countries::where('country_code', $countryCode)->first();
            // get partner id from partnerships table
            $partnership = Partnerships::where('country_id', $country->id)->first();
            //create new Client
            $newClient = new Clients();
            $newClient->name = $request->company_name_en;
            $newClient->name_ar = $request->company_name_ar;
            $newClient->country = $request->company_country;
            $newClient->industry = $request->company_sector;
            $newClient->client_size = $request->company_size;
            $newClient->phone = $request->phone;
            $newClient->logo_path = $filename;
            $newClient->webiste = $request->website;
            $newClient->partner_id = $partnership == null ? null : $partnership->partner_id;
            $newClient->save();
            //create new user
            $newUser = new User();
            $newUser->name = $request->focal_name;
            $newUser->email = $request->focal_email;
            $newUser->password = Hash::make($request->password);
            $newUser->client_id = $newClient->id;
            //user_type
            $newUser->user_type = "client";
            //is_active
            $newUser->is_active = true;
            //phone
            $newUser->phone = $request->focal_phone;
            $newUser->save();
            //create new focal point
            $newFocal = new FocalPoints();
            $newFocal->name = $request->focal_name;
            $newFocal->email = $request->focal_email;
            $newFocal->phone = $request->focal_phone;
            $newFocal->client_id = $newClient->id;
            $newFocal->is_active = true;
            $newFocal->save();
            //redirect to login page with success message
            return redirect('/login')->with('success', 'You are registered successfully');
        }
    }
}
