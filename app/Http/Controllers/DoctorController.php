<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
}
