<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transport;
use App\Models\TransportSchedule;
use App\Models\User;

class FlightManagerAPIController extends Controller
{
  
    //Aircraft CRUD
    public function getAllAircraft(){
        $transport = Transport::all();
        $aircrafts = array();
        foreach ($transport as $t){
            $at = array
            (
                "Aircraft Id"=> $t->id,
                "Aircraft Name"=>$t->name,
                "Maximum Seats"=>$t->maximum_seat,
                "Created by"=>$t->createdBy->name,
                "Creator Id"=>$t->created_by
            );
            array_push($aircrafts,$at);
        }
        return response()->json($aircrafts,200);
    }
    public function getAircraft(Request $req){
        $t = Transport::where('id',$req->id)->first();
        if($t){
            $at = array
            (
                "Aircraft Id"=> $t->id,
                "Aircraft Name"=>$t->name,
                "Maximum Seats"=>$t->maximum_seat,
                "Created by"=>$t->createdBy->name,
                "Creator Id"=>$t->created_by
            );
            return response()->json($at,200);
        }
        return response()->json(["msg"=>"notfound"],404);
        
    }
    public function createAircraftSubmit(Request $req){
        $transport = new Transport();
        $transport->name = $req->name;
        $transport->maximum_seat = $req->maximum_seat;
        $transport->created_by = $req->created_by;
        $transport->save();
        return response()->json($transport,200);  
    }
    public function editAircraftSubmit(Request $req){
        $transport = Transport::where('id',$req->id)->first();
        if($transport){
            $transport->name = $req->name;
            $transport->maximum_seat = $req->maximum_seat;
            $transport->save();
            return response()->json(["msg"=>"Aircraft Updated","Updated Values"=>$transport],200);
        }
        return response()->json(["msg"=>"Aircraft not found"],404); 
    }
    public function deleteAircraft(Request $req){
        $transport = Transport::where('id',$req->id)->first();
        if($transport){
            $transport->delete();
            return response()->json(["msg"=>"Aircraft deleted"],200);
        }
        return response()->json(["msg"=>"Aircraft not found"],404); 
    }



    //======================= Transport Schedule CRUD ================================



    public function getAllSchedule(){
        $schedule = TransportSchedule::all();
        $schedules = array();
        foreach ($schedule as $s){
            $as = array
            (
                "Schedule Id"=> $s->id,
                "Aircraft Id"=>$s->transport_id,
                "Aircraft Name"=>$s->transport->name,
                "From Airport Name"=>$s->fromstopage->name,
                "From Airport Id"=>$s->from_stopage_id,
                "To Airport Name"=>$s->tostopage->name,
                "To Airport Id"=>$s->to_stopage_id,
                "Day"=>$s->day,
                "Time"=>($s->time)/100
            );
            array_push($schedules,$as);
        }
        return response()->json($schedules,200);
    }
    public function getSchedule(Request $req){
        $s = TransportSchedule::where('id',$req->id)->first();
        if($s){
            $as = array
            (
                "Schedule Id"=> $s->id,
                "Aircraft Id"=>$s->transport_id,
                "Aircraft Name"=>$s->transport->name,
                "From Airport Name"=>$s->fromstopage->name,
                "From Airport Id"=>$s->from_stopage_id,
                "To Airport Name"=>$s->tostopage->name,
                "To Airport Id"=>$s->to_stopage_id,
                "Day"=>$s->day,
                "Time"=>($s->time)/100
            );
            return response()->json($as,200);
        }
        return response()->json(["msg"=>"notfound"],404);
        
    }
    public function createScheduleSubmit(Request $req){
        $schedule = new TransportSchedule();
        $schedule->transport_id = $req->transport_id;
        $schedule->from_stopage_id = $req->from_stopage_id;
        $schedule->to_stopage_id = $req->to_stopage_id;
        $schedule->day = $req->day;
        $schedule->time = $req->time;
        $schedule->save();
        return response()->json($schedule,200);  
    }
    public function editScheduleSubmit(Request $req){
        $schedule = TransportSchedule::where('id',$req->id)->first();
        if($schedule){
            $schedule->transport_id = $req->transport_id;
            $schedule->from_stopage_id = $req->from_stopage_id;
            $schedule->to_stopage_id = $req->to_stopage_id;
            $schedule->day = $req->day;
            $schedule->time = $req->time;
            $schedule->save();
            return response()->json(["msg"=>"Schedule Updated","Updated Values"=>$schedule],200);
        }
        return response()->json(["msg"=>"Schedule not found"],404); 
    }
    public function deleteSchedule(Request $req){
        $schedule = TransportSchedule::where('id',$req->id)->first();
        if($schedule){
            $schedule->delete();
            return response()->json(["msg"=>"Schedule deleted"],200);
        }
        return response()->json(["msg"=>"Schedule not found"],404); 
    }

       //===================Profile RUD===================================
       
    public function getProfileInfo(Request $req){
        $u = User::where('id',$req->id)->first();
        if($u){
            $at = array
            (
                "User Name"=> $u->username,
                "Name"=>$u->name,
                "Date of Birth"=>$u->date_of_birth,
                "Address"=>$u->address,
                "Email"=>$u->email,
                "Phone No"=>$u->phone,
                "role"=>$u->role
            );
            return response()->json($at,200);
        }
        return response()->json(["msg"=>"notfound"],404);
        
    }
    public function editProfile(Request $req){
        $u = User::where('id',$req->id)->first();
        if($u){
            $u->name = $req->name;
            $u->address = $req->address;
            $u->email = $req->email;
            $u->phone = $req->phone;
            $u->save();
            return response()->json(["msg"=>"Profile Updated","Updated Values"=>$u],200);
        }
        return response()->json(["msg"=>"Not found"],404); 
    }
    public function deleteAccount(Request $req){
        $u = User::where('id',$req->id)->first();
        if($u){
            $u->delete();
            return response()->json(["msg"=>"Account deleted"],200);
        }
        return response()->json(["msg"=>"Not found"],404); 
    }
    
}
