<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {

        // $current_timestamp_date = Carbon::now()->format('Y-m-d');
        // $current_timestamp_month = Carbon::now()->format('Y-m');
        // $current_timestamp_year = Carbon::now()->format('Y');
        // //today Ticket Count

        $total_patients = DB::select("SELECT IFNULL(COUNT(id),0) AS totalPatient FROM  cardio_thoraric");

        $total_waiting_patients = DB::select("SELECT IFNULL(COUNT(id),0) AS totalWaitingPatient FROM  cardio_thoraric
        WHERE 'status' = 'Awaiting' ");

        $total_sucessfull_patients = DB::select("SELECT IFNULL(COUNT(id),0) AS totalSucessfullPatient FROM  cardio_thoraric 
        WHERE 'status' = 'Surgery Done' ");

        $total_other_patients = DB::select("SELECT IFNULL(COUNT(id), 0) AS totalOtherPatient FROM cardio_thoraric 
        WHERE 'status' NOT IN ('Surgery Done', 'Awaiting')");

        $pie_charts = DB::select("SELECT status, IFNULL(COUNT(id), 0) AS totalPatients FROM cardio_thoraric 
        GROUP BY status");


        return view('pages.index')
            ->with('total_patients', $total_patients)
            ->with('total_waiting_patients', $total_waiting_patients)
            ->with('total_sucessfull_patients', $total_sucessfull_patients)
            ->with('total_other_patients', $total_other_patients)
            ->with('pie_charts', $pie_charts);
    }
}
