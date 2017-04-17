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
use App\DentalSchedule;
use App\Prescription;
use App\DentalRecord;
use App\AdditionalDentalRecord;
use App\DentalBilling;
use App\PhysicalExamination;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use File;

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

		$params['medical_appointments'] = MedicalSchedule::join('medical_appointments', 'medical_schedules.id', '=', 'medical_appointments.medical_schedule_id')->join('staff_info', 'medical_schedules.staff_id', '=', 'staff_info.staff_id')->where('medical_appointments.patient_id', '=', Auth::user()->user_id)->orderBy('schedule_day', 'desc')->get();
		$params['dental_appointments'] = DentalSchedule::join('dental_appointments', 'dental_schedules.id', '=', 'dental_appointments.dental_schedule_id')->join('staff_info', 'dental_schedules.staff_id', '=', 'staff_info.staff_id')->where('dental_appointments.patient_id', '=', Auth::user()->user_id)->orderBy('schedule_start', 'desc')->get();
    	$params['current_physical_status'] = PhysicalExamination::join('medical_appointments', 'medical_appointments.id', 'physical_examinations.medical_appointment_id')->where('patient_id', Auth::user()->user_id)->latest('physical_examinations.created_at')->select('physical_examinations.*', 'medical_appointments.*', 'physical_examinations.created_at as date_latest')->first();
        // dd($params['current_physical_status']);
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'dashboard';
		return view('patient.dashboard', $params);
	}

	public function getremarkspatientdashboard(Request $request)
	{
		$prescription = Prescription::where('medical_appointment_id', $request->medical_appointment_id)->first();

		$patient_senior_checker = Patient::join('senior_citizen_ids', 'patient_info.patient_id', 'senior_citizen_ids.patient_id')->join('medical_appointments', 'medical_appointments.patient_id', 'patient_info.patient_id')->where('medical_appointments.id', $request->medical_appointment_id)->get();
		if(count($patient_senior_checker) == 0){
			$patient_type_checker = Patient::join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')->where('medical_appointments.id', $request->medical_appointment_id)->pluck('patient_type_id')->first();
		}
		else{
			$patient_type_checker = $patient_senior_checker;
		}

		$display_medical_billing = DB::table('medical_billings')
        		->join('medical_services', 'medical_services.id', '=', 'medical_billings.medical_service_id')
        		->where('medical_billings.medical_appointment_id', '=', $request->medical_appointment_id)
        		->get();
 
    $payment_status = "unpaid";
    $medical_billing_status = DB::table('medical_billings')
        		->where('medical_billings.medical_appointment_id', '=', $request->medical_appointment_id)
        		->first();

    if(count($medical_billing_status) == 1 && $medical_billing_status->status=="paid"){
    	$payment_status = "paid";
    }
    $medical_receipt = DB::table('medical_appointments')
    				->join('patient_info', 'medical_appointments.patient_id', '=', 'patient_info.patient_id')
    				->join('medical_schedules', 'medical_appointments.medical_schedule_id', '=', 'medical_schedules.id')
    				->join('staff_info', 'medical_schedules.staff_id', '=', 'staff_info.staff_id')
        		->where('medical_appointments.id', '=', $request->medical_appointment_id)
        		->first();

		if (count($prescription) == 1)
		{
			return response()->json(['success' => '1',
				'prescription' => $prescription->prescription,
				'date' => date_format(date_create($prescription->created_at), 'F j, Y'),
				'display_medical_billing' => $display_medical_billing, 
				'payment_status' => $payment_status, 
				'medical_receipt' => $medical_receipt,
				'patient_type_checker' => $patient_type_checker,
				]);
		}
		else
		{
			return response()->json(['success' => '0', 
				'display_medical_billing' => $display_medical_billing,
				'payment_status' => $payment_status,
				'medical_receipt' => $medical_receipt, 
				'patient_type_checker' => $patient_type_checker,
				]);
		}
	}

	public function profile()
	{
		$patient = Patient::find(Auth::user()->user_id);
		$birthday = explode("-",$patient->birthday);
		$params['age'] = Carbon::createFromDate($birthday[0], $birthday[1], $birthday[2])->age;
		// $params['age'] = (date('Y') - date('Y',strtotime($patient->birthday)));
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
        if($request->updatepassword != "")
        {
            $user = Auth::user();
            $user->password = bcrypt($request->updatepassword);
            $user->update();
        }
		$patient = Patient::find(Auth::user()->user_id);
		$patient->sex = $request->input('sex');
		if(Auth::user()->patient->patient_type_id == 1)
		{
			$patient->degree_program_id = $request->input('degree_program');
			$patient->year_level = $request->input('year_level');
		}
		
		// $patient->birthday = $request->input('birthdate');
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
			$path = 'images';
			$file_name = Input::file('picture')->getClientOriginalName(); 
			$file_name_fin = $patient->patient_id.'_'.$file_name;
			$image_type = pathinfo($file_name_fin,PATHINFO_EXTENSION);
			if($image_type == 'jpg' || $image_type == 'jpeg' || $image_type == 'png'){
				Input::file('picture')->move($path, $file_name_fin);
				File::delete('images/'.$patient->picture);
				$patient->picture = $file_name_fin;
			}
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
				if($json['rows'][0]['elements'][0]['status'] == 'OK')
				{
					$distance=$json['rows'][0]['elements'][0]['distance']['value'];
					$town->distance_to_miagao = $distance/1000;
				}
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
			if($json['rows'][0]['elements'][0]['status'] == 'OK')
			{
				$distance=$json['rows'][0]['elements'][0]['distance']['value'];
				$town->distance_to_miagao = $distance/1000;
			}
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
		$guardian_info->street = $request->input('guardian_street');
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
				if($json['rows'][0]['elements'][0]['status'] == 'OK')
				{
					$distance=$json['rows'][0]['elements'][0]['distance']['value'];
					$guardian_town->distance_to_miagao = $distance/1000;
				}
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
		$params['medical_appointments'] = MedicalSchedule::join('medical_appointments', 'medical_schedules.id', '=', 'medical_appointments.medical_schedule_id')->join('staff_info', 'medical_schedules.staff_id', '=', 'staff_info.staff_id')->where('medical_appointments.patient_id', '=', Auth::user()->user_id)->orderBy('schedule_day', 'desc')->where('medical_appointments.status', '=', '2')->get();
		$params['dental_appointments'] = DentalSchedule::join('dental_appointments', 'dental_schedules.id', '=', 'dental_appointments.dental_schedule_id')->join('staff_info', 'dental_schedules.staff_id', '=', 'staff_info.staff_id')->where('dental_appointments.patient_id', '=', Auth::user()->user_id)->orderBy('schedule_start', 'desc')->where('dental_appointments.status', '=', '2')->get();
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
		$appointment_id = $request->appointment_id;

		$stacks_condition = array();
		$stacks_operation = array();
		for ($x = 55; $x >= 51; $x--)
		{
	    $dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	  	if(count($dental_chart_results) == 0){
	  		$condition_id = 6;
	  		$operation_id = 6;
	  	}
	  	else{
	  		$condition_id = $dental_chart_results->condition_id;
	  		$operation_id = $dental_chart_results->operation_id;
	  	}
	  	array_push($stacks_condition, $condition_id);
	  	array_push($stacks_operation, $operation_id);
	  }
		for ($x = 61; $x <= 65; $x++)
		{
			$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	  	if(count($dental_chart_results) == 0){
	  		$condition_id = 6;
	  		$operation_id = 6;
	  	}
	  	else{
	  		$condition_id = $dental_chart_results->condition_id;
	  		$operation_id = $dental_chart_results->operation_id;
	  	}
	  	array_push($stacks_condition, $condition_id);
	  	array_push($stacks_operation, $operation_id);
	  }
		for ($x = 18; $x >= 11; $x--)
		{
			$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	  	if(count($dental_chart_results) == 0){
	  		$condition_id = 6;
	  		$operation_id = 6;
	  	}
	  	else{
	  		$condition_id = $dental_chart_results->condition_id;
	  		$operation_id = $dental_chart_results->operation_id;
	  	}
	  	array_push($stacks_condition, $condition_id);
	  	array_push($stacks_operation, $operation_id);
	  }
		for ($x = 21; $x <= 28; $x++)
		{
	    $dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	    $dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	  	if(count($dental_chart_results) == 0){
	  		$condition_id = 6;
	  		$operation_id = 6;
	  	}
	  	else{
	  		$condition_id = $dental_chart_results->condition_id;
	  		$operation_id = $dental_chart_results->operation_id;
	  	}
	  	array_push($stacks_condition, $condition_id);
	  	array_push($stacks_operation, $operation_id);
		}
		for ($x = 48; $x >= 41; $x--)
		{
	    $dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
			$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	  	if(count($dental_chart_results) == 0){
	  		$condition_id = 6;
	  		$operation_id = 6;
	  	}
	  	else{
	  		$condition_id = $dental_chart_results->condition_id;
	  		$operation_id = $dental_chart_results->operation_id;
	  	}
	  	array_push($stacks_condition, $condition_id);
	  	array_push($stacks_operation, $operation_id);
		}
		for ($x = 31; $x <= 38; $x++)
		{
	  	$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
			$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	  	if(count($dental_chart_results) == 0){
	  		$condition_id = 6;
	  		$operation_id = 6;
	  	}
	  	else{
	  		$condition_id = $dental_chart_results->condition_id;
	  		$operation_id = $dental_chart_results->operation_id;
	  	}
	  	array_push($stacks_condition, $condition_id);
	  	array_push($stacks_operation, $operation_id);
		}
		for ($x = 85; $x >= 81; $x--)
		{
	  	$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
			$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	  	if(count($dental_chart_results) == 0){
	  		$condition_id = 6;
	  		$operation_id = 6;
	  	}
	  	else{
	  		$condition_id = $dental_chart_results->condition_id;
	  		$operation_id = $dental_chart_results->operation_id;
	  	}
	  	array_push($stacks_condition, $condition_id);
	  	array_push($stacks_operation, $operation_id);
		}
		for ($x = 71; $x <= 75; $x++)
		{
			$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
			$dental_chart_results = DentalRecord::join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id') ->orderBy('dental_records.created_at', 'desc')->where('teeth_id', $x)->where('patient_id', $patient_id)->select('condition_id', 'operation_id')->first();
	  	if(count($dental_chart_results) == 0){
	  		$condition_id = 6;
	  		$operation_id = 6;
	  	}
	  	else{
	  		$condition_id = $dental_chart_results->condition_id;
	  		$operation_id = $dental_chart_results->operation_id;
	  	}
	  	array_push($stacks_condition, $condition_id);
	  	array_push($stacks_operation, $operation_id);
		}
		$stacks_condition_color = array();
		$stacks_operation_color = array();
		foreach ($stacks_condition as $stack_condition) {
			if($stack_condition == 1){
				array_push($stacks_condition_color, "#ff4000");
			}
			elseif($stack_condition == 2){
				array_push($stacks_condition_color, "#ffff00");
			}
			elseif($stack_condition == 3){
				array_push($stacks_condition_color, "#00ff00");
			}
			elseif($stack_condition == 4){
				array_push($stacks_condition_color, "#00ffff");	
			}
			elseif($stack_condition == 5){
				array_push($stacks_condition_color, "#0000ff");
			}
			else{
				array_push($stacks_condition_color, "white");
			}
		}

		foreach ($stacks_operation as $stack_operation) {
			if($stack_operation == 1){
				array_push($stacks_operation_color, "#bf00ff");
			}
			elseif($stack_operation == 2){
				array_push($stacks_operation_color, "#ff0080");
			}
			elseif($stack_operation == 3){
				array_push($stacks_operation_color, "#ff0000");
			}
			elseif($stack_operation == 4){
				array_push($stacks_operation_color, "#808080");	
			}
			elseif($stack_operation == 5){
				array_push($stacks_operation_color, "#194d19");
			}
			else{
				array_push($stacks_operation_color, "white");
			}
		}
		$additional_dental_records = AdditionalDentalRecord::where('appointment_id', '=', $appointment_id)->first();
		if(count($additional_dental_records) == 0){
			$additional_dental_records = "no_additional_record";
 		}

 		$patient_senior_checker = Patient::join('senior_citizen_ids', 'patient_info.patient_id', 'senior_citizen_ids.patient_id')->join('dental_appointments', 'dental_appointments.patient_id', 'patient_info.patient_id')->where('dental_appointments.id', $appointment_id)->get();
		if(count($patient_senior_checker) == 0){
			$patient_type_checker = Patient::join('dental_appointments', 'patient_info.patient_id', 'dental_appointments.patient_id')->where('dental_appointments.id', $appointment_id)->pluck('patient_type_id')->first();
		}
		else{
			$patient_type_checker = $patient_senior_checker;
		}

		$display_dental_billing = DentalBilling::join('dental_services', 'dental_services.id', '=', 'dental_billings.dental_service_id')
        		->where('dental_billings.appointment_id', '=', $appointment_id)
        		->get();

    $payment_status = "unpaid";
    $dental_billing_status = DB::table('dental_billings')
        		->where('dental_billings.appointment_id', '=', $appointment_id)
        		->first();

    if(count($dental_billing_status) == 1 && $dental_billing_status->status=="paid"){
    	$payment_status = "paid";
    }
    $dental_receipt = DB::table('dental_appointments')
    				->join('patient_info', 'dental_appointments.patient_id', '=', 'patient_info.patient_id')
    				->join('dental_schedules', 'dental_appointments.dental_schedule_id', '=', 'dental_schedules.id')
    				->join('staff_info', 'dental_schedules.staff_id', '=', 'staff_info.staff_id')
        		->where('dental_appointments.id', '=', $appointment_id)
        		->first();

		return response()->json(['stacks_condition_color' => $stacks_condition_color, 
														'stacks_operation_color' => $stacks_operation_color,
														'stacks_condition' => $stacks_condition,
														'stacks_operation' => $stacks_operation,
														'additional_dental_records' => $additional_dental_records,
														'display_dental_billing' => $display_dental_billing,
														'payment_status' => $payment_status,
														'dental_receipt' => $dental_receipt, 
														'patient_type_checker' => $patient_type_checker,
														]); 
	}
}
