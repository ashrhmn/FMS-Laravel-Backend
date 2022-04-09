<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightManagerAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//=========Admin Start========//



//=========Admin End=========//

//=========Flight-Manager Start========//
//Aircraft CRUD
Route::get('/aircraft/all',[FlightManagerAPIController::class,'getAllAircraft']);
Route::get('/aircraft/{id}',[FlightManagerAPIController::class,'getAircraft']);
Route::post('/aircraft/create',[FlightManagerAPIController::class,'createAircraftSubmit']);
Route::post('/aircraft/edit',[FlightManagerAPIController::class,'editAircraftSubmit']);
Route::get('/aircraft/delete/{id}',[FlightManagerAPIController::class,'deleteAircraft']);
//Schedule CRUD
Route::get('/schedule/all',[FlightManagerAPIController::class,'getAllSchedule']);
Route::get('/schedule/{id}',[FlightManagerAPIController::class,'getSchedule']);
Route::post('schedule/create',[FlightManagerAPIController::class,'createScheduleSubmit']);
Route::post('/schedule/edit',[FlightManagerAPIController::class,'editScheduleSubmit']);
Route::get('/schedule/delete/{id}',[FlightManagerAPIController::class,'deleteSchedule']);
//Profile RUD
Route::get('/profile/{id}',[FlightManagerAPIController::class,'getProfileInfo']);
Route::post('/profile/edit',[FlightManagerAPIController::class,'editProfile']);
Route::get('/profile/delete/{id}',[FlightManagerAPIController::class,'deleteAccount']);
//=========Flight-Manager End=========//

//=========User Start========//



//=========User End=========//

//=========Manager Start========//



//=========Manager End=========//







