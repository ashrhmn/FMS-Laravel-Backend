<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\City;
use App\Models\EmailVerifyToken;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function signIn(Request $req)
    {
        $user = User::where('username', $req->username)->where('password', md5($req->password))->first();
        if ($user) {
            $tokenGen = bin2hex(random_bytes(37));
            $token = new Token();
            $token->value = $tokenGen;
            $token->user_id = $user->id;
            $token->save();
            $token->token = $token->value;
            return response()->json(["data" => $token, "error" => null], 201);
        } else {
            return response()->json(["data" => null, "error" => "Username or password is incorrect"], 401);
        }
    }


    public function signUp(Request $req)
    {
        $existingUser = User::where('username', $req->username)->first();
        if ($existingUser) {
            return response()->json(["data" => null, "error" => "Username already exists"], 200);
        }

        $user = new User();
        $user->username = $req->username;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->phone = $req->phone;
        $user->date_of_birth = $req->dateOfBirth;
        $user->password = md5($req->password);
        $user->city_id = $req->cityId;
        $user->verified = 0;
        $user->save();

        $tokenGen = bin2hex(random_bytes(37));

        $emailToken = new EmailVerifyToken();
        $emailToken->value = $tokenGen;
        $emailToken->user_id = $user->id;
        $emailToken->save();

        $mail = new SendMail($req->name, $tokenGen);
        Mail::to($req->email)->send($mail);


        return response()->json(["data" => $user, "error" => null], 201);
    }

    public function verifyEmail($token)
    {
        $tokenModel = EmailVerifyToken::where('value', $token)->first();
        if (!$tokenModel) return "Token invalid";
        $user = User::where('id', $tokenModel->user->id)->first();
        $user->verified = 1;
        $user->save();
        $tokenModel->delete();
        return "Email Verified";
    }

    public function sendMail(Request $req)
    {
        $mail = new SendMail($req->subject, $req->body);
        $result = Mail::to($req->to)->send($mail);
        return $result;
    }

    public function resendVerificationMail(Request $req)
    {
        $token = $req->header('token');
        $userToken = Token::where('value', $token)->first();
        if (!$userToken) return "Invalid token";

        $user = $userToken->user;

        EmailVerifyToken::where('user_id', $user->id)->delete();

        $tokenGen = bin2hex(random_bytes(37));

        $emailToken = new EmailVerifyToken();
        $emailToken->value = $tokenGen;
        $emailToken->user_id = $user->id;
        $emailToken->save();

        $mail = new SendMail($user->name, $tokenGen);
        Mail::to($user->email)->send($mail);
        return "Sent successfully";
    }


    public function currentUser(Request $req)
    {
        $token = $req->header('token');
        $userToken = Token::where('value', $token)->first();
        if (!$userToken) return response()->json(["data" => null, "error" => "Invalid Token"], 404);
        return response()->json(["data" => $userToken->user, "error" => null], 200);
    }

    public function getCities()
    {
        return response()->json(["data" => City::all(), "error" => null], 200);
    }
}
