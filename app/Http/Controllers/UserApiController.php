<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserApiController extends Controller
{

    public function getAll()
    {
        $users = User::all();
        return $users;
    }
    public function getOne($id)
    {
        $user = User::where('id', $id)->first();
        return $user;
    }
    public function addOne(Request $req)
    {
        $user = new User();
        $user->username = $req->username;
        $user->name = $req->name;
        $user->password = $req->password;
        $user->date_of_birth = $req->date_of_birth;
        $user->address = $req->address;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->role = $req->role;
        $user->save();
        return response()->json(["msg" => "Added Successfully", "value" => $user], 201);
    }

    public function updateOne(Request $req)
    {
        $user = User::where('id', $req->id)->first();
        $user->username = $req->username;
        $user->name = $req->name;
        $user->password = $req->password;
        $user->date_of_birth = $req->date_of_birth;
        $user->address = $req->address;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->role = $req->role;
        $user->save();
        return response()->json(["msg" => "User Updated Successfully", "value" => $user], 200);
    }

    public function deleteOne(Request $req)
    {
        $user = User::where('id', $req->id)->first();
        $user->delete();
        return response()->json(["msg" => "User deleted Successfully"], 201);
    }
}
