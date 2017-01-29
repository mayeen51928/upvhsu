<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\DentalSchedule;
use App\DentalRecord;
use App\DentalAppointment;
use App\Patient;
use DB;
use App\Staff;
use App\Town;
use App\Province;
use Log;

class DentistController extends Controller
{
	public function __construct()
		{
			$this->middleware(function ($request, $next) {
				if(Auth::check()){
					if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 1){
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
			$user = Auth::user();
			$dental_appointments_fin = DB::table('dental_schedules')
					->join('dental_appointments', 'dental_schedules.id', '=', 'dental_appointments.dental_schedule_id')
					->join('patient_info', 'dental_appointments.patient_id', '=', 'patient_info.patient_id')
					->where('dental_schedules.staff_id', '=', $user->user_id)
					->where('dental_appointments.status', '=', '0')
					->get();

			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'dashboard';
			return view('staff.dental-dentist.dashboard', $params, compact('dental_appointments_fin'));
		}

		public function updatedentalrecord(Request $request)
		{
			$appointment_id = $request->addDentalRecord;
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'dashboard';

			$patient_infos = DB::table('dental_appointments')
					->join('patient_info', 'dental_appointments.patient_id', '=', 'patient_info.patient_id')
					->join('dental_schedules', 'dental_appointments.dental_schedule_id', '=', 'dental_schedules.id')
					->where('dental_appointments.id', '=', $appointment_id)
					->get();

			$appointment_ids = DB::table('dental_appointments')
					->where('dental_appointments.id', '=', $appointment_id)
					->get();

			$stacks_condition = array();
			$stacks_operation = array();
			for ($x = 55; $x >= 51; $x--)
			{
		    $dental_chart_results = DB::table('dental_records')
		    ->orderBy('created_at', 'desc')
				->where('teeth_id', '=', $x)
				->pluck('condition_id')
				->first();

				if($dental_chart_results == 0){
					$dental_chart_results = "white";
				}
				elseif($dental_chart_results == 1){
					$dental_chart_results = "blue";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "red";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "yellow";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "cyan";
				}
				else{
					$dental_chart_results = "pink";
				}
				array_push($stacks_condition, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
		    ->orderBy('created_at', 'desc')
				->where('teeth_id', '=', $x)
				->pluck('operation_id')
				->first();

				if($dental_chart_results == 0){
					$dental_chart_results = "white";
				}
				elseif($dental_chart_results == 1){
					$dental_chart_results = "blue";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "red";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "yellow";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "cyan";
				}
				else{
					$dental_chart_results = "pink";
				}
				array_push($stacks_operation, $dental_chart_results);
			}
					
			return view('staff.dental-dentist.adddentalrecord', $params, compact('appointment_ids', 'patient_infos', 'stacks_condition', 'stacks_operation'));
		}

		public function updatedentalrecordmodal(Request $request)
		{
			$teeth_id = $request->teeth_id;
			$teeth_info_condition = DB::table('dental_records')
		    ->orderBy('created_at', 'desc')
				->where('teeth_id', '=', $teeth_id)
				->pluck('condition_id')
				->first();

			$teeth_info_operation = DB::table('dental_records')
		    ->orderBy('created_at', 'desc')
				->where('teeth_id', '=', $teeth_id)
				->pluck('operation_id')
				->first();

			if(count($teeth_info_operation) > 0){
				$status = 1;
			}
			else{
				$status = 0;
			} 

			return response()->json(['condition_id' => $teeth_info_condition, 'operation_id' => $teeth_info_operation, 'status' => $status,]); 

		}

		public function insertdentalrecordmodal(Request $request)
		{
	  //     	$current_dental_record = DB::table('dental_records')
			// 			->where('dental_records.teeth_id', '=', $request->teeth_id)
			// 			->where('dental_records.appointment_id', '=', $request->appointment_id)
			// 			->get();

			// if(count($current_dental_record) == 0)
	      	{
		      	$dental_record = new DentalRecord();
	            $dental_record->teeth_id = $request->teeth_id;
	            $dental_record->condition_id = $request->condition_id;
	            $dental_record->operation_id = $request->operation_id;
	            $dental_record->appointment_id = $request->appointment_id;
	            $dental_record->save();
	      	}
	      	// else
	      	// {
	      	// 	$update = [['condition_id'=>$request->condition_id],['operation_id' => $request->operation_id]];

		      // 	$dental_record = DB::table('dental_records')
		      // 		->where('dental_records.teeth_id', $request->teeth_id)
		      // 		->where('dental_records.appointment_id', $request->appointment_id)
	       //      ->update($update);
	      	// };

	      	return response()->json(['success' => 'success']); 
				 
		}

		public function updatedentaldiagnosis(Request $request)
		{
			DB::table('dental_appointments')
	            ->where('dental_appointments.id', $request->appointment_id)
	            ->update(['status' => '1']);
	      	return response()->json(['success' => $request->appointment_id]); 
				 
		}

	    public function profile()
	    {
	        $dentist = Staff::find(Auth::user()->user_id);
	        $params['sex'] = $dentist->sex;
	        $params['position'] = $dentist->position;
	        $params['birthday'] = $dentist->birthday;
	        $params['civil_status'] = $dentist->civil_status;
	        $params['personal_contact_number'] = $dentist->personal_contact_number;
	        $params['street'] = $dentist->street;
	        if(!is_null($dentist->town_id))
	        {
	        	$params['town'] = Town::find($dentist->town_id)->town_name;
	        	$params['province'] = Province::find(Town::find($dentist->town_id)->province_id)->province_name;
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
	        return view('staff.dental-dentist.profile', $params);
	    }
	    public function editprofile()
	    {
	        $dentist = Staff::find(Auth::user()->user_id);
	        // $params['age'] = (date('Y') - date('Y',strtotime($dentist->birthday)));
	        $params['sex'] = $dentist->sex;
	        $params['position'] = $dentist->position;
	        $params['birthday'] = $dentist->birthday;
	        $params['civil_status'] = $dentist->civil_status;
	        $params['personal_contact_number'] = $dentist->personal_contact_number;
	        $params['street'] = $dentist->street;
	        if(!is_null($dentist->town_id))
	        {
	        	$params['town'] = Town::find($dentist->town_id)->town_name;
	        	$params['province'] = Province::find(Town::find($dentist->town_id)->province_id)->province_name;
	        }
	        else
	        {
	        	$params['town'] = '';
	        	$params['province'] = '';
	        }
	        
	        $params['navbar_active'] = 'account';
	        $params['sidebar_active'] = 'profile';
	        return view('staff.dental-dentist.editprofile', $params);
	    }

	    public function updateprofile(Request $request)
	    {
	        $dentist = Staff::find(Auth::user()->user_id);
	        $dentist->sex = $request->input('sex');
	        $dentist->birthday = $request->input('birthday');
	        $dentist->street = $request->input('street');
	        $province = Province::where('province_name', $request->input('province'))->first();
	        if(count($province)>0)
	        {
	            // $dentist->nationality_id = $nationality->id;
	            $town = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first();
	            if(count($town)>0)
	            {
	                $dentist->town_id = $town->id;
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
	                $distance=$json['rows'][0]['elements'][0]['distance']['value'];
	                $town->distance_to_miagao = $distance/1000;
	                $town->save();
	                $dentist->town_id = Town::where('town_name', $request->input('town'))->where('province_id', $province->id)->first()->id;
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
	            $distance=$json['rows'][0]['elements'][0]['distance']['value'];
	            $town->distance_to_miagao = $distance/1000;
	            $town->save();
	            $dentist->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
	        }
	        $dentist->personal_contact_number = $request->input('personal_contact_number');
	        $dentist->update();
	        return redirect('dentist/profile');
	    }

		public function manageschedule()
		{
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'manageschedule';
			return view('staff.dental-dentist.manageschedule', $params);
		}

		public function searchpatient()
		{
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.dental-dentist.searchpatient', $params);
		}

		public function addschedule(Request $request)
		{
				$schedules = $request->schedules;
				for($i=0; $i < sizeof($schedules); $i++){
						$explode_schedules = explode(";;;", $schedules[$i]);
						$start = $explode_schedules[0];
						$end = $explode_schedules[1];
						$schedule = new DentalSchedule();
						$schedule->staff_id = Auth::user()->user_id;
						$schedule->schedule_start = $start;
						$schedule->schedule_end = $end;
						$schedule->save();
				}
				
				return response()->json(['success' => 'success']); 
		}
}
