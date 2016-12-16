<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'profile';
    	return view('staff.medical-lab.profile', $params);
    }

    public function searchpatient()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'searchpatient';
    	return view('staff.medical-lab.searchpatient', $params);
    }
}
