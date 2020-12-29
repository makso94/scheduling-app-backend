<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function getAll(Request $request)
    {
        try {

            $query_params = $request->all();
            if ($query_params) {

                $conditions =  array_filter($query_params, function ($key) {
                    if ($key != 'first_name' && $key != 'last_name' && $key != 'email') {
                        return $key;
                    }
                }, ARRAY_FILTER_USE_KEY);

                return new UserResource(
                    User::where($conditions)
                        ->where('first_name', 'like', '%' . $request->first_name . '%')
                        ->where('last_name', 'like', '%' . $request->last_name . '%')
                        ->where('email', 'like', '%' . $request->email . '%')
                        ->get()
                );
            }

            return new UserResource(User::all());
        } catch (Exception $e) {
            return response()->json(['msg' => 'Invalid filter'], 400);
        }
    }

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
        } catch (Exception $e) {
        }
    }
}
