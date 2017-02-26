<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
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
use App\MedicalAppointment;
use App\MedicalSchedule;
use App\Prescription;
use Illuminate\Support\Facades\Input;
class PatientController extends Controller
{
	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			if(Auth::check()){
				if(Auth::user()->user_type_id == 1){
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
		$params['medical_appointments'] = DB::table('medical_appointments')->join('medical_schedules', 'medical_schedules.id', '=', 'medical_appointments.medical_schedule_id')->join('staff_info', 'medical_schedules.staff_id', '=', 'staff_info.staff_id')->where('medical_appointments.patient_id', '=', Auth::user()->user_id)->get();
		$params['dental_appointments'] = DB::table('dental_appointments')->join('dental_schedules', 'dental_schedules.id', '=', 'dental_appointments.dental_schedule_id')->join('staff_info', 'dental_schedules.staff_id', '=', 'staff_info.staff_id')->where('dental_appointments.patient_id', '=', Auth::user()->user_id)->get();
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'dashboard';
		return view('patient.dashboard', $params);
	}

	public function getremarkspatientdashboard(Request $request)
	{
		$prescription = Prescription::where('medical_appointment_id', $request->medical_appointment_id)->first();
		if (count($prescription) == 1)
		{
			return response()->json(['success' => '1',
				'prescription' => $prescription->prescription,
				'date' => date_format(date_create($prescription->created_at), 'F j, Y')]);
		}
		else
		{
			return response()->json(['success' => '0']);
		}

	}

	public function profile()
	{
		$patient = Patient::find(Auth::user()->user_id);
		$params['age'] = (date('Y') - date('Y',strtotime($patient->birthday)));
		$params['sex'] = $patient->sex;
		if(Auth::user()->patient->patient_type_id ==1 )
		{
			$params['degree_program'] = DegreeProgram::find($patient->degree_program_id)->degree_program_description;
			$params['year_level'] = $patient->year_level;
		}
		
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
		$params['residence_telephone_number'] = $patient->residence_telephone_number;
		$params['personal_contact_number'] = $patient->personal_contact_number;
		$params['residence_contact_number'] = $patient->residence_contact_number;
		$params['picture'] = $patient->picture;
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
		if(Auth::user()->patient->patient_type_id == 1)
		{
		   $params['degree_program'] = $patient->degree_program_id;
		   $params['year_level'] = $patient->year_level; 
		}
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
		// $params['region'] = Region::find(Province::find(Town::find($patient->town_id)->province_id)->region_id)->region_name;
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
		return view('patient.editprofile', $params);
	}

	public function updateprofile(Request $request)
	{
		$patient = Patient::find(Auth::user()->user_id);
		$patient->sex = $request->input('sex');
		if(Auth::user()->patient->patient_type_id == 1)
		{
			$patient->degree_program_id = $request->input('degree_program');
			$patient->year_level = $request->input('year_level');
		}
		
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
			$patient->religion_id = Religion::where('religion_description', $request->input('religion'))->first()->id;
		}
		$nationality = Nationality::where('nationality_description', $request->input('nationality'))->first();
		if(count($nationality)>0)
		{
			$patient->nationality_id = $nationality->id;
		}
		else
		{
			$nationality = new Nationality;
			$nationality->nationality_description = $request->input('nationality');
			$nationality->save();
			$patient->nationality_id = Nationality::where('nationality_description', $request->input('nationality'))->first()->id;
		}

		if (Input::file('picture') != NULL) { 
			$path = '..\public\images';
			$file_name = Input::file('picture')->getClientOriginalName(); 
			Input::file('picture')->move($path, $file_name);
			$patient->picture = $file_name;
		}

		$parents = HasParent::where('patient_id', Auth::user()->user_id)->get();

		foreach($parents as $parent)
		{
			if (ParentModel::find($parent->parent_id)->sex == 'M')
			{
				$father = ParentModel::find($parent->parent_id);
				$father->parent_first_name = $request->input('father_first_name');
				$father->parent_middle_name = $request->input('father_middle_name');
				$father->parent_last_name = $request->input('father_last_name');
				$father->update();
			}
			else{
				$mother = ParentModel::find($parent->parent_id);
				$mother->parent_first_name = $request->input('mother_first_name');
				$mother->parent_middle_name = $request->input('mother_middle_name');
				$mother->parent_last_name = $request->input('mother_last_name');
				$mother->update();
			}
		}
		$patient->street = $request->input('street');
		$province = Province::where('province_name', $request->input('province'))->first();
		if(count($province)>0)
		{
			// $patient->nationality_id = $nationality->id;
			$town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
			if(count($town)>0)
			{
				$patient->town_id = $town->id;
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
				$patient->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
			$patient->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
		}
		$patient->residence_telephone_number = $request->input('residence_telephone_number');
		$patient->personal_contact_number = $request->input('personal_contact_number');
		$patient->residence_contact_number = $request->input('residence_contact_number');
		$guardian = HasGuardian::where('patient_id', Auth::user()->user_id)->first();
		$guardian_info = Guardian::find($guardian->guardian_id);
		$guardian_info->guardian_first_name = $request->input('guardian_first_name');
		$guardian_info->guardian_middle_name = $request->input('guardian_middle_name');
		$guardian_info->guardian_last_name = $request->input('guardian_last_name');
		$guardian_info->street;
		$guardian_province = Province::where('province_name', $request->input('guardian_province'))->first();
		if(count($guardian_province)>0)
		{
			$guardian_town = Town::where('town_name', $request->input('guardian_town'))->where('province_id', $guardian_province->id)->first();
			if(count($guardian_town)>0)
			{
				$guardian_info->town_id = $guardian_town->id;
			}
			else
			{
				$guardian_town = new Town;
				$guardian_town->town_name = $request->input('guardian_town');
				$guardian_town->province_id = $guardian_province->id;
				//insert the distance from miagao using Google Distance Matrix API
				$location = preg_replace("/\s+/", "+",$request->input('guardian_town')." ".$request->input('guardian_province'));
				$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
				$json = json_decode(file_get_contents($url), true);
				$distance=$json['rows'][0]['elements'][0]['distance']['value'];
				$guardian_town->distance_to_miagao = $distance/1000;
				$guardian_town->save();
				$guardian_info->town_id = Town::where('town_name', $request->input('guardian_town'))->where('province_id', $guardian_province->id)->first()->id;
			}
		}
		else
		{
			$guardian_province = new Province;
			$guardian_province->province_name = $request->input('guardian_province');
			$guardian_province->save();
			$guardian_town = new Town;
			$guardian_town->town_name = $request->input('guardian_town');
			$guardian_town->province_id = Province::where('province_name', $request->input('guardian_province'))->first()->id;
			$guardian_town->save();
			$guardian_info->town_id = Town::where('town_name', $request->input('guardian_town'))->where('province_id', Province::where('province_name', $request->input('guardian_province'))->first()->id)->first()->id;
		}
		$guardian->relationship = $request->input('relationship');
		$guardian_info->guardian_telephone_number = $request->input('guardian_tel_number');
		$guardian_info->guardian_contact_number = $request->input('guardian_cellphone');
		$guardian->update();
		$guardian_info->update();
		$patient->update();
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

	public function viewdentalrecorddashboard(Request $request)
	{
		$patient_id = $request->patient_id;

		$stacks_condition = array();
		$stacks_operation = array();
		for ($x = 55; $x >= 51; $x--)
		{
		$dental_chart_results = DB::table('dental_records')
				->orderBy('created_at', 'desc')
					->where('teeth_id', '=', $x)
					->pluck('condition_id')
					->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#ff4000";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ffff00";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#00ff00";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#00ffff";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#0000ff";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_condition, $dental_chart_results);


			$dental_chart_results = DB::table('dental_records')
			->orderBy('created_at', 'desc')
				->where('teeth_id', '=', $x)
			   
				->pluck('operation_id')
				->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#bf00ff";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ff0080";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#ff0000";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#808080";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#194d19";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_operation, $dental_chart_results);
		}

		$stacks_condition2 = array();
		$stacks_operation2 = array();
		for ($x = 61; $x <= 65; $x++)
		{
	    $dental_chart_results = DB::table('dental_records')
	    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
					->pluck('condition_id')
					->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#ff4000";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ffff00";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#00ff00";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#00ffff";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#0000ff";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_condition2, $dental_chart_results);


			$dental_chart_results = DB::table('dental_records')
			->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
		    ->orderBy('dental_records.created_at', 'desc')
				->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
				->pluck('operation_id')
				->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#bf00ff";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ff0080";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#ff0000";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#808080";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#194d19";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_operation2, $dental_chart_results);
		}

		$stacks_condition3 = array();
		$stacks_operation3 = array();
		for ($x = 18; $x >= 11; $x--)
		{
	    $dental_chart_results = DB::table('dental_records')
	    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
					->pluck('condition_id')
					->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#ff4000";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ffff00";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#00ff00";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#00ffff";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#0000ff";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_condition3, $dental_chart_results);


			$dental_chart_results = DB::table('dental_records')
			->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
		    ->orderBy('dental_records.created_at', 'desc')
				->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
				->pluck('operation_id')
				->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#bf00ff";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ff0080";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#ff0000";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#808080";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#194d19";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_operation3, $dental_chart_results);
		}

		$stacks_condition4 = array();
		$stacks_operation4 = array();
		for ($x = 21; $x <= 28; $x++)
		{
	    $dental_chart_results = DB::table('dental_records')
	    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
					->pluck('condition_id')
					->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#ff4000";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ffff00";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#00ff00";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#00ffff";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#0000ff";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_condition4, $dental_chart_results);


			$dental_chart_results = DB::table('dental_records')
			->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
		    ->orderBy('dental_records.created_at', 'desc')
				->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
				->pluck('operation_id')
				->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#bf00ff";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ff0080";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#ff0000";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#808080";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#194d19";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_operation4, $dental_chart_results);
		}

		$stacks_condition5 = array();
		$stacks_operation5 = array();
		for ($x = 48; $x >= 41; $x--)
		{
	    $dental_chart_results = DB::table('dental_records')
	    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
					->pluck('condition_id')
					->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#ff4000";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ffff00";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#00ff00";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#00ffff";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#0000ff";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_condition5, $dental_chart_results);


			$dental_chart_results = DB::table('dental_records')
			->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
		    ->orderBy('dental_records.created_at', 'desc')
				->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
				->pluck('operation_id')
				->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#bf00ff";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ff0080";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#ff0000";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#808080";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#194d19";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_operation5, $dental_chart_results);
		}

		$stacks_condition6 = array();
		$stacks_operation6 = array();
		for ($x = 31; $x <= 38; $x++)
		{
	    $dental_chart_results = DB::table('dental_records')
	    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
					->pluck('condition_id')
					->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#ff4000";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ffff00";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#00ff00";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#00ffff";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#0000ff";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_condition6, $dental_chart_results);


			$dental_chart_results = DB::table('dental_records')
			->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
		    ->orderBy('dental_records.created_at', 'desc')
				->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
				->pluck('operation_id')
				->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#bf00ff";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ff0080";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#ff0000";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#808080";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#194d19";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_operation6, $dental_chart_results);
		}

		$stacks_condition7 = array();
		$stacks_operation7 = array();
		for ($x = 85; $x >= 81; $x--)
		{
	    $dental_chart_results = DB::table('dental_records')
	    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
					->pluck('condition_id')
					->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#ff4000";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ffff00";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#00ff00";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#00ffff";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "0000ff";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_condition7, $dental_chart_results);


			$dental_chart_results = DB::table('dental_records')
			->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
		    ->orderBy('dental_records.created_at', 'desc')
				->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
				->pluck('operation_id')
				->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#bf00ff";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ff0080";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#ff0000";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#808080";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#194d19";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_operation7, $dental_chart_results);
		}

		$stacks_condition8 = array();
		$stacks_operation8 = array();
		for ($x = 71; $x <= 75; $x++)
		{
	    $dental_chart_results = DB::table('dental_records')
	    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
					->pluck('condition_id')
					->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#ff4000";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ffff00";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#00ff00";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#00ffff";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#0000ff";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_condition8, $dental_chart_results);


			$dental_chart_results = DB::table('dental_records')
			->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
		    ->orderBy('dental_records.created_at', 'desc')
				->where([
						['teeth_id', '=', $x],
						['patient_id', '=', $patient_id],
					])
				->pluck('operation_id')
				->first();

			if($dental_chart_results == 1){
				$dental_chart_results = "#bf00ff";
			}
			elseif($dental_chart_results == 2){
				$dental_chart_results = "#ff0080";
			}
			elseif($dental_chart_results == 3){
				$dental_chart_results = "#ff0000";
			}
			elseif($dental_chart_results == 4){
				$dental_chart_results = "#808080";
			}
			elseif($dental_chart_results == 5){
				$dental_chart_results = "#194d19";
			}
			else{
				$dental_chart_results = "white";
			}
			array_push($stacks_operation8, $dental_chart_results);
		}
		return response()->json([
			'stacks_condition' => $stacks_condition, 
			'stacks_operation' => $stacks_operation,
			'stacks_condition2' => $stacks_condition2, 
			'stacks_operation2' => $stacks_operation2,
			'stacks_condition3' => $stacks_condition3, 
			'stacks_operation3' => $stacks_operation3,
			'stacks_condition4' => $stacks_condition4, 
			'stacks_operation4' => $stacks_operation4,
			'stacks_condition5' => $stacks_condition5, 
			'stacks_operation5' => $stacks_operation5,
			'stacks_condition6' => $stacks_condition6, 
			'stacks_operation6' => $stacks_operation6,
			'stacks_condition7' => $stacks_condition7, 
			'stacks_operation7' => $stacks_operation7,
			'stacks_condition8' => $stacks_condition8, 
			'stacks_operation8' => $stacks_operation8,
			]); 
	}
}
