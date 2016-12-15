<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
    	$params['sidebar_active'] = 'dashboard';
    	return view('staff.dental-dentist.dashboard', $params);
    }

    public function profile()
    {
    	$params['sidebar_active'] = 'profile';
    	return view('staff.dental-dentist.profile', $params);
    }

    public function manageschedule()
    {
    	$params['sidebar_active'] = 'manageschedule';
    	return view('staff.dental-dentist.manageschedule', $params);
    }

    public function searchpatient()
    {
    	$params['sidebar_active'] = 'searchpatient';
    	return view('staff.dental-dentist.searchpatient', $params);
    }
}
