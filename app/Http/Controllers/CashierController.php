<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'profile';
    	return view('staff.cashier.profile', $params);
    }

    public function searchpatient()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'searchpatient';
    	return view('staff.cashier.searchpatient', $params);
    }
}
