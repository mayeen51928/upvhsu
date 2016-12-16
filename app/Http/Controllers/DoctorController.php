<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\MedicalSchedule;
class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::check()){
                if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 2){
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
        return view('staff.medical-doctor.dashboard', $params);
    }

    public function profile()
    {
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.medical-doctor.profile', $params);
    }

    public function manageschedule()
    {
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'manageschedule';
        return view('staff.medical-doctor.manageschedule', $params);
    }

    public function searchpatient()
    {
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'searchpatient';
        return view('staff.medical-doctor.searchpatient', $params);
    }

    public function addschedule(Request $request)
    {
        $schedules = $request->schedules;
        for($i=0; $i < sizeof($schedules); $i++){
            $checker_if_exists = MedicalSchedule::where('staff_id', Auth::user()->user_id)->where('schedule_day', $schedules[$i]);
            // if(count($checker_if_exists) == 0){
                $schedule = new MedicalSchedule();
                $schedule->staff_id = Auth::user()->user_id;
                $schedule->schedule_day = $schedules[$i];
                $schedule->save();
            // }
            
        }
        
        return response()->json(['success' => 'success']); 
    }
}
