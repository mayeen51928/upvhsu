<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PatientController extends Controller
{
	public function __construct()
    {
    	$this->middleware(function ($request, $next) {
    		if(Auth::check()){
    			if(Auth::user()->user_type_id == 1){
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
        return view('patient.dashboard', $params);
    }

    public function profile()
    {
    	$params['sidebar_active'] = 'profile';
    	return view('patient.profile', $params);
    }

    public function visits()
    {
    	$params['sidebar_active'] = 'visits';
    	return view('patient.visits', $params);
    }

    public function bills()
    {
    	$params['sidebar_active'] = 'bills';
    	return view('patient.bills', $params);
    }
}
