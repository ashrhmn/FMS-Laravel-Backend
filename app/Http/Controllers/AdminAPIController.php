<?php
 

namespace App\Http\Controllers;
ini_set('memory_limit', '3000M');
ini_set('max_execution_time', 180);

use Illuminate\Http\Request;
use App\Models\User;

class AdminAPIController extends Controller
{

    public function userlist(){


        $user = User::where('role', 'User')
            ->get();
        return $user;
    }
    //
    public function adduser(Request $req){

    
        $add= new User();

        $add->username = $req->username;
        $add->name = $req->name;
        $add->password = $req->password;
        $add->date_of_birth = $req->date_of_birth;
        $add->address = $req->address;
        $add->email = $req->email;
        $add->phone = $req->phone;
        $add->role = $req->role;
        $add->save();
        return response()->json(["msg"=>"Added Successfully","Values"=>$add],200);
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
        $edit->save();
        return response()->json(["msg"=>"user Updated Successfully","Updated Values"=>$edit],200);

    }

    public function deleteuser(Request $req){
        $delete = User::where('id',$req->id)->first();
        $delete->delete();
        return response()->json(["msg"=>"User deleted Successfully"],200);
    }

    public function searchuser(Request $req){


        $sear = User::where('username', 'like', '%' . $req->username . '%')
            ->where('role', 'User')
            ->get();
        return response()->json(["msg"=>"searching only Users","Values"=>$sear],200);
    }

    /* Admin Profile */

    public function __construct(){
        $this->user_id = 37;
    }

    public function adminprofile(){
        $user = User::where('id',$this->user_id)
                ->select('name','username','date_of_birth','email','phone','address')->first();

        return $user;
    }

    public function admineditProfile(Request $req){
        $edit = User::where('id', $this->user_id)->first();

        $edit->username = $req->username;
        $edit->name = $req->name;
        $edit->date_of_birth = $req->date_of_birth;
        $edit->address = $req->address;
        $edit->email = $req->email;
        $edit->phone = $req->phone;
        $edit->save();
        return response()->json(["msg"=>"user Updated Successfully","Updated Values"=>$edit],200);
    

    }

    /* Admin Profile End */




          /* manager start*/



    public function managerlist(){


        $user = User::where('role', 'Manager')
            ->get();
        return $user;
    }

    public function addmanager(Request $req){


        $add= new User();

        $add->username = $req->username;
        $add->name = $req->name;
        $add->password = $req->password;
        $add->date_of_birth = $req->date_of_birth;
        $add->address = $req->address;
        $add->email = $req->email;
        $add->phone = $req->phone;
        $add->role = $req->role;
        $add->save();
        return response()->json(["msg"=>"Add Manager Successfully","Values"=>$add],200);

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
        //$edit->role = $req->role;
        $edit->save();
        return response()->json(["msg"=>"Manager Updated Successfully","Values"=>$edit],200);

    }

    public function deletemanager(Request $req){


        $delete = User::where('id',$req->id)->first();
        $delete->delete();
        return response()->json(["msg"=>"Manager deleted Successfully"],200);

    }

    public function searchmanager(Request $req){

        $sear = User::where('username', 'like', '%' . $req->username . '%')
            ->where('role', 'Manager')
            ->get();
        return response()->json(["msg"=>"searching only Users","Values"=>$sear],200);
    }


   /* manager end*/



    /* flightmanager start */




    public function flightmanagerlist(){


        $user = User::where('role', 'FlightManage')
            ->get();
        return $user;
    }

    public function addflightmanager(Request $req){


        $add= new User();

        $add->username = $req->username;
        $add->name = $req->name;
        $add->password = $req->password;
        $add->date_of_birth = $req->date_of_birth;
        $add->address = $req->address;
        $add->email = $req->email;
        $add->phone = $req->phone;
        $add->role = $req->role;
        $add->save();
        return response()->json(["msg"=>"FlightManage Added Successfully","Values"=>$add],200);

    }

    
    public function editflightmanager(Request $req){


        $edit = User::where('id',$req->id)->
        select('id','name','username','date_of_birth','email','phone','address','role')->first();

        $edit->username = $req->username;
        $edit->name = $req->name;
        //$edit->password = $req->password;
        $edit->date_of_birth = $req->date_of_birth;
        $edit->address = $req->address;
        $edit->email = $req->email;
        $edit->phone = $req->phone;
        $edit->role = $req->role;
        $edit->save();
        return response()->json(["msg"=>"FlightManage Updated Successfully","Values"=>$edit],200);

    }

    public function deleteflightmanager(Request $req){


        $delete = User::where('id',$req->id)->first();
        $delete->delete();
        return response()->json(["msg"=>"FlightManage deleted Successfully"],200);

    }

    public function searchflightmanager(Request $req){

        $sear = User::where('username', 'like', '%' . $req->username . '%')
            ->where('role', 'FlightManage')
            ->get();
        return response()->json(["msg"=>"searching FlightManage","Values"=>$sear],200);
    }

    /* flightmanager end */






}
