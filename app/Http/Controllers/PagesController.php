<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\DentalAppointment;
use App\DentalSchedule;
use App\MedicalSchedule;
use App\Staff;

class PagesController extends Controller
{
	public function index()
    {
    	$params['navbar_active'] = 'home';
        return view('index', $params);
    }
	public function scheduleappointment()
    {
    	$params['navbar_active'] = 'scheduleappointment';
        return view('scheduleappointment', $params);
    }

    public function displayscheduledental(Request $request)
    {
      $dental_date = $request->dental_date;
      $displaySchedules = DentalSchedule::all();
      $startdatesarray = array();
      $enddatesarray = array();
      $staffnamearray = array();
      foreach ($displaySchedules as $displayschedule){
        $datestartdental=explode(" ", $displayschedule->schedule_start);
        $dateenddental=explode(" ", $displayschedule->schedule_end);
        
        if ($datestartdental[0] == $dental_date){
          $staff = Staff::where('staff_id', $displayschedule->staff_id)->first();
          array_push($startdatesarray, $datestartdental[1]);
          array_push($enddatesarray, $dateenddental[1]);
          array_push($staffnamearray,  $staff->staff_first_name .' '. $staff->staff_last_name);
        }
      }
      return response()->json(['start' => $startdatesarray,'end' => $enddatesarray,'staff' => $staffnamearray]); 
    }

    public function displayschedulemedical(Request $request)
    {
      $medical_date = $request->medical_date;
      $displaySchedules = MedicalSchedule::where('schedule_day', $medical_date)->get();
      $staffnamearray = array();
      foreach ($displaySchedules as $displayschedule){
        $staff = Staff::where('staff_id', $displayschedule->staff_id)->first();
        array_push($staffnamearray,  $staff->staff_first_name .' '. $staff->staff_last_name);
      }
      return response()->json(['staff' => $staffnamearray]); 
    }


}
