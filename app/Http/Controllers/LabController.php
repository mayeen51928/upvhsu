<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use App\MedicalAppointment;
use App\Staff;
use App\Town;
use App\Province;
use App\CbcResult;
use App\ChestXrayResult;
use App\DrugTestResult;
use App\UrinalysisResult;
use App\FecalysisResult;
use App\MedicalBilling;
use App\MedicalService;

class LabController extends Controller
{
	public function __construct()
		{
			$this->middleware(function ($request, $next) {
				if(Auth::check()){
					if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 3){
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
			$params['lab_requests'] = MedicalAppointment::
				where('status', '0')
				->leftjoin('cbc_results', 'medical_appointments.id', 'cbc_results.medical_appointment_id')
				->leftjoin('drug_test_results', 'drug_test_results.medical_appointment_id', 'medical_appointments.id')
				->leftjoin('fecalysis_results', 'medical_appointments.id', 'fecalysis_results.medical_appointment_id')
				->leftjoin('urinalysis_results', 'medical_appointments.id', 'urinalysis_results.medical_appointment_id')
				->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')
				->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')
				->join('staff_info', 'medical_schedules.staff_id', 'staff_info.staff_id')
				->select('medical_appointments.id','patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'medical_schedules.schedule_day')
				->paginate(10);
				$cbc_requests = CbcResult::whereNull('hemoglobin')->orWhereNull('hemasocrit')->orWhereNull('wbc')->orderBy('cbc_results.created_at', 'desc');
				$drug_test_requests = DrugTestResult::whereNull('drug_test_result')->orderBy('drug_test_results.created_at', 'desc');
				$fecalysis_requests = FecalysisResult::whereNull('macroscopic')->orWhereNull('microscopic')->orderBy('fecalysis_results.created_at', 'desc');
				$urinalysis_requests = UrinalysisResult::whereNull('pus_cells')->orWhereNull('rbc')->orWhereNull('albumin')->orWhereNull('sugar')->orderBy('urinalysis_results.created_at', 'desc');
				$params['cbc_request_count'] = count($cbc_requests->get());
				if(count($cbc_requests->get())>0)
				{
					$params['cbc_latest'] = $cbc_requests->first()->created_at;
				}
				$params['drug_test_request_count'] = count($drug_test_requests->get());
				if(count($drug_test_requests->get())>0)
				{
					$params['drug_test_latest'] = $drug_test_requests->first()->created_at;
				}
				$params['fecalysis_request_count'] = count($fecalysis_requests->get());
				if(count($fecalysis_requests->get())>0)
				{
					$params['fecalysis_latest'] = $fecalysis_requests->first()->created_at;
					// dd($fecalysis_requests->get());
				}
				$params['urinalysis_request_count'] = count($urinalysis_requests->get());
				if(count($urinalysis_requests->get())>0)
				{
					$params['urinalysis_latest'] = $urinalysis_requests->first()->created_at;
				}
				$params['navbar_active'] = 'account';
				$params['sidebar_active'] = 'dashboard';
			return view('staff.medical-lab.dashboard', $params);
		}
		public function viewlabdiagnosis(Request $request)
		{
		$appointment_id = $request->medical_appointment_id;
		$cbc_result = CbcResult::where('medical_appointment_id', $appointment_id)->first();
		$drug_test_result = DrugTestResult::where('medical_appointment_id', $appointment_id)->first();
		$fecalysis_result = FecalysisResult::where('medical_appointment_id', $appointment_id)->first();
		$urinalysis_result = UrinalysisResult::where('medical_appointment_id', $appointment_id)->first();
		return response()->json([
			'cbc_result' => $cbc_result,
			'drug_test_result' => $drug_test_result,
			'fecalysis_result' => $fecalysis_result,
			'urinalysis_result' => $urinalysis_result,
			]);
		}

		public function updatelabdiagnosis(Request $request)
		{
			$cbc = CbcResult::where('medical_appointment_id', $request->medical_appointment_id)->first();
			if(count($cbc)==1 && ($request->hemoglobin!='' || $request->hemasocrit!='' || $request->wbc!='' ))
			{
				$cbc->lab_staff_id = Auth::user()->user_id;
				if($request->hemoglobin!='')
				{
					$cbc->hemoglobin = $request->hemoglobin;
				}
				if($request->hemasocrit!='')
				{
					$cbc->hemasocrit = $request->hemasocrit;	
				}
				if($request->wbc!='')
				{
					$cbc->wbc = $request->wbc;	
				}
				$cbc->update();
			}
		$drug_test = DrugTestResult::where('medical_appointment_id', $request->medical_appointment_id)->first();
		if(count($drug_test)==1 && ($request->drug_test !=''))
			{
				$drug_test->lab_staff_id = Auth::user()->user_id;
				if($request->drug_test!='')
				{
					$drug_test->drug_test_result = $request->drug_test;
				}
				$drug_test->update();
			}
		$fecalysis = FecalysisResult::where('medical_appointment_id', $request->medical_appointment_id)->first();
		if(count($fecalysis)==1 && ($request->macroscopic !='' || $request->microscopic !=''))
			{
				$fecalysis->lab_staff_id = Auth::user()->user_id;
				if($request->macroscopic!='')
				{
					$fecalysis->macroscopic = $request->macroscopic;
				}
				if($request->microscopic!='')
				{
					$fecalysis->microscopic = $request->microscopic;
				}
				
				$fecalysis->update();
			}
		$urinalysis = UrinalysisResult::where('medical_appointment_id', $request->medical_appointment_id)->first();
		if(count($urinalysis)==1 && ($request->pus_cells !='' || $request->rbc !='' || $request->albumin !='' || $request->sugar !=''))
			{
				if($request->pus_cells!='')
				{
					$urinalysis->pus_cells = $request->pus_cells;
				}
				if($request->rbc!='')
				{
						$urinalysis->rbc = $request->rbc;
					}
					if($request->albumin!='')
				{
						$urinalysis->albumin = $request->albumin;
					}
					if($request->sugar!='')
				{
						$urinalysis->sugar = $request->sugar;
					}
					$urinalysis->update();
			}
		}

		public function addbillinglab(Request $request)
		{
			$appointment_id = $request->appointment_id;

			$patient_info = DB::table('patient_info')->join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')->where('medical_appointments.id', $appointment_id)->first();
			$patient_name = $patient_info->patient_first_name . ' ' . $patient_info->patient_last_name;

			$has_cbc_request = CbcResult::where('medical_appointment_id', $appointment_id)->get();
			$has_cbc_request_counter = 0;
			if (count($has_cbc_request)>0) {
				$has_cbc_request_counter++;
			}
			$has_drug_request = DrugTestResult::where('medical_appointment_id', $appointment_id)->get();
			$has_drug_request_counter = 0;
			if (count($has_drug_request)>0) {
				$has_drug_request_counter++;
			}
			$has_fecalysis_request = FecalysisResult::where('medical_appointment_id', $appointment_id)->get();
			$has_fecalysis_request_counter = 0;
			if (count($has_fecalysis_request)>0) {
				$has_fecalysis_request_counter++;
			}
			$has_urinalysis_request = UrinalysisResult::where('medical_appointment_id', $appointment_id)->get();
			$has_urinalysis_request_counter = 0;
			if (count($has_urinalysis_request)>0) {
				$has_urinalysis_request_counter++;
			}

			$display_cbc_services = MedicalAppointment::join('cbc_results', 'medical_appointments.id', 'cbc_results.medical_appointment_id')->where('medical_appointments.id', $appointment_id)->get();
			$check_cbc_if_exists = CbcResult::where('medical_appointment_id', $appointment_id)->where('hemoglobin','!=',NULL)->where('hemasocrit','!=',NULL)->where('wbc','!=',NULL)->get();
			$added_cbc_record = 0;
			if (count($check_cbc_if_exists)>0) {
				$added_cbc_record++;
			}
			$cbc_counter = 0;
			$cbc_counter_senior = 0;
			if(count($display_cbc_services)>0){
				$cbc_counter=MedicalService::where('patient_type_id', $patient_info->patient_type_id)->where('service_type', 'cbc')->get();
				if($patient_info->patient_type_id == '5'){
					$cbc_counter_senior=MedicalService::where('patient_type_id', '6')->where('service_type', 'cbc')->get();
				}
			}

			$display_drug_services = MedicalAppointment::join('drug_test_results', 'medical_appointments.id', 'drug_test_results.medical_appointment_id')->where('medical_appointments.id', $appointment_id)->get();
			$check_drug_if_exists = DrugTestResult::where('medical_appointment_id', $appointment_id)->where('drug_test_result','!=',NULL)->get();
			$added_drug_record = 0;
			if (count($check_drug_if_exists)>0) {
				$added_drug_record++;
			}
			$drug_counter = 0;
			$drug_counter_senior = 0;
			if(count($display_drug_services)>0){
				$drug_counter = MedicalService::where('patient_type_id', $patient_info->patient_type_id)->where('service_type', 'drugtest')->get();
				if($patient_info->patient_type_id == '5'){
					$drug_counter_senior=MedicalService::where('patient_type_id', '6')->where('service_type', 'drugtest')->get();
				}
			}

			$display_fecalysis_services = MedicalAppointment::join('fecalysis_results', 'medical_appointments.id', 'fecalysis_results.medical_appointment_id')->where('medical_appointments.id', $appointment_id)->get();
			$check_fecalysis_if_exists = FecalysisResult::where('medical_appointment_id', $appointment_id)->where('macroscopic','!=',NULL)->where('microscopic','!=',NULL)->get();
			$added_fecalysis_record = 0;
			if (count($check_fecalysis_if_exists)>0) {
				$added_fecalysis_record++;
			}
			$fecalysis_counter = 0;
			$fecalysis_counter_senior = 0;
			if(count($display_fecalysis_services)>0){
				$fecalysis_counter=MedicalService::where('patient_type_id', $patient_info->patient_type_id)->where('service_type', 'fecalysis')->get();
				if($patient_info->patient_type_id == 5){
					$fecalysis_counter_senior=MedicalService::where('patient_type_id', '6')->where('service_type', 'fecalysis')->get();
				}
			}

			$display_urinalysis_services = MedicalAppointment::join('urinalysis_results', 'medical_appointments.id', 'urinalysis_results.medical_appointment_id')->where('medical_appointments.id', $appointment_id)->get();
			$check_urinalysis_if_exists = UrinalysisResult::where('medical_appointment_id', $appointment_id)->where('pus_cells','!=',NULL)->where('rbc','!=',NULL)->where('albumin','!=',NULL)->where('sugar','!=',NULL)->get();
			$added_urinalysis_record = 0;
			if (count($check_urinalysis_if_exists)>0) {
				$added_urinalysis_record++;
			}
			$urinalysis_counter = 0;
			$urinalysis_counter_senior = 0;
			if(count($display_urinalysis_services)>0){
				$urinalysis_counter=MedicalService::where('patient_type_id', $patient_info->patient_type_id)->where('service_type', 'urinalysis')->get();
				if($patient_info->patient_type_id == 5){
					$urinalysis_counter_senior=MedicalService::where('patient_type_id', '6')->where('service_type', 'urinalysis')->get();
				}
			}

			if($patient_info->patient_type_id == 5){
				return response()->json(['patient_info' => $patient_info, 
																'patient_type_id' => $patient_info->patient_type_id, 
																'added_cbc_record'=>$added_cbc_record,
																'added_drug_record'=>$added_drug_record,  
																'added_fecalysis_record'=>$added_fecalysis_record, 
																'added_urinalysis_record'=>$added_urinalysis_record, 
																'display_cbc_services' => $display_cbc_services, 
																'display_drug_services' => $display_drug_services, 
																'display_fecalysis_services' => $display_fecalysis_services, 
																'display_urinalysis_services' => $display_urinalysis_services, 
																'cbc_counter' => $cbc_counter, 
																'cbc_counter_senior' => $cbc_counter_senior, 
																'drug_counter' => $drug_counter, 
																'drug_counter_senior' => $drug_counter_senior, 
																'fecalysis_counter' => $fecalysis_counter, 
																'fecalysis_counter_senior' => $fecalysis_counter_senior, 
																'urinalysis_counter' => $urinalysis_counter, 
																'urinalysis_counter_senior' => $urinalysis_counter_senior, 
																'has_cbc_request_counter' => $has_cbc_request_counter,
																'has_drug_request_counter' => $has_drug_request_counter,
																'has_fecalysis_request_counter' => $has_fecalysis_request_counter,
																'has_urinalysis_request_counter' => $has_urinalysis_request_counter,
																'patient_type' => $patient_info->patient_type_id, ]);
			}
			else{
				return response()->json(['patient_info' => $patient_info, 
															'patient_type_id' => $patient_info->patient_type_id, 
															'added_cbc_record'=>$added_cbc_record,
															'added_drug_record'=>$added_drug_record,  
															'added_fecalysis_record'=>$added_fecalysis_record, 
															'added_urinalysis_record'=>$added_urinalysis_record,  
															'display_cbc_services' => $display_cbc_services, 
															'display_drug_services' => $display_drug_services, 
															'display_fecalysis_services' => $display_fecalysis_services, 
															'display_urinalysis_services' => $display_urinalysis_services, 
															'cbc_counter' => $cbc_counter, 'drug_counter' => $drug_counter, 
															'fecalysis_counter' => $fecalysis_counter, 
															'urinalysis_counter' => $urinalysis_counter,
															'has_cbc_request_counter' => $has_cbc_request_counter,
															'has_drug_request_counter' => $has_drug_request_counter,
															'has_fecalysis_request_counter' => $has_fecalysis_request_counter,
															'has_urinalysis_request_counter' => $has_urinalysis_request_counter, 
															'patient_type' => $patient_info->patient_type_id, ]);
			}
	}

	public function confirmbillinglab(Request $request){	
		$appointment_id = $request->appointment_id;
		$ps = $request->checked_services_array_id;
		$ls = $request->checked_services_array_rate;
		for($i=0; $i < sizeof($ps); $i++){
				$billing = new MedicalBilling;
				$billing->medical_service_id = $ps[$i];
				$billing->medical_appointment_id = $appointment_id;
				$billing->status = 'unpaid';
				$billing->amount = $ls[$i];
				$billing->save();
		}
		MedicalAppointment::where('id', $appointment_id)->update(['status' => '1']);
		return response()->json(['success' => 'success']); 
	}


		public function profile()
		{
				$lab = Staff::find(Auth::user()->user_id);
				$params['sex'] = $lab->sex;
				$params['position'] = $lab->position;
				$params['birthday'] = $lab->birthday;
				$params['civil_status'] = $lab->civil_status;
				$params['personal_contact_number'] = $lab->personal_contact_number;
				$params['street'] = $lab->street;
				$params['picture'] = $lab->picture;
				if(!is_null($lab->town_id))
						{
								$params['town'] = Town::find($lab->town_id)->town_name;
								$params['province'] = Province::find(Town::find($lab->town_id)->province_id)->province_name;
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
				return view('staff.medical-lab.profile', $params);
		}
		public function editprofile()
		{
				$lab = Staff::find(Auth::user()->user_id);
				// $params['age'] = (date('Y') - date('Y',strtotime($lab->birthday)));
				$params['sex'] = $lab->sex;
				$params['position'] = $lab->position;
				$params['birthday'] = $lab->birthday;
				$params['civil_status'] = $lab->civil_status;
				$params['personal_contact_number'] = $lab->personal_contact_number;
				$params['street'] = $lab->street;
				if(!is_null($lab->town_id))
						{
								$params['town'] = Town::find($lab->town_id)->town_name;
								$params['province'] = Province::find(Town::find($lab->town_id)->province_id)->province_name;
						}
						else
						{
								$params['town'] = '';
								$params['province'] = '';
						}
				$params['navbar_active'] = 'account';
				$params['sidebar_active'] = 'profile';
				return view('staff.medical-lab.editprofile', $params);
		}

		public function updateprofile(Request $request)
		{
				if($request->updatepassword != "")
				{
						$user = Auth::user();
						$user->password = bcrypt($request->updatepassword);
						$user->update();
				}
				$lab = Staff::find(Auth::user()->user_id);
				$lab->sex = $request->input('sex');
				$lab->birthday = $request->input('birthday');
				$lab->street = $request->input('street');
				$lab->position = $request->input('position');
				$lab->civil_status = $request->civil_status;
				$province = Province::where('province_name', $request->input('province'))->first();
				if(count($province)>0)
				{
						// $lab->nationality_id = $nationality->id;
						$town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
						if(count($town)>0)
						{
								$lab->town_id = $town->id;
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
								$town-save();
								$lab->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
						$lab->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
				}
				$lab->personal_contact_number = $request->input('personal_contact_number');
				if (Input::file('picture') != NULL) { 
					$path = '..\public\images';
					$file_name = Input::file('picture')->getClientOriginalName(); 
					$file_name_fin = $lab->staff_id.'_'.$file_name;
					$image_type = pathinfo($file_name_fin,PATHINFO_EXTENSION);
					if($image_type == 'jpg' || $image_type == 'jpeg' || $image_type == 'png'){
						Input::file('picture')->move($path, $file_name_fin);
						$lab->picture = $file_name_fin;
					}
				}

				$lab->update();
				return redirect('lab/profile');
		}

		public function searchpatient()
		{
				$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.medical-lab.searchpatient', $params);
		}
}
