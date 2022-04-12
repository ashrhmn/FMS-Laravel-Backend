<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerAPIController;

use App\Http\Controllers\AdminAPIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightManagerAPIController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\UserDashboardController;

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


//user Crud
Route::get('/admin/userlist', [AdminAPIController::class, 'userlist']);
Route::post('/admin/add', [AdminAPIController::class, 'adduser']);
Route::post('/admin/edit/{id}', [AdminAPIController::class, 'edituser']);
Route::delete('/admin/delete/{id}', [AdminAPIController::class, 'deleteuser']);
Route::post('/admin/search', [AdminAPIController::class, 'searchuser']);
//admin profile
Route::get('/admin/profile', [AdminAPIController::class, 'adminprofile']);
Route::post('/admin/editProfile', [AdminAPIController::class, 'admineditProfile']);
//Manager Crud
Route::get('/admin/managerlist', [AdminAPIController::class, 'managerlist']);
Route::post('/admin/addmanager', [AdminAPIController::class, 'addmanager']);
Route::post('/admin/editmanager/{id}', [AdminAPIController::class, 'editmanager']);
Route::delete('/admin/deletemanager/{id}', [AdminAPIController::class, 'deletemanager']);
Route::post('/admin/searchmanager', [AdminAPIController::class, 'searchmanager']);
//flightmanager Crud
Route::get('/admin/flightmanagerlist', [AdminAPIController::class, 'flightmanagerlist']);
Route::post('/admin/addflightmanager', [AdminAPIController::class, 'addflightmanager']);
Route::post('/admin/editflightmanager/{id}', [AdminAPIController::class, 'editflightmanager']);
Route::delete('/admin/deleteflightmanager/{id}', [AdminAPIController::class, 'deleteflightmanager']);
Route::post('/admin/searchflightmanager', [AdminAPIController::class, 'searchflightmanager']);




//=========Admin End=========//



//=========User Start========//

//=========Auth Start=========//

Route::post('/auth/sign-in', [AuthController::class, 'signIn']);
Route::post('/auth/sign-up', [AuthController::class, 'signUp']);
Route::get('/auth/current-user', [AuthController::class, 'currentUser']);

//=========Auth End========//


Route::get('/users/', [UserApiController::class, 'getAll']);
Route::get('/users/{id}', [UserApiController::class, 'getOne']);
Route::post('/users/', [UserApiController::class, 'addOne']);
Route::put('/users/', [UserApiController::class, 'updateOne']);
Route::delete('/users/{id}', [UserApiController::class, 'deleteOne']);

Route::get('/userdb/flights', [UserDashboardController::class, 'getFlightList']);


//=========User End=========//



//=========Flight-Manager Start========//

Route::get('/aircraft/all', [FlightManagerAPIController::class, 'getAllAircraft']);
Route::get('/aircraft/{id}', [FlightManagerAPIController::class, 'getAircraft']);
Route::post('/aircraft/create', [FlightManagerAPIController::class, 'createAircraftSubmit']);
Route::post('/aircraft/edit', [FlightManagerAPIController::class, 'editAircraftSubmit']);
Route::get('/aircraft/delete/{id}', [FlightManagerAPIController::class, 'deleteAircraft']);

Route::get('/schedule/all', [FlightManagerAPIController::class, 'getAllSchedule']);
Route::get('/schedule/{id}', [FlightManagerAPIController::class, 'getSchedule']);
Route::post('schedule/create', [FlightManagerAPIController::class, 'createScheduleSubmit']);
Route::post('/schedule/edit', [FlightManagerAPIController::class, 'editScheduleSubmit']);
Route::get('/schedule/delete/{id}', [FlightManagerAPIController::class, 'deleteSchedule']);

Route::get('/profile/{id}', [FlightManagerAPIController::class, 'getProfileInfo']);
Route::post('/profile/edit', [FlightManagerAPIController::class, 'editProfile']);
Route::get('/profile/delete/{id}', [FlightManagerAPIController::class, 'deleteAccount']);

Route::get('/stopage/all', [FlightManagerAPIController::class, 'getAllStopage']);
Route::get('/stopage/{id}', [FlightManagerAPIController::class, 'getStopage']);
Route::post('/stopage/create', [FlightManagerAPIController::class, 'createStopageSubmit']);
Route::post('/stopage/edit', [FlightManagerAPIController::class, 'editStopageSubmit']);
Route::get('/stopage/delete/{id}', [FlightManagerAPIController::class, 'deleteStopage']);

Route::post('/aircraft/search', [FlightManagerAPIController::class, 'flightSearch']);
Route::get('/scheduledaircraft', [FlightManagerAPIController::class, 'scheduledAircrafts']);
//=========Flight-Manager End=========//

//=========User Start========//



//=========User End=========//

//=========Manager Start========//
Route::get('/manager/profile', [ManagerAPIController::class, 'profile']);
Route::get('/manager/changepass', [ManagerAPIController::class, 'changepass']);
Route::get('/manager/userlist', [ManagerAPIController::class, 'userlist']);
Route::get('/manager/flightmanagerlist', [ManagerAPIController::class, 'flightmanagerlist']);
Route::get('/manager/userdetails/{id}', [ManagerAPIController::class, 'userdetails']);
Route::get('/manager/userticketlist/{id}', [ManagerAPIController::class, 'userticketlist']);
Route::get('/manager/ticketdetails/{id}', [ManagerAPIController::class, 'ticketdetails']);
Route::get('/manager/flightlist', [ManagerAPIController::class, 'flightlist']);
Route::get('/manager/flightdetails/{id}', [ManagerAPIController::class, 'flightdetails']);
Route::get('/manager/cancelticket/{u_id}/{t_id}', [ManagerAPIController::class, 'cancelticket']);
Route::get('/manager/deleteflight/{id}/{fid}', [ManagerAPIController::class, 'deleteflight']);
Route::get('/manager/transportlist', [ManagerAPIController::class, 'transportlist']);


Route::post('/manager/editProfile', [ManagerAPIController::class, 'editProfile']);
Route::post('/manager/changepass', [ManagerAPIController::class, 'changepassSubmit']);
Route::post('/manager/edituserdetails', [ManagerAPIController::class, 'edituserdetails']);
Route::post('/manager/userlistSearch', [ManagerAPIController::class, 'userlistSearch']);
Route::post('/manager/editticket', [ManagerAPIController::class, 'editticket']);
Route::post('/manager/bookticket', [ManagerAPIController::class, 'bookticket']);
Route::post('/manager/flightSearch', [ManagerAPIController::class, 'flightSearch']);
Route::post('/manager/flightManagerSearch', [ManagerAPIController::class, 'flightManagerSearch']);



//=========Manager End=========//
