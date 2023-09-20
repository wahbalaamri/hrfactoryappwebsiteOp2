<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrainingController;
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

Route::get('/', [HomeController::class,'index'])->name("Home");
Route::get('/about-us', [HomeController::class,'aboutus'])->name("Home.about-us");
Route::get('/profile', [HomeController::class,'profile'])->name("Home.profile");
Route::get('/training', [TrainingController::class,'index'])->name("Training");
