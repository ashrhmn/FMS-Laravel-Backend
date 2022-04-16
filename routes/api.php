<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerAPIController;
use App\Http\Controllers\AuthAPIController;
use App\Http\Controllers\AdminAPIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightManagerAPIController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AuthFmController;

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
Route::get('/auth/sign-up/cities', [AuthController::class, 'getCities']);

Route::get('/auth/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::get('/auth/resend-verification-mail', [AuthController::class, 'resendVerificationMail']);

Route::post('/auth/send-mail', [AuthController::class, 'sendMail']);

//=========Auth End========//


Route::get('/users/', [UserApiController::class, 'getAll']);
Route::get('/users/{id}', [UserApiController::class, 'getOne']);
Route::post('/users/', [UserApiController::class, 'addOne']);
Route::put('/users/', [UserApiController::class, 'updateOne']);
Route::delete('/users/{id}', [UserApiController::class, 'deleteOne']);

Route::get('/user-db/flights', [UserDashboardController::class, 'getFlightList']);


//=========User End=========//



//=========Flight-Manager Start========//

Route::get('/fm/aircraft/all', [FlightManagerAPIController::class, 'getAllAircraft']);
Route::get('/fm/aircraft/{id}', [FlightManagerAPIController::class, 'getAircraft']);
Route::post('/fm/aircraft/create', [FlightManagerAPIController::class, 'createAircraftSubmit']);
Route::post('/fm/aircraft/edit', [FlightManagerAPIController::class, 'editAircraftSubmit']);
Route::get('/fm/aircraft/delete/{id}', [FlightManagerAPIController::class, 'deleteAircraft']);

Route::get('/fm/schedule/all', [FlightManagerAPIController::class, 'getAllSchedule']);
Route::get('/fm/schedule/{id}', [FlightManagerAPIController::class, 'getSchedule']);
Route::post('/fmschedule/create', [FlightManagerAPIController::class, 'createScheduleSubmit']);
Route::post('/fm/schedule/edit', [FlightManagerAPIController::class, 'editScheduleSubmit']);
Route::get('/fm/schedule/delete/{id}', [FlightManagerAPIController::class, 'deleteSchedule']);

Route::get('/fm/profile/{id}', [FlightManagerAPIController::class, 'getProfileInfo']);
Route::post('/fm/profile/edit', [FlightManagerAPIController::class, 'editProfile']);
Route::get('/fm/profile/delete/{id}', [FlightManagerAPIController::class, 'deleteAccount']);

Route::get('/fm/stopage/all', [FlightManagerAPIController::class, 'getAllStopage']);
Route::get('/fm/stopage/{id}', [FlightManagerAPIController::class, 'getStopage']);
Route::post('/fm/stopage/create', [FlightManagerAPIController::class, 'createStopageSubmit']);
Route::post('/fm/stopage/edit', [FlightManagerAPIController::class, 'editStopageSubmit']);
Route::get('/fm/stopage/delete/{id}', [FlightManagerAPIController::class, 'deleteStopage']);

Route::post('/fm/aircraft/search', [FlightManagerAPIController::class, 'flightSearch']);
Route::get('/fm/scheduledaircraft', [FlightManagerAPIController::class, 'scheduledAircrafts']);
Route::get('/fm/bookedseats/{id}', [FlightManagerAPIController::class, 'bookedSeatsAircraft']);

Route::post('/authfm/registration', [AuthFmController::class, 'registration']);
Route::post('/authfm/login', [AuthFmController::class, 'login']);

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
Route::get('/manager/pendingcancellist', [ManagerAPIController::class, 'pendingcancellist']);
Route::get('/manager/cancelpendingticket/{id}', [ManagerAPIController::class, 'cancelpendingticket']);
Route::get('/manager/deleteflight/{id}/{fid}', [ManagerAPIController::class, 'deleteflight']);
Route::get('/manager/transportlist', [ManagerAPIController::class, 'transportlist']);


Route::post('/manager/editProfile', [ManagerAPIController::class, 'editProfile']);
Route::post('/manager/changepass', [ManagerAPIController::class, 'changepassSubmit']);
Route::post('/manager/edituserdetails', [ManagerAPIController::class, 'edituserdetails']);
Route::post('/manager/userlistSearch', [ManagerAPIController::class, 'userlistSearch']);
Route::post('/manager/editticket', [ManagerAPIController::class, 'editticket']);
Route::post('/manager/bookticket', [ManagerAPIController::class, 'bookticket']);
Route::post('/manager/bookflightticket', [ManagerAPIController::class, 'bookflightticket']);
Route::post('/manager/flightSearch', [ManagerAPIController::class, 'flightSearch']);
Route::post('/manager/flightManagerSearch', [ManagerAPIController::class, 'flightManagerSearch']);



//=========Manager End=========//
Route::post('/auth/registration', [AuthAPIController::class, 'registration']);
Route::post('/auth/login', [AuthAPIController::class, 'login']);
//=========Auth Start=========//



//=========Auth End=========//
