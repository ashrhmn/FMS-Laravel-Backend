<?php
 

namespace App\Http\Controllers;
ini_set('memory_limit', '3000M');
ini_set('max_execution_time', 180);

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TransportSchedule;
use App\Models\Stopage;
use App\Models\Transport;
use App\Models\SeatInfo;
use App\Models\PurchasedTicket;

class AdminAPIController extends Controller
{

    public function userlist(){


        $user = User::where('role', 'User')
            ->get();
            return response()->json(["msg"=>"User List","Values"=>$user],200);
    }
    //
    public function adduser(Request $req){

     try{
        $add= new User();

        $add->username = $req->username;
        $add->name = $req->name;
        $add->password = md5($req->password);
        $add->date_of_birth = $req->date_of_birth;
        $add->address = $req->address;
        $add->email = $req->email;
        $add->phone = $req->phone;
        $add->role = $req->role;
        if($add->save()){

            return response()->json(["msg"=>"Added Successfully","Values"=>$add],200);

        }
    }
        catch(\Exception $ex){
            return response()->json(["msg"=>"Could not add"],500);
        }
      

    }



    public function edituser(Request $req){
        $edit = User::where('id',$req->id)->first();

        $edit->username = $req->username;
        $edit->name = $req->name;
        //$edit->password = $req->password;
        $edit->date_of_birth = $req->date_of_birth;
        $edit->address = $req->address;
        $edit->email = $req->email;
        $edit->phone = $req->phone;
        $edit->role = $req->role;
       if ($edit->save()){

        return response()->json(["msg"=>"user Updated Successfully","Updated Values"=>$edit],200);

       };
      

    }

    public function deleteuser(Request $req){
       
        $delete = User::where('id',$req->id,)->where('role', 'User')->first();
       
        $delete->delete();
        return response()->json(["msg"=>"User deleted Successfully"],200);

        
        
    }

    public function searchuser(Request $req){


        $sear = User::where('username', 'like', '%' . $req->username . '%')
            ->where('role', 'User')
            ->get();
            if($sear){
                return response()->json(["msg"=>"searching only Users","Values"=>$sear],200);
            }
        
    }

 

    public function __construct(){
        $this->user_id = 37;
    }

    public function adminprofile(){
        $user = User::where('id',$this->user_id)->first();
                // ->select('name','username','date_of_birth','email','phone','address')

            return response()->json(["msg"=>"Admin Profile","Values"=>$user],200);
    }

    public function admineditProfile(Request $req){
        $edit = User::where('id', $this->user_id)->first();

        $edit->username = $req->username;
        $edit->name = $req->name;
        $edit->date_of_birth = $req->date_of_birth;
        $edit->address = $req->address;
        $edit->email = $req->email;
        $edit->phone = $req->phone;
        if($edit->save()){

            return response()->json(["msg"=>"user Updated Successfully","Updated Values"=>$edit],200);
        }
        
    

    }





    public function managerlist(){


        $user = User::where('role', 'Manager')
            ->get();
            return response()->json(["msg"=>"Manager List","Values"=>$user],200);
    }

    public function addmanager(Request $req){


        $add= new User();

        $add->username = $req->username;
        $add->name = $req->name;
        $add->password = md5($req->password);
        $add->date_of_birth = $req->date_of_birth;
        $add->address = $req->address;
        $add->email = $req->email;
        $add->phone = $req->phone;
        $add->role = $req->role;
        if($add->save()){
            return response()->json(["msg"=>"Add Manager Successfully","Values"=>$add],200);


        };
       

    }

    
    public function editmanager(Request $req){


        $edit = User::where('id',$req->id)->first();

        $edit->username = $req->username;
        $edit->name = $req->name;
        //$edit->password = $req->password;
        $edit->date_of_birth = $req->date_of_birth;
        $edit->address = $req->address;
        $edit->email = $req->email;
        $edit->phone = $req->phone;
        $edit->role = $req->role;
       if( $edit->save()){
        return response()->json(["msg"=>"Manager Updated Successfully","Values"=>$edit],200);

       };
       

    }

    public function deletemanager(Request $req){


        $delete = User::where('id',$req->id)->where('role', 'Manager')->first();
        
            $delete->delete();
        return response()->json(["msg"=>"Manager deleted Successfully"],200);

        
        

    }

    public function searchmanager(Request $req){

        $sear = User::where('username', 'like', '%' . $req->username . '%')
            ->where('role', 'Manager')
            ->get();
        return response()->json(["msg"=>"searching manager","Values"=>$sear],200);
    }







    public function flightmanagerlist(){


        $user = User::where('role', 'FlightManager')
            ->get();
            return response()->json(["msg"=>"Manager List","Values"=>$user],200);
    }

    public function addflightmanager(Request $req){


        $add= new User();

        $add->username = $req->username;
        $add->name = $req->name;
        $add->password = md5($req->password);
        $add->date_of_birth = $req->date_of_birth;
        $add->address = $req->address;
        $add->email = $req->email;
        $add->phone = $req->phone;
        $add->role = $req->role;
        if($add->save()){
            return response()->json(["msg"=>"FlightManager Added Successfully","Values"=>$add],200);

        };
        

    }

    
    public function editflightmanager(Request $req){


        $edit = User::where('id',$req->id)->first();
        // ->select('id','name','username','date_of_birth','email','phone','address','role')

        $edit->username = $req->username;
        $edit->name = $req->name;
        //$edit->password = $req->password;
        $edit->date_of_birth = $req->date_of_birth;
        $edit->address = $req->address;
        $edit->email = $req->email;
        $edit->phone = $req->phone;
        $edit->role = $req->role;
        if($edit->save()){

            return response()->json(["msg"=>"FlightManager Updated Successfully","Values"=>$edit],200);
        };
       

    }

    public function deleteflightmanager(Request $req){


        $delete = User::where('id',$req->id)->where('role', 'FlightManager')->first();
        $delete->delete();
        return response()->json(["msg"=>"FlightManager deleted Successfully"],200);

    }

    public function searchflightmanager(Request $req){

        $sear = User::where('username', 'like', '%' . $req->username . '%')
            ->where('role', 'FlightManager')
            ->get();
        return response()->json(["msg"=>"searching FlightManage","Values"=>$sear],200);
    }


    public function flighlistAll(){

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
        return response()->json(["msg" => "No flight Available"],200);

    }

    public function userticketlistAll(Request $req){

        $user = User::where('id', $req->id)->first();
        // $user = User::all();


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


    public function ticketdetails (Request $req){

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


  






}
