<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\EmailVerifyToken;
use App\Models\Transport;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
    public function getTransports()
    {
        $transports = Transport::all();
        foreach ($transports as $transport) {
            $transport->tickets = $transport->seatinfos;
        }
        return response()->json(["data" => $transports, 200]);
    }

    public function getUsers()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->city;
        }
        return response()->json(["data" => $users, 200]);
    }

    public function getCities()
    {
        $cities = City::all();
        foreach ($cities as $city) {
            $city->stopages;
        }
        return response()->json(["data" => $cities, "error" => null], 200);
    }
}
