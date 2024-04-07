<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MigrationConrtoller;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ServiceApproachesController;
use App\Http\Controllers\ServiceFeaturesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name("Home");
Route::get('/about-us', [HomeController::class, 'aboutus'])->name("Home.about-us");
Route::get('/profile', [HomeController::class, 'profile'])->name("Home.profile");
Route::get('/training', [TrainingController::class, 'index'])->name("Training");
//start up plan
Route::get('/startup', [PlansController::class, 'startup'])->name("Plans.startup");
Route::get('/manualBuilder', [PlansController::class, 'manualBuilder'])->name("Plans.manualBuilder");
Route::get('/client/startup', [PlansController::class, 'Clientstartup'])->name("Client.startup")->middleware('auth');
Route::get('/client/manualBuilder', [PlansController::class, 'ClientmanualBuilder'])->name("Client.manualBuilder")->middleware('auth');
Route::get('/SectionPlans', [PlansController::class, 'SectionPlans'])->name("Plans.SectionPlans");
Route::get('/checkout/{plan}/{Period}/{Amount}', [PlansController::class, 'checkout'])->name("Plans.checkout");
Route::get('/thawani', [PlansController::class, 'thawani'])->name("Plans.thawani");
Route::get('/payTabs', [PlansController::class, 'payTabs'])->name("Plans.payTabs");
Route::get('/CheckUser', [HomeController::class, 'CheckUser'])->name("CheckUser");
Route::get('/setupUsrPlans', [HomeController::class, 'setupUsrPlans'])->name("setupUsrPlans");
Route::get('/MigrateUsersOldSections', [MigrationConrtoller::class, 'MigrateUsersOldSections'])->name("MigrateUsersOldSections");
Route::get('/sections/editSec/{id}', [SectionsController::class, 'EditSe'])->name('sections.editSec');
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth:web');
Route::get('/client/dashboard', [HomeController::class, 'client'])->name('client.dashboard')->middleware('auth:web');
Route::post('Coupons/getCouponRate', [CouponsController::class, 'getCouponRate'])->name('coupon.getCouponRate');
Route::get('tools/view/{id}',[HomeController::class,'viewTool'])->name('tools.view');
Route::post('register/newclient', [RegisterController::class, 'registerNewClient'])->name('register.newclient');
Route::get('lang/{locale}', function () {
    session()->put('locale', request()->locale);
    return redirect()->back();
})->name('lang.swap');

//group routes for admin
Route::group(['middleware' => ['auth:web'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
/*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                                  SERVICE ROUTES START                                          =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
  Route::resource('services',ServicesController::class);
/*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                                  SERVICE ROUTES END                                            =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
/*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                         SERVICE FEATURES ROUTES START                                          =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    Route::resource('service-features',ServiceFeaturesController::class);
/*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                         SERVICE FEATURES ROUTES END                                            =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
/*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE APPROACHES ROUTES START                                         =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    Route::resource('service-approaches',ServiceApproachesController::class);
/*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE APPROACHES ROUTES END                                           =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
/*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE PLANS ROUTES START                                              =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    Route::get('service-plans/create/{id}',[PlansController::class,'create'])->name('service-plans.create');
    Route::post('service-plans/store/{id}',[PlansController::class,'store'])->name('service-plans.store');
    Route::get('service-plans/show/{id}',[PlansController::class,'show'])->name('service-plans.show');
/*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE PLANS ROUTES END                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
});
//group routes for client

