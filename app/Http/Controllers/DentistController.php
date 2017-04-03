<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\DentalSchedule;
use App\DentalRecord;
use App\DentalAppointment;
use App\AdditionalDentalRecord;
use App\Patient;
use App\DegreeProgram;
use App\Religion;
use App\Nationality;
use App\ParentModel;
use App\HasParent;
use App\HasGuardian;
use App\Guardian;
use DB;
use App\Staff;
use App\Town;
use App\Province;
use App\DentalBilling;
use App\DentalService;
use App\MedicalHistory;
use Log;
use App\StaffNote;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class DentistController extends Controller
{
	public function __construct()
		{
			$this->middleware(function ($request, $next) {
				if(Auth::check()){
					if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 1){
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
			$user = Auth::user();
			$dental_appointments_today = DB::table('dental_schedules')->join('dental_appointments', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->join('patient_info', 'dental_appointments.patient_id', 'patient_info.patient_id')->whereDate('schedule_start', '=', date('Y-m-d'))->where('status', '0')->where('dental_schedules.staff_id', '=', Auth::user()->user_id)->orderBy('dental_schedules.schedule_start', 'asc')->paginate(15);
			$dental_appointments_future = DB::table('dental_schedules')->join('dental_appointments', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->join('patient_info', 'dental_appointments.patient_id', 'patient_info.patient_id')->whereDate('schedule_start', '>', date('Y-m-d'))->where('status', '0')->where('dental_schedules.staff_id', '=', Auth::user()->user_id)->orderBy('dental_schedules.schedule_start', 'asc')->get();
			$params['staff_notes'] = $staff_note = StaffNote::where('staff_id', Auth::user()->user_id)->first()->notes;
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'dashboard';
			return view('staff.dental-dentist.dashboard', $params, compact('dental_appointments_today', 'dental_appointments_future'));
		}
		public function totalnumberofdentalpatients(Request $request)
		{
			return response()->json([
			'finished' => count(DentalSchedule::join('dental_appointments', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->whereDate('schedule_start', '=', date('Y-m-d'))->where('dental_schedules.staff_id', Auth::user()->user_id)->where('status', '!=', '0')->get()),
			'unfinished' =>count(DentalSchedule::join('dental_appointments', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->whereDate('schedule_start', '=', date('Y-m-d'))->where('dental_schedules.staff_id', Auth::user()->user_id)->where('status', '0')->get())
			]);
		}

		public function updatestaffnotes(Request $request)
		{
			$staff_note = StaffNote::where('staff_id', Auth::user()->user_id)->first();
			$staff_note->notes = $request->note;
			$staff_note->update();
		}

		public function updatedentalrecord($id)
		{
			$appointment_id = $id;
			$patient_id = DentalAppointment::find($id)->patient_id;
			$params['appointment_id'] = $appointment_id;
			$params['dental_billing_services'] = DentalService::get();
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'dashboard';

			$patient_info = DentalAppointment::join('patient_info', 'dental_appointments.patient_id', '=', 'patient_info.patient_id')->join('dental_schedules', 'dental_appointments.dental_schedule_id', '=', 'dental_schedules.id')->orderBy('dental_schedules.schedule_start', 'desc')->where('dental_appointments.id', $appointment_id)->first();

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
			return view('staff.dental-dentist.adddentalrecord', $params, compact('patient_info', 'stacks_condition_color', 'stacks_operation_color', 'additional_dental_records'));
		}

		public function updatedentalrecordmodal(Request $request)
		{
			$teeth_id = $request->teeth_id;
			$teeth_info = DentalRecord::where('teeth_id', $teeth_id)->orderBy('created_at', 'desc')->select('condition_id', 'operation_id')->first();
			if(count($teeth_info) == 0){
				$condition_id = NULL;
				$operation_id = NULL;
			}
			else{
				$condition_id = $teeth_info->condition_id;
				$operation_id = $teeth_info->operation_id;
			}
			return response()->json(['condition_id' => $condition_id, 'operation_id' => $operation_id]); 

		}

		public function insertdentalrecordmodal(Request $request)
		{
	   	$current_dental_record = DentalRecord::where('dental_records.teeth_id', '=', $request->teeth_id)->where('dental_records.appointment_id', '=', $request->appointment_id)->get();

			if(count($current_dental_record) == 0)
    	{
      	$dental_record = new DentalRecord();
      	$dental_record->appointment_id = $request->appointment_id;
        $dental_record->teeth_id = $request->teeth_id;
        $dental_record->condition_id = $request->condition_id;
        $dental_record->operation_id = $request->operation_id;
        $dental_record->save();
    	}
    	else
    	{
    		DentalRecord::where('appointment_id', $request->appointment_id)->update(['condition_id' => $request->condition_id, 'operation_id' => $request->operation_id]);
    	}

    	return response()->json(['success' => 'success']); 
				 
		}

		public function updatedentaldiagnosis(Request $request)
		{
			DentalAppointment::where('dental_appointments.id', $request->appointment_id)->update(['status' => '1']);
	    return response()->json(['success' => $request->appointment_id]);		 
		}

	    public function profile()
	    {
	        $dentist = Staff::find(Auth::user()->user_id);
	        $params['sex'] = $dentist->sex;
	        $params['position'] = $dentist->position;
	        $params['birthday'] = $dentist->birthday;
	        $params['civil_status'] = $dentist->civil_status;
	        $params['personal_contact_number'] = $dentist->personal_contact_number;
	        $params['street'] = $dentist->street;
	        $params['picture'] = $dentist->picture;
	        if(!is_null($dentist->town_id))
	        {
	        	$params['town'] = Town::find($dentist->town_id)->town_name;
	        	$params['province'] = Province::find(Town::find($dentist->town_id)->province_id)->province_name;
	        }
	        else
	        {
	        	$params['town'] = '';
	        	$params['province'] = '';
	        }
	        $params['navbar_active'] = 'account';
	        $params['sidebar_active'] = 'profile';
	        $params['navbar_active'] = 'account';
	        $params['sidebar_active'] = 'profile';
	        return view('staff.dental-dentist.profile', $params);
	    }

	    public function editprofile()
	    {
	        $dentist = Staff::find(Auth::user()->user_id);
	        // $params['age'] = (date('Y') - date('Y',strtotime($dentist->birthday)));
	        $params['sex'] = $dentist->sex;
	        $params['position'] = $dentist->position;
	        $params['birthday'] = $dentist->birthday;
	        $params['civil_status'] = $dentist->civil_status;
	        $params['personal_contact_number'] = $dentist->personal_contact_number;
	        $params['street'] = $dentist->street;
	        if(!is_null($dentist->town_id))
	        {
	        	$params['town'] = Town::find($dentist->town_id)->town_name;
	        	$params['province'] = Province::find(Town::find($dentist->town_id)->province_id)->province_name;
	        }
	        else
	        {
	        	$params['town'] = '';
	        	$params['province'] = '';
	        }
	        
	        $params['navbar_active'] = 'account';
	        $params['sidebar_active'] = 'profile';
	        return view('staff.dental-dentist.editprofile', $params);
	    }

	    public function updateprofile(Request $request)
	    {
	    	if($request->updatepassword != "")
	        {
	            $user = Auth::user();
	            $user->password = bcrypt($request->updatepassword);
	            $user->update();
	        }
	        $dentist = Staff::find(Auth::user()->user_id);
	        $dentist->sex = $request->input('sex');
	        $dentist->birthday = $request->input('birthday');
	        $dentist->street = $request->input('street');
	        $dentist->position = $request->input('position');
	        $dentist->civil_status = $request->civil_status;
	        $province = Province::where('province_name', $request->input('province'))->first();
	   
	        if(count($province)>0)
	        {
	            // $dentist->nationality_id = $nationality->id;
	            $town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
	            if(count($town)>0)
	            {
	                $dentist->town_id = $town->id;
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
	                $dentist->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
	            $dentist->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
	        }

	        if (Input::file('picture') != NULL) { 
            $path = 'images';
						$file_name = Input::file('picture')->getClientOriginalName(); 
						$file_name_fin = $dentist->staff_id.'_'.$file_name;
						$image_type = pathinfo($file_name_fin,PATHINFO_EXTENSION);
						if($image_type == 'jpg' || $image_type == 'jpeg' || $image_type == 'png'){
							Input::file('picture')->move($path, $file_name_fin);
							$dentist->picture = $file_name_fin;
						}
	        }
	        
	        $dentist->personal_contact_number = $request->input('personal_contact_number');
	        $dentist->update();
	        return redirect('dentist/profile');
	    }

		public function manageschedule()
		{
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'manageschedule';
			return view('staff.dental-dentist.manageschedule', $params);
		}

		public function searchpatient()
		{
			$params['patients'] = DentalAppointment::where('status', '!=', '0')->select('dental_appointments.patient_id', 'patient_info.patient_first_name', 'patient_info.patient_last_name')->distinct()->join('patient_info', 'patient_info.patient_id', 'dental_appointments.patient_id')->orderBy('patient_last_name', 'asc')->get();
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.dental-dentist.searchpatient', $params);
		}
		public function searchpatientnamerecorddental(Request $request){

			// To fix: when searching for first name and last name combination
			// already fixed chereettt
			// dd($request->search_string);
			if($request->search_string!='')
			{
				$counter = 0;
				$search_string = explode(" ",$request->search_string);
				for($i=0; $i < sizeof($search_string); $i++)
				{
					$search_patient_id_records = Patient::where('patient_first_name', 'like', '%'.$search_string[$i].'%')->orWhere('patient_middle_name', 'like', '%'.$search_string[$i].'%')->orWhere('patient_last_name', 'like', '%'.$search_string[$i].'%')->pluck('patient_id')->all();
				}
				if(count($search_patient_id_records) > 0){
					$searchpatientfirstnamearray = array();
					$searchpatientlastnamearray = array();
					$searchpatientidarray = array();
					foreach ($search_patient_id_records as $search_patient_id_record)
					{
						array_push($searchpatientfirstnamearray, Patient::find($search_patient_id_record)->patient_first_name);
						array_push($searchpatientlastnamearray, Patient::find($search_patient_id_record)->patient_last_name);
						array_push($searchpatientidarray, $search_patient_id_record);
					}
					$counter++;
					return response()->json(['searchpatientidarray' => $searchpatientidarray, 'searchpatientfirstnamearray' => $searchpatientfirstnamearray, 'searchpatientlastnamearray' => $searchpatientlastnamearray, 'counter' => $counter]);
				}
				else
				{
					return response()->json(['counter' => $counter]);
				}
			}
			else
			{
				return response()->json(['counter' => 'blankstring']);
			}
		}
		public function displaypatientrecordsearchdental(Request $request)
		{
			$patient = Patient::find($request->patient_id);
			$birthday = explode("-",$patient->birthday);
			$params['age'] = Carbon::createFromDate($birthday[0], $birthday[1], $birthday[2])->age;

			$params['sex'] = $patient->sex;
			$params['picture'] = $patient->picture;
	        if($patient->patient_type_id == 1)
	        {
	        	$params['display_course_and_year_level'] = 1;
	        	$params['degree_program_description'] = DegreeProgram::find($patient->degree_program_id)->degree_program_description;
	        	
	        	$params['year_level'] = $patient->year_level; 
	        }
	        else
	        {
	        	$params['display_course_and_year_level'] = 0;
	        }
	        $params['birthday'] = date_format(date_create($patient->birthday), 'F j, Y');
	        $params['religion'] = Religion::find($patient->religion_id)->religion_description;
	        $params['nationality'] = Nationality::find($patient->nationality_id)->nationality_description;
	        $parents = HasParent::where('patient_id', $request->patient_id)->get();
	        foreach($parents as $parent)
	        {
	        	$parent_id = $parent->parent_id;
	            if (ParentModel::find($parent_id)->sex == 'M')
	            {
	            	$params['father_first_name'] = ParentModel::find($parent_id)->parent_first_name;
	                $params['father_middle_name'] = ParentModel::find($parent_id)->parent_middle_name;
	                $params['father_last_name'] = ParentModel::find($parent_id)->parent_last_name;
	            }
	            else{
	                $params['mother_first_name'] = ParentModel::find($parent_id)->parent_first_name;
	                $params['mother_middle_name'] = ParentModel::find($parent_id)->parent_middle_name;
	                $params['mother_last_name'] = ParentModel::find($parent_id)->parent_last_name;
	            }
	        }
	        $params['street'] = $patient->street;
	        $params['town'] = Town::find($patient->town_id)->town_name;
	        $params['province'] = Province::find(Town::find($patient->town_id)->province_id)->province_name;
	        $params['residence_telephone_number'] = $patient->residence_telephone_number;
	        $params['personal_contact_number'] = $patient->personal_contact_number;
	        $params['residence_contact_number'] = $patient->residence_contact_number;
	        $guardian = HasGuardian::where('patient_id', $request->patient_id)->first();
	        $guardian_info = Guardian::find($guardian->guardian_id);
	        $params['guardian_first_name'] = $guardian_info->guardian_first_name;
	        $params['guardian_middle_name'] = $guardian_info->guardian_middle_name;
	        $params['guardian_last_name'] = $guardian_info->guardian_last_name;
	        $params['guardian_street'] = $guardian_info->street;
	        $params['guardian_town'] = Town::find($guardian_info->town_id)->town_name;
	        $params['guardian_province'] = Province::find(Town::find($guardian_info->town_id)->province_id)->province_name;
	        $params['relationship'] = $guardian->relationship;
	        $params['guardian_tel_number'] = $guardian_info->guardian_telephone_number;
	        $params['guardian_cellphone'] = $guardian_info->guardian_contact_number;
	        $medical_history = MedicalHistory::where('patient_id', $request->patient_id)->first();
	        $params['illness'] = $medical_history->illness;
	        $params['operation'] = $medical_history->operation;
	        $params['allergies'] = $medical_history->allergies;
	        $params['family'] = $medical_history->family;
	        $params['maintenance_medication'] = $medical_history->maintenance_medication;
			return response()->json(['patient_info' => $params]);
		}
		public function viewrecords($id)
		{
			$params['records'] = DentalSchedule::join('dental_appointments', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->where('patient_id', $id)->get();
			// dd($params['records']);
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.dental-dentist.viewrecords', $params);
		}
		public function searchpatientbydate(){
			$params['patients'] = DentalAppointment::where('status', '!=', '0')->select('dental_appointments.patient_id', 'patient_info.patient_first_name', 'patient_info.patient_last_name')->distinct()->join('patient_info', 'patient_info.patient_id', 'dental_appointments.patient_id')->orderBy('patient_last_name', 'asc')->get();
			$params['years'] = DentalSchedule::select(DB::raw("YEAR(schedule_start) as year"))->groupBy(DB::raw("YEAR(schedule_start)"))->get();
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.dental-dentist.searchpatientbydate', $params);
		}

		public function searchpatientbydaterecorddental(Request $request){
			if($request->search_month!='00' || $request->search_date!='00' || $request->search_year!='00')
			{
				$counter = 0;
				if($request->search_month!='00' && $request->search_date=='00' && $request->search_year=='00')
				{
					$search_by_months = DentalSchedule::whereMonth('schedule_start', $request->search_month)->whereDay('schedule_start', '<=', date('Y-m-d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_months)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_months as $search_by_month){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_month->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);
								array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month=='00' && $request->search_date!='00' && $request->search_year=='00')
				{
					$search_by_dates = DentalSchedule::whereDay('schedule_start', $request->search_date)->whereDay('schedule_start', '<=', date('Y-m-d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_dates)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_dates as $search_by_date){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_date->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month=='00' && $request->search_date=='00' && $request->search_year!='00')
				{
					$sarch_by_years = DentalSchedule::whereYear('schedule_start', $request->search_year)->whereDay('schedule_start', '<=', date('Y-m-d'))->orderBy('schedule_start', 'asc')->get();
					if(count($sarch_by_years)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($sarch_by_years as $sarch_by_year){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $sarch_by_year->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month!='00' && $request->search_date!='00' && $request->search_year=='00')
				{
					$search_by_month_dates = DentalSchedule::whereMonth('schedule_start', $request->search_month)->whereDay('schedule_start', $request->search_date)->whereDay('schedule_start', '<=', date('Y-m-d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_month_dates)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_month_dates as $search_by_month_date){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_month_date->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month!='00' && $request->search_date!='00' && $request->search_year!='00')
				{
					$search_by_month_date_years = DentalSchedule::whereMonth('schedule_start', $request->search_month)->whereDay('schedule_start', $request->search_date)->whereYear('schedule_start', $request->search_year)->whereDay('schedule_start', '<=', date('Y-m-d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_month_date_years)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_month_date_years as $search_by_month_date_year){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_month_date_year->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month!='00' && $request->search_date=='00' && $request->search_year!='00')
				{
					$search_by_month_years = DentalSchedule::whereMonth('schedule_start', $request->search_month)->whereYear('schedule_start', $request->search_year)->whereDay('schedule_start', '<=', date('Y-m-d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_month_years)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_month_years as $search_by_month_year){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_month_year->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
					
				}
			}
			else
			{
				return response()->json(['counter' => 'blankstring']);
			}
		}
		public function addschedule(Request $request)
		{
				$schedules = $request->schedules;
				for($i=0; $i < sizeof($schedules); $i++){
					if($schedules[$i]!=''){
						$explode_schedules = explode(";;;", $schedules[$i]);
						$start = $explode_schedules[0];
						$end = $explode_schedules[1];
						$checker_if_exists = DentalSchedule::where('staff_id', Auth::user()->user_id)->where('schedule_start', $start)->where('schedule_end', $end)->first();
						if(count($checker_if_exists) == 0){
							$schedule = new DentalSchedule();
							$schedule->staff_id = Auth::user()->user_id;
							$schedule->schedule_start = $start;
							$schedule->schedule_end = $end;
							$schedule->save();
						}
					}
				}
				return response()->json(['success' => 'success']); 
		}

		public function hoverdentalchart(Request $request)
		{
				$teeth_id = $request->teeth_id;
				$type = $request->type;
				if($type == 'operation'){
					$dental_chart_hover_result = DB::table('dental_records')
			            ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $teeth_id],
						])
						->pluck('operation_id')
						->first();
				}
				else{
					$dental_chart_hover_result = DB::table('dental_records')
			            ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $teeth_id],
						])
						->pluck('condition_id')
						->first();
				}
	
				return response()->json(['id' => $dental_chart_hover_result, 'type' => $type]); 
		}

		public function additionaldentalrecord(Request $request)
		{
				$additional_dental_record = new AdditionalDentalRecord;
				$additional_dental_record->appointment_id = $request->appointment_id;
				$additional_dental_record->dental_caries = $request->dental_caries;
				$additional_dental_record->gingivitis = $request->gingivitis;
				$additional_dental_record->peridontal_pocket = $request->peridontal_pocket;
				$additional_dental_record->oral_debris = $request->oral_debris;
				$additional_dental_record->calculus = $request->calculus;
				$additional_dental_record->neoplasm = $request->neoplasm;
				$additional_dental_record->dental_facio_anomaly = $request->dental_facio_anomaly;
				$additional_dental_record->teeth_present = $request->teeth_present;
				$additional_dental_record->save();
		}

		public function viewdentalrecord($id)
		{
			$appointment_id = $id;
			$patient_id = DentalAppointment::find($id)->patient_id;
			$params['appointment_id'] = $appointment_id;
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'dashboard';

			$patient_info = DentalAppointment::join('patient_info', 'dental_appointments.patient_id', '=', 'patient_info.patient_id')->join('dental_schedules', 'dental_appointments.dental_schedule_id', '=', 'dental_schedules.id')->orderBy('dental_schedules.schedule_start', 'desc')->where('dental_appointments.id', $appointment_id)->first();

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
			return view('staff.dental-dentist.viewdentalrecord', $params, compact('patient_info', 'stacks_condition_color', 'stacks_operation_color', 'additional_dental_records'));
		}



	public function addbillingdental(Request $request){
		$appointment_id = $request->appointment_id;

		$patient_info = Patient::join('dental_appointments', 'patient_info.patient_id', 'dental_appointments.patient_id')->where('dental_appointments.id', $appointment_id)->first();
		$patient_name = $patient_info->patient_first_name . ' ' . $patient_info->patient_last_name;

		$checker = 0;
		$checker_if_exists_dental = DentalRecord::where('appointment_id', $appointment_id)->get();
		$checker_if_exists_additional_dental = AdditionalDentalRecord::where('appointment_id', $appointment_id)->get();
		if(count($checker_if_exists_dental)>0 && count($checker_if_exists_additional_dental)>0){
			$checker = 1;
		}
		
		$display_dental_services = DentalService::where('patient_type_id', '=', $patient_info->patient_type_id)->get();
		if($patient_info->patient_type_id == 5){
			$display_dental_services_senior = DentalService::where('patient_type_id', '=', 6)->get();
		}

		if($patient_info->patient_type_id == 5){
				return response()->json(['patient_info' => $patient_info, 
							'display_dental_services' => $display_dental_services,
							'display_dental_services_senior' => $display_dental_services_senior,  
							'checker' => $checker,
							'patient_type_id' => $patient_info->patient_type_id,
			]);
		}
		else{
			return response()->json(['patient_info' => $patient_info, 
							'display_dental_services' => $display_dental_services,
							'checker' => $checker,
							'patient_type_id' => $patient_info->patient_type_id,
			]);
		}
	}

	public function confirmbillingdental(Request $request){		
		$appointment_id = $request->appointment_id;
		$checked_services_array_id = $request->checked_services_array_id;
		$checked_services_array_rate = $request->checked_services_array_rate;
		for($i=0; $i < sizeof($checked_services_array_id); $i++){
		    $billing = new DentalBilling;
				$billing->dental_service_id = $checked_services_array_id[$i];
        $billing->appointment_id = $appointment_id;
        $billing->status = 'unpaid';
        $billing->amount = $checked_services_array_rate[$i];
        $billing->save();
		}
		DB::table('dental_appointments')
		      ->where('id', $appointment_id)
		      ->update(['status' => '1']);

		return response()->json(['success' => 'success']); 
	}
}
