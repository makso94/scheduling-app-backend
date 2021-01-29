<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentsResource;
use App\Http\Resources\WorkingDaysResource;
use App\Models\Appointments;
use App\Models\Service;
use App\Models\WorkingDays;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Empty_;

class AppointmentsController extends Controller
{
    public function getAppoitmentsByDate(Request $req)
    {
        if ($req->has('month') && $req->has('year')) {
            $month = $req->month;
            $year = $req->year;
            $monthStart = Carbon::create($year, $month)->startOfMonth()->toDateString();
            $monthEnd = Carbon::create($year, $month)->endOfMonth()->toDateString();

            return new WorkingDaysResource(
                WorkingDays::whereBetween('date', [$monthStart,  $monthEnd])
                    ->with('appointments.services')->get()
            );
        }

        try {
            if ($req->has('working_days_id')) {
                return new AppointmentsResource(Appointments::where('working_days_id', $req->working_days_id)
                    ->with('services')
                    ->orderBy('start')
                    ->get());
            }
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
        try {
            $req->validate([
                'working_day_id' => 'required',
                'user_id' => 'required',
                'start' => 'required',
                'service_ids' => 'required'
            ]);
            $app = new Appointments();
            $app->working_days_id = $req->working_day_id;
            $app->users_id = $req->user_id;
            $app->start = $req->start;
            $app->save();

            $app->services()->attach($req->service_ids);
            return response()->json(['msg' => 'Successfuly created appointment'], 200);
        } catch (Exception $e) {
            return response()->json(['msg' => 'The given data was invalid'], 422);
        }
    }
}
