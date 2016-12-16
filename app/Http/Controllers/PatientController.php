<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Patient;
use App\DegreeProgram;
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
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'dashboard';
        return view('patient.dashboard', $params);
    }

    public function profile()
    {
        $patient = Patient::find(Auth::user()->user_id);
        $params['age'] = (date('Y') - date('Y',strtotime($patient->birthday)));
        $params['sex'] = $patient->sex;
        $params['degree_program'] = DegreeProgram::find($patient->degree_program_id)->degree_program_description;
        $params['year_level'] = $patient->year_level;
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'profile';
    	return view('patient.profile', $params);
    }

    public function visits()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'visits';
    	return view('patient.visits', $params);
    }

    public function bills()
    {
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'bills';
    	return view('patient.bills', $params);
    }
}
