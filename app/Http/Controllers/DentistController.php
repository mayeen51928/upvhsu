<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\DentalSchedule;
use App\Staff;
use App\Town;
use App\Province;
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
        $dentist = Staff::find(Auth::user()->user_id);
        $params['sex'] = $dentist->sex;
        $params['position'] = $dentist->position;
        $params['birthday'] = $dentist->birthday;
        $params['civil_status'] = $dentist->civil_status;
        $params['personal_contact_number'] = $dentist->personal_contact_number;
        $params['street'] = $dentist->street;
        $params['town'] = Town::find($dentist->town_id)->town_name;
        $params['province'] = Province::find(Town::find($dentist->town_id)->province_id)->province_name;
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.dental-dentist.profile', $params);
    }
    public function editprofile()
    {
        $dentist = Staff::find(Auth::user()->user_id);
        // $params['age'] = (date('Y') - date('Y',strtotime($dentist->birthday)));
        $params['sex'] = $dentist->sex;
        $params['position'] = $dentist->position;
        $params['birthday'] = $dentist->birthday;
        $params['civil_status'] = $dentist->civil_status;
        $params['personal_contact_number'] = $dentist->personal_contact_number;
        $params['street'] = $dentist->street;
        $params['town'] = Town::find($dentist->town_id)->town_name;
        $params['province'] = Province::find(Town::find($dentist->town_id)->province_id)->province_name;
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.dental-dentist.editprofile', $params);
    }

    public function updateprofile(Request $request)
    {
        $dentist = Staff::find(Auth::user()->user_id);
        $dentist->sex = $request->input('sex');
        $dentist->birthday = $request->input('birthday');
        $dentist->street = $request->input('street');
        $province = Province::where('province_name', $request->input('province'))->first();
        if(count($province)>0)
        {
            // $dentist->nationality_id = $nationality->id;
            $town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
            if(count($town)>0)
            {
                $dentist->town_id = $town->id;
            }
            else
            {
                $town = new Town;
                $town->town_name = $request->input('town');
                $town->province_id = $province->id;
                //insert the distance from miagao using Google Distance Matrix API
                $town->save();
                $dentist->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
            }
        }
        else
        {
            $province = new Province;
            $province->province_name = $request->input('province');
            $province->save();
            $town = new Town;
            $town->town_name = $request->input('town');
            $town->province_id = Province::where('province_name', $request->input('province'))->first()->id;
            $town->save();
            $dentist->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
        }
        $dentist->personal_contact_number = $request->input('personal_contact_number');
        $dentist->update();
        return redirect('dentist/profile');
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
