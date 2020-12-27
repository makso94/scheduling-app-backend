<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function create(Request $request)
    {
        try {
            $request->validate([
                'first_name' => ['required', 'max:32'],
                'last_name' => ['required', 'max:32'],
                'email' => ['required', 'max:64'],
                'password' => ['required', 'max:64'],
                'is_admin' => ['required'],
            ]);

            if (User::where('email', $request->email)->first()) {
                return response()->json(['msg' => 'Duplicate email'], 422);
            }

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = hash('sha512',  $request->password);
            $user->is_admin = $request->is_admin;
            $user->save();

            return response()->json(['msg' => 'You have successfully created a user.'], 201);
        } catch (Error $error) {
        }
    }
}
