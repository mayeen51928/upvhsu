<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Staff;
use App\Town;
use App\Province;
use App\MedicalBilling;
use App\MedicalSchedule;
use DB;
class CashierController extends Controller
{
	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			if(Auth::check()){
				if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 5){
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
	  $unpaid_bills = DB::table('medical_billings')
	  	->join('medical_appointments', 'medical_appointments.id', '=', 'medical_billings.medical_appointment_id')
	  	->join('medical_schedules', 'medical_appointments.medical_schedule_id', '=', 'medical_schedules.id')
	  	->join('staff_info', 'staff_info.staff_id', '=', 'medical_schedules.staff_id')
			->join('patient_info', 'patient_info.patient_id', '=', 'medical_appointments.patient_id')
	  	->select('patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'medical_schedules.schedule_day', DB::raw('medical_billings.medical_appointment_id, sum(medical_billings.amount) as amount'))
			->groupBy(DB::raw('medical_billings.medical_appointment_id, patient_info.patient_first_name, patient_info.patient_last_name, staff_info.staff_first_name, staff_info.staff_last_name, medical_schedules.schedule_day'))
			->where('medical_billings.status', '=', 'unpaid')
			->get();


	  $counter = 0;
	  if(count($unpaid_bills)>0){
			$counter++;
	  }

		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'dashboard';
		$params['counter'] = $counter;
		return view('staff.cashier.dashboard', $params, compact('unpaid_bills'));
	}

	public function profile()
	{
		$cashier = Staff::find(Auth::user()->user_id);
		$params['sex'] = $cashier->sex;
		$params['position'] = $cashier->position;
		$params['birthday'] = $cashier->birthday;
		$params['civil_status'] = $cashier->civil_status;
		$params['personal_contact_number'] = $cashier->personal_contact_number;
		$params['street'] = $cashier->street;
		$params['picture'] = $cashier->picture;
		if(!is_null($cashier->town_id))
			{
				$params['town'] = Town::find($cashier->town_id)->town_name;
				$params['province'] = Province::find(Town::find($cashier->town_id)->province_id)->province_name;
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
		return view('staff.cashier.profile', $params);
	}
	public function editprofile()
	{
		$cashier = Staff::find(Auth::user()->user_id);
		// $params['age'] = (date('Y') - date('Y',strtotime($cashier->birthday)));
		$params['sex'] = $cashier->sex;
		$params['position'] = $cashier->position;
		$params['birthday'] = $cashier->birthday;
		$params['civil_status'] = $cashier->civil_status;
		$params['personal_contact_number'] = $cashier->personal_contact_number;
		$params['street'] = $cashier->street;
		if(!is_null($cashier->town_id))
			{
				$params['town'] = Town::find($cashier->town_id)->town_name;
				$params['province'] = Province::find(Town::find($cashier->town_id)->province_id)->province_name;
			}
			else
			{
				$params['town'] = '';
				$params['province'] = '';
			}
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'profile';
		return view('staff.cashier.editprofile', $params);
	}

	public function updateprofile(Request $request)
	{
		$cashier = Staff::find(Auth::user()->user_id);
		$cashier->sex = $request->input('sex');
		$cashier->birthday = $request->input('birthday');
		$cashier->street = $request->input('street');
		$cashier->position = $request->input('position');
		$cashier->civil_status = $request->civil_status;
		$province = Province::where('province_name', $request->input('province'))->first();
		if(count($province)>0)
		{
			// $cashier->nationality_id = $nationality->id;
			$town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
			if(count($town)>0)
			{
				$cashier->town_id = $town->id;
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
				$cashier->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
			$cashier->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
		}

		if (Input::file('picture') != NULL) { 
			$path = '..\public\images';
			$file_name = Input::file('picture')->getClientOriginalName(); 
			Input::file('picture')->move($path, $file_name);
			$cashier->picture = $file_name;
		}

		$cashier->personal_contact_number = $request->input('personal_contact_number');
		$cashier->update();
		return redirect('cashier/profile');
	}

	public function searchpatient()
	{
		$params['navbar_active'] = 'account';
		$params['sidebar_active'] = 'searchpatient';
		return view('staff.cashier.searchpatient', $params);
	}

	public function displaymedicalbilling(Request $request)
	{
		$display_medical_billing = DB::table('medical_billings')
				->join('medical_services', 'medical_services.id', '=', 'medical_billings.medical_service_id')
				->where('medical_billings.medical_appointment_id', '=', $request->appointment_id)
				->get();    
		return response()->json(['display_medical_billing' => $display_medical_billing ]);
	}

	public function confirmmedicalbilling(Request $request)
	{
		DB::table('medical_billings')
			->where('medical_appointment_id', $request->appointment_id)
			->update(['status' => 'paid']);
		return response()->json(['success' => 'success']); 
	}
}
