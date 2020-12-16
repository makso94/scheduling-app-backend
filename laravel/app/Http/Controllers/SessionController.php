<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function login(Request $req)
    {
        try {
            $user = User::where('email', $req->email)->first();
            if ($user === null) {
                return response()->json(['msg' => 'Could not find you email'], 403);
            } else {
                if ($user->password == $req->password) {
                    session_start();
                    return response()->json(['msg' => 'You have logged in successfully'], 200)->cookie('session', json_encode($user), 20160);
                } else {
                    return response()->json(['msg' => 'Forbidden, wrong password'], 403);
                }
            }
        } catch (Error $err) {
            return response()->json(['msg' => 'Unknown error'], 500);
        }
    }
}
