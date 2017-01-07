<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Patient;
use App\DegreeProgram;
use App\Religion;
use App\Nationality;
use App\ParentModel;
use App\HasParent;
use App\Town;
use App\Province;
use App\Region;
use App\Guardian;
use App\HasGuardian;
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
        $params['birthday'] = $patient->birthday;
        $params['religion'] = Religion::find($patient->religion_id)->religion_description;
        $params['nationality'] = Nationality::find($patient->nationality_id)->nationality_description;
        $parents = HasParent::where('patient_id', Auth::user()->user_id)->get();
        foreach($parents as $parent)
        {
            if (ParentModel::find($parent->parent_id)->sex == 'M')
            {
                $params['father'] = ParentModel::find($parent->parent_id)->parent_first_name.' '.ParentModel::find($parent->parent_id)->parent_last_name;
            }
            else{
                $params['mother'] = ParentModel::find($parent->parent_id)->parent_first_name.' '.ParentModel::find($parent->parent_id)->parent_last_name;
            }
        }
        $params['street'] = $patient->street;
        $params['town'] = Town::find($patient->town_id)->town_name;
        $params['province'] = Province::find(Town::find($patient->town_id)->province_id)->province_name;
        $params['region'] = Region::find(Province::find(Town::find($patient->town_id)->province_id)->region_id)->region_name;
        $params['residence_telephone_number'] = $patient->residence_telephone_number;
        $params['personal_contact_number'] = $patient->personal_contact_number;
        $params['residence_contact_number'] = $patient->residence_contact_number;
        $guardian = HasGuardian::where('patient_id', Auth::user()->user_id)->first();
        $params['guardian_first_name'] = Guardian::find($guardian->guardian_id)->guardian_first_name;
        $params['guardian_middle_name'] = Guardian::find($guardian->guardian_id)->guardian_middle_name;
        $params['guardian_last_name'] = Guardian::find($guardian->guardian_id)->guardian_last_name;
        $params['guardian_street'] = Guardian::find($guardian->guardian_id)->street;
        $params['guardian_town'] = Town::find(Guardian::find($guardian->guardian_id)->town_id)->town_name;
        $params['guardian_province'] = Province::find(Town::find(Guardian::find($guardian->guardian_id)->town_id)->province_id)->province_name;
        $params['relationship'] = $guardian->relationship;
        $params['guardian_tel_number'] = Guardian::find($guardian->guardian_id)->guardian_telephone_number;
        $params['guardian_cellphone'] = Guardian::find($guardian->guardian_id)->guardian_contact_number;
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'profile';
    	return view('patient.profile', $params);
    }
    public function editprofile()
    {
        $patient = Patient::find(Auth::user()->user_id);
        $params['age'] = (date('Y') - date('Y',strtotime($patient->birthday)));
        $params['sex'] = $patient->sex;
        $params['degree_program'] = $patient->degree_program_id;
        $params['year_level'] = $patient->year_level;
        $params['birthday'] = $patient->birthday;
        $params['religion'] = Religion::find($patient->religion_id)->religion_description;
        $params['nationality'] = Nationality::find($patient->nationality_id)->nationality_description;
        $parents = HasParent::where('patient_id', Auth::user()->user_id)->get();
        foreach($parents as $parent)
        {
            if (ParentModel::find($parent->parent_id)->sex == 'M')
            {
                $params['father_first_name'] = ParentModel::find($parent->parent_id)->parent_first_name;
                $params['father_middle_name'] = ParentModel::find($parent->parent_id)->parent_middle_name;
                $params['father_last_name'] = ParentModel::find($parent->parent_id)->parent_last_name;
            }
            else{
                $params['mother_first_name'] = ParentModel::find($parent->parent_id)->parent_first_name;
                $params['mother_middle_name'] = ParentModel::find($parent->parent_id)->parent_middle_name;
                $params['mother_last_name'] = ParentModel::find($parent->parent_id)->parent_last_name;
            }
        }
        $params['street'] = $patient->street;
        $params['town'] = Town::find($patient->town_id)->town_name;
        $params['province'] = Province::find(Town::find($patient->town_id)->province_id)->province_name;
        $params['region'] = Region::find(Province::find(Town::find($patient->town_id)->province_id)->region_id)->region_name;
        $params['residence_telephone_number'] = $patient->residence_telephone_number;
        $params['personal_contact_number'] = $patient->personal_contact_number;
        $params['residence_contact_number'] = $patient->residence_contact_number;
        // $guardian = HasGuardian::where('patient_id', Auth::user()->user_id)->first();
        $guardian = HasGuardian::where('patient_id', Auth::user()->user_id)->first();
        $params['guardian_first_name'] = Guardian::find($guardian->guardian_id)->guardian_first_name;
        $params['guardian_middle_name'] = Guardian::find($guardian->guardian_id)->guardian_middle_name;
        $params['guardian_last_name'] = Guardian::find($guardian->guardian_id)->guardian_last_name;
        $params['guardian_street'] = Guardian::find($guardian->guardian_id)->street;
        $params['guardian_town'] = Town::find(Guardian::find($guardian->guardian_id)->town_id)->town_name;
        $params['guardian_province'] = Province::find(Town::find(Guardian::find($guardian->guardian_id)->town_id)->province_id)->province_name;
        $params['relationship'] = $guardian->relationship;
        $params['guardian_tel_number'] = Guardian::find($guardian->guardian_id)->guardian_telephone_number;
        $params['guardian_cellphone'] = Guardian::find($guardian->guardian_id)->guardian_contact_number;
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'profile';
        return view('patient.editprofile', $params);
    }

    public function updateprofile(Request $request)
    {
        $patient = Patient::find(Auth::user()->user_id);
        $patient->sex = $request->input('sex');
        $patient->degree_program_id = $request->input('degree_program');
        $patient->birthday = $request->input('birthdate');
        $religion = Religion::where('religion_description', $request->input('religion'))->first();
        // dd($religion->id);
        if(count($religion)>0)
        {
            $patient->religion_id = $religion->id;
        }
        else
        {
            $religion = new Religion;
            $religion->religion_description = $request->input('religion');
            $religion->save();
            $patient->religion_id = Religion::where('religion_description', $request->input('religion')->first()->id);
        }
        $nationality = Nationality::where('nationality_description', $request->input('nationality'))->first();
        // dd($religion->id);
        if(count($nationality)>0)
        {
            $patient->nationality_id = $nationality->id;
        }
        else
        {
            $nationality = new Nationality;
            $nationality->nationality_description = $request->input('nationality');
            $nationality->save();
            $patient->nationality_id = Nationality::where('nationality_description', $request->input('nationality')->first()->id);
        }
        $patient->update();
        // $request->session()->flash('alert-success', 'Update Success!');     
        return redirect('account/profile');
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
