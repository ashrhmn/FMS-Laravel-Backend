<?php

namespace App\Http\Controllers;

use App\Models\TransportSchedule;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');
    }
    public function getFlightList()
    {
        $schedules = TransportSchedule::all();
        foreach ($schedules as $schedule) {
            $schedule->transport;
            $schedule->date = gmdate("Y-m-d", strtotime("next " . $schedule->day));
            $schedule->fromstopage->city;
            $schedule->tostopage->city;
        }
        return response($schedules, 200);
    }
}
