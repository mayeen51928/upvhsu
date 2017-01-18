<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Staff;
use App\Town;
use App\Province;
class LabController extends Controller
{
	public function __construct()
    {
    	$this->middleware(function ($request, $next) {
    		if(Auth::check()){
    			if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 3){
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
    	return view('staff.medical-lab.dashboard', $params);
    }

    public function profile()
    {
        $lab = Staff::find(Auth::user()->user_id);
        $params['sex'] = $lab->sex;
        $params['position'] = $lab->position;
        $params['birthday'] = $lab->birthday;
        $params['civil_status'] = $lab->civil_status;
        $params['personal_contact_number'] = $lab->personal_contact_number;
        $params['street'] = $lab->street;
        if(!is_null($lab->town_id))
            {
                $params['town'] = Town::find($lab->town_id)->town_name;
                $params['province'] = Province::find(Town::find($lab->town_id)->province_id)->province_name;
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
        return view('staff.medical-lab.profile', $params);
    }
    public function editprofile()
    {
        $lab = Staff::find(Auth::user()->user_id);
        // $params['age'] = (date('Y') - date('Y',strtotime($lab->birthday)));
        $params['sex'] = $lab->sex;
        $params['position'] = $lab->position;
        $params['birthday'] = $lab->birthday;
        $params['civil_status'] = $lab->civil_status;
        $params['personal_contact_number'] = $lab->personal_contact_number;
        $params['street'] = $lab->street;
        if(!is_null($lab->town_id))
            {
                $params['town'] = Town::find($lab->town_id)->town_name;
                $params['province'] = Province::find(Town::find($lab->town_id)->province_id)->province_name;
            }
            else
            {
                $params['town'] = '';
                $params['province'] = '';
            }
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.medical-lab.editprofile', $params);
    }

    public function updateprofile(Request $request)
    {
        $lab = Staff::find(Auth::user()->user_id);
        $lab->sex = $request->input('sex');
        $lab->birthday = $request->input('birthday');
        $lab->street = $request->input('street');
        $province = Province::where('province_name', $request->input('province'))->first();
        if(count($province)>0)
        {
            // $lab->nationality_id = $nationality->id;
            $town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
            if(count($town)>0)
            {
                $lab->town_id = $town->id;
            }
            else
            {
                $town = new Town;
                $town->town_name = $request->input('town');
                $town->province_id = $province->id;
                //insert the distance from miagao using Google Distance Matrix API
                $town->save();
                $lab->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
            $lab->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
        }
        $lab->personal_contact_number = $request->input('personal_contact_number');
        $lab->update();
        return redirect('lab/profile');
    }

    public function searchpatient()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'searchpatient';
    	return view('staff.medical-lab.searchpatient', $params);
    }
}
