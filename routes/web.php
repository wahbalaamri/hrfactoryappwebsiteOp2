<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Leader360ReviewController;
use App\Http\Controllers\ManageEmployeeEngagmentController;
use App\Http\Controllers\ManageHrDiagnosisController;
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
Route::get('tools/view/{id}', [HomeController::class, 'viewTool'])->name('tools.view');
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
    Route::resource('services', ServicesController::class);
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
    Route::resource('service-features', ServiceFeaturesController::class);
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
    Route::resource('service-approaches', ServiceApproachesController::class);
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
    Route::get('service-plans/create/{id}', [PlansController::class, 'create'])->name('service-plans.create');
    Route::post('service-plans/store/{id}', [PlansController::class, 'store'])->name('service-plans.store');
    Route::get('service-plans/show/{id}', [PlansController::class, 'show'])->name('service-plans.show');
    /*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE PLANS ROUTES END                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    /*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE ManageHrDiagnosis ROUTES START                                              =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    Route::get('ManageHrDiagnosis/index', [ManageHrDiagnosisController::class, 'index'])->name('ManageHrDiagnosis.index');
    Route::get('ManageHrDiagnosis/createFunction', [ManageHrDiagnosisController::class, 'createFunction'])->name('ManageHrDiagnosis.createFunction');
    Route::post('ManageHrDiagnosis/storeFunction', [ManageHrDiagnosisController::class, 'storeFunction'])->name('ManageHrDiagnosis.storeFunction');
    Route::get('ManageHrDiagnosis/showPractices/{id}', [ManageHrDiagnosisController::class, 'showPractices'])->name('ManageHrDiagnosis.showPractices');
    Route::get('ManageHrDiagnosis/createPractice/{id}', [ManageHrDiagnosisController::class, 'createPractice'])->name('ManageHrDiagnosis.createPractice');
    Route::post('ManageHrDiagnosis/storePractice/{id}', [ManageHrDiagnosisController::class, 'storePractice'])->name('ManageHrDiagnosis.storePractice');
    Route::get('ManageHrDiagnosis/showQuestions/{id}', [ManageHrDiagnosisController::class, 'showQuestions'])->name('ManageHrDiagnosis.showQuestions');
    Route::get('ManageHrDiagnosis/editPractice/{id}', [ManageHrDiagnosisController::class, 'editPractice'])->name('ManageHrDiagnosis.editPractice');
    Route::delete('ManageHrDiagnosis/destroyPractice/{id}', [ManageHrDiagnosisController::class, 'destroyPractice'])->name('ManageHrDiagnosis.destroyPractice');
    Route::get('ManageHrDiagnosis/editFunction/{id}', [ManageHrDiagnosisController::class, 'editFunction'])->name('ManageHrDiagnosis.editFunction');
    Route::put('ManageHrDiagnosis/updateFunction/{id}', [ManageHrDiagnosisController::class, 'updateFunction'])->name('ManageHrDiagnosis.updateFunction');
    Route::delete('ManageHrDiagnosis/destroyFunction/{id}', [ManageHrDiagnosisController::class, 'destroyFunction'])->name('ManageHrDiagnosis.destroyFunction');
    Route::get('ManageHrDiagnosis/createQuestion/{id}', [ManageHrDiagnosisController::class, 'createQuestion'])->name('ManageHrDiagnosis.createQuestion');
    Route::post('ManageHrDiagnosis/storeQuestion/{id}', [ManageHrDiagnosisController::class, 'storeQuestion'])->name('ManageHrDiagnosis.storeQuestion');
    Route::get('ManageHrDiagnosis/editQuestion/{id}', [ManageHrDiagnosisController::class, 'editQuestion'])->name('ManageHrDiagnosis.editQuestion');
    Route::put('ManageHrDiagnosis/updateQuestion/{id}', [ManageHrDiagnosisController::class, 'updateQuestion'])->name('ManageHrDiagnosis.updateQuestion');
    Route::delete('ManageHrDiagnosis/deleteQuestion/{id}', [ManageHrDiagnosisController::class, 'deleteQuestion'])->name('ManageHrDiagnosis.deleteQuestion');
    Route::put('ManageHrDiagnosis/updatePractice/{id}', [ManageHrDiagnosisController::class, 'updatePractice'])->name('ManageHrDiagnosis.updatePractice');
    /*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE ManageHrDiagnosis ROUTES END                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    /*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE Leader360Review ROUTES START                                              =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    Route::get('Leader360Review/index', [Leader360ReviewController::class, 'index'])->name('Leader360Review.index');
    Route::get('Leader360Review/createFunction', [Leader360ReviewController::class, 'createFunction'])->name('Leader360Review.createFunction');
    Route::post('Leader360Review/storeFunction', [Leader360ReviewController::class, 'storeFunction'])->name('Leader360Review.storeFunction');
    Route::get('Leader360Review/showPractices/{id}', [Leader360ReviewController::class, 'showPractices'])->name('Leader360Review.showPractices');
    Route::get('Leader360Review/createPractice/{id}', [Leader360ReviewController::class, 'createPractice'])->name('Leader360Review.createPractice');
    Route::post('Leader360Review/storePractice/{id}', [Leader360ReviewController::class, 'storePractice'])->name('Leader360Review.storePractice');
    Route::get('Leader360Review/showQuestions/{id}', [Leader360ReviewController::class, 'showQuestions'])->name('Leader360Review.showQuestions');
    Route::get('Leader360Review/editPractice/{id}', [Leader360ReviewController::class, 'editPractice'])->name('Leader360Review.editPractice');
    Route::delete('Leader360Review/destroyPractice/{id}', [Leader360ReviewController::class, 'destroyPractice'])->name('Leader360Review.destroyPractice');
    Route::get('Leader360Review/editFunction/{id}', [Leader360ReviewController::class, 'editFunction'])->name('Leader360Review.editFunction');
    Route::put('Leader360Review/updateFunction/{id}', [Leader360ReviewController::class, 'updateFunction'])->name('Leader360Review.updateFunction');
    Route::delete('Leader360Review/destroyFunction/{id}', [Leader360ReviewController::class, 'destroyFunction'])->name('Leader360Review.destroyFunction');
    Route::get('Leader360Review/createQuestion/{id}', [Leader360ReviewController::class, 'createQuestion'])->name('Leader360Review.createQuestion');
    Route::post('Leader360Review/storeQuestion/{id}', [Leader360ReviewController::class, 'storeQuestion'])->name('Leader360Review.storeQuestion');
    Route::get('Leader360Review/editQuestion/{id}', [Leader360ReviewController::class, 'editQuestion'])->name('Leader360Review.editQuestion');
    Route::put('Leader360Review/updateQuestion/{id}', [Leader360ReviewController::class, 'updateQuestion'])->name('Leader360Review.updateQuestion');
    Route::delete('Leader360Review/deleteQuestion/{id}', [Leader360ReviewController::class, 'deleteQuestion'])->name('Leader360Review.deleteQuestion');
    Route::put('Leader360Review/updatePractice/{id}', [Leader360ReviewController::class, 'updatePractice'])->name('Leader360Review.updatePractice');
    /*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE Leader360Review ROUTES END                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    /*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE EmployeeEngagment ROUTES START                                              =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
    Route::get('EmployeeEngagment/index', [ManageEmployeeEngagmentController::class, 'index'])->name('EmployeeEngagment.index');
    Route::get('EmployeeEngagment/createFunction', [ManageEmployeeEngagmentController::class, 'createFunction'])->name('EmployeeEngagment.createFunction');
    Route::post('EmployeeEngagment/storeFunction', [ManageEmployeeEngagmentController::class, 'storeFunction'])->name('EmployeeEngagment.storeFunction');
    Route::get('EmployeeEngagment/showPractices/{id}', [ManageEmployeeEngagmentController::class, 'showPractices'])->name('EmployeeEngagment.showPractices');
    Route::get('EmployeeEngagment/createPractice/{id}', [ManageEmployeeEngagmentController::class, 'createPractice'])->name('EmployeeEngagment.createPractice');
    Route::post('EmployeeEngagment/storePractice/{id}', [ManageEmployeeEngagmentController::class, 'storePractice'])->name('EmployeeEngagment.storePractice');
    Route::get('EmployeeEngagment/showQuestions/{id}', [ManageEmployeeEngagmentController::class, 'showQuestions'])->name('EmployeeEngagment.showQuestions');
    Route::get('EmployeeEngagment/editPractice/{id}', [ManageEmployeeEngagmentController::class, 'editPractice'])->name('EmployeeEngagment.editPractice');
    Route::delete('EmployeeEngagment/destroyPractice/{id}', [ManageEmployeeEngagmentController::class, 'destroyPractice'])->name('EmployeeEngagment.destroyPractice');
    Route::get('EmployeeEngagment/editFunction/{id}', [ManageEmployeeEngagmentController::class, 'editFunction'])->name('EmployeeEngagment.editFunction');
    Route::put('EmployeeEngagment/updateFunction/{id}', [ManageEmployeeEngagmentController::class, 'updateFunction'])->name('EmployeeEngagment.updateFunction');
    Route::delete('EmployeeEngagment/destroyFunction/{id}', [ManageEmployeeEngagmentController::class, 'destroyFunction'])->name('EmployeeEngagment.destroyFunction');
    Route::get('EmployeeEngagment/createQuestion/{id}', [ManageEmployeeEngagmentController::class, 'createQuestion'])->name('EmployeeEngagment.createQuestion');
    Route::post('EmployeeEngagment/storeQuestion/{id}', [ManageEmployeeEngagmentController::class, 'storeQuestion'])->name('EmployeeEngagment.storeQuestion');
    Route::get('EmployeeEngagment/editQuestion/{id}', [ManageEmployeeEngagmentController::class, 'editQuestion'])->name('EmployeeEngagment.editQuestion');
    Route::put('EmployeeEngagment/updateQuestion/{id}', [ManageEmployeeEngagmentController::class, 'updateQuestion'])->name('EmployeeEngagment.updateQuestion');
    Route::delete('EmployeeEngagment/deleteQuestion/{id}', [ManageEmployeeEngagmentController::class, 'deleteQuestion'])->name('EmployeeEngagment.deleteQuestion');
    Route::put('EmployeeEngagment/updatePractice/{id}', [ManageEmployeeEngagmentController::class, 'updatePractice'])->name('EmployeeEngagment.updatePractice');
    /*==================================================================================================================
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                        SERVICE EmployeeEngagment ROUTES END                                                =
  =                                                                                                                =
  =                                                                                                                =
  =                                                                                                                =
  ==================================================================================================================*/
});
//group routes for client
