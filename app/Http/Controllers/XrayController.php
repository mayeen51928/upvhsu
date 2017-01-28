<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Staff;
use App\Town;
use App\Province;
class XrayController extends Controller
{
	public function __construct()
    {
    	$this->middleware(function ($request, $next) {
    		if(Auth::check()){
    			if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 4){
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
    	return view('staff.medical-xray.dashboard', $params);
    }

    public function profile()
    {
        $xray = Staff::find(Auth::user()->user_id);
        $params['sex'] = $xray->sex;
        $params['position'] = $xray->position;
        $params['birthday'] = $xray->birthday;
        $params['civil_status'] = $xray->civil_status;
        $params['personal_contact_number'] = $xray->personal_contact_number;
        $params['street'] = $xray->street;
        if(!is_null($xray->town_id))
            {
                $params['town'] = Town::find($xray->town_id)->town_name;
                $params['province'] = Province::find(Town::find($xray->town_id)->province_id)->province_name;
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
        return view('staff.medical-xray.profile', $params);
    }
    public function editprofile()
    {
        $xray = Staff::find(Auth::user()->user_id);
        // $params['age'] = (date('Y') - date('Y',strtotime($xray->birthday)));
        $params['sex'] = $xray->sex;
        $params['position'] = $xray->position;
        $params['birthday'] = $xray->birthday;
        $params['civil_status'] = $xray->civil_status;
        $params['personal_contact_number'] = $xray->personal_contact_number;
        $params['street'] = $xray->street;
        if(!is_null($xray->town_id))
            {
                $params['town'] = Town::find($xray->town_id)->town_name;
                $params['province'] = Province::find(Town::find($xray->town_id)->province_id)->province_name;
            }
            else
            {
                $params['town'] = '';
                $params['province'] = '';
            }
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.medical-xray.editprofile', $params);
    }

    public function updateprofile(Request $request)
    {
        $xray = Staff::find(Auth::user()->user_id);
        $xray->sex = $request->input('sex');
        $xray->birthday = $request->input('birthday');
        $xray->street = $request->input('street');
        $province = Province::where('province_name', $request->input('province'))->first();
        if(count($province)>0)
        {
            // $xray->nationality_id = $nationality->id;
            $town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
            if(count($town)>0)
            {
                $xray->town_id = $town->id;
            }
            else
            {
                $town = new Town;
                $town->town_name = $request->input('town');
                $town->province_id = $province->id;
                //insert the distance from miagao using Google Distance Matrix API
                $location = preg_replace("/\s+/", "+",$request->input('town')." ".$request->input('province'));
                $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
                $json = json_decode(file_get_contents($url), true);
                $distance=$json['rows'][0]['elements'][0]['distance']['value'];
                $town->distance_to_miagao = $distance/1000;
                $town->save();
                $xray->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
            $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
            $json = json_decode(file_get_contents($url), true);
            $distance=$json['rows'][0]['elements'][0]['distance']['value'];
            $town->distance_to_miagao = $distance/1000;
            $town->save();
            $xray->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
        }
        $xray->personal_contact_number = $request->input('personal_contact_number');
        $xray->update();
        return redirect('xray/profile');
    }

    public function searchpatient()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'searchpatient';
    	return view('staff.medical-xray.searchpatient', $params);
    }
}
