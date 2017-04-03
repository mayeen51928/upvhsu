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
use App\MedicalBilling;
use App\DentalBilling;
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
		$params['unpaid'] = MedicalBilling::join('medical_appointments', 'medical_billings.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('medical_billings.status', 'unpaid')->sum('amount') + DentalBilling::join('dental_appointments', 'dental_billings.appointment_id', 'dental_appointments.id')->join('dental_schedules', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->where('dental_billings.status', 'unpaid')->sum('amount');
		$params['paid'] = MedicalBilling::join('medical_appointments', 'medical_billings.medical_appointment_id', 'medical_appointments.id')->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('medical_billings.status', 'paid')->sum('amount') + DentalBilling::join('dental_appointments', 'dental_billings.appointment_id', 'dental_appointments.id')->join('dental_schedules', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->where('dental_billings.status', 'paid')->sum('amount');
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
			$dental_appointments[$i] = count(DentaLAppointment::join('dental_schedules', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->whereDate('schedule_start', $date)->get());
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

		$service_type = $request->service_type;

		$display_medical_services = DB::table('medical_services')
					->where('service_type', '=', $service_type)
					->get();

		return response()->json(['display_medical_services' => $display_medical_services]); 
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
		$service_type = $request->service_type;

		$display_medical_services = DB::table('medical_services')
					->where('service_type', '=', $service_type)
					->get();

		return response()->json(['display_medical_services' => $display_medical_services]); 
	}

	public function updatemedicalservices(Request $request)
	{
		$medicalservices = $request->medical_services;
		DB::table('medical_services')->where('service_type', '=', $request->service_type)->delete();
		for($i = 0; $i < sizeof($medicalservices); $i++){
			if($medicalservices[$i]!=''){
				$explode_medical_services = explode("(:::)", $medicalservices[$i]);
				$service_description = $explode_medical_services[0];
				$student_rate = $explode_medical_services[1];
				$faculty_staff_dependent_rate = $explode_medical_services[2];
				$opd_rate = $explode_medical_services[3];
				$senior_rate = $explode_medical_services[4];

				$medical_service = new MedicalService();
				$medical_service->service_description = $service_description;
				$medical_service->student_rate = $student_rate;
				$medical_service->faculty_staff_dependent_rate = $faculty_staff_dependent_rate;
				$medical_service->opd_rate = $opd_rate;
				$medical_service->senior_rate = $senior_rate;
				$medical_service->service_type = $request->service_type;
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
