<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkingDaysResource;
use App\Models\WorkingDays;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

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
            $month = $request->month;
            $year = $request->year;
            $days_off = $request->days_off;
            $date = Carbon::create($year, $month);

            for ($i = 1; $i <= $date->daysInMonth; $i++) {
                if (!in_array($i, $days_off)) {
                    $day = WorkingDays::firstOrNew(['date' => Carbon::create($year, $month, $i)->toDateString()]);
                    $day->date = Carbon::create($year, $month, $i)->toDateString();
                    $day->opens = Carbon::create($year, $month, $i, explode(':', $request->opens)[0], explode(':', $request->opens)[1])->toDateTimeString();
                    $day->closes = Carbon::create($year, $month, $i, explode(':', $request->closes)[0], explode(':', $request->closes)[1])->toDateTimeString();
                    $day->is_business_day = true;
                    $day->save();
                }
            }
            return response()->json(['msg' => 'Successfully created month'], 201);
        } catch (Exception $e) {
        }
    }
}