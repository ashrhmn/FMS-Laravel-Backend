<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;

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
            return response()->json(["data" => $token, "error" => null], 201);
        } else {
            return response()->json(["data" => null, "error" => "Username or password is incorrect"], 401);
        }
    }


    public function signUp(Request $req)
    {
        $existingUser = User::where('username', $req->username)->first();
        if ($existingUser) {
            return response()->json(["data" => null, "error" => "Username already exists"], 401);
        }
        $user = new User();

        $user->username = $req->username;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->phone = $req->phone;
        $user->date_of_birth = $req->dob;
        $user->password = md5($req->password);
        $user->save();

        return response()->json(["data" => $user, "error" => null], 201);
    }


    public function currentUser(Request $req)
    {
        $token = $req->header('token');
        $userToken = Token::where('value', $token)->first();
        if (!$userToken) return response()->json(["data" => null, "error" => "Invalid Token"], 404);
        return response()->json(["data" => $userToken->user, "error" => null], 200);
    }
}