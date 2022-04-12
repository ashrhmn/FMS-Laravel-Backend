<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User; 
use App\Models\PurchasedTicket;
use App\Models\Stopage;
use App\Models\SeatInfo;
use App\Models\Transport;
use App\Models\TransportSchedule;

class ManagerAPIController extends Controller
{
    //
    public function __construct(){
        $this->user_id = 36;
    }

    public function profile(){
        $user = User::where('id',$this->user_id)
                ->select('name','username','date_of_birth','email','phone','address')->first();

        return $user;
    }

    public function editProfile(Request $req){
        $rules = array(
            'name' => "required",
            'email' => "required|email",
            'phone' => "required|regex:/(01)[0-9]{9}/",
            'date_of_birth' => "required",
            'address' => "required"
        );
        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            return $validator->errors();
        }

        $user = User::where('id', $this->user_id)->first();
        if($user){
            $user->name = $req->name;
            $user->email = $req->email;
            $user->phone = $req->phone;
            $user->date_of_birth = $req->date_of_birth;
            $user->address = $req->address;

            $user->save();
            return response()->json(["msg"=>"Profile Updated Successfully","value"=>$user],200);
        }
        return response()->json(["msg"=>"Profile Not Updated","value"=>$user],200);
    }

    public function changepass(Request $req){
        $user = User::where('id', '=', $this->user_id)
            ->select('id', 'name')
            ->first();

        return response()->json([
                                "id" => $user->id,
                                "name" => $user->name,
                            ],200);
    }

    public function changepassSubmit(Request $req){

        $rules = array(
            'oldpass' => 'min:4',
            'password' => 'min:4',
            'conpass' => 'min:4|same:password'
        );
        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            return $validator->errors();
        }


        if($req->password == $req->conpass){
            $users = User::where('id', $this->user_id)
            ->where('password', md5($req->oldpass))
            ->first();

            if ($users) {
                $user = User::where('id', $this->user_id)
                    ->update(['password' => md5($req->password)]);

                return response()->json(["msg"=>"Password Changed Successfully"],200);
            }
            else{
                return response()->json(["msg"=>"Old Password is Wrong"],200);

            }

        }
        else{
            return response()->json(["msg"=>"Confirm Password & New Password Not Matched"],200);
        }
        
    }

    public function userlist(){
        $users = User::where('role', 'User')
                ->select('id','name','username','date_of_birth','email','phone','address')->get();
        //$stopage = Stopage::all();
        return $users;
    }
    public function flightmanagerlist(){
        $users = User::where('role', 'FlightManager')
                ->select('id','name','username','date_of_birth','email','phone','address')->get();
        //$stopage = Stopage::all();
        return $users;
    }

    public function flightManagerSearch(Request $req){
        if($req->uname != ""){
            $users = User::where('role', 'FlightManager')
                    ->where('username','like','%'.$req->uname.'%')
                    ->get();
            return $users;
        }
        else{
            $users = User::where('role', 'FlightManager')->get();
            return $users;
        }
        
    }

    public function userdetails(Request $req){
        $user = User::where('id', '=', $req->id)
        ->select('id','name','username','date_of_birth','email','phone','address','role')->first();
        return $user;
    }

    public function edituserdetails(Request $req){

        $rules = array(
            'id' => 'required',
            'name' => 'required',
            'email' => "required|email",
            'phone' => "required|regex:/(01)[0-9]{9}/",
            'date_of_birth' => "required",
            'address' => "required",
            'role' => "required"
        );
        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            return $validator->errors();
        }

        $user = User::where('id', $req->id)
        ->select('id','name','username','date_of_birth','email','phone','address','role')->first();
        if($user){
            $user->name = $req->name;
            $user->email = $req->email;
            $user->phone = $req->phone;
            $user->date_of_birth = $req->date_of_birth;
            $user->address = $req->address;
            $user->role = $req->role;

            $user->save();
            return response()->json(["msg"=>"User Details Updated Successfully","value"=>$user],200);
        }
        return response()->json(["msg"=>"User Details Not Updated","value"=>$user],200);
    }

    public function userlistSearch(Request $req){
        if ($req->booked != 'yes') {
            $users = User::where('role', 'User')
                    ->select('id','name','username','date_of_birth','email','phone','address')->get();
            //$stopage = Stopage::all();
            return $users;
        }
        elseif ($req->booked == 'yes' && $req->fromstopage == null && $req->tostopage == null) {
            //$purchaseduser = PurchasedTicket::distinct()->get(['purchased_by']);
            //$users = User::with('purchasedtickets')->get();
            //$users = $purchaseduser->user;
            $tickets = PurchasedTicket::all();
            if(count($tickets) != 0){
                $users = array();
                foreach ($tickets as $ticket) {
                    if (!in_array($ticket->user, $users)) {
                        array_push($users, $ticket->user);
                    }
                }
                //$stopage = Stopage::all();
                return $users;
            }
            return response()->json(["msg"=>"No User Found"],200);
        } 
        elseif ($req->booked == 'yes' && $req->fromstopage != null && $req->tostopage == null) {
            $from = Stopage::where('name','=', $req->fromstopage)->select('id')->first();
            if($from){
                $tickets = PurchasedTicket::where('from_stopage_id', '=', $from->id)->get();
                if(count($tickets) != 0){
                    $users = array();
    
                    foreach ($tickets as $ticket) {
                        if (!in_array($ticket->user, $users)) {
                            array_push($users, $ticket->user);
                        }
                    }
                    //$stopage = Stopage::all();
                    return $users;
                } 
                return response()->json(["msg"=>"No User Found"],200);
            }
            return response()->json(["msg"=>"No User Found"],200); 
        } 
        elseif ($req->booked == 'yes' && $req->fromstopage == null && $req->tostopage != null) {
            $to = Stopage::where('name','=', $req->tostopage)->select('id')->first();
            if($to){
                $tickets = PurchasedTicket::where('to_stopage_id', '=', $to->id)->get();
                if(count($tickets) != 0){
                    $users = array();

                    foreach ($tickets as $ticket) {
                        if (!in_array($ticket->user, $users)) {
                            array_push($users, $ticket->user);
                        }
                    }
                    //$stopage = Stopage::all();
                    return $users;
                }
                return response()->json(["msg"=>"No User Found"],200);
            }
            return response()->json(["msg"=>"No User Found"],200);
        } 
        elseif ($req->booked == 'yes' && $req->fromstopage != null && $req->tostopage != null) {
            $from = Stopage::where('name','=', $req->fromstopage)->select('id')->first();
            $to = Stopage::where('name','=', $req->tostopage)->select('id')->first();
            if($from != null && $to != null){
                $tickets = PurchasedTicket::where('from_stopage_id', '=', $from->id)
                ->where('to_stopage_id', '=', $to->id)->get();
                if(count($tickets) != 0){
                    $users = array();

                    foreach ($tickets as $ticket) {
                        if (!in_array($ticket->user, $users)) {
                            array_push($users, $ticket->user);
                        }
                    }
                    //$stopage = Stopage::all();
                    return $users;
                } 
                return response()->json(["msg"=>"No User Found"],200);   
            }
            return response()->json(["msg"=>"No User Found"],200);
            
        }
    }

    public function userticketlist(Request $req){
        $user = User::where('id', $req->id)->first();

        $tickets = PurchasedTicket::where('purchased_by', $user->id)->get();
        if(count($tickets) != 0){
            $tkts = [];
            foreach($tickets as $ticket){
                
                $tkt =[
                    "ticket_id" => $ticket->id,
                    "fromStopage" => $ticket->fromstopage->name,
                    "toStopage" => $ticket->tostopage->name,
                ];
                array_push($tkts, $tkt);
            }

            return response()->json([
                                       "id" => $user->id,
                                       "name" => $user->name,
                                       "username" => $user->username,
                                       "email" => $user->email,
                                       "phone" => $user->phone,
                                       "ticket_list" => $tkts
                                    ]);
            
        }
        return response()->json([
                                "id" => $user->id,
                                "name" => $user->name,
                                "username" => $user->username,
                                "email" => $user->email,
                                "phone" => $user->phone,
                                "ticket_list" => "Ticket Not Booked Yet"
                            ]);
    }

    public function ticketdetails(Request $req){
        
        $ticket= PurchasedTicket::where('id', $req->id)->first();
        //return $ticket->id;
        //$sts = SeatInfo::where('ticket_id', $ticket->id)->get();
        
        $seats = [];
        foreach($ticket->seatinfos as $st){
            //return $st->id;
            $seat = [
                "seat_id" => $st->id,
                "flight_name" => $st->transport->name,
                "flight_time" => $st->start_time,
                "seat_class" => $st->seat_class,
                "age_class" => $st->age_class
            ];

            array_push($seats, $seat);

        }
        return response()->json([
                                    "ticket_id" => $ticket->id,
                                    "fromStopage" => $ticket->fromstopage->name,
                                    "from_stopage_city"=> $ticket->fromstopage->city->name,
                                    "from_stopage_country"=> $ticket->fromstopage->city->country,
                                    "toStopage" => $ticket->tostopage->name,
                                    "to_stopage_city"=> $ticket->tostopage->city->name,
                                    "to_stopage_country"=> $ticket->tostopage->city->country,
                                    "purchased by" => $ticket->user->name,
                                    "seat_flight_details" => $seats
                                    
                                ]);

    }

    public function flightlist(){
        $flights = TransportSchedule::all();
        
        if(count($flights) !=0){
            
            $flts =[];
            foreach($flights as $flight){
                $trans = Transport::where("id", $flight->transport_id)->first();
                $seats = SeatInfo::where('transport_id',$trans->id)
                                 ->where('start_time',$flight->start_time)
                                 ->where('status','Booked')->get();
                $available_seat = $trans->maximum_seat - count($seats);
                $flt =[
                        "flight_id"=> $flight->id,
                        "flight_name"=> $trans->name,
                        "transport_id" => $trans->id,
                        "from_stopage"=> $flight->fromstopage->name,
                        "from_stopage_city"=> $flight->fromstopage->city->name,
                        "from_stopage_country"=> $flight->fromstopage->city->country,
                        "to_stopage"=> $flight->tostopage->name,
                        "to_stopage_city"=> $flight->tostopage->city->name,
                        "to_stopage_country"=> $flight->tostopage->city->country,
                        "flight_time" => $flight->start_time,
                        "flight_day"=> $flight->day,
                        "maximum_seat" => $trans->maximum_seat,
                        "available_seat"=> $available_seat
                    ];
                    array_push($flts, $flt);
                
            } 

            return $flts;
        }
        return reponse()->json(["msg" => "No flight Available"],200);
    }

    public function flightdetails(Request $req){
        
        $flight = TransportSchedule::where('id',$req->id)->first();
        
        if($flight){
            
            $trans = Transport::where('id', $flight->transport_id)->first();
            
            $seats = SeatInfo::where('transport_id',$trans->id)
                                ->where('start_time',$flight->start_time)
                                ->where('status','Booked')->get();
            $available_seat = $trans->maximum_seat - count($seats);
            
            $fromstopage = Stopage::where('id', $flight->from_stopage_id)->first();
            $tostopage = Stopage::where('id', $flight->to_stopage_id)->first();
            
            $route = abs(($fromstopage->fare_from_root) - ($tostopage->fare_from_root));
            //return $route;
            $economy_price = $route * 1000;
            $peconomy_price = $route * 1200;
            $business_price = $route * 1500;

            $flt =[
                    "flight_id"=> $flight->id,
                    "flight_name"=> $trans->name,
                    "transport_id" => $trans->id,
                    "from_stopage"=> $flight->fromstopage->name,
                    "from_stopage_city"=> $flight->fromstopage->city->name,
                    "from_stopage_country"=> $flight->fromstopage->city->country,
                    "to_stopage"=> $flight->tostopage->name,
                    "to_stopage_city"=> $flight->tostopage->city->name,
                    "to_stopage_country"=> $flight->tostopage->city->country,
                    "flight_time" => $flight->start_time,
                    "flight_day"=> $flight->day,
                    "maximum_seat" => $trans->maximum_seat,
                    "available_seat"=> $available_seat,
                    "economy_ticket_price" => $economy_price,
                    "premium_economy_ticket_price" => $peconomy_price,
                    "business_ticket_price" => $business_price
                ];

            return $flt;
        }
        return reponse()->json(["msg" => "No flight Available"],200);
    }

    public function deleteflight(Request $req){

        $flight = Transport::where('id', '=', $req->fid)->first();
        $schedules= TransportSchedule::where('transport_id','=',$req->fid)->get();

        $booked = SeatInfo::where('transport_id', '=', $req->fid)
            ->where('status', 'Booked')
            ->get();
        
        $available_seat = (($flight->maximum_seat) - (count($booked)));
        if($available_seat == $flight->maximum_seat){
            $deleteticket = TransportSchedule::where('id', '=', $req->id)->delete();
            
            return response()->json(["msg"=> "Flight Schedule cancelled Successfully"]);
        }
        else{
            
            return response()->json(["msg"=> "Flight Schedule cannot be cancelled"]);
        }
    }

    public function editticket(Request $req){

        $rules = array(
            'id' => 'required',
            'seat_class' => 'required',
            'age_class' => "required"
        );
        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            return $validator->errors();
        }

        $ticket = PurchasedTicket::where('id',$req->id)->first();
        $seats = SeatInfo::where('ticket_id',$ticket->id)->get();
        
        if(count($seats) != 0){
            foreach($seats as $seat){
                $extra_price = 0;
                if($req->seat_class == "Economy" && $seat->seat_class != "Economy"){
                    if($seat->seat_class = "Premium Economy"){
                        $extra_price = $extra_price -1000;
                    }
                    else{
                        $extra_price = $extra_price - 2000;
                    }
                }
                elseif($req->seat_class == "Premium Economy" && $seat->seat_class != "Premium Economy"){
                    if($seat->seat_class = "Economy"){
                        $extra_price = $extra_price + 1000;
                    }
                    else{
                        $extra_price = $extra_price -1000;
                    }
                }
                elseif($req->seat_class == "Business" && $seat->seat_class != "Business"){
                    if($seat->seat_class = "Premium Economy"){
                        $extra_price = $extra_price + 1000;
                    }
                    else{
                        $extra_price = $extra_price + 2000;
                    }
                }

                $seat->seat_class = $req->seat_class;
                $seat->age_class = $req->age_class;

                $seat->save();

                if($extra_price < 0){
                    $extra_price = abs($extra_price);
                    return response()->json(["msg" => "Ticket Updated Successfully","msg1"=>"Customer will get $extra_price TK"],200);
                }
                else{
                    return response()->json(["msg" => "Ticket Updated Successfully","msg1"=> "Customer have to pay extra $extra_price tk"]);
                }
        
            }
            //return response()->json(["msg" => "Ticket Updated Successfully"]);
        }
        return response()->json(["msg" => "Ticket Not Updated"]);

    }

    public function pendingcancellist(){
        $seatss = SeatInfo::where('status', 'Cancel-Pending')->get();
        if(count($seatss) !=0){
            $seats = [];
            foreach($seatss as $sts){
                
                $ticket= PurchasedTicket::where('id', $sts->ticket_id)->first();
                //return $ticket->id;
                //$sts = SeatInfo::where('ticket_id', $ticket->id)->get();
                foreach($ticket->seatinfos as $st){
                    
                    $seat = [
                        "ticket_id" => $ticket->id,
                        "fromStopage" => $ticket->fromstopage->name,
                        "from_stopage_city"=> $ticket->fromstopage->city->name,
                        "from_stopage_country"=> $ticket->fromstopage->city->country,
                        "toStopage" => $ticket->tostopage->name,
                        "to_stopage_city"=> $ticket->tostopage->city->name,
                        "to_stopage_country"=> $ticket->tostopage->city->country,
                        "purchased by" => $ticket->user->name,
                        "seat_id" => $st->id,
                        "flight_name" => $st->transport->name,
                        "flight_time" => $st->start_time,
                        "seat_class" => $st->seat_class,
                        "age_class" => $st->age_class,
                        "Ticket_Status" => $st->status
                    ];
                    
                    array_push($seats, $seat);

                }
                

            }
            return $seats;
        }
        return response()->json(["msg" => "No Pending Cancel Tickets"]);
    }

    public function cancelpendingticket(Request $req){
        $ticket = PurchasedTicket::where('id','=',$req->id)->first();
        if($ticket){
            $deleteticket = PurchasedTicket::where('id', '=', $ticket->id)->delete();

            return response()->json(["msh"=> "Ticket cancelled Successfully"],200);
        }
        return response()->json(["msh"=> "Ticket not found"],200);

    }

    public function cancelticket(Request $req){
        $ticketcount = PurchasedTicket::where('purchased_by','=',$req->u_id)->count();
        if ($ticketcount <= 1) {

            return response()->json(["msh"=> "Ticket cannot be canceled"],200);
        } 
        else {
            $deleteticket = PurchasedTicket::where('id', '=', $req->t_id)->delete();

            return response()->json(["msh"=> "Ticket cancelled Successfully"],200);
        }
    }


    public function bookflightticket(Request $req){

        $rules = array(
            'user_id' => 'required',
            'flight_id' => 'required',
            'age_class' => 'required',
            'seat_class'=> 'required'

        );
        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            return $validator->errors();
        }

        $user = User::where('id',$req->user_id)->first();
        if($user){
            $flight = TransportSchedule::where('id',$req->flight_id)->first();
            if($flight){
                $ticket = new PurchasedTicket();
                $ticket->from_stopage_id = $flight->from_stopage_id;
                $ticket->to_stopage_id = $flight->to_stopage_id;
                $ticket->purchased_by = $req->user_id;
                $ticket->save();

                $seat = new SeatInfo();
                $seat->start_time = $flight->start_time;
                $seat->ticket_id = $ticket->id;
                $seat->transport_id = $flight->transport_id;
                $seat->age_class = $req->age_class;
                $seat->seat_class = $req->seat_class;
                $seat->status = "Booked";
                $seat->save();

                return response()->json(["msg" => "Ticket Booked Successfully"],200);
            }
            return response()->json(["msg" => "Flight Not Found"],200);
        }
        return response()->json(["msg" => "User Not Found"],200);

    }


    public function bookticket(Request $req){

        $rules = array(
            'user_id' => 'required',
            'transport_id' => 'required',
            'from_stopage' => 'required',
            'to_stopage' => 'required',
            'flight_time' => 'required',
            'age_class' => 'required',
            'seat_class'=> 'required'

        );
        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            return $validator->errors();
        }

        $fromstopage = Stopage::where('name','=', $req->from_stopage)->select('id')->first();
        $tostopage = Stopage::where('name','=', $req->to_stopage)->select('id')->first();

        $ticket = new PurchasedTicket();
        $ticket->from_stopage_id = $fromstopage->id;
        $ticket->to_stopage_id = $tostopage->id;
        $ticket->purchased_by = $req->user_id;
        $ticket->save();

        $seat = new SeatInfo();
        $seat->start_time = $req->flight_time;
        $seat->ticket_id = $ticket->id;
        $seat->transport_id = $req->transport_id;
        $seat->age_class = $req->age_class;
        $seat->seat_class = $req->seat_class;
        $seat->status = "Booked";
        $seat->save();

        return response()->json(["msg" => "Ticket Booked Successfully"],200);

    }

    public function transportlist(){

        $trans = Transport::all();
        if(count($trans) != 0){
            $ts = [];
            foreach($trans as $tr){
                $creator = User::where('id', $tr->created_by)->first();
                $flights = TransportSchedule::where('transport_id', $tr->id)->get();

                if(count($flights) != 0){
                    foreach($flights as $flight){

                        $f = [
                            "id"=> $flight->id,
                            "from_stopage_id"=> $flight->fromstopage->name,
                            "to_stopage_id"=> $flight->tostopage->name,
                            "day"=> $flight->day,
                            "time"=> $flight->time,
                            "start_time"=> $flight->start_time,
                        ];


                        $t = [
                            "transport_id" => $tr->id,
                            "Transport_name" => $tr->name,
                            "maximum_seat" => $tr->maximum_seat,
                            "created_by" => $creator->username,
                            "flight_list" => $f,
                        ];
    
                        array_push($ts,$t);
                    }
                }
                else{
                    $t = [
                        "transport_id" => $tr->id,
                        "Transport_name" => $tr->name,
                        "maximum_seat" => $tr->maximum_seat,
                        "created_by" => $creator->username,
                        "flight_list" => "No flights under this transport",
                    ];
    
                    array_push($ts,$t);
                }
                

            }
            return $ts;


        }

    }

    public function flightSearch(Request $req){
        
        $stopage = Stopage::all();
        if($req->fsid != null && $req->tsid == null && $req->date != ""){
            $fromstopage = Stopage::where('id', $req->fsid)->first();
            $transShed = TransportSchedule::where('from_stopage_id', '=', $fromstopage->id)
                    ->get();
            $schedules = [];
            foreach ($transShed as $sched) {
                if ($req->date == date('Y-m-d', strtotime('next ' . $sched->day)) || $req->date == date('Y-m-d', strtotime($sched->day)) || $req->date == date('Y-m-d', strtotime($sched->day . ' next week'))) {
                        
                    $occupiedSeats = SeatInfo::where('transport_id', '=', $sched->transport_id)
                        ->where('status', '=', 'Booked')
                        ->count();
                    $f = Transport::where('id', '=', $sched->transport_id)->first();    
                    $sched->avilableSeats = $f->maximum_seat - $occupiedSeats;

                    $sc = [
                        "id" => $sched->id,
                        "transport_id" => $sched->transport->id,
                        "flight_name" => $sched->transport->name,
                        "from_stopage" => $sched->fromstopage->name,
                        "to_stopage" => $sched->tostopage->name,
                        "day" => $sched->day,
                        "flight_time" => $sched->start_time,
                        "maximum_seat" => $f->maximum_seat,
                        "available_seat" => $sched->avilableSeats
                    ];

                    array_push($schedules,$sc);
                    
                }
                
            }
            return $schedules;


        }
        else if($req->fsid != null && $req->tsid != null && $req->date != ""){
            $fromstopage = Stopage::where('id', $req->fsid)->first();
            $tostopage = Stopage::where('id', $req->tsid)->first();
            $transShed = TransportSchedule::where('from_stopage_id', '=', $fromstopage->id)
                    ->where('to_stopage_id', '=', $tostopage->id)
                    ->get();
            $schedules = [];
            foreach ($transShed as $sched) {
                if ($req->date == date('Y-m-d', strtotime('next ' . $sched->day)) || $req->date == date('Y-m-d', strtotime($sched->day)) || $req->date == date('Y-m-d', strtotime($sched->day . ' next week'))) {
                        
                    $occupiedSeats = SeatInfo::where('transport_id', '=', $sched->transport_id)
                        ->where('status', '=', 'Booked')
                        ->count();
                    $f = Transport::where('id', '=', $sched->transport_id)->first();
                    $sched->avilableSeats = $f->maximum_seat - $occupiedSeats;
                    $sc = [
                        "id" => $sched->id,
                        "transport_id" => $sched->transport->id,
                        "flight_name" => $sched->transport->name,
                        "from_stopage" => $sched->fromstopage->name,
                        "to_stopage" => $sched->tostopage->name,
                        "day" => $sched->day,
                        "flight_time" => $sched->start_time,
                        "maximum_seat" => $f->maximum_seat,
                        "available_seat" => $sched->avilableSeats
                    ];

                    array_push($schedules,$sc);  
                }

            }
            return $schedules;

        }
        else if($req->fsid == null && $req->tsid != null && $req->date != ""){
            $tostopage = Stopage::where('id', $req->tsid)->first();
            $transShed = TransportSchedule::where('to_stopage_id', '=', $tostopage->id)
                    ->get();

            
            foreach ($transShed as $sched) {
                if ($req->date == date('Y-m-d', strtotime('next ' . $sched->day)) || $req->date == date('Y-m-d', strtotime($sched->day)) || $req->date == date('Y-m-d', strtotime($sched->day . ' next week'))) {
                       
                    $occupiedSeats = SeatInfo::where('transport_id', '=', $sched->transport_id)
                        ->where('status', '=', 'Booked')
                        ->count();
                    $f = Transport::where('id', '=', $sched->transport_id)->first();
                    $sched->avilableSeats = $f->maximum_seat - $occupiedSeats;
                    $sc = [
                        "id" => $sched->id,
                        "transport_id" => $sched->transport->id,
                        "flight_name" => $sched->transport->name,
                        "from_stopage" => $sched->fromstopage->name,
                        "to_stopage" => $sched->tostopage->name,
                        "day" => $sched->day,
                        "flight_time" => $sched->start_time,
                        "maximum_seat" => $f->maximum_seat,
                        "available_seat" => $sched->avilableSeats
                    ];

                    array_push($schedules,$sc);    
                }
            }
            return $schedules;
        }
        else {
            $transShed = TransportSchedule::all();
            $schedules = [];
            foreach ($transShed as $s) {
                $occupiedSeats = SeatInfo::where('transport_id', '=', $s->transport_id)
                    ->where('status', '=', 'Booked')
                    ->count();
                $f = Transport::where('id', '=', $s->transport_id)->first();
                $avilableSeats = $f->maximum_seat - $occupiedSeats;
                $s->avilableSeats = $avilableSeats;
                $sc = [
                    "id" => $s->id,
                    "transport_id" => $s->transport->id,
                    "flight_name" => $s->transport->name,
                    "from_stopage" => $s->fromstopage->name,
                    "to_stopage" => $s->tostopage->name,
                    "day" => $s->day,
                    "flight_time" => $s->start_time,
                    "maximum_seat" => $f->maximum_seat,
                    "available_seat" => $s->avilableSeats
                ];

                array_push($schedules,$sc);
               
            }
    
            return $schedules;
        }

    }

}
