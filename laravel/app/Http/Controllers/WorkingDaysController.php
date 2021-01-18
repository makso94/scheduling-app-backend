<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkingDaysResource;
use App\Models\WorkingDays;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class WorkingDaysController extends Controller
{
    //
    public function getByMonthYear(Request $request)
    {
        try {
            $month = $request->get('month');
            $year = $request->get('year');
            $monthStart = Carbon::create($year, $month)->startOfMonth()->toDateString();
            $monthEnd = Carbon::create($year, $month)->endOfMonth()->toDateString();

            return new WorkingDaysResource(WorkingDays::whereBetween('date', [$monthStart, $monthEnd])->get());
        } catch (Exception $e) {
        }
    }


    public function createByMonthYear(Request $request)
    {
        try {
            $request->validate([
                'year' => ['required'],
                'month' => ['required'],
                'days'  => ['required'],
                'opens' => ['required'],
                'closes' => ['required']
            ]);

            $month = $request->month;
            $year = $request->year;
            $days = $request->days;
            $date = Carbon::create($year, $month);

            $insertDays = [];

            for ($i = 1; $i <= $date->daysInMonth; $i++) {
                if (in_array($i, $days)) {
                    array_push($insertDays, [
                        'date' => Carbon::create($year, $month, $i)->toDateString(),
                        'opens' => Carbon::create($year, $month, $i, explode(':', $request->opens)[0], explode(':', $request->opens)[1])->toDateTimeString(),
                        'closes' => Carbon::create($year, $month, $i, explode(':', $request->closes)[0], explode(':', $request->closes)[1])->toDateTimeString(),
                        'is_business_day' => true
                    ]);
                }
            }
            WorkingDays::insert($insertDays);
            return response()->json(['msg' => 'Successfully created month'], 201);
        } catch (Exception $e) {
            return response()->json(['msg' => 'The given data was invalid'], 422);
        }
    }

    public function update(Request $req, $id)
    {
        try {
            $req->validate([
                'closes' => ['required'],
                'opens' => ['required'],
            ]);

            $day = WorkingDays::findOrFail($id);
            $day->opens = $day->date . ' ' . $req->opens;
            $day->closes = $day->date . ' ' . $req->closes;
            $day->save();
            return response()->json(['msg' => 'Successfully updated working day'], 200);
        } catch (Exception $e) {
            return response()->json(['msg' => 'The given data was invalid'], 422);
        }
    }
}
