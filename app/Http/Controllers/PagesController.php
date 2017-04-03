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
use App\MedicalService;
use App\DentalService;
use DB;

class PagesController extends Controller
{

	public function index()
	{
		$params['navbar_active'] = 'home';
		$params['announcements'] = Announcement::take(6)->orderBy('created_at', 'desc')->get();
		$params['staffs'] = Staff::take(15)->orderBy('staff_last_name', 'asc')->get();
		return view('index', $params);
	}
	public function announcementmodal(Request $request)
	{
		$announcement = Announcement::find($request->announcement_id);
		return response()->json(['announcement' => $announcement]);

	}

	public function about()
	{
		$user = Auth::user();
		$params['navbar_active'] = 'about';

		$studentdisplaymedicalservices = MedicalService::where('service_type', 'medical')->select('service_description', 'student_rate')->get();
		$facultydisplaymedicalservices = MedicalService::where('service_type', 'medical')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$staffdisplaymedicalservices = MedicalService::where('service_type', 'medical')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$dependentdisplaymedicalservices = MedicalService::where('service_type', 'medical')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$opddisplaymedicalservices = MedicalService::where('service_type', 'medical')->select('service_description', 'opd_rate')->get();
		$seniordisplaymedicalservices = MedicalService::where('service_type', 'medical')->select('service_description', 'senior_rate')->get();

		$studentdisplaydentalservices = DentalService::select('service_description', 'student_rate')->get();
		$facultydisplaydentalservices = DentalService::select('service_description', 'faculty_staff_dependent_rate')->get();
		$staffdisplaydentalservices = DentalService::select('service_description', 'faculty_staff_dependent_rate')->get();
		$dependentdisplaydentalservices = DentalService::select('service_description', 'faculty_staff_dependent_rate')->get();
		$opddisplaydentalservices = DentalService::select('service_description', 'opd_rate')->get();
		$seniordisplaydentalservices = DentalService::select('service_description', 'senior_rate')->get();

		$studentdisplaycbcservices = MedicalService::where('service_type', 'cbc')->select('service_description', 'student_rate')->get();
		$facultydisplaycbcservices = MedicalService::where('service_type', 'cbc')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$staffdisplaycbcservices = MedicalService::where('service_type', 'cbc')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$dependentdisplaycbcservices = MedicalService::where('service_type', 'cbc')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$opddisplaycbcservices = MedicalService::where('service_type', 'cbc')->select('service_description', 'opd_rate')->get();
		$seniordisplaycbcservices = MedicalService::where('service_type', 'cbc')->select('service_description', 'senior_rate')->get();

		$studentdisplaydrugservices = MedicalService::where('service_type', 'drugtest')->select('service_description', 'student_rate')->get();
		$facultydisplaydrugservices = MedicalService::where('service_type', 'drugtest')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$staffdisplaydrugservices = MedicalService::where('service_type', 'drugtest')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$dependentdisplaydrugservices = MedicalService::where('service_type', 'drugtest')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$opddisplaydrugservices = MedicalService::where('service_type', 'drugtest')->select('service_description', 'opd_rate')->get();
		$seniordisplaydrugservices = MedicalService::where('service_type', 'drugtest')->select('service_description', 'senior_rate')->get();

		$studentdisplayfecalysisservices = MedicalService::where('service_type', 'fecalysis')->select('service_description', 'student_rate')->get();
		$facultydisplayfecalysisservices = MedicalService::where('service_type', 'fecalysis')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$staffdisplayfecalysisservices = MedicalService::where('service_type', 'fecalysis')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$dependentdisplayfecalysisservices = MedicalService::where('service_type', 'fecalysis')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$opddisplayfecalysisservices = MedicalService::where('service_type', 'fecalysis')->select('service_description', 'opd_rate')->get();
		$seniordisplayfecalysisservices = MedicalService::where('service_type', 'fecalysis')->select('service_description', 'senior_rate')->get();

		$studentdisplayurinalysisservices = MedicalService::where('service_type', 'urinalysis')->select('service_description', 'student_rate')->get();
		$facultydisplayurinalysisservices = MedicalService::where('service_type', 'urinalysis')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$staffdisplayurinalysisservices = MedicalService::where('service_type', 'urinalysis')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$dependentdisplayurinalysisservices = MedicalService::where('service_type', 'urinalysis')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$opddisplayurinalysisservices = MedicalService::where('service_type', 'urinalysis')->select('service_description', 'opd_rate')->get();
		$seniordisplayurinalysisservices = MedicalService::where('service_type', 'urinalysis')->select('service_description', 'senior_rate')->get();

		$studentdisplayxrayservices = MedicalService::where('service_type', 'xray')->select('service_description', 'student_rate')->get();
		$facultydisplayxrayservices = MedicalService::where('service_type', 'xray')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$staffdisplayxrayservices = MedicalService::where('service_type', 'xray')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$dependentdisplayxrayservices = MedicalService::where('service_type', 'xray')->select('service_description', 'faculty_staff_dependent_rate')->get();
		$opddisplayxrayservices = MedicalService::where('service_type', 'xray')->select('service_description', 'opd_rate')->get();
		$seniordisplayxrayservices = MedicalService::where('service_type', 'xray')->select('service_description', 'senior_rate')->get();

		return view('about', $params, compact('studentdisplaymedicalservices', 'facultydisplaymedicalservices', 'staffdisplaymedicalservices', 'dependentdisplaymedicalservices', 'opddisplaymedicalservices', 'seniordisplaymedicalservices',
																					'studentdisplaydentalservices', 'facultydisplaydentalservices', 'staffdisplaydentalservices', 'dependentdisplaydentalservices', 'opddisplaydentalservices', 'seniordisplaydentalservices',   
																					'studentdisplaycbcservices', 'facultydisplaycbcservices', 'staffdisplaycbcservices', 'dependentdisplaycbcservices', 'opddisplaycbcservices', 'seniordisplaycbcservices', 
																					'studentdisplaydrugservices', 'facultydisplaydrugservices', 'staffdisplaydrugservices', 'dependentdisplaydrugservices', 'opddisplaydrugservices', 'seniordisplaydrugservices',
																					'studentdisplayfecalysisservices', 'facultydisplayfecalysisservices', 'staffdisplayfecalysisservices', 'dependentdisplayfecalysisservices', 'opddisplayfecalysisservices', 'seniordisplayfecalysisservices', 
																					'studentdisplayurinalysisservices', 'facultydisplayurinalysisservices', 'staffdisplayurinalysisservices', 'dependentdisplayurinalysisservices', 'opddisplayurinalysisservices', 'seniordisplayurinalysisservices', 
																					'studentdisplayxrayservices', 'facultydisplayxrayservices', 'staffdisplayxrayservices', 'dependentdisplayxrayservices', 'opddisplayxrayservices', 'seniordisplayxrayservices'));
	}

	public function scheduleappointment()
	{
		// if(Auth::check() && Auth::user()->user_type_id==1)
		// {
		// 	$params['medicalscheduleschecker'] = MedicalAppointment::where('patient_id', Auth::user()->user_id)->get();
		// 	$params['']
		// }
		if(Auth::check() && Auth::user()->user_type_id == 1)
		{
			$params['sidebar_active'] = 'scheduleappointment';
		}
		$params['navbar_active'] = 'scheduleappointment';
		return view('scheduleappointment', $params);
	}

	public function announcements()
	{
		$user = Auth::user();

		$params['navbar_active'] = 'announcements';
		$announcements = Announcement::orderBy('created_at', 'desc')
		->get();

		return view('announcements', $params, compact('announcements', 'user'));
	}

	public function editannouncement(Request $request)
    {
    	$params['navbar_active'] = 'announcements';
    	$announcement = Announcement::where('id', $request->announcementId)->first();
    	$params['id'] = $request->announcementId;
    	$params['announcement_title'] = $announcement->announcement_title;
    	$params['announcement_body'] = $announcement->announcement_body;

        return view('editannouncement', $params);
    }

    public function updateannouncement(Request $request)
    {
    	$update_announcement = Announcement::where('id', $request->announcementId)->first();
    	$update_announcement->announcement_title = $request->input('announcement_title');
    	$update_announcement->announcement_body = $request->input('announcement_body');
    	$update_announcement->update();
    	return redirect('announcements');
    }

    public function deleteannouncement(Request $request)
    {
    	$delete_announcement = Announcement::where('id', $request->announcementId)->first();
    	$delete_announcement->delete();
    	return redirect('announcements');
    }

    public function medicalstaff()
    {
    	$params['staffs'] = Staff::orderBy('staff_last_name')->get();
    	$params['navbar_active'] = 'medicalstaff';
		return view('medicalstaff', $params);
    }

    public function viewmedicalstaffinfo(Request $request)
    {
    	if(Staff::find($request->staff_id)->staff_type_id == 2)
    	{
    		$schedules = MedicalSchedule::where('schedule_day', '>', date('Y-m-d'))->where('staff_id', $request->staff_id)->orderBy('schedule_day')->get();
	    	$schedules_formatted = array();
			foreach ($schedules as $schedule){
				array_push($schedules_formatted, date_format(date_create($schedule->schedule_day), 'F j, Y'));
			}
			// dd($schedules_formatted);
	    	return response()->json(['staff_info' => Staff::find($request->staff_id), 'schedules' => $schedules_formatted]); 
    	}
    	if(Staff::find($request->staff_id)->staff_type_id == 1)
    	{
    		$schedules = DentalSchedule::where('schedule_start', '>', date('Y-m-d'))->where('staff_id', $request->staff_id)->orderBy('schedule_start')->get();
	    	$schedules_formatted = array();
	    	$schedules_time = array();
			foreach ($schedules as $schedule){
				array_push($schedules_formatted, date_format(date_create($schedule->schedule_start), 'F j, Y'));
				array_push($schedules_time,date_format(date_create($schedule->schedule_start), 'h:i A').' - '.date_format(date_create($schedule->schedule_end), 'h:i A'));
			}
			// dd($schedules_formatted);
	    	return response()->json(['staff_info' => Staff::find($request->staff_id), 'schedules' => $schedules_formatted, 'times' =>$schedules_time]); 
    	}
    	
    }
	public function displayscheduledental(Request $request)
	{
		$dental_date = $request->dental_date;
		$display_schedules = DentalSchedule::where('booked', '0')->get();
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
				array_push($startdatesarray, date_format(date_create($datestartdental[1]), 'h:i A'));
				array_push($enddatesarray, date_format(date_create($dateenddental[1]), 'h:i A'));
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
			if(Auth::check())
			{
				if(count(MedicalAppointment::where('medical_schedule_id', $display_schedule->id)->where('patient_id', Auth::user()->user_id)->first())==0)
				{
					$staff = Staff::where('staff_id', $display_schedule->staff_id)->first();
					$scheduleid = $display_schedule->id;
					array_push($staffnamearray,  $staff->staff_first_name .' '. $staff->staff_last_name);
					array_push($scheduleidarray, $scheduleid);
				}
			}
			else
			{
				$staff = Staff::where('staff_id', $display_schedule->staff_id)->first();
					$scheduleid = $display_schedule->id;
					array_push($staffnamearray,  $staff->staff_first_name .' '. $staff->staff_last_name);
					array_push($scheduleidarray, $scheduleid);
			}
			
		}
		return response()->json(['staff' => $staffnamearray, 'id' => $scheduleidarray]); 
	}

	public function createappointmentdental(Request $request)
	{
		if(Auth::check()){
			if(Auth::user()->user_type_id != 2 || Auth::user()->user_type_id != 3){
				if(count(DentalAppointment::where('dental_schedule_id', $request->dental_schedule_id)->where('patient_id', Auth::user()->user_id)->first())==0)
				{
					$dental_appointment = new DentalAppointment;
					$dental_appointment->patient_id = Auth::user()->user_id;
					$dental_appointment->dental_schedule_id = $request->dental_schedule_id;
					$dental_appointment->reasons = $request->reasons;
					$dental_appointment->save();
					$dental_schedule_booked = DentalSchedule::find($request->dental_schedule_id);
					$dental_schedule_booked->booked = '1';
					$dental_schedule_booked->update();
					return response()->json(['success' => 'yes']);
				}
				else
				{
					return response()->json(['success' => 'alreadyexists']);
				}
				
			}
			else
			{
				return response()->json(['success' => 'no']);
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
			if(Auth::user()->user_type_id != 2 || Auth::user()->user_type_id != 3){
				// dd(count(MedicalAppointment::where('medical_schedule_id', $request->medical_schedule_id)->where('patient_id', Auth::user()->user_id)->first()));
				if(count(MedicalAppointment::where('medical_schedule_id', $request->medical_schedule_id)->where('patient_id', Auth::user()->user_id)->first())==0)
				{
					$medical_appointment = new MedicalAppointment;
					$medical_appointment->patient_id = Auth::user()->user_id;
					$medical_appointment->medical_schedule_id = $request->medical_schedule_id;
					$medical_appointment->reasons = $request->reasons;
					$medical_appointment->save();
					$medical_schedule_booked = MedicalSchedule::find($request->medical_schedule_id);
					$medical_schedule_booked->update();
					return response()->json(['success' => 'yes']);
				}
				else
				{
					return response()->json(['success' => 'alreadyexists']);
				}
			}
			else
			{
				return response()->json(['success' => 'no']);
			}
		}
		else
		{
			return response()->json(['success' => 'no']);
		}
	}

	public function loginfromdentalappointment(Request $request)
	{
		$hashedPassword = User::where('user_id', $request->user_name_modal_dental)->where('user_type_id', '1')->first();
		if (count($hashedPassword)==1 && Hash::check($request->password_modal_dental, $hashedPassword->password))
		{
			Auth::loginUsingId($request->user_name_modal_dental, true);
			$dental_appointment = new DentalAppointment;
			$dental_appointment->patient_id = Auth::user()->user_id;
			$dental_appointment->dental_schedule_id = $request->dental_schedule_id;
			$dental_appointment->reasons = $request->reasons;
			$dental_appointment->save();
			$dental_schedule_booked = DentalSchedule::find($request->dental_schedule_id);
			$dental_schedule_booked->booked = '1';
			$dental_schedule_booked->update();
			return response()->json(['passwordmatch' => 'yes']);
		}
		else{
			return response()->json(['passwordmatch' => 'no']);
		}
	}

	public function loginfrommedicalappointment(Request $request)
	{
		$hashedPassword = User::where('user_id', $request->user_name_modal_medical)->where('user_type_id', '1')->first();
		if (count($hashedPassword)==1 && Hash::check($request->password_modal_medical, $hashedPassword->password))
		{
			Auth::loginUsingId($request->user_name_modal_medical, true);
			if(count(MedicalAppointment::where('medical_schedule_id', $request->medical_schedule_id)->where('patient_id', Auth::user()->user_id)->first())==0)
			{
				$medical_appointment = new MedicalAppointment;
				$medical_appointment->patient_id = Auth::user()->user_id;
				$medical_appointment->medical_schedule_id = $request->medical_schedule_id;
				$medical_appointment->reasons = $request->reasons;
				$medical_appointment->save();
				$medical_schedule_booked = MedicalSchedule::find($request->medical_schedule_id);
				$medical_schedule_booked->update();
				return response()->json(['passwordmatch' => 'yes']);
			}
			else
			{
				Auth::logout();
				return response()->json(['passwordmatch' => 'alreadyexists']);
			}		
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
			if(($request->patient_type_id == 1 && count($check_student_database) == 1) || $request->patient_type_id != 1)
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
				if($request->patient_type_id != 1)
				{
					$patient->year_level = 0;
				}
				else
				{
					$patient->year_level = $request->year_level;
					$patient->degree_program_id = $request->degree_program_id;
				}
				$patient->graduated = '0';
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
						$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
						$json = json_decode(file_get_contents($url), true);
						if($json['rows'][0]['elements'][0]['status'] == 'OK')
						{
							$distance=$json['rows'][0]['elements'][0]['distance']['value'];
							$town->distance_to_miagao = $distance/1000;
						}
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
					$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
					$json = json_decode(file_get_contents($url), true);
					if($json['rows'][0]['elements'][0]['status'] == 'OK')
					{
						$distance=$json['rows'][0]['elements'][0]['distance']['value'];
						$town->distance_to_miagao = $distance/1000;
					}
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
	         				$location = preg_replace("/\s+/", "+",$request->guardian_town." ".$request->guardian_province);
							$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
							$json = json_decode(file_get_contents($url), true);
							if($json['rows'][0]['elements'][0]['status'] == 'OK')
							{
								$distance=$json['rows'][0]['elements'][0]['distance']['value'];
								$guardian_town->distance_to_miagao = $distance/1000;
							}
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
						$location = preg_replace("/\s+/", "+",$request->guardian_town." ".$request->guardian_province);
						$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
						$json = json_decode(file_get_contents($url), true);
						if($json['rows'][0]['elements'][0]['status'] == 'OK')
						{
							$distance=$json['rows'][0]['elements'][0]['distance']['value'];
							$guardian_town->distance_to_miagao = $distance/1000;
						}
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
				$dental_schedule_booked = DentalSchedule::find($request->schedule_id);
				$dental_schedule_booked->booked = '1';
				$dental_schedule_booked->update();
				Auth::loginUsingId($request->user_name, true);
				return response()->json(['message' => 'Success']);
			}
			else
			{
				if($request->patient_type_id == '1')
				{
					return response()->json(['message' =>'User is not included in the student database. Please contact UPV HSU immediately.']);
				}
				else
				{
					return response()->json(['message' =>'Error! Please refresh page and try again.']);
				}
			}
		}
	}

	public function signupfrommedicalappointment(Request $request)
	{
		$check_if_already_exists = User::where('user_id', $request->user_name)->where('user_type_id', '1')->first();
		if(count($check_if_already_exists) == 1)
		{
			return response()->json(['message' =>'User already exists.']);
		}
		else
		{
			$check_student_database = StudentNumber::where('student_number', $request->user_name)->first();
			// dd($check_student_database);
			if(($request->patient_type_id == '1' && count($check_student_database) == 1) || $request->patient_type_id != '1')
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
				if($request->patient_type_id != 1)
				{
					$patient->year_level = 0;
				}
				else
				{
					$patient->year_level = $request->year_level;
					$patient->degree_program_id = $request->degree_program_id;
				}
				$patient->graduated = '0';
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
            			$location = preg_replace("/\s+/", "+",$request->town." ".$request->province);
						$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
						$json = json_decode(file_get_contents($url), true);
						if($json['rows'][0]['elements'][0]['status'] == 'OK')
						{
							$distance=$json['rows'][0]['elements'][0]['distance']['value'];
							$town->distance_to_miagao = $distance/1000;
						}
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
					$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
					$json = json_decode(file_get_contents($url), true);
					if($json['rows'][0]['elements'][0]['status'] == 'OK')
					{
						$distance=$json['rows'][0]['elements'][0]['distance']['value'];
						$town->distance_to_miagao = $distance/1000;
					}
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
	         				$location = preg_replace("/\s+/", "+",$request->guardian_town." ".$request->guardian_province);
							$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
							$json = json_decode(file_get_contents($url), true);
							if($json['rows'][0]['elements'][0]['status'] == 'OK')
							{
								$distance=$json['rows'][0]['elements'][0]['distance']['value'];
								$guardian_town->distance_to_miagao = $distance/1000;
							}
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
						$location = preg_replace("/\s+/", "+",$request->guardian_town." ".$request->guardian_province);
						$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary,+Up+Visayas,+Miagao,+5023+Iloilo&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
						$json = json_decode(file_get_contents($url), true);
						if($json['rows'][0]['elements'][0]['status'] == 'OK')
						{
							$distance=$json['rows'][0]['elements'][0]['distance']['value'];
							$guardian_town->distance_to_miagao = $distance/1000;
						}
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
				$medical_schedule_booked = MedicalSchedule::find($request->schedule_id);
				$medical_schedule_booked->update();
				Auth::loginUsingId($request->user_name, true);
				return response()->json(['message' => 'Success']);
			}
			else
			{
				if($request->patient_type_id == '1')
				{
					return response()->json(['message' =>'User is not included in the student database. Please contact UPV HSU immediately.']);
				}
				else
				{
					return response()->json(['message' =>'Error! Please refresh page and try again.']);
				}
				
			}
			
		}
	}
}