<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentsResource;
use App\Models\Appointments;
use Exception;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    public function getAppoitmentsByDate(Request $req)
    {
        try {
            return new AppointmentsResource(
                Appointments::where('working_days_id', $req->get('working_days_id'))
                    ->orderBy('start')
                    ->get()
            );
        } catch (Exception $e) {
            return response()->json(['msg' => 'The given data was invalid'], 422);
        }
    }

    public function getSerivesByAppointment(Request $req, $id)
    {
        try {
            $app = Appointments::findOrFail($id);
            return (new AppointmentsResource($app->services->all()));
        } catch (Exception $e) {
        }
    }
    public function create(Request $req)
    {
        $req->validate([
            'working_day_id' => 'required',
            'user_id' => 'required',
            'start' => 'required',

        ]);
        // return $req;
        $app = new Appointments();
        $app->working_days_id = $req->working_day_id;
        $app->users_id = $req->user_id;
        $app->start = $req->start;
        $app->save();
    }
}
