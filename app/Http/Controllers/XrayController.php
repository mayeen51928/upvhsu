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
		$params['xray_requests'] = DB::table('chest_xray_results')
		->join('medical_appointments', 'chest_xray_results.medical_appointment_id', 'medical_appointments.id')
		->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')
		->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')
		->join('staff_info', 'medical_schedules.staff_id', 'staff_info.staff_id')
		->select('patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'chest_xray_results.*')
		->where('status', '0')
		->where('xray_result', null)
		->get();
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'dashboard';
		return view('staff.medical-xray.dashboard', $params);
	}

	public function addxrayresult(Request $request)
	{
		$xray = ChestXrayResult::find($request->xray_id);
		$xray->xray_staff_id = Auth::user()->user_id;
		$xray->xray_result = $request->chest_xray;
		$xray->update();
	}

	public function addbillingxray(Request $request){
		$appointment_id = $request->appointment_id;

		$patient_info = DB::table('patient_info')
					->join('medical_appointments', 'patient_info.patient_id', 'medical_appointments.patient_id')
					->where('medical_appointments.id', $appointment_id)
					->first();
		$patient_name = $patient_info->patient_first_name . ' ' . $patient_info->patient_last_name;

		$checker = 0;
		$xray_result_checker = DB::table('chest_xray_results')
					->where([
							['medical_appointment_id', '=', $appointment_id],
							['xray_result', '!=', NULL],
						])
					->first();
		if(count($xray_result_checker)>0){
			$checker = 1;
		}


		if($patient_info->patient_type_id == 1){
			$display_xray_services = DB::table('medical_services')
					->where([
							['patient_type_id', '=', 1],
							['service_type', '=', 'xray'],
						])
					->get();
		}

		if($patient_info->patient_type_id == 5){
			$display_xray_services = DB::table('medical_services')
					->where([
							['patient_type_id', '=', 5],
							['service_type', '=', 'xray'],
						])
					->get();

			$display_xray_services_senior = DB::table('medical_services')
					->where([
							['patient_type_id', '=', 6],
							['service_type', '=', 'xray'],
						])
					->get();
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
			$path = '..\public\images';
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
