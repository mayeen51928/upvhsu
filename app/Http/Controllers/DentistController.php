<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\DentalSchedule;

class DentistController extends Controller
{
	public function __construct()
    {
    	$this->middleware(function ($request, $next) {
    		if(Auth::check()){
    			if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 1){
					return $next($request);
				}
    		}
    		else{
    			return redirect('/');
    		}
		});
    }
    public function dashboard()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'dashboard';
    	return view('staff.dental-dentist.dashboard', $params);
    }

    public function profile()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'profile';
    	return view('staff.dental-dentist.profile', $params);
    }

    public function manageschedule()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'manageschedule';
    	return view('staff.dental-dentist.manageschedule', $params);
    }

    public function searchpatient()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'searchpatient';
    	return view('staff.dental-dentist.searchpatient', $params);
    }

    public function addschedule(Request $request)
    {
        $schedules = $request->schedules;
        for($i=0; $i < sizeof($schedules); $i++){
            $explode_schedules = explode(";;;", $schedules[$i]);
            $start = $explode_schedules[0];
            $end = $explode_schedules[1];
            $schedule = new DentalSchedule();
            $schedule->staff_id = Auth::user()->user_id;
            $schedule->schedule_start = $start;
            $schedule->schedule_end = $end;
            $schedule->save();
        }
        
        return response()->json(['success' => 'success']); 
    }
}
