<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\DentalAppointment;
use App\MedicalAppointment;
use App\DentalSchedule;
use App\MedicalSchedule;
use App\Staff;
use App\Announcement;
use App\User;
use App\Patient;
use App\Religion;
use App\Nationality;
use App\Town;
use App\Province;
use App\ParentModel;
use App\HasParent;
use App\Guardian;
use App\HasGuardian;
use App\MedicalHistory;
use App\StudentNumber;
use DB;

class PagesController extends Controller
{

	public function index()
	{
		$params['navbar_active'] = 'home';
		$announcements = DB::table('announcements')
		->skip(0)
		->take(3)
		->get();
		return view('index', $params, compact('announcements'));
	}

	public function scheduleappointment()
	{
		$params['navbar_active'] = 'scheduleappointment';
		return view('scheduleappointment', $params);
	}

	public function announcements()
	{
		$params['navbar_active'] = 'announcements';
		$announcements = Announcement::orderBy('created_at', 'desc')
		->get();

		return view('announcements', $params, compact('announcements'));
	}

	public function seemoreannouncements(Request $request)
	{
    // $announcement_id = $request->announcement_id;
    // $see_more_announcements = DB::table('announcements')
    //         ->where('announcements.id', '=', $announcement_id)
    //         ->first();
    // return response()->json(['see_more_announcements' => $see_more_announcements]);
	}

	public function displayscheduledental(Request $request)
	{
		$dental_date = $request->dental_date;
		$display_schedules = DentalSchedule::all();
		$startdatesarray = array();
		$enddatesarray = array();
		$staffnamearray = array();
		$scheduleidarray = array();
		foreach ($display_schedules as $display_schedule){
			$datestartdental=explode(" ", $display_schedule->schedule_start);
			$dateenddental=explode(" ", $display_schedule->schedule_end);
			$scheduleid = $display_schedule->id;
			if ($datestartdental[0] == $dental_date){
				$staff = Staff::where('staff_id', $display_schedule->staff_id)->first();
				array_push($startdatesarray, $datestartdental[1]);
				array_push($enddatesarray, $dateenddental[1]);
				array_push($staffnamearray,  $staff->staff_first_name .' '. $staff->staff_last_name);
				array_push($scheduleidarray,  $scheduleid);
			}
		}
		return response()->json(['start' => $startdatesarray,'end' => $enddatesarray,'staff' => $staffnamearray ,'id' => $scheduleidarray]); 
	}

	public function displayschedulemedical(Request $request)
	{
		$medical_date = $request->medical_date;
		$display_schedules = MedicalSchedule::where('schedule_day', $medical_date)->get();
		$staffnamearray = array();
		$scheduleidarray = array();
		foreach ($display_schedules as $display_schedule){
			$staff = Staff::where('staff_id', $display_schedule->staff_id)->first();
			$scheduleid = $display_schedule->id;
			array_push($staffnamearray,  $staff->staff_first_name .' '. $staff->staff_last_name);
			array_push($scheduleidarray, $scheduleid);
		}
		return response()->json(['staff' => $staffnamearray, 'id' => $scheduleidarray]); 
	}

	public function createappointmentdental(Request $request)
	{
		if(Auth::check()){
			if(Auth::user()->user_type_id == 1){
				$dental_appointment = new DentalAppointment;
				$dental_appointment->patient_id = Auth::user()->user_id;
				$dental_appointment->dental_schedule_id = $request->dental_schedule_id;
				$dental_appointment->reasons = $request->reasons;
				$dental_appointment->save();
				return response()->json(['success' => 'yes']);
			}
		}
		else
		{
			return response()->json(['success' => 'no']);
		}
	}

	public function createappointmentmedical(Request $request)
	{
		if(Auth::check()){
			if(Auth::user()->user_type_id == 1){
				$medical_appointment = new MedicalAppointment;
				$medical_appointment->patient_id = Auth::user()->user_id;
				$medical_appointment->medical_schedule_id = $request->medical_schedule_id;
				$medical_appointment->reasons = $request->reasons;
				$medical_appointment->save();
				return response()->json(['success' => 'yes']);
			}
		}
		else
		{
			return response()->json(['success' => 'no']);
		}
	}

	public function loginfromdentalappointment(Request $request)
	{
		$hashedPassword = User::where('user_id', $request->user_name_modal_dental)->first();
		if (count($hashedPassword)==1 && Hash::check($request->password_modal_dental, $hashedPassword->password))
		{
			Auth::loginUsingId($request->user_name_modal_dental, true);
			$dental_appointment = new DentalAppointment;
			$dental_appointment->patient_id = Auth::user()->user_id;
			$dental_appointment->dental_schedule_id = $request->dental_schedule_id;
			$dental_appointment->reasons = $request->reasons;
			$dental_appointment->save();
			return response()->json(['passwordmatch' => 'yes']);
		}
		else{
			return response()->json(['passwordmatch' => 'no']);
		}
	}

	public function loginfrommedicalappointment(Request $request)
	{
		$hashedPassword = User::where('user_id', $request->user_name_modal_medical)->first();
		if (count($hashedPassword)==1 && Hash::check($request->password_modal_medical, $hashedPassword->password))
		{
			Auth::loginUsingId($request->user_name_modal_medical, true);
			$medical_appointment = new MedicalAppointment;
			$medical_appointment->patient_id = Auth::user()->user_id;
			$medical_appointment->medical_schedule_id = $request->medical_schedule_id;
			$medical_appointment->reasons = $request->reasons;
			$medical_appointment->save();
			return response()->json(['passwordmatch' => 'yes']);
		}
		else{
			return response()->json(['passwordmatch' => 'no']);
		}
	}

	public function signupfromdentalappointment(Request $request)
	{
		$check_if_already_exists = User::where('user_id', $request->user_name)->first();
		if(count($check_if_already_exists) == 1)
		{
			return response()->json(['message' =>'User already exists.']);
		}
		else
		{
			$check_student_database = StudentNumber::where('student_number', $request->user_name)->first();
			// dd($check_student_database);
			if(count($check_student_database) == 1)
			{
				$user = new User;
				$user->user_id = $request->user_name;
				$user->user_type_id = 1;
				$user->password = bcrypt($request->password);
				$user->save();
				$patient = new Patient;
				$patient->patient_id = $request->user_name;
				$patient->patient_type_id = $request->patient_type_id;
				$patient->patient_first_name = $request->first_name;
				$patient->patient_middle_name = $request->middle_name;
				$patient->patient_last_name = $request->last_name;
				$patient->year_level = $request->year_level;
				$patient->degree_program_id = $request->degree_program_id;
				$patient->sex = $request->sex;
				$patient->birthday = $request->birthdate;
				$patient->civil_status = 'Single';
				$religion = Religion::where('religion_description', $request->input)->first();

				if(count($religion)>0)
				{
					$patient->religion_id = $religion->id;
				}
				else
				{
					$religion = new Religion;
					$religion->religion_description = $request->religion;
					$religion->save();
					$patient->religion_id = Religion::where('religion_description', $request->religion)->first()->id;
				}
				$nationality = Nationality::where('nationality_description', $request->nationality)->first();
        // dd($religion->id);
				if(count($nationality)>0)
				{
					$patient->nationality_id = $nationality->id;
				}
				else
				{
					$nationality = new Nationality;
					$nationality->nationality_description = $request->nationality;
					$nationality->save();
					$patient->nationality_id = Nationality::where('nationality_description', $request->nationality)->first()->id;
				}
				$patient->street = $request->street;
				$province = Province::where('province_name', $request->province)->first();
				if(count($province)>0)
				{
					$town = Town::where('town_name', $request->town)->where('province_id', $province->id)->first();
					if(count($town)>0)
					{
						$patient->town_id = $town->id;
					}
					else
					{
						$town = new Town;
						$town->town_name = $request->town;
						$town->province_id = $province->id;
            	//insert the distance from miagao using Google Distance Matrix API
						$location = preg_replace("/\s+/", "+",$request->town." ".$request->province);
						$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
						$json = json_decode(file_get_contents($url), true);
						$distance=$json['rows'][0]['elements'][0]['distance']['value'];
						$town->distance_to_miagao = $distance/1000;
						$town->save();
						$patient->town_id = Town::where('town_name', $request->town)->where('province_id', $province->id)->first()->id;
					}
				}
				else
				{
					$province = new Province;
					$province->province_name = $request->province;
					$province->save();
					$town = new Town;
					$town->town_name = $request->town;
					$town->province_id = Province::where('province_name', $request->province)->first()->id;
					$location = preg_replace("/\s+/", "+",$request->town." ".$request->province);
					$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
					$json = json_decode(file_get_contents($url), true);
					$distance=$json['rows'][0]['elements'][0]['distance']['value'];
					$town->distance_to_miagao = $distance/1000;
					$town->save();
					$patient->town_id = Town::where('town_name', $request->town)->where('province_id', Province::where('province_name', $request->province)->first()->id)->first()->id;
				}
				$patient->residence_telephone_number = $request->residencetelephone;
				$patient->personal_contact_number = $request->personalcontactnumber;
				$patient->residence_contact_number = $request->residencecellphone;
				$patient->save();
				$check_if_father_exists = ParentModel::where('parent_first_name', $request->father_first_name)->where('parent_middle_name', $request->father_middle_name)->where('parent_last_name', $request->father_last_name)->first();
				if(count($check_if_father_exists) == 0)
				{
					$father = new ParentModel;
					$father->parent_first_name = $request->father_first_name;
					$father->parent_middle_name = $request->father_middle_name;
					$father->parent_last_name = $request->father_last_name;
					$father->sex = 'M';
					$father->save();
				}
				$check_if_mother_exists = ParentModel::where('parent_first_name', $request->mother_first_name)->where('parent_middle_name', $request->mother_middle_name)->where('parent_last_name', $request->mother_last_name)->first();
				if(count($check_if_mother_exists) == 0)
				{
					$mother = new ParentModel;
					$mother->parent_first_name = $request->mother_first_name;
					$mother->parent_middle_name = $request->mother_middle_name;
					$mother->parent_last_name = $request->mother_last_name;
					$mother->sex = 'F';
					$mother->save();
				}

				$has_father = new HasParent;
				$has_father->patient_id = $request->user_name;
				$has_father->parent_id = ParentModel::where('parent_first_name', $request->father_first_name)->where('parent_middle_name', $request->father_middle_name)->where('parent_last_name', $request->father_last_name)->first()->id;
				$has_father->save();
				$has_mother = new HasParent;
				$has_mother->patient_id = $request->user_name;
				$has_mother->parent_id = ParentModel::where('parent_first_name', $request->mother_first_name)->where('parent_middle_name', $request->mother_middle_name)->where('parent_last_name', $request->mother_last_name)->first()->id;
				$has_mother->save();
				$check_if_guardian_exists = Guardian::where('guardian_first_name', $request->guardian_first_name)->where('guardian_middle_name', $request->guardian_middle_name)->where('guardian_last_name', $request->guardian_last_name)->first();
				if(count($check_if_guardian_exists) == 0)
				{
					$guardian = new Guardian;
					$guardian->guardian_first_name = $request->guardian_first_name;
					$guardian->guardian_middle_name = $request->guardian_middle_name;
					$guardian->guardian_last_name = $request->guardian_last_name;
					$guardian->guardian_contact_number = $request->guardianresidencecellphone;
					$guardian->guardian_telephone_number = $request->guardianresidencetelephone;
					$guardian->street = $request->guardian_street;
					$guardian_province = Province::where('province_name', $request->guardian_province)->first();
					if(count($guardian_province)>0)
					{
						$guardian_town = Town::where('town_name', $request->guardian_town)->where('province_id', $guardian_province->id)->first();
						if(count($guardian_town)>0)
						{
							$guardian->town_id = $guardian_town->id;
						}
						else
						{
							$guardian_town = new Town;
							$guardian_town->town_name = $request->guardian_town;
							$guardian_town->province_id = $guardian_province->id;
	         		//insert the distance from miagao using Google Distance Matrix API
							$guardian_town->save();
							$guardian->town_id = Town::where('town_name', $request->guardian_town)->where('province_id', $guardian_province->id)->first()->id;
						}
					}
					else
					{
						$guardian_province = new Province;
						$guardian_province->province_name = $request->guardian_province;
						$guardian_province->save();
						$guardian_town = new Town;
						$guardian_town->town_name = $request->guardian_town;
						$guardian_town->province_id = Province::where('province_name', $request->guardian_province)->first()->id;
						$guardian_town->save();
						$guardian->town_id = Town::where('town_name', $request->guardian_town)->where('province_id', Province::where('province_name', $request->guardian_province)->first()->id)->first()->id;
					}
					$guardian->save();
				}
				$has_guardian = new HasGuardian;
				$has_guardian->patient_id = $request->user_name;
				$has_guardian->guardian_id = Guardian::where('guardian_first_name', $request->guardian_first_name)->where('guardian_middle_name', $request->guardian_middle_name)->where('guardian_last_name', $request->guardian_last_name)->first()->id;
				$has_guardian->relationship = $request->guardian_relationship;
				$has_guardian->save();
				$medical_history = new MedicalHistory;
				$medical_history->patient_id = $request->user_name;
				$medical_history->illness = $request->illness_history;
				$medical_history->operation = $request->operation_history;
				$medical_history->allergies = $request->allergies_history;
				$medical_history->family = $request->family_history;
				$medical_history->maintenance_medication = $request->maintenance_medication_history;
				$medical_history->save();

				$dental_appointment = new DentalAppointment;
				$dental_appointment->patient_id = $request->user_name;
				$dental_appointment->dental_schedule_id = $request->schedule_id;
				$dental_appointment->reasons = $request->reasons;
				$dental_appointment->save();
				Auth::loginUsingId($request->user_name, true);
				return response()->json(['message' => 'Success']);
			}
			else
			{
				return response()->json(['message' =>'User is not included in the student database. Please contact UPV HSU immediately.']);
			}
		}
	}

	public function signupfrommedicalappointment(Request $request)
	{
		$check_if_already_exists = User::where('user_id', $request->user_name)->first();
		if(count($check_if_already_exists) == 1)
		{
			return response()->json(['message' =>'User already exists.']);
		}
		else
		{
			$check_student_database = StudentNumber::where('student_number', $request->user_name)->first();
			// dd($check_student_database);
			if(count($check_student_database) == 1)
			{
				$user = new User;
				$user->user_id = $request->user_name;
				$user->user_type_id = 1;
				$user->password = bcrypt($request->password);
				$user->save();
				$patient = new Patient;
				$patient->patient_id = $request->user_name;
				$patient->patient_type_id = $request->patient_type_id;
				$patient->patient_first_name = $request->first_name;
				$patient->patient_middle_name = $request->middle_name;
				$patient->patient_last_name = $request->last_name;
				$patient->year_level = $request->year_level;
				$patient->degree_program_id = $request->degree_program_id;
				$patient->sex = $request->sex;
				$patient->birthday = $request->birthdate;
				$patient->civil_status = 'Single';
				$religion = Religion::where('religion_description', $request->input)->first();
        // dd($religion->id);
				if(count($religion)>0)
				{
					$patient->religion_id = $religion->id;
				}
				else
				{
					$religion = new Religion;
					$religion->religion_description = $request->religion;
					$religion->save();
					$patient->religion_id = Religion::where('religion_description', $request->religion)->first()->id;
				}
				$nationality = Nationality::where('nationality_description', $request->nationality)->first();
        // dd($religion->id);
				if(count($nationality)>0)
				{
					$patient->nationality_id = $nationality->id;
				}
				else
				{
					$nationality = new Nationality;
					$nationality->nationality_description = $request->nationality;
					$nationality->save();
					$patient->nationality_id = Nationality::where('nationality_description', $request->nationality)->first()->id;
				}
				$patient->street = $request->street;
				$province = Province::where('province_name', $request->province)->first();
				if(count($province)>0)
				{
					$town = Town::where('town_name', $request->town)->where('province_id', $province->id)->first();
					if(count($town)>0)
					{
						$patient->town_id = $town->id;
					}
					else
					{
						$town = new Town;
						$town->town_name = $request->town;
						$town->province_id = $province->id;
            	//insert the distance from miagao using Google Distance Matrix API
						$town->save();
						$patient->town_id = Town::where('town_name', $request->town)->where('province_id', $province->id)->first()->id;
					}
				}
				else
				{
					$province = new Province;
					$province->province_name = $request->province;
					$province->save();
					$town = new Town;
					$town->town_name = $request->town;
					$town->province_id = Province::where('province_name', $request->province)->first()->id;
					$town->save();
					$patient->town_id = Town::where('town_name', $request->town)->where('province_id', Province::where('province_name', $request->province)->first()->id)->first()->id;
				}
				$patient->residence_telephone_number = $request->residencetelephone;
				$patient->personal_contact_number = $request->personalcontactnumber;
				$patient->residence_contact_number = $request->residencecellphone;
				$patient->save();
				$check_if_father_exists = ParentModel::where('parent_first_name', $request->father_first_name)->where('parent_middle_name', $request->father_middle_name)->where('parent_last_name', $request->father_last_name)->first();
				if(count($check_if_father_exists) == 0)
				{
					$father = new ParentModel;
					$father->parent_first_name = $request->father_first_name;
					$father->parent_middle_name = $request->father_middle_name;
					$father->parent_last_name = $request->father_last_name;
					$father->sex = 'M';
					$father->save();
				}
				$check_if_mother_exists = ParentModel::where('parent_first_name', $request->mother_first_name)->where('parent_middle_name', $request->mother_middle_name)->where('parent_last_name', $request->mother_last_name)->first();
				if(count($check_if_mother_exists) == 0)
				{
					$mother = new ParentModel;
					$mother->parent_first_name = $request->mother_first_name;
					$mother->parent_middle_name = $request->mother_middle_name;
					$mother->parent_last_name = $request->mother_last_name;
					$mother->sex = 'F';
					$mother->save();
				}

				$has_father = new HasParent;
				$has_father->patient_id = $request->user_name;
				$has_father->parent_id = ParentModel::where('parent_first_name', $request->father_first_name)->where('parent_middle_name', $request->father_middle_name)->where('parent_last_name', $request->father_last_name)->first()->id;
				$has_father->save();
				$has_mother = new HasParent;
				$has_mother->patient_id = $request->user_name;
				$has_mother->parent_id = ParentModel::where('parent_first_name', $request->mother_first_name)->where('parent_middle_name', $request->mother_middle_name)->where('parent_last_name', $request->mother_last_name)->first()->id;
				$has_mother->save();
				$check_if_guardian_exists = Guardian::where('guardian_first_name', $request->guardian_first_name)->where('guardian_middle_name', $request->guardian_middle_name)->where('guardian_last_name', $request->guardian_last_name)->first();
				if(count($check_if_guardian_exists) == 0)
				{
					$guardian = new Guardian;
					$guardian->guardian_first_name = $request->guardian_first_name;
					$guardian->guardian_middle_name = $request->guardian_middle_name;
					$guardian->guardian_last_name = $request->guardian_last_name;
					$guardian->guardian_contact_number = $request->guardianresidencecellphone;
					$guardian->guardian_telephone_number = $request->guardianresidencetelephone;
					$guardian->street = $request->guardian_street;
					$guardian_province = Province::where('province_name', $request->guardian_province)->first();
					if(count($guardian_province)>0)
					{
						$guardian_town = Town::where('town_name', $request->guardian_town)->where('province_id', $guardian_province->id)->first();
						if(count($guardian_town)>0)
						{
							$guardian->town_id = $guardian_town->id;
						}
						else
						{
							$guardian_town = new Town;
							$guardian_town->town_name = $request->guardian_town;
							$guardian_town->province_id = $guardian_province->id;
	         		//insert the distance from miagao using Google Distance Matrix API
							$guardian_town->save();
							$guardian->town_id = Town::where('town_name', $request->guardian_town)->where('province_id', $guardian_province->id)->first()->id;
						}
					}
					else
					{
						$guardian_province = new Province;
						$guardian_province->province_name = $request->guardian_province;
						$guardian_province->save();
						$guardian_town = new Town;
						$guardian_town->town_name = $request->guardian_town;
						$guardian_town->province_id = Province::where('province_name', $request->guardian_province)->first()->id;
						$guardian_town->save();
						$guardian->town_id = Town::where('town_name', $request->guardian_town)->where('province_id', Province::where('province_name', $request->guardian_province)->first()->id)->first()->id;
					}
					$guardian->save();
				}
				$has_guardian = new HasGuardian;
				$has_guardian->patient_id = $request->user_name;
				$has_guardian->guardian_id = Guardian::where('guardian_first_name', $request->guardian_first_name)->where('guardian_middle_name', $request->guardian_middle_name)->where('guardian_last_name', $request->guardian_last_name)->first()->id;
				$has_guardian->relationship = $request->guardian_relationship;
				$has_guardian->save();
				$medical_history = new MedicalHistory;
				$medical_history->patient_id = $request->user_name;
				$medical_history->illness = $request->illness_history;
				$medical_history->operation = $request->operation_history;
				$medical_history->allergies = $request->allergies_history;
				$medical_history->family = $request->family_history;
				$medical_history->maintenance_medication = $request->maintenance_medication_history;
				$medical_history->save();

				$medical_appointment = new MedicalAppointment;
				$medical_appointment->patient_id = $request->user_name;
				$medical_appointment->medical_schedule_id = $request->schedule_id;
				$medical_appointment->reasons = $request->reasons;
				$medical_appointment->save();
				Auth::loginUsingId($request->user_name, true);
				return response()->json(['message' => 'Success']);
			}
			else
			{
				return response()->json(['message' =>'User is not included in the student database. Please contact UPV HSU immediately.']);
			}
			
		}
	}
}