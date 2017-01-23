<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\MedicalSchedule;
use App\Staff;
use App\Town;
use App\Province;
class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(Auth::check()){
                if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 2){
                    return $next($request);
                }
                else{
                    return back();
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
        $doctor = Staff::find(Auth::user()->user_id);
        $params['sex'] = $doctor->sex;
        $params['position'] = $doctor->position;
        $params['birthday'] = $doctor->birthday;
        $params['civil_status'] = $doctor->civil_status;
        $params['personal_contact_number'] = $doctor->personal_contact_number;
        $params['street'] = $doctor->street;
        if(!is_null($doctor->town_id))
            {
                $params['town'] = Town::find($doctor->town_id)->town_name;
                $params['province'] = Province::find(Town::find($doctor->town_id)->province_id)->province_name;
            }
            else
            {
                $params['town'] = '';
                $params['province'] = '';
            }
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.medical-doctor.profile', $params);
    }
    public function editprofile()
    {
        $doctor = Staff::find(Auth::user()->user_id);
        // $params['age'] = (date('Y') - date('Y',strtotime($doctor->birthday)));
        $params['sex'] = $doctor->sex;
        $params['position'] = $doctor->position;
        $params['birthday'] = $doctor->birthday;
        $params['civil_status'] = $doctor->civil_status;
        $params['personal_contact_number'] = $doctor->personal_contact_number;
        $params['street'] = $doctor->street;
        if(!is_null($doctor->town_id))
            {
                $params['town'] = Town::find($doctor->town_id)->town_name;
                $params['province'] = Province::find(Town::find($doctor->town_id)->province_id)->province_name;
            }
            else
            {
                $params['town'] = '';
                $params['province'] = '';
            }
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.medical-doctor.editprofile', $params);
    }

    public function updateprofile(Request $request)
    {
        $doctor = Staff::find(Auth::user()->user_id);
        $doctor->sex = $request->input('sex');
        $doctor->birthday = $request->input('birthday');
        $doctor->street = $request->input('street');
        $province = Province::where('province_name', $request->input('province'))->first();
        if(count($province)>0)
        {
            // $doctor->nationality_id = $nationality->id;
            $town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
            if(count($town)>0)
            {
                $doctor->town_id = $town->id;
            }
            else
            {
                $town = new Town;
                $town->town_name = $request->input('town');
                $town->province_id = $province->id;
                //insert the distance from miagao using Google Distance Matrix API
                $location = preg_replace("/\s+/", "+",$request->input('town')." ".$request->input('province'));
                $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
                $json = json_decode(file_get_contents($url), true);
                $distance=$json['rows'][0]['elements'][0]['distance']['value'];
                $town->distance_to_miagao = $distance/1000;
                $town->save();
                $doctor->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
            $location = preg_replace("/\s+/", "+",$request->input('town')." ".$request->input('province'));
            $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
            $json = json_decode(file_get_contents($url), true);
            $distance=$json['rows'][0]['elements'][0]['distance']['value'];
            $town->distance_to_miagao = $distance/1000;
            $town->save();
            $doctor->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
        }
        $doctor->personal_contact_number = $request->input('personal_contact_number');
        $doctor->update();
        return redirect('doctor/profile');
    }

    public function manageschedule()
    {
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'manageschedule';
        return view('staff.medical-doctor.manageschedule', $params);
    }

    public function searchdoctor()
    {
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'searchdoctor';
        return view('staff.medical-doctor.searchdoctor', $params);
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
