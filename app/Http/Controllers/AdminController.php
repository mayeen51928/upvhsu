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
use App\DentaLAppointment;
use App\MedicalAppointment;
use App\CbcResult;
use App\FecalysisResult;
use App\DrugTestResult;
use App\UrinalysisResult;
use App\ChestXrayResult;
use App\StaffNote;
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
		for($i=0; $i<7; $i++)
		{
			$date = ($request->date)+$i;
			$dental_appointments[$i] = count(DentaLAppointment::join('dental_schedules', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->whereDate('schedule_start', date_format(date_create($request->year.'-'.$request->month.'-'.$date), 'Y-m-d'))->get());
			$medical_appointments[$i] = count(MedicalAppointment::join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', date_format(date_create($request->year.'-'.$request->month.'-'.$date), 'Y-m-d'))->get());
			$cbc_requests[$i] = count(CbcResult::join('medical_appointments', 'cbc_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', date_format(date_create($request->year.'-'.$request->month.'-'.$date), 'Y-m-d'))->get());
			$fecalysis_requests[$i] = count(FecalysisResult::join('medical_appointments', 'fecalysis_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', date_format(date_create($request->year.'-'.$request->month.'-'.$date), 'Y-m-d'))->get());
			$drug_test_requests[$i] = count(DrugTestResult::join('medical_appointments', 'drug_test_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', date_format(date_create($request->year.'-'.$request->month.'-'.$date), 'Y-m-d'))->get());
			$urinalysis_requests[$i] = count(UrinalysisResult::join('medical_appointments', 'urinalysis_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', date_format(date_create($request->year.'-'.$request->month.'-'.$date), 'Y-m-d'))->get());
			$xray_requests[$i] = count(ChestXrayResult::join('medical_appointments', 'chest_xray_results.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day', date_format(date_create($request->year.'-'.$request->month.'-'.$date), 'Y-m-d'))->get());
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

	public function addaccount()
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

		$patient_type_id = $request->patient_type_id;

		$display_medical_services = DB::table('medical_services')
					->where('patient_type_id', '=', $patient_type_id)
					->get();

		$counter = 0;
		if(count($display_medical_services)>0){
			$counter++;
		}

		return response()->json(['display_medical_services' => $display_medical_services, 'counter' => $counter]); 
	}

	public function viewservicesdental(Request $request)
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'editservices';

		$patient_type_id = $request->patient_type_id;

		return view('admin.editservices', $params);
	}

	public function editmedicalservices(Request $request)
	{
		$patient_type_id = $request->patient_type_id;

		$display_medical_services = DB::table('medical_services')
					->where('patient_type_id', '=', $patient_type_id)
					->get();

		$counter = 0;
		if(count($display_medical_services)>0){
			$counter++;
		}

		return response()->json(['display_medical_services' => $display_medical_services, 'counter' => $counter]); 
	}

	public function updatemedicalservices(Request $request)
	{
		$medicalservices = $request->medical_services;
		$patient_type_id = $request->patient_type_id;

		DB::table('medical_services')->where('patient_type_id', '=', $request->patient_type_id)->delete();

		for($i=0; $i < sizeof($medicalservices); $i++){
			if($medicalservices[$i]!=''){
				$explode_medical_services = explode("(:::)", $medicalservices[$i]);
				$service_description = $explode_medical_services[0];
				$service_rate = $explode_medical_services[1];
				$service_type = $explode_medical_services[2];

				$medical_service = new MedicalService();
				$medical_service->patient_type_id = $request->patient_type_id;
				$medical_service->service_description = $service_description;
				$medical_service->service_rate = $service_rate;
				$medical_service->service_type = $service_type;
				$medical_service->save();
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
		return redirect('admin/addaccount')->with('status', 'Staff account added!');
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
		$params['schedules'] = DB::table('patient_info')->join('towns', 'patient_info.town_id', '=', 'towns.id')->join('provinces', 'towns.province_id', '=', 'provinces.id')->where('patient_type_id', 1)->where('graduated', '0')->orderBy('distance_to_miagao', 'desc')->get();
		// check also if the student has graduated
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'generateschedule';
		return view('admin.generateschedule', $params);
	}
}
