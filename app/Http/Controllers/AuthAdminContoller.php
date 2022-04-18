<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User; 
use App\Mail\UserVerification;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailVerifyToken;

class AuthAdminContoller extends Controller
{


    public function registration(Request $req){
        
        $rules = array(
            'username' => 'required|unique:users,username|min:3',
            'name' => 'required|min:5',
            'password' => 'required|min:4',
            'conpass' => 'required|same:password',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
            'dob' => 'required',
            'address' => 'required'
        );
        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            //return $validator->errors();
            return response()->json($validator->messages());
        }

        //Mail::to($req->email)->Send(new UserVerification("FMS User Verifiaction", "Demodeoby"));

        $user = new User();
        $user->username = $req->username;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->phone = $req->phone;
        $user->date_of_birth = $req->dob;
        $user->password = md5($req->password);
        $user->role = "User";
        $user->save();

        $tokenGen = bin2hex(random_bytes(37));
        $emailToken = new EmailVerifyToken();
        $emailToken->value = $tokenGen;
        $emailToken->user_id = $user->id;
        $emailToken->save();

        $mail = new UserVerification("Email Verification",$req->name, $tokenGen);
        Mail::to($req->email)->send($mail);

        return response()->json(["msg"=> "Registration Successfull. Check Your Email For Verification"]);

    }


    public function emailVerification($token)
    {
        $tokenModel = EmailVerifyToken::where('value', $token)->first();
        if (!$tokenModel) return "Link Expired";
        $user = User::where('id', $tokenModel->user->id)->first();
        $user->verified = 1;
        $user->save();
        $tokenModel->delete();
        return "Email Verified";
    }





    public function login(Request $req){
        $rules = array(
            'username' => 'required|min:3',
            'password' => 'required|min:4',
        );
        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            //return $validator->errors();
            return response()->json($validator->messages());
        }

        $user = User::where('username', $req->username)->where('password', md5($req->password))->first();
        if ($user) {
            return response()->json(["msg"=> 200]);
        } else {

            return response()->json(["msg1" => "Username or password is incorrect"]);
        }
        
    }




}
