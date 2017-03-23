<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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
use App\MedicalSchedule;
use App\MedicalAppointment;
use App\Staff;
use App\PhysicalExamination;
use App\CbcResult;
use App\ChestXrayResult;
use App\DrugTestResult;
use App\Prescription;
use App\Remark;
use App\UrinalysisResult;
use App\FecalysisResult;
use App\MedicalBilling;
use App\MedicalService;
use App\StaffNote;
use Illuminate\Support\Facades\Input;
class DoctorController extends Controller
{
	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			if(Auth::check()){
				if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 2){
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
		$params['medical_appointments_today'] = DB::table('medical_schedules')->join('medical_appointments', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')->where('schedule_day','=', date('Y-m-d'))->where('status', '0')->where('medical_schedules.staff_id', '=', Auth::user()->user_id)->get();
		$params['medical_appointments_past'] = DB::table('medical_schedules')->join('medical_appointments', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')->where('schedule_day','<', date('Y-m-d'))->where('status', '0')->where('medical_schedules.staff_id', '=', Auth::user()->user_id)->get();
		$params['medical_appointments_future'] = DB::table('medical_schedules')->join('medical_appointments', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')->where('schedule_day','>', date('Y-m-d'))->where('status', '0')->where('medical_schedules.staff_id', '=', Auth::user()->user_id)->get();
		// dd($params['medical_appointments']);
		$params['staff_notes'] = StaffNote::where('staff_id', Auth::user()->user_id)->first()->notes;
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'dashboard';
		return view('staff.medical-doctor.dashboard', $params);
	}

	public function totalnumberofpatients(Request $request)
	{
		return response()->json([
			'max' => count(DB::table('medical_schedules')->join('medical_appointments', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')->where('schedule_day','=', date('Y-m-d'))->where('medical_schedules.staff_id', '=', Auth::user()->user_id)->get()),
			'actual' =>count(MedicalSchedule::join('medical_appointments', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('schedule_day','=', date('Y-m-d'))->where('medical_schedules.staff_id', '=', Auth::user()->user_id)->leftjoin('prescriptions', 'medical_appointments.id', 'prescriptions.medical_appointment_id')->where('status', '1')->orWhere('status', '2')->get())
			]);
	}

	public function updatestaffnotes(Request $request)
	{
		$staff_note = StaffNote::where('staff_id', Auth::user()->user_id)->first();
		$staff_note->notes = $request->note;
		$staff_note->update();
	}

	public function profile()
	{
		$doctor = Staff::find(Auth::user()->user_id);
		$params['sex'] = $doctor->sex;
		$params['position'] = $doctor->position;
		$params['birthday'] = $doctor->birthday;
		$params['civil_status'] = $doctor->civil_status;
		$params['personal_contact_number'] = $doctor->personal_contact_number;
		$params['street'] = $doctor->street;
		$params['picture'] = $doctor->picture;
		if(!is_null($doctor->town_id))
			{
				$params['town'] = Town::find($doctor->town_id)->town_name;
				$params['province'] = Province::find(Town::find($doctor->town_id)->province_id)->province_name;
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
		return view('staff.medical-doctor.profile', $params);
	}
	public function editprofile()
	{
		$doctor = Staff::find(Auth::user()->user_id);
		// $params['age'] = (date('Y') - date('Y',strtotime($doctor->birthday)));
		$params['sex'] = $doctor->sex;
		$params['position'] = $doctor->position;
		$params['birthday'] = $doctor->birthday;
		$params['civil_status'] = $doctor->civil_status;
		$params['personal_contact_number'] = $doctor->personal_contact_number;
		$params['street'] = $doctor->street;
		if(!is_null($doctor->town_id))
			{
				$params['town'] = Town::find($doctor->town_id)->town_name;
				$params['province'] = Province::find(Town::find($doctor->town_id)->province_id)->province_name;
			}
			else
			{
				$params['town'] = '';
				$params['province'] = '';
			}
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'profile';
		return view('staff.medical-doctor.editprofile', $params);
	}
	
    public function updateprofile(Request $request)
    {
    	if($request->updatepassword != "")
        {
            $user = Auth::user();
            $user->password = bcrypt($request->updatepassword);
            $user->update();
        }
        $doctor = Staff::find(Auth::user()->user_id);
        $doctor->sex = $request->input('sex');
        $doctor->birthday = $request->input('birthday');
        $doctor->street = $request->input('street');
        $doctor->position = $request->input('position');
        $doctor->civil_status = $request->civil_status;
        $province = Province::where('province_name', $request->input('province'))->first();
        if(count($province)>0)
        {
            // $doctor->nationality_id = $nationality->id;
            $town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
            if(count($town)>0)
            {
                $doctor->town_id = $town->id;
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
                $doctor->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
            $doctor->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
        }
        
        if (Input::file('picture') != NULL) { 
            $path = '..\public\images';
			$file_name = Input::file('picture')->getClientOriginalName(); 
			$file_name_fin = $doctor->staff_id.'_'.$file_name;
			$image_type = pathinfo($file_name_fin,PATHINFO_EXTENSION);
			if($image_type == 'jpg' || $image_type == 'jpeg' || $image_type == 'png'){
				Input::file('picture')->move($path, $file_name_fin);
				$doctor->picture = $file_name_fin;
			}
        }

        $doctor->personal_contact_number = $request->input('personal_contact_number');
        $doctor->update();
        return redirect('doctor/profile');
    }

    
	public function manageschedule()
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'manageschedule';
		return view('staff.medical-doctor.manageschedule', $params);
	}

	public function searchdoctor()
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'searchdoctor';
		return view('staff.medical-doctor.searchdoctor', $params);
	}

	public function addschedule(Request $request)
	{
		$schedules = $request->schedules;
		for($i=0; $i < sizeof($schedules); $i++){
			if($schedules[$i]!=''){
				$checker_if_exists = MedicalSchedule::where('staff_id', Auth::user()->user_id)->where('schedule_day', $schedules[$i])->first();
				if(count($checker_if_exists) == 0){
					$schedule = new MedicalSchedule();
					$schedule->staff_id = Auth::user()->user_id;
					$schedule->schedule_day = $schedules[$i];
					$schedule->save();
				}
			}
		}
		
		return response()->json(['success' => 'success']); 
	}

    public function viewmedicaldiagnosis(Request $request)
    {
        $counter = 0;
        $appointment_id = $request->appointment_id;

		$medical_appointment = MedicalAppointment::find($appointment_id);
		$patient_info = Patient::where('patient_id', $medical_appointment->patient_id)->first();
		$physical_examination = PhysicalExamination::where('medical_appointment_id', $appointment_id)->first();
		$cbc_result = CbcResult::where('medical_appointment_id', $appointment_id)->first();
		$chest_xray_result = ChestXrayResult::where('medical_appointment_id', $appointment_id)->first();
		$drug_test_result = DrugTestResult::where('medical_appointment_id', $appointment_id)->first();
		$fecalysis_result = FecalysisResult::where('medical_appointment_id', $appointment_id)->first();
		$urinalysis_result = UrinalysisResult::where('medical_appointment_id', $appointment_id)->first();
		$prescription = Prescription::where('medical_appointment_id', $appointment_id)->first();
		$remark = Remark::where('medical_appointment_id', $appointment_id)->first();
		$lab_xray_request_counter = 0;
		if(count($physical_examination) == 1)
		{
			$counter++;
		}
		if(count($cbc_result) == 1)
		{
			$counter++;
			$lab_xray_request_counter++;
		}
		if(count($chest_xray_result) == 1)
		{
			$counter++;
			$lab_xray_request_counter++;
		}
		if(count($drug_test_result) == 1)
		{
			$counter++;
			$lab_xray_request_counter++;
		}
		if(count($fecalysis_result) == 1)
		{
			$counter++;
			$lab_xray_request_counter++;
		}
		if(count($urinalysis_result) == 1)
		{
			$counter++;
			$lab_xray_request_counter++;
		}
		if(count($remark) == 1)
		{
			$counter++;
		}
		if(count($prescription) == 1)
		{
			$counter++;
		}
		// dd($counter);
		if($counter > 0)
		{
			return response()->json([
				'hasRecord' => 'yes',
				'patient_name' =>$patient_info->patient_first_name.' '.$patient_info->patient_last_name,
				'reasons' => $medical_appointment->reasons,
				'physical_examination' => $physical_examination,
				'cbc_result' => $cbc_result,
				'chest_xray_result' => $chest_xray_result,
				'drug_test_result' => $drug_test_result,
				'fecalysis_result' => $fecalysis_result,
				'urinalysis_result' => $urinalysis_result,
				'lab_xray_request_counter' => $lab_xray_request_counter,
				'remark' => $remark,
				'prescription' => $prescription,
			]);
		}
		else
		{
			return response()->json([
				'patient_name' =>$patient_info->patient_first_name.' '.$patient_info->patient_last_name,
				'reasons' => $medical_appointment->reasons,
				'hasRecord' => 'no',
				]);
		}
		
	}

	public function searchpatient(){
		$params['patients'] = MedicalAppointment::select('medical_appointments.patient_id', 'patient_info.patient_first_name', 'patient_info.patient_last_name')->distinct()->join('patient_info', 'patient_info.patient_id', 'medical_appointments.patient_id')->orderBy('patient_last_name', 'asc')->get();
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'searchpatient';
		return view('staff.medical-doctor.searchpatient', $params);
	}

	public function searchpatientbydate(){
		$params['patients'] = MedicalAppointment::select('medical_appointments.patient_id', 'patient_info.patient_first_name', 'patient_info.patient_last_name')->distinct()->join('patient_info', 'patient_info.patient_id', 'medical_appointments.patient_id')->orderBy('patient_last_name', 'asc')->get();
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'searchpatient';
		return view('staff.medical-doctor.searchpatientbydate', $params);
	}

	public function searchpatientnamerecord(Request $request){

		// To fix: when searching for first name and last name combination
		// already fixed chereettt
		// dd($request->search_string);
		if($request->search_string!='')
		{
			$counter = 0;
			$search_string = explode(" ",$request->search_string);
			for($i=0; $i < sizeof($search_string); $i++)
			{
				$search_patient_id_records = Patient::where('patient_first_name', 'like', '%'.$search_string[$i].'%')->orWhere('patient_middle_name', 'like', '%'.$search_string[$i].'%')->orWhere('patient_last_name', 'like', '%'.$search_string[$i].'%')->orderBy('patient_last_name', 'asc')->pluck('patient_id')->all();
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

	public function searchpatientbydaterecord(Request $request){
		if($request->search_month!='00' || $request->search_date!='00' || $request->search_year!='00')
		{
			$counter = 0;
			if($request->search_month!='00' && $request->search_date=='00' && $request->search_year=='00')
			{
				$search_by_months = MedicalSchedule::whereMonth('schedule_day', $request->search_month)->whereDay('schedule_day', '<=', date('Y-m-d'))->orderBy('schedule_day', 'asc')->get();
				if(count($search_by_months)>0)
				{
					$searchpatientnamearray = array();
					$searchpatientscheduledayarray = array();
					$searchpatientappointmentidyarray = array();
					foreach($search_by_months as $search_by_month){
						$get_appointment_ids = MedicalAppointment::where('medical_schedule_id', $search_by_month->id)->get();
						foreach($get_appointment_ids as $get_appointment_id){
							
							array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
							array_push($searchpatientscheduledayarray, date_format(date_create(MedicalSchedule::find($get_appointment_id->medical_schedule_id)->schedule_day), 'F j, Y'));
							array_push($searchpatientappointmentidyarray, $get_appointment_id->id);
						}
					}
					$counter++;
					return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'counter' => $counter]);
				}
				else
				{
					return response()->json(['counter' => $counter]);
				}
			}
			if($request->search_month=='00' && $request->search_date!='00' && $request->search_year=='00')
			{
				$search_by_dates = MedicalSchedule::whereDay('schedule_day', $request->search_date)->whereDay('schedule_day', '<=', date('Y-m-d'))->orderBy('schedule_day', 'asc')->get();
				if(count($search_by_dates)>0)
				{
					$searchpatientnamearray = array();
					$searchpatientscheduledayarray = array();
					$searchpatientappointmentidyarray = array();
					foreach($search_by_dates as $search_by_date){
						$get_appointment_ids = MedicalAppointment::where('medical_schedule_id', $search_by_date->id)->get();
						foreach($get_appointment_ids as $get_appointment_id){
							
							array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
							array_push($searchpatientscheduledayarray, date_format(date_create(MedicalSchedule::find($get_appointment_id->medical_schedule_id)->schedule_day), 'F j, Y'));
							array_push($searchpatientappointmentidyarray, $get_appointment_id->id);
						}
					}
					$counter++;
					return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'counter' => $counter]);
				}
				else
				{
					return response()->json(['counter' => $counter]);
				}
			}
			if($request->search_month=='00' && $request->search_date=='00' && $request->search_year!='00')
			{
				$sarch_by_years = MedicalSchedule::whereYear('schedule_day', $request->search_year)->whereDay('schedule_day', '<=', date('Y-m-d'))->orderBy('schedule_day', 'asc')->get();
				if(count($sarch_by_years)>0)
				{
					$searchpatientnamearray = array();
					$searchpatientscheduledayarray = array();
					$searchpatientappointmentidyarray = array();
					foreach($sarch_by_years as $sarch_by_year){
						$get_appointment_ids = MedicalAppointment::where('medical_schedule_id', $sarch_by_year->id)->get();
						foreach($get_appointment_ids as $get_appointment_id){
							
							array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
							array_push($searchpatientscheduledayarray, date_format(date_create(MedicalSchedule::find($get_appointment_id->medical_schedule_id)->schedule_day), 'F j, Y'));
							array_push($searchpatientappointmentidyarray, $get_appointment_id->id);
						}
					}
					$counter++;
					return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'counter' => $counter]);
				}
				else
				{
					return response()->json(['counter' => $counter]);
				}
			}
			if($request->search_month!='00' && $request->search_date!='00' && $request->search_year=='00')
			{
				$search_by_month_dates = MedicalSchedule::whereMonth('schedule_day', $request->search_month)->whereDay('schedule_day', $request->search_date)->whereDay('schedule_day', '<=', date('Y-m-d'))->orderBy('schedule_day', 'asc')->get();
				if(count($search_by_month_dates)>0)
				{
					$searchpatientnamearray = array();
					$searchpatientscheduledayarray = array();
					$searchpatientappointmentidyarray = array();
					foreach($search_by_month_dates as $search_by_month_date){
						$get_appointment_ids = MedicalAppointment::where('medical_schedule_id', $search_by_month_date->id)->get();
						foreach($get_appointment_ids as $get_appointment_id){
							
							array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
							array_push($searchpatientscheduledayarray, date_format(date_create(MedicalSchedule::find($get_appointment_id->medical_schedule_id)->schedule_day), 'F j, Y'));
							array_push($searchpatientappointmentidyarray, $get_appointment_id->id);
						}
					}
					$counter++;
					return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'counter' => $counter]);
				}
				else
				{
					return response()->json(['counter' => $counter]);
				}
			}
			if($request->search_month!='00' && $request->search_date!='00' && $request->search_year!='00')
			{
				$search_by_month_date_years = MedicalSchedule::whereMonth('schedule_day', $request->search_month)->whereDay('schedule_day', $request->search_date)->whereYear('schedule_day', $request->search_year)->whereDay('schedule_day', '<=', date('Y-m-d'))->orderBy('schedule_day', 'asc')->get();
				if(count($search_by_month_date_years)>0)
				{
					$searchpatientnamearray = array();
					$searchpatientscheduledayarray = array();
					$searchpatientappointmentidyarray = array();
					foreach($search_by_month_date_years as $search_by_month_date_year){
						$get_appointment_ids = MedicalAppointment::where('medical_schedule_id', $search_by_month_date_year->id)->get();
						foreach($get_appointment_ids as $get_appointment_id){
							
							array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
							array_push($searchpatientscheduledayarray, date_format(date_create(MedicalSchedule::find($get_appointment_id->medical_schedule_id)->schedule_day), 'F j, Y'));
							array_push($searchpatientappointmentidyarray, $get_appointment_id->id);
						}
					}
					$counter++;
					return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'counter' => $counter]);
				}
				else
				{
					return response()->json(['counter' => $counter]);
				}
			}
			if($request->search_month!='00' && $request->search_date=='00' && $request->search_year!='00')
			{
				$search_by_month_years = MedicalSchedule::whereMonth('schedule_day', $request->search_month)->whereYear('schedule_day', $request->search_year)->whereDay('schedule_day', '<=', date('Y-m-d'))->orderBy('schedule_day', 'asc')->get();
				if(count($search_by_month_years)>0)
				{
					$searchpatientnamearray = array();
					$searchpatientscheduledayarray = array();
					$searchpatientappointmentidyarray = array();
					foreach($search_by_month_years as $search_by_month_year){
						$get_appointment_ids = MedicalAppointment::where('medical_schedule_id', $search_by_month_year->id)->get();
						foreach($get_appointment_ids as $get_appointment_id){
							
							array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
							array_push($searchpatientscheduledayarray, date_format(date_create(MedicalSchedule::find($get_appointment_id->medical_schedule_id)->schedule_day), 'F j, Y'));
							array_push($searchpatientappointmentidyarray, $get_appointment_id->id);
						}
					}
					$counter++;
					return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'counter' => $counter]);
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

	public function displaypatientrecordsearch(Request $request){
		$patient = Patient::find($request->patient_id);
		$params['age'] = (date('Y') - date('Y',strtotime($patient->birthday)));
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
        $params['residence_telephone_number'] = $patient->residence_telephone_number;
        $params['personal_contact_number'] = $patient->personal_contact_number;
        $params['residence_contact_number'] = $patient->residence_contact_number;
        $guardian = HasGuardian::where('patient_id', $request->patient_id)->first();
        $params['guardian_first_name'] = Guardian::find($guardian->guardian_id)->guardian_first_name;
        $params['guardian_middle_name'] = Guardian::find($guardian->guardian_id)->guardian_middle_name;
        $params['guardian_last_name'] = Guardian::find($guardian->guardian_id)->guardian_last_name;
        $params['guardian_street'] = Guardian::find($guardian->guardian_id)->street;
        $params['guardian_town'] = Town::find(Guardian::find($guardian->guardian_id)->town_id)->town_name;
        $params['guardian_province'] = Province::find(Town::find(Guardian::find($guardian->guardian_id)->town_id)->province_id)->province_name;
        $params['relationship'] = $guardian->relationship;
        $params['guardian_tel_number'] = Guardian::find($guardian->guardian_id)->guardian_telephone_number;
        $params['guardian_cellphone'] = Guardian::find($guardian->guardian_id)->guardian_contact_number;
		return response()->json(['patient_info' => $params]);
	}

	public function viewrecords($id)
	{
		$params['records'] = MedicalSchedule::join('medical_appointments', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->where('patient_id', $id)->orderBy('schedule_day', 'desc')->get();
		// dd($params['records']);
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'searchpatient';
		return view('staff.medical-doctor.viewrecords', $params);
	}

	public function viewindividualrecordfromsearch(Request $request)
	{
		$counter = 0;

		$appointment_id = $request->medical_appointment_id;
		// dd($appointment_id);
		$medical_appointment = MedicalAppointment::find($appointment_id);
		// dd($medical_appointment);
		$patient_info = Patient::where('patient_id', $medical_appointment->patient_id)->first();
		$physical_examination = PhysicalExamination::where('medical_appointment_id', $appointment_id)->first();
		$cbc_result = CbcResult::where('medical_appointment_id', $appointment_id)->first();
		$chest_xray_result = ChestXrayResult::where('medical_appointment_id', $appointment_id)->first();
		$drug_test_result = DrugTestResult::where('medical_appointment_id', $appointment_id)->first();
		$fecalysis_result = FecalysisResult::where('medical_appointment_id', $appointment_id)->first();
		$urinalysis_result = UrinalysisResult::where('medical_appointment_id', $appointment_id)->first();
		$prescription = Prescription::where('medical_appointment_id', $appointment_id)->first();
		$remark = Remark::where('medical_appointment_id', $appointment_id)->first();
		if(count($physical_examination) == 1)
		{
			$counter++;
		}
		if(count($cbc_result) == 1)
		{
			$counter++;
		}
		if(count($chest_xray_result) == 1)
		{
			$counter++;
		}
		if(count($drug_test_result) == 1)
		{
			$counter++;
		}
		if(count($fecalysis_result) == 1)
		{
			$counter++;
		}
		if(count($urinalysis_result) == 1)
		{
			$counter++;
		}
		if(count($remark) == 1)
		{
			$counter++;
		}
		if(count($prescription) == 1)
		{
			$counter++;
		}

		if($counter > 0)
		{
			return response()->json([
				'hasRecord' => 'yes',
				'patient_name' =>$patient_info->patient_first_name.' '.$patient_info->patient_last_name,
				'reasons' => $medical_appointment->reasons,
				'physical_examination' => $physical_examination,
				'cbc_result' => $cbc_result,
				'chest_xray_result' => $chest_xray_result,
				'drug_test_result' => $drug_test_result,
				'fecalysis_result' => $fecalysis_result,
				'urinalysis_result' => $urinalysis_result,
				'remark' => $remark,
				'prescription' => $prescription,
			]);
		}
		else
		{
			return response()->json([
				'patient_name' =>$patient_info->patient_first_name.' '.$patient_info->patient_last_name,
				'reasons' => $medical_appointment->reasons,
				'hasRecord' => 'no',
				]);
		}
	}

	public function addrecordswithoutappointment($id)
	{
		$medical_schedule = MedicalSchedule::where('schedule_day', date('Y-m-d'))->where('staff_id', Auth::user()->user_id)->first();
		// $params['has_existing_appointment'] = 1;
		if(count($medical_schedule) > 0)
		{
			$params['has_existing_appointment'] = count(MedicalAppointment::where('medical_schedule_id',$medical_schedule->id)->where('patient_id', $id)->get());
		}
		else
		{
			$params['has_existing_appointment'] = 2; //Doctor did not add a schedule for today. Therefore, he is not allowed to add records today.
		}
		
		// dd(count($medical_schedule));
		// dd($params['has_existing_appointment']);
		$params['patient_info'] = Patient::find($id);
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'searchpatient';
		return view('staff.medical-doctor.addrecords', $params);
	}

	public function addrecord(Request $request)
	{
		// dd($request->requestCBC); //returns "on"
		// Add medical appointment
		$medical_schedule_id = MedicalSchedule::where('schedule_day', date('Y-m-d'))->where('staff_id', Auth::user()->user_id)->first()->id;
		// dd($medical_schedule_id);
		$medical_appointment = new MedicalAppointment;
		$medical_appointment->patient_id = $request->patient_id;
		$medical_appointment->medical_schedule_id = $medical_schedule_id;
		$medical_appointment->reasons = 'Walk-in patient';
		if($request->requestCBC == 'on' || $request->requestUrinalysis == 'on' || $request->requestFecalysis == 'on' || $request->requestDrugTest == 'on' || $request->requestXray == 'on')
        {
        	$medical_appointment->has_lab_or_xray_request = '1';
        }
		$medical_appointment->save();

		$medical_appointment_id = MedicalAppointment::where('medical_schedule_id', $medical_schedule_id)->where('patient_id', $request->patient_id)->first()->id;
		// dd($medical_appointment_id);
		$physical_examination = new PhysicalExamination;
        $physical_examination->medical_appointment_id = $medical_appointment_id;
        $physical_examination->height = $request->height;
        $physical_examination->weight = $request->weight;
        $physical_examination->blood_pressure = $request->bloodpressure;
        $physical_examination->pulse_rate = $request->pulserate;
        $physical_examination->right_eye = $request->righteye;
        $physical_examination->left_eye = $request->lefteye;
        $physical_examination->head = $request->head;
        $physical_examination->eent = $request->eent;
        $physical_examination->neck = $request->neck;
        $physical_examination->chest = $request->chest;
        $physical_examination->heart = $request->heart;
        $physical_examination->lungs = $request->lungs;
        $physical_examination->abdomen = $request->abdomen;
        $physical_examination->back = $request->back;
        $physical_examination->skin = $request->skin;
        $physical_examination->extremities = $request->extremities;
        $physical_examination->save();
        if($request->requestCBC == 'on')
        {
            $cbc = new CbcResult;
            $cbc->medical_appointment_id = $medical_appointment_id;
            $cbc->save();
        }
        if($request->requestUrinalysis == 'on')
        {
            $urinalysis = new UrinalysisResult;
            $urinalysis->medical_appointment_id = $medical_appointment_id;
            $urinalysis->save();
        }
        if($request->requestFecalysis == 'on')
        {
            $fecalysis = new FecalysisResult;
            $fecalysis->medical_appointment_id = $medical_appointment_id;
            $fecalysis->save();
        }
        if($request->requestDrugTest == 'on')
        {
            $drug_test = new DrugTestResult;
            $drug_test->medical_appointment_id = $medical_appointment_id;
            $drug_test->save();
        }
        if($request->requestXray == 'on')
        {
            $request_xray = new ChestXrayResult;
            $request_xray->medical_appointment_id = $medical_appointment_id;
            $request_xray->save();
        }
		$params['patient_info'] = Patient::find($request->patient_id);
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'searchpatient';
		return back()->with('status', 'Record successfully added!');
	}

    public function addmedicaldiagnosis(Request $request)
    {
        $physical_examination = new PhysicalExamination;
        $physical_examination->medical_appointment_id = $request->appointment_id;
        $physical_examination->height = $request->height;
        $physical_examination->weight = $request->weight;
        $physical_examination->blood_pressure = $request->blood_pressure;
        $physical_examination->pulse_rate = $request->pulse_rate;
        $physical_examination->right_eye = $request->right_eye;
        $physical_examination->left_eye = $request->left_eye;
        $physical_examination->head = $request->head;
        $physical_examination->eent = $request->eent;
        $physical_examination->neck = $request->neck;
        $physical_examination->chest = $request->chest;
        $physical_examination->heart = $request->heart;
        $physical_examination->lungs = $request->lungs;
        $physical_examination->abdomen = $request->abdomen;
        $physical_examination->back = $request->back;
        $physical_examination->skin = $request->skin;
        $physical_examination->extremities = $request->extremities;
        $physical_examination->save();
        if($request->request_cbc == 'yes' || $request->request_urinalysis == 'yes' || $request->request_fecalysis == 'yes' || $request->request_drug_test == 'yes' || $request->request_xray == 'yes')
        {
        	$medical_appointment = MedicalAppointment::find($request->appointment_id);
        	$medical_appointment->has_lab_or_xray_request = '1';
        	$medical_appointment->update();
        }
        if($request->request_cbc == 'yes')
        {
            $cbc = new CbcResult;
            $cbc->medical_appointment_id = $request->appointment_id;
            $cbc->save();
        }
        if($request->request_urinalysis == 'yes')
        {
            $urinalysis = new UrinalysisResult;
            $urinalysis->medical_appointment_id = $request->appointment_id;
            $urinalysis->save();
        }
        if($request->request_fecalysis == 'yes')
        {
            $fecalysis = new FecalysisResult;
            $fecalysis->medical_appointment_id = $request->appointment_id;
            $fecalysis->save();
        }
        if($request->request_drug_test == 'yes')
        {
            $drug_test = new DrugTestResult;
            $drug_test->medical_appointment_id = $request->appointment_id;
            $drug_test->save();
        }
        if($request->request_xray == 'yes')
        {
            $request_xray = new ChestXrayResult;
            $request_xray->medical_appointment_id = $request->appointment_id;
            $request_xray->save();
        }
    }

    public function updatemedicaldiagnosis(Request $request)
    {
        $appointment_id = $request->appointment_id;
        $physical_examination = PhysicalExamination::where('medical_appointment_id', $appointment_id)->first();
        if(count($physical_examination) == 0)
        {
            $physical_examination = new PhysicalExamination;
            $physical_examination->medical_appointment_id = $request->appointment_id;
            $physical_examination->height = $request->height;
            $physical_examination->weight = $request->weight;
            $physical_examination->blood_pressure = $request->blood_pressure;
            $physical_examination->pulse_rate = $request->pulse_rate;
            $physical_examination->right_eye = $request->right_eye;
            $physical_examination->left_eye = $request->left_eye;
            $physical_examination->head = $request->head;
            $physical_examination->eent = $request->eent;
            $physical_examination->neck = $request->neck;
            $physical_examination->chest = $request->chest;
            $physical_examination->heart = $request->heart;
            $physical_examination->lungs = $request->lungs;
            $physical_examination->abdomen = $request->abdomen;
            $physical_examination->back = $request->back;
            $physical_examination->skin = $request->skin;
            $physical_examination->extremities = $request->extremities;
            $physical_examination->save();
        }
        $finished_appointment_counter = 0;
        $prescription = Prescription::where('medical_appointment_id', $appointment_id)->first();
        if(count($prescription) == 0 && $request->prescription != '')
        {
            $prescription = new Prescription;
            $prescription->medical_appointment_id = $request->appointment_id;
            $prescription->prescription = $request->prescription;
            $prescription->save();
            $finished_appointment_counter++;
        }
        elseif(count($prescription) == 1)
        {
            $finished_appointment_counter++;
        }
        else
        {
            
        }
        $remark = Remark::where('medical_appointment_id', $appointment_id)->first();
        if(count($remark) == 0 && $request->remarks != '')
        {
            $remark = new Remark;
            $remark->medical_appointment_id = $request->appointment_id;
            $remark->remark = $request->remarks;
            $remark->save();
            $finished_appointment_counter++;
        }
        elseif(count($remark) == 1)
        {
            $finished_appointment_counter++;
        }
        else
        {
            
        }

        if($finished_appointment_counter == 2)
        {
            $medical_appointment = MedicalAppointment::find($appointment_id);
            // $medical_appointment->status = '1';
            $medical_appointment->update();
            return response()->json([
                'status' =>'done'
            ]);
        }
    }

	public function addbillingmedical(Request $request){
		$appointment_id = $request->appointment_id;

		$patient_info = DB::table('patient_info')
					->join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')
					->where('medical_appointments.id', $appointment_id)
					->first();
		$patient_name = $patient_info->patient_first_name . ' ' . $patient_info->patient_last_name;

		$checker = 0;
		$physical_examination_checker = PhysicalExamination::where('medical_appointment_id', $appointment_id)->first();
		$remarks_checker = Remark::where('medical_appointment_id', $appointment_id)->first();
		$prescription_checker = Prescription::where('medical_appointment_id', $appointment_id)->first();		
		if(count($physical_examination_checker)>0 && count($remarks_checker)>0 && count($prescription_checker)>0){
			$checker = 1;
		}

		$display_medical_services = MedicalService::where('patient_type_id', $patient_info->patient_type_id)->where('service_type', 'medical')->get();

		if($patient_info->patient_type_id == 5){
			$display_medical_services_senior = MedicalService::where('patient_type_id',6)->where('service_type', 'medical')->get();
		}

		if($patient_info->patient_type_id == 5){
				return response()->json(['patient_info' => $patient_info, 
							'display_medical_services' => $display_medical_services,
							'display_medical_services_senior' => $display_medical_services_senior,  
							'checker' => $checker,
							'patient_type_id' => $patient_info->patient_type_id,
			]);
		}
		else{
			return response()->json(['patient_info' => $patient_info, 
							'display_medical_services' => $display_medical_services,
							'checker' => $checker,
							'patient_type_id' => $patient_info->patient_type_id,
			]);
		}
	}

	public function confirmbillingmedical(Request $request){		
		$appointment_id = $request->appointment_id;
		$checked_services_array_id = $request->checked_services_array_id;
		$checked_services_array_rate = $request->checked_services_array_rate;
		for($i=0; $i < sizeof($checked_services_array_id); $i++){
	    $billing = new MedicalBilling;
			$billing->medical_service_id = $checked_services_array_id[$i];
      $billing->medical_appointment_id = $appointment_id;
      $billing->status = 'unpaid';
      $billing->amount = $checked_services_array_rate[$i];
      $billing->save();
		}
		MedicalAppointment::where('id', $appointment_id)->update(['status' => '1']);
		return response()->json(['success' => 'success']); 
	}
}
