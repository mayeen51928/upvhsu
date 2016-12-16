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
      $display_schedules = DentalSchedule::all();
      $startdatesarray = array();
      $enddatesarray = array();
      $staffnamearray = array();
      $scheduleidarray = array();
      foreach ($display_schedules as $display_schedule){
        $datestartdental=explode(" ", $display_schedule->schedule_start);
        $dateenddental=explode(" ", $display_schedule->schedule_end);
        $scheduleid = $display_schedule->id;
        if ($datestartdental[0] == $dental_date){
          $staff = Staff::where('staff_id', $display_schedule->staff_id)->first();
          array_push($startdatesarray, $datestartdental[1]);
          array_push($enddatesarray, $dateenddental[1]);
          array_push($staffnamearray,  $staff->staff_first_name .' '. $staff->staff_last_name);
          array_push($scheduleidarray,  $scheduleid);
        }
      }
      return response()->json(['start' => $startdatesarray,'end' => $enddatesarray,'staff' => $staffnamearray ,'id' => $scheduleidarray]); 
    }

    public function displayschedulemedical(Request $request)
    {
      $medical_date = $request->medical_date;
      $display_schedules = MedicalSchedule::where('schedule_day', $medical_date)->get();
      $staffnamearray = array();
      $scheduleidarray = array();
      foreach ($display_schedules as $display_schedule){
        $staff = Staff::where('staff_id', $display_schedule->staff_id)->first();
        $scheduleid = $display_schedule->id;
        array_push($staffnamearray,  $staff->staff_first_name .' '. $staff->staff_last_name);
        array_push($scheduleidarray, $scheduleid);
      }
      return response()->json(['staff' => $staffnamearray, 'id' => $scheduleidarray]); 
    }

    public function createappointmentdental(Request $request)
    {
      
    }

    public function createappointmentmedical(Request $request)
    {
      
    }


}
