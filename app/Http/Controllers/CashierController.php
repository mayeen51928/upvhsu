<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Staff;
use App\Town;
use App\Province;
class CashierController extends Controller
{
	public function __construct()
    {
    	$this->middleware(function ($request, $next) {
    		if(Auth::check()){
    			if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 5){
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
    	return view('staff.cashier.dashboard', $params);
    }

    public function profile()
    {
        $cashier = Staff::find(Auth::user()->user_id);
        $params['sex'] = $cashier->sex;
        $params['position'] = $cashier->position;
        $params['birthday'] = $cashier->birthday;
        $params['civil_status'] = $cashier->civil_status;
        $params['personal_contact_number'] = $cashier->personal_contact_number;
        $params['street'] = $cashier->street;
        $params['town'] = Town::find($cashier->town_id)->town_name;
        $params['province'] = Province::find(Town::find($cashier->town_id)->province_id)->province_name;
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.cashier.profile', $params);
    }
    public function editprofile()
    {
        $cashier = Staff::find(Auth::user()->user_id);
        // $params['age'] = (date('Y') - date('Y',strtotime($cashier->birthday)));
        $params['sex'] = $cashier->sex;
        $params['position'] = $cashier->position;
        $params['birthday'] = $cashier->birthday;
        $params['civil_status'] = $cashier->civil_status;
        $params['personal_contact_number'] = $cashier->personal_contact_number;
        $params['street'] = $cashier->street;
        $params['town'] = Town::find($cashier->town_id)->town_name;
        $params['province'] = Province::find(Town::find($cashier->town_id)->province_id)->province_name;
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('staff.cashier.editprofile', $params);
    }

    public function updateprofile(Request $request)
    {
        $cashier = Staff::find(Auth::user()->user_id);
        $cashier->sex = $request->input('sex');
        $cashier->birthday = $request->input('birthday');
        $cashier->street = $request->input('street');
        $province = Province::where('province_name', $request->input('province'))->first();
        if(count($province)>0)
        {
            // $cashier->nationality_id = $nationality->id;
            $town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
            if(count($town)>0)
            {
                $cashier->town_id = $town->id;
            }
            else
            {
                $town = new Town;
                $town->town_name = $request->input('town');
                $town->province_id = $province->id;
                //insert the distance from miagao using Google Distance Matrix API
                $town->save();
                $cashier->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
            $cashier->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
        }
        $cashier->personal_contact_number = $request->input('personal_contact_number');
        $cashier->update();
        return redirect('cashier/profile');
    }

    public function searchpatient()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'searchpatient';
    	return view('staff.cashier.searchpatient', $params);
    }
}
