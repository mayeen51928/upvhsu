<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use App\Staff;
use App\Town;
use App\Province;
use App\ChestXrayResult;
use App\MedicalBilling;
use App\MedicalAppointment;
use App\Patient;
use App\MedicalService;
class XrayController extends Controller
{
	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			if(Auth::check()){
				if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 4){
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
		$params['xray_requests'] = MedicalAppointment::where('medical_appointments.has_lab_or_xray_request', '1')
		->join('chest_xray_results', 'chest_xray_results.medical_appointment_id', 'medical_appointments.id')
		->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')
        ->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')
        ->join('staff_info', 'medical_schedules.staff_id', 'staff_info.staff_id')
        ->select('medical_appointments.id','patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'medical_schedules.schedule_day')
		->where('chest_xray_results.status', '0')
		->paginate(10);
		$xray_requests = ChestXrayResult::whereNull('xray_result')->orderBy('chest_xray_results.created_at', 'desc');
		$params['xray_request_count'] = count($xray_requests->get());
		if(count($xray_requests->get())>0)
    {
    	$params['xray_latest'] = $xray_requests->first()->created_at;
    }
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'dashboard';
		return view('staff.medical-xray.dashboard', $params);
	}

	public function viewxraydiagnosis(Request $request)
	{
		$appointment_id = $request->medical_appointment_id;
		$xray_result = ChestXrayResult::where('medical_appointment_id', $appointment_id)->first();
		$patient_type_id = Patient::join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')->where('medical_appointments.id', $appointment_id)->pluck('patient_type_id')->first();
		$xray_billing_services = MedicalService::where('service_type', 'xray')->get();
		$xray_billing_status = MedicalBilling::join('medical_appointments', 'medical_billings.medical_appointment_id', 'medical_appointments.id')->join('medical_services', 'medical_billings.medical_service_id', 'medical_services.id')->where('medical_billings.medical_appointment_id', $appointment_id)->where('medical_services.service_type', 'xray')->get();
		return response()->json([
			'patient_type_id' => $patient_type_id,
			'xray_result' => $xray_result, 
			'xray_billing_services' => $xray_billing_services,
			'xray_billing_status' => $xray_billing_status,
		]);
	}

	public function addxrayresult(Request $request)
	{
		$patient_type_id = Patient::join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')->where('medical_appointments.id', $request->medical_appointment_id)->pluck('patient_type_id')->first();
		$xray_billing = MedicalBilling::join('medical_services', 'medical_services.id', 'medical_billings.medical_service_id')->where('medical_appointment_id',  $request->medical_appointment_id)->where('medical_services.service_type', 'xray')->get();
		if($request->xray_status == 1){
			ChestXrayResult::where('medical_appointment_id', $request->medical_appointment_id)->update(array('status' => '1'));
		}
		if(count($xray_billing) == 0){
			for($i = 0; $i < sizeof($request->xray_services_id); $i++){
				$billing = new MedicalBilling;
				$billing->medical_service_id = $request->xray_services_id[$i];
				$billing->medical_appointment_id = $request->medical_appointment_id;
				$billing->status = 'unpaid';
				if($patient_type_id == 1){
					$billing->amount = MedicalService::where('id', $request->xray_services_id[$i])->pluck('student_rate')->first();
				}
				elseif($patient_type_id == 2 || $patient_type_id == 3 || $patient_type_id == 4){
					$billing->amount = MedicalService::where('id', $request->xray_services_id[$i])->pluck('faculty_staff_dependent_rate')->first();
				}
				else{
					$billing->amount = MedicalService::where('id', $request->xray_services_id[$i])->pluck('opd_rate')->first();
				}
				$billing->save();
			}
		}

		$xray = ChestXrayResult::where('medical_appointment_id',$request->medical_appointment_id)->first();
		$xray->xray_staff_id = Auth::user()->user_id;
		$xray->xray_result = $request->chest_xray;
		$xray->update();
	}

	public function addbillingxray(Request $request){
		$appointment_id = $request->appointment_id;

		$patient_info = Patient::join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')->where('medical_appointments.id', $appointment_id)->first();
		$patient_name = $patient_info->patient_first_name . ' ' . $patient_info->patient_last_name;
		$checker = 0;
		$xray_result_checker = ChestXrayResult::where('medical_appointment_id',$appointment_id)->where('xray_result', '!=', NULL)->first();
		if(count($xray_result_checker)>0){
			$checker = 1;
		}
		$display_xray_services = MedicalService::where('patient_type_id', $patient_info->patient_type_id)->where('service_type', 'xray')->get();

		if($patient_info->patient_type_id == 5){
			$display_xray_services_senior = MedicalService::where('patient_type_id', 6)->where('service_type', 'xray')->get();
		}
		
		if($patient_info->patient_type_id == 5){
				return response()->json(['patient_info' => $patient_info, 
							'display_xray_services' => $display_xray_services,
							'display_xray_services_senior' => $display_xray_services_senior,  
							'checker' => $checker,
							'patient_type_id' => $patient_info->patient_type_id,
			]);
		}
		else{
			return response()->json(['patient_info' => $patient_info, 
							'display_xray_services' => $display_xray_services,
							'checker' => $checker,
							'patient_type_id' => $patient_info->patient_type_id,
			]);
		}
		
	}

	public function confirmbillingxray(Request $request){	
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
		ChestXrayResult::where('medical_appointment_id', $appointment_id)->update(['status' => '1']);
		return response()->json(['success' => 'success']); 
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
		return view('staff.medical-xray.profile', $params);
	}
	public function editprofile()
	{
		$xray = Staff::find(Auth::user()->user_id);
		// $params['age'] = (date('Y') - date('Y',strtotime($xray->birthday)));
		$params['sex'] = $xray->sex;
		$params['position'] = $xray->position;
		$params['birthday'] = $xray->birthday;
		$params['civil_status'] = $xray->civil_status;
		$params['personal_contact_number'] = $xray->personal_contact_number;
		$params['street'] = $xray->street;
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
		return view('staff.medical-xray.editprofile', $params);
	}

	public function updateprofile(Request $request)
	{
		if($request->updatepassword != "")
		{
			$user = Auth::user();
			$user->password = bcrypt($request->updatepassword);
			$user->update();
		}
		$xray = Staff::find(Auth::user()->user_id);
		$xray->sex = $request->input('sex');
		$xray->birthday = $request->input('birthday');
		$xray->street = $request->input('street');
		$xray->position = $request->input('position');
		$xray->civil_status = $request->civil_status;
		$province = Province::where('province_name', $request->input('province'))->first();
		if(count($province)>0)
		{
			// $xray->nationality_id = $nationality->id;
			$town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
			if(count($town)>0)
			{
				$xray->town_id = $town->id;
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
				$xray->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
			$xray->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
		}

		if (Input::file('picture') != NULL) { 
			$path = 'images';
			$file_name = Input::file('picture')->getClientOriginalName(); 
			$file_name_fin = $xray->staff_id.'_'.$file_name;
			$image_type = pathinfo($file_name_fin,PATHINFO_EXTENSION);
			if($image_type == 'jpg' || $image_type == 'jpeg' || $image_type == 'png'){
				Input::file('picture')->move($path, $file_name_fin);
				$xray->picture = $file_name_fin;
			}
		}

		$xray->personal_contact_number = $request->input('personal_contact_number');
		$xray->update();
		return redirect('xray/profile');
	}

	public function searchpatient()
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'searchpatient';
		return view('staff.medical-xray.searchpatient', $params);
	}
}
