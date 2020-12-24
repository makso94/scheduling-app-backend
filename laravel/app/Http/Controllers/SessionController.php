<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SessionController extends Controller
{


    public function checkSession(Request $req)
    {
        try {
            $reqSessionId = $req->cookie('session_id');

            dd(Redis::connection());

            dd(session($reqSessionId));
        } catch (Error $err) {
        }
    }



    public function login(Request $req)
    {
        try {
            $user = User::where('email', $req->email)->first();
            if ($user === null) {
                return response()->json(['msg' => 'Could not find you email'], 403);
            }
            if ($user->password == $req->password) {
                $session_id = (string) Str::uuid();
                session(['kurac' => 'palac']);
                // Session::set('kurac', 'palac');
                // session()->put('key', 'value');

                // dd(session()->get('*'));
                // Redis::set($session_id, json_encode($user));
                return response()->json(['msg' => 'You have logged in successfully'], 200)->cookie('session_id', $session_id, 20160);
            } else {
                return response()->json(['msg' => 'Forbidden, wrong password'], 403);
            }
        } catch (Error $err) {
            return response()->json(['msg' => 'Unknown error'], 500);
        }
    }
}
