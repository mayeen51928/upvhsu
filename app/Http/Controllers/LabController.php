<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use App\MedicalAppointment;
use App\Patient;
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
				where('medical_appointments.has_lab_request', '1')
				->where('medical_appointments.status', '0')
				->leftjoin('cbc_results', 'medical_appointments.id', 'cbc_results.medical_appointment_id')
				->leftjoin('drug_test_results', 'drug_test_results.medical_appointment_id', 'medical_appointments.id')
				->leftjoin('fecalysis_results', 'medical_appointments.id', 'fecalysis_results.medical_appointment_id')
				->leftjoin('urinalysis_results', 'medical_appointments.id', 'urinalysis_results.medical_appointment_id')
				->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')
				->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')
				->join('staff_info', 'medical_schedules.staff_id', 'staff_info.staff_id')
				->select('medical_appointments.id','patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'medical_schedules.schedule_day')
				->orderBy('schedule_day', 'asc')
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
				}
				$params['urinalysis_request_count'] = count($urinalysis_requests->get());
				if(count($urinalysis_requests->get())>0)
				{
					$params['urinalysis_latest'] = $urinalysis_requests->first()->created_at;
				}
				$params['cbc_billing_services'] = MedicalService::where('service_type', 'cbc')->get();
				$params['navbar_active'] = 'account';
				$params['sidebar_active'] = 'dashboard';
			return view('staff.medical-lab.dashboard', $params);
		}
		public function viewlabdiagnosis(Request $request)
		{
			$appointment_id = $request->medical_appointment_id;
			$patient_type_id = Patient::join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')->where('medical_appointments.id', $appointment_id)->pluck('patient_type_id')->first();
			$cbc_result = CbcResult::where('medical_appointment_id', $appointment_id)->first();
			$drug_test_result = DrugTestResult::where('medical_appointment_id', $appointment_id)->first();
			$fecalysis_result = FecalysisResult::where('medical_appointment_id', $appointment_id)->first();
			$urinalysis_result = UrinalysisResult::where('medical_appointment_id', $appointment_id)->first();
			$cbc_billing_services = MedicalService::where('service_type', 'cbc')->get();
			$drug_billing_service = MedicalService::where('service_type', 'drugtest')->first();
			$fecalysis_billing_service = MedicalService::where('service_type', 'fecalysis')->first();
			$urinalysis_billing_service = MedicalService::where('service_type', 'urinalysis')->first();
			$cbc_billing_status = MedicalBilling::join('medical_appointments', 'medical_billings.medical_appointment_id', 'medical_appointments.id')->join('medical_services', 'medical_billings.medical_service_id', 'medical_services.id')->where('medical_billings.medical_appointment_id', $appointment_id)->where('medical_services.service_type', 'cbc')->orWhere('medical_services.service_type', 'drugtest')->orWhere('medical_services.service_type', 'fecalysis')->orWhere('medical_services.service_type', 'urinalysis')->get();

			return response()->json([
				'patient_type_id' => $patient_type_id,
				'cbc_result' => $cbc_result,
				'drug_test_result' => $drug_test_result,
				'fecalysis_result' => $fecalysis_result,
				'urinalysis_result' => $urinalysis_result,
				'cbc_billing_services' => $cbc_billing_services,
				'drug_billing_service' => $drug_billing_service,
				'fecalysis_billing_service' => $fecalysis_billing_service,
				'urinalysis_billing_service' => $urinalysis_billing_service,
				'cbc_billing_status' => $cbc_billing_status,
				]);
		}

		public function updatelabdiagnosis(Request $request)
		{
			$patient_type_id = Patient::join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')->where('medical_appointments.id', $request->medical_appointment_id)->pluck('patient_type_id')->first();
			$cbc = CbcResult::where('medical_appointment_id', $request->medical_appointment_id)->first();
			$counter = 0;
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

				if($cbc->status == '0')
				{
					for($i = 0; $i < sizeof($request->cbc_services_id); $i++){
						$billing = new MedicalBilling;
						$billing->medical_service_id = $request->cbc_services_id[$i];
						$billing->medical_appointment_id = $request->medical_appointment_id;
						$billing->status = 'unpaid';
						if($patient_type_id == 1){
							$billing->amount = MedicalService::where('id', $request->cbc_services_id[$i])->pluck('student_rate')->first();
						}
						elseif($patient_type_id == 2 || $patient_type_id == 3 || $patient_type_id == 4){
							$billing->amount = MedicalService::where('id', $request->cbc_services_id[$i])->pluck('faculty_staff_dependent_rate')->first();
						}
						else{
							$billing->amount = MedicalService::where('id', $request->cbc_services_id[$i])->pluck('opd_rate')->first();
						}
						$billing->save();
					}
					$cbc->status = '1';
				}
				$cbc->update();

				if($request->hemoglobin!='' && $request->hemasocrit!='' && $request->wbc!=''){
					$counter++;
				}
			}
		$drug_test = DrugTestResult::where('medical_appointment_id', $request->medical_appointment_id)->first();
		if(count($drug_test)==1 && ($request->drug_test !=''))
			{
				$drug_test->lab_staff_id = Auth::user()->user_id;
				if($request->drug_test!='')
				{
					$drug_test->drug_test_result = $request->drug_test;
				}
				if($drug_test->status == '0')
				{
					$billing = new MedicalBilling;
					$billing->medical_service_id = 36;
					$billing->medical_appointment_id = $request->medical_appointment_id;
					$billing->status = 'unpaid';
					if($patient_type_id == 1){
						$billing->amount = MedicalService::where('id', $request->drug_service_id)->pluck('student_rate')->first();
					}
					elseif($patient_type_id == 2 || $patient_type_id == 3 || $patient_type_id == 4){
						$billing->amount = MedicalService::where('id', $request->drug_service_id)->pluck('faculty_staff_dependent_rate')->first();
					}
					else{
						$billing->amount = MedicalService::where('id', $request->drug_service_id)->pluck('opd_rate')->first();
					}
					$billing->save();
					$drug_test->status = '1';
				}
				$drug_test->update();
				$counter++;
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

				if($fecalysis->status == '0')
				{
					$billing = new MedicalBilling;
					$billing->medical_service_id = $request->fecalysis_service_id;
					$billing->medical_appointment_id = $request->medical_appointment_id;
					$billing->status = 'unpaid';
					if($patient_type_id == 1){
						$billing->amount = MedicalService::where('id', $request->fecalysis_service_id)->pluck('student_rate')->first();
					}
					elseif($patient_type_id == 2 || $patient_type_id == 3 || $patient_type_id == 4){
						$billing->amount = MedicalService::where('id', $request->fecalysis_service_id)->pluck('faculty_staff_dependent_rate')->first();
					}
					else{
						$billing->amount = MedicalService::where('id', $request->fecalysis_service_id)->pluck('opd_rate')->first();
					}
					$billing->save();
					$fecalysis->status = '1';
				}
				$fecalysis->update();

				if($request->macroscopic !='' && $request->microscopic !=''){
					$counter++;
				}
			}
		$urinalysis = UrinalysisResult::where('medical_appointment_id', $request->medical_appointment_id)->first();
		if(count($urinalysis)==1 && ($request->pus_cells !='' || $request->rbc !='' || $request->albumin !='' || $request->sugar !=''))
			{
				$urinalysis->lab_staff_id = Auth::user()->user_id;
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

				if($urinalysis->status == '0'){
					$billing = new MedicalBilling;
					$billing->medical_service_id = $request->urinalysis_service_id;
					$billing->medical_appointment_id = $request->medical_appointment_id;
					$billing->status = 'unpaid';
					if($patient_type_id == 1){
						$billing->amount = MedicalService::where('id', $request->urinalysis_service_id)->pluck('student_rate')->first();
					}
					elseif($patient_type_id == 2 || $patient_type_id == 3 || $patient_type_id == 4){
						$billing->amount = MedicalService::where('id', $request->urinalysis_service_id)->pluck('faculty_staff_dependent_rate')->first();
					}
					else{
						$billing->amount = MedicalService::where('id', $request->urinalysis_service_id)->pluck('opd_rate')->first();
					}
					$billing->save();
					$urinalysis->status = '1';
				}
				$urinalysis->update();

				if($request->pus_cells !='' && $request->rbc !='' && $request->albumin !='' && $request->sugar !=''){
					$counter++;
				}
			}

			$medical_appointment = MedicalAppointment::find($request->medical_appointment_id);

			$sum = count($cbc)+count($drug_test)+count($fecalysis)+count($urinalysis);
			if($sum == $counter){
				$medical_appointment->has_lab_request = '2';
				$medical_appointment->update();
				return response()->json([ "delete" => "yes", ]);
			}
		}
		public function profile()
	{
		$xray = Staff::find(Auth::user()->user_id);
		$params['sex'] = $xray->sex;
		$params['position'] = $xray->position;
		$params['birthday'] = $xray->birthday;
		$params['civil_status'] = $xray->civil_status;
		$params['personal_contact_number'] = $xray->personal_contact_number;
		$params['street'] = $xray->street;
		$params['picture'] = $xray->picture;
		if(!is_null($xray->town_id))
			{
				$params['town'] = Town::find($xray->town_id)->town_name;
				$params['province'] = Province::find(Town::find($xray->town_id)->province_id)->province_name;
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
								$town->save();
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
					$path = 'images';
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
