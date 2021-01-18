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
}
