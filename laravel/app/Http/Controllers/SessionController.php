<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class SessionController extends Controller
{

    public function login(Request $req)
    {
        try {
            $user = User::where('email', $req->email)->first();
            if ($user === null) {
                return response()->json(['msg' => 'Could not find you email'], 403);
            }
            if ($user->password === hash('sha512', $req->password)) {

                $session_id = (string) Str::uuid();
                Redis::set($session_id, json_encode($user));

                return response()->json(['msg' => 'You have logged in successfully', 'user' => $user], 200)->cookie('session_id', $session_id, 20160);
            }

            return response()->json(['msg' => 'Forbidden, wrong password'], 403);
        } catch (Error $err) {
            return response()->json(['msg' => 'Unknown error'], 500);
        }
    }


    public function checkSession(Request $req)
    {
        try {
            $reqSessionId = $req->cookie('session_id');
            $userFromRedis = Redis::get($reqSessionId);

            if ($userFromRedis) {
                return response()->json(json_decode($userFromRedis));
            };
            return response()->json(['msg' => 'Forbidden, you are not logged in'], 403);
        } catch (Error $err) {
            return response()->json(['msg' => 'Unknown error'], 500);
        }
    }

    public function logout(Request $req)
    {
        try {
            $reqSessionId = $req->cookie('session_id');
            $cookie = Cookie::forget('session_id');
            if (!!Redis::del($reqSessionId)) {
                return response()->json(['msg' => 'You are successfully logged out'], 200)->cookie($cookie);
            }
            return response()->json(['msg' => 'You are already logged out'], 200)->cookie($cookie);
        } catch (Error $err) {
            return response()->json(['msg' => 'Unknown error'], 500);
        }
    }
}
