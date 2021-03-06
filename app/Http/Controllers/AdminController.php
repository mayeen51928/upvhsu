<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Staff;
use App\Announcement;
use App\StudentNumber;
use App\MedicalService;
use DB;
use App\DentalAppointment;
use App\MedicalAppointment;
use App\CbcResult;
use App\FecalysisResult;
use App\DrugTestResult;
use App\UrinalysisResult;
use App\ChestXrayResult;
use App\StaffNote;
use App\MedicalBilling;
use App\DentalBilling;
use App\DentalService;
use App\Patient;
use App\Province;
Use App\Town;
Use App\Religion;
use App\Guardian;
use App\ParentModel;
use App\HasParent;
use App\HasGuardian;
use App\Nationality;
use App\MedicalHistory;
use Carbon\Carbon;
class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			if(Auth::check()){
				if(Auth::user()->user_type_id == 3){
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
		$params['unpaid'] = MedicalBilling::join('medical_appointments', 'medical_billings.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->whereDate('schedule_day', '=', date('Y-m-d'))->where('medical_billings.status', 'unpaid')->sum('amount') + DentalBilling::join('dental_appointments', 'dental_billings.appointment_id', 'dental_appointments.id')->join('dental_schedules', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->whereDate('schedule_start', '=', date('Y-m-d'))->where('dental_billings.status', 'unpaid')->sum('amount');
		$params['paid'] = MedicalBilling::join('medical_appointments', 'medical_billings.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->whereDate('schedule_day', '=', date('Y-m-d'))->where('medical_billings.status', 'paid')->sum('amount') + DentalBilling::join('dental_appointments', 'dental_billings.appointment_id', 'dental_appointments.id')->join('dental_schedules', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->whereDate('schedule_start', '=', date('Y-m-d'))->where('dental_billings.status', 'paid')->sum('amount');
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'dashboard';
		return view('admin.dashboard', $params);
	}

	public function admingraphdata(Request $request)
	{
		$dental_appointments = array();
		$medical_appointments = array();
		$cbc_requests = array();
		$fecalysis_requests = array();
		$drug_test_requests = array();
		$urinalysis_requests = array();
		$xray_requests = array();
		$dt = Carbon::create($request->year, $request->month, $request->date);
		$date = $dt->format('Y-m-d');
		for($i=0; $i<7; $i++)
		{
			$dental_appointments[$i] = count(DentalAppointment::join('dental_schedules', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->whereDate('schedule_start', $date)->get());
			$medical_appointments[$i] = count(MedicalAppointment::join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', $date)->get());
			$cbc_requests[$i] = count(CbcResult::join('medical_appointments', 'cbc_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', $date)->get());
			$fecalysis_requests[$i] = count(FecalysisResult::join('medical_appointments', 'fecalysis_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', $date)->get());
			$drug_test_requests[$i] = count(DrugTestResult::join('medical_appointments', 'drug_test_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', $date)->get());
			$urinalysis_requests[$i] = count(UrinalysisResult::join('medical_appointments', 'urinalysis_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', $date)->get());
			$xray_requests[$i] = count(ChestXrayResult::join('medical_appointments', 'chest_xray_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', $date)->get());
			$date = $dt->addDay()->format('Y-m-d');
		}
		return response()->json([
			'dental_appointment_count' => $dental_appointments,
			'medical_appointment_count' => $medical_appointments,
			'cbc_request_count' => $cbc_requests,
			'fecalysis_request_count' => $fecalysis_requests,
			'drug_test_request_count' => $drug_test_requests,
			'urinalysis_request_count' => $urinalysis_requests,
			'chest_xray_request_count' => $xray_requests,
			]);
	}

	public function announcement()
	{
		$params['navbar_active'] = 'postannouncement';
		$params['sidebar_active'] = 'postannouncement';
		return view('admin.postannouncement', $params);
	}

	public function addstaffaccount()
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'addstaffaccount';
		return view('admin.addaccount', $params);
	}
	public function addstudent()
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'addstudentnumber';
		return view('admin.addstudent', $params);
	}

	public function addpatientaccount()
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'addpatientaccount';
		return view('admin.addpatientaccount', $params);
	}

	public function manageaccounts(){
		$staff = User::where('user_type_id', '2')->join('staff_info', 'staff_info.staff_id', 'users.user_id')->join('user_types', 'user_types.id', 'users.user_type_id')->select('staff_first_name as user_first_name', 'staff_last_name as user_last_name', 'staff_id as user_id', 'user_type_description', 'staff_info.created_at as created_at', 'staff_info.updated_at as updated_at');
		$params['users'] = User::where('user_type_id', '1')->join('patient_info', 'patient_info.patient_id', 'users.user_id')->join('user_types', 'user_types.id', 'users.user_type_id')->select('patient_first_name as user_first_name', 'patient_last_name as user_last_name', 'patient_id as user_id', 'user_type_description', 'patient_info.created_at as created_at', 'patient_info.updated_at as updated_at')->union($staff)->orderBy('user_last_name', 'asc')->get();
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'manageaccounts';
		return view('admin.manageaccounts', $params);
	}
	public function changepassword(Request $request){
		$user = User::find($request->user_id);
		$user->password = bcrypt($request->password);
		$user->save();
		return response()->json(['success' => 'yes']);

	}
	public function checkifuserexists(Request $request)
	{
		if(count(User::where('user_id', $request->user_name)->get()) > 0 )
		{
			return response()->json(['already_exists' => 'yes']);
		}
	}
	public function createpatientaccount(Request $request)
	{
		// dd($request);
		
				$user = new User;
				$user->user_id = $request->user_name;
				$user->user_type_id = '1';
				$user->password = bcrypt($request->password);
				$user->save();
				$patient = new Patient;
				$patient->patient_id = $request->user_name;
				$patient->patient_type_id = $request->patient_type_medical;
				$patient->patient_first_name = $request->first_name;
				$patient->patient_middle_name = $request->middle_name;
				$patient->patient_last_name = $request->last_name;
				if($request->patient_type_medical != '1')
				{
					$patient->year_level = '0';
				}
				else
				{
					$patient->year_level = $request->yearlevel_medical;
					$patient->degree_program_id = $request->degree_program_medical;
				}
				$patient->graduated = '0';
				$patient->sex = $request->sex;
				$patient->birthday = $request->birthdate_medical;
				$patient->civil_status = $request->civil_status;
				$religion = Religion::where('religion_description', $request->religion)->first();
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
				if($request->senior_citizen_id != '')
				{
					$senior_citizen_id = new SeniorCitizenId;
					$senior_citizen_id->patient_id = $request->user_name;
					$senior_citizen_id->senior_citizen_id = $request->senior_citizen_id;
					$senior_citizen_id->save();
				}
				$check_if_father_exists = ParentModel::where('parent_first_name', $request->father_first)->where('parent_middle_name', $request->father_middle)->where('parent_last_name', $request->father_last)->first();
				if(count($check_if_father_exists) == 0)
				{
					$father = new ParentModel;
					$father->parent_first_name = $request->father_first;
					$father->parent_middle_name = $request->father_middle;
					$father->parent_last_name = $request->father_last;
					$father->sex = 'M';
					$father->save();
				}
				$check_if_mother_exists = ParentModel::where('parent_first_name', $request->mother_first)->where('parent_middle_name', $request->mother_middle)->where('parent_last_name', $request->mother_last)->first();
				if(count($check_if_mother_exists) == 0)
				{
					$mother = new ParentModel;
					$mother->parent_first_name = $request->mother_first;
					$mother->parent_middle_name = $request->mother_middle;
					$mother->parent_last_name = $request->mother_last;
					$mother->sex = 'F';
					$mother->save();
				}

				$has_father = new HasParent;
				$has_father->patient_id = $request->user_name;
				$has_father->parent_id = ParentModel::where('parent_first_name', $request->father_first)->where('parent_middle_name', $request->father_middle)->where('parent_last_name', $request->father_last)->first()->id;
				$has_father->save();
				$has_mother = new HasParent;
				$has_mother->patient_id = $request->user_name;
				$has_mother->parent_id = ParentModel::where('parent_first_name', $request->mother_first)->where('parent_middle_name', $request->mother_middle)->where('parent_last_name', $request->mother_last)->first()->id;
				$has_mother->save();
				$check_if_guardian_exists = Guardian::where('guardian_first_name', $request->guardian_first)->where('guardian_middle_name', $request->guardian_middle)->where('guardian_last_name', $request->guardian_last)->first();
				if(count($check_if_guardian_exists) == 0)
				{
					$guardian = new Guardian;
					$guardian->guardian_first_name = $request->guardian_first;
					$guardian->guardian_middle_name = $request->guardian_middle;
					$guardian->guardian_last_name = $request->guardian_last;
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
				$has_guardian->guardian_id = Guardian::where('guardian_first_name', $request->guardian_first)->where('guardian_middle_name', $request->guardian_middle)->where('guardian_last_name', $request->guardian_last)->first()->id;
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
			
		return redirect('admin/addpatientaccount')->with('status', 'Patient account added!');
	}
	public function modifyservices()
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'editservices';
		return view('admin.editservices', $params);
	}

	public function viewservicesmedical(Request $request)
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'editservices';

		$service_type = $request->service_type;

		$display_medical_services = DB::table('medical_services')
					->where('service_type', '=', $service_type)
					->get();

		return response()->json(['display_medical_services' => $display_medical_services]); 
	}

	public function editmedicalservices(Request $request)
	{
		$service_type = $request->service_type;

		$display_medical_services = DB::table('medical_services')
					->where('service_type', '=', $service_type)
					->get();

		return response()->json(['display_medical_services' => $display_medical_services]); 
	}

	public function editdentalservices(Request $request)
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'editservices';

		$display_dental_services = DentalService::get();

		return response()->json(['display_dental_services' => $display_dental_services]); 
	}


	public function updatemedicalservices(Request $request)
	{
		$medicalservices = $request->medical_services;
		for($i = 0; $i < sizeof($medicalservices); $i++){
			if($medicalservices[$i]!=''){
				$explode_medical_services = explode("(:::)", $medicalservices[$i]);
				$student_rate = $explode_medical_services[0];
				$faculty_staff_dependent_rate = $explode_medical_services[1];
				$opd_rate = $explode_medical_services[2];
				$senior_rate = $explode_medical_services[3];
				$service_id = $explode_medical_services[4];

				$medical_service = MedicalService::where('id', $service_id)->first();
				$medical_service->student_rate = $student_rate;
				$medical_service->faculty_staff_dependent_rate = $faculty_staff_dependent_rate;
				$medical_service->opd_rate = $opd_rate;
				$medical_service->senior_rate = $senior_rate;
				$medical_service->service_type = $request->service_type;
				$medical_service->update();
			}
		}
		return response()->json(['success' => 'success']); 
	}

	public function updatedentalservices(Request $request)
	{
		$dentalservices = $request->dental_services;
		for($i = 0; $i < sizeof($dentalservices); $i++){
			if($dentalservices[$i]!=''){
				$explode_dental_services = explode("(:::)", $dentalservices[$i]);
				$student_rate = $explode_dental_services[0];
				$faculty_staff_dependent_rate = $explode_dental_services[1];
				$opd_rate = $explode_dental_services[2];
				$senior_rate = $explode_dental_services[3];
				$service_id = $explode_dental_services[4];

				$dental_service = DentalService::where('id', $service_id)->first();
				$dental_service->student_rate = $student_rate;
				$dental_service->faculty_staff_dependent_rate = $faculty_staff_dependent_rate;
				$dental_service->opd_rate = $opd_rate;
				$dental_service->senior_rate = $senior_rate;
				$dental_service->update();
			}
		}
		return response()->json(['success' => 'success']); 
	}

	public function createstaffaccount(Request $request)
	{
		$staff = new User;
		$staff->user_id = $request->staff_id;
		$staff->user_type_id = 2;
		$staff->password = bcrypt($request->staff_password);
		$staff->save();
		$staff_info = new Staff;
		$staff_info->staff_id = $request->staff_id;
		$staff_info->staff_type_id = $request->staff_type_id;
		$staff_info->staff_first_name = $request->staff_first_name;
		$staff_info->staff_middle_name = $request->staff_middle_name;
		$staff_info->staff_last_name = $request->staff_last_name;
		$staff_info->save();
		if($request->staff_type_id == 1 || $request->staff_type_id == 2)
		{
			$staff_note = new StaffNote;
			$staff_note->staff_id = $request->staff_id;
			$staff_note->save();
		}
		return redirect('admin/addstaffaccount')->with('status', 'Staff account added!');
	}

	public function createstudent(Request $request)
	{
		$student = new StudentNumber;
		$student->student_number = $request->student_number;
		$student->save();
		return redirect('admin/addstudent')->with('status', 'Student number added!');
	}

	public function postannouncement(Request $request)
	{
		$announcement = new Announcement;
		$announcement->announcement_title = $request->announcement_title;
		$announcement->announcement_body = $request->announcement_body;
		$announcement->save();
		return redirect('announcements')->with('status', 'Announcement posted!');
	}

	public function generateschedule()
	{
		$student_patients = Patient::where('patient_type_id', 1)->where('graduated', '0')->get();
		foreach ($student_patients as $student_patient) {
			$student_patient->year_level = intval(date("Y")) - intval(substr($student_patient->patient_id, 0, 4));
			if((intval(substr($student_patient->patient_id, 0, 4)) < intval(date("Y")) - 3 && ($student_patient->degree_program_id!=34 && $student_patient->degree_program_id!=40))
				||
				(intval(substr($student_patient->patient_id, 0, 4)) < intval(date("Y")) - 4 && ($student_patient->degree_program_id==34 || $student_patient->degree_program_id==40))){
				// $student_patient->degree_program_id = 34 ---->BS Accountancy
				// $student_patient->degree_program_id = 34 ---->BS Chemical Engineering
				$student_patient->graduated = '1';
			}
			$student_patient->update();
		}
		$params['schedules'] = Patient::join('towns', 'patient_info.town_id', '=', 'towns.id')->join('provinces', 'towns.province_id', '=', 'provinces.id')->where('patient_type_id', 1)->where('graduated', '0')->orderBy('distance_to_miagao', 'desc')->paginate(20);
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'generateschedule';
		return view('admin.generateschedule', $params);
	}
	public function postschedule(Request $request){
		$announcement_sched = new Announcement;
		$schedules = Patient::join('towns', 'patient_info.town_id', '=', 'towns.id')->join('provinces', 'towns.province_id', '=', 'provinces.id')->join('degree_programs', 'patient_info.degree_program_id', 'degree_programs.id')->where('patient_type_id', 1)->where('graduated', '0')->orderBy('distance_to_miagao', 'desc')->get();
		$day_counter=1;
		$day_accommodate=1;
		$announcement = '<table id="generatescheduletable" class="table table-striped schedule-bordered table-condensed"><thead><tr><th class="info text-center">Day '.$day_counter.'</th><th class="info"></th></tr></thead>';
		foreach ($schedules as $schedule) {
			if($day_accommodate>20){
				$day_counter ++;
				$announcement = $announcement.'<thead><tr><th class="info text-center">Day '.$day_counter.'</th class="info"><th></th></tr></thead>';
				$day_accommodate=1;
			}
			if($day_accommodate<=20){
				$announcement = $announcement.'<tr><td>'.$schedule->patient_last_name.'</td><td>'.$schedule->patient_first_name.'</td></tr>';
				$day_accommodate++;
			}
		}
		$announcement = $announcement.'</table>';
		// dd($announcement);
		$announcement_sched->announcement_title = 'Schedule for Upperclassmen Physical Exam';
		$announcement_sched->announcement_body = $announcement;
		$announcement_sched->save();
	}
}
