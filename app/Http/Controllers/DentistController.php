<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\DentalSchedule;
use App\DentalRecord;
use App\DentalAppointment;
use App\AdditionalDentalRecord;
use App\Patient;
use App\DegreeProgram;
use App\Religion;
use App\Nationality;
use App\ParentModel;
use App\HasParent;
use App\HasGuardian;
use App\Guardian;
use DB;
use App\Staff;
use App\Town;
use App\Province;
use Log;
use Illuminate\Support\Facades\Input;


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
					// ->where('dental_appointments.created_at', '=', date('Y-m-d'))
					->get();

			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'dashboard';
			return view('staff.dental-dentist.dashboard', $params, compact('dental_appointments_fin'));
		}

		public function updatedentalrecord(Request $request)
		{
			$appointment_id = $request->addDentalRecord;
			$patient_id = $request->addDentalRecord2;

			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'dashboard';

			$patient_info = DB::table('dental_appointments')
					->join('patient_info', 'dental_appointments.patient_id', '=', 'patient_info.patient_id')
					->join('dental_schedules', 'dental_appointments.dental_schedule_id', '=', 'dental_schedules.id')
					->orderBy('dental_schedules.schedule_start', 'desc')
					->where('dental_appointments.id', '=', $appointment_id)
					->first();

			$stacks_condition = array();
			$stacks_operation = array();
			for ($x = 55; $x >= 51; $x--)
			{
		    $dental_chart_results = DB::table('dental_records')
		    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
				    ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
						->pluck('condition_id')
						->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#ff4000";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ffff00";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#00ff00";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#00ffff";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#0000ff";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_condition, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
					->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    	->orderBy('dental_records.created_at', 'desc')
					->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
					->pluck('operation_id')
					->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#bf00ff";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ff0080";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#ff0000";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#808080";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#194d19";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_operation, $dental_chart_results);
			}

			$stacks_condition2 = array();
			$stacks_operation2 = array();
			for ($x = 61; $x <= 65; $x++)
			{
		    $dental_chart_results = DB::table('dental_records')
		    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
				    ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
						->pluck('condition_id')
						->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#ff4000";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ffff00";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#00ff00";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#00ffff";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#0000ff";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_condition2, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
				->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
					->pluck('operation_id')
					->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#bf00ff";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ff0080";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#ff0000";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#808080";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#194d19";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_operation2, $dental_chart_results);
			}

			$stacks_condition3 = array();
			$stacks_operation3 = array();
			for ($x = 18; $x >= 11; $x--)
			{
		    $dental_chart_results = DB::table('dental_records')
		    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
				    ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
						->pluck('condition_id')
						->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#ff4000";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ffff00";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#00ff00";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#00ffff";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#0000ff";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_condition3, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
				->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
					->pluck('operation_id')
					->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#bf00ff";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ff0080";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#ff0000";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#808080";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#194d19";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_operation3, $dental_chart_results);
			}

			$stacks_condition4 = array();
			$stacks_operation4 = array();
			for ($x = 21; $x <= 28; $x++)
			{
		    $dental_chart_results = DB::table('dental_records')
		    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
				    ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
						->pluck('condition_id')
						->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#ff4000";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ffff00";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#00ff00";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#00ffff";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#0000ff";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_condition4, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
				->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
					->pluck('operation_id')
					->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#bf00ff";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ff0080";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#ff0000";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#808080";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#194d19";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_operation4, $dental_chart_results);
			}

			$stacks_condition5 = array();
			$stacks_operation5 = array();
			for ($x = 48; $x >= 41; $x--)
			{
		    $dental_chart_results = DB::table('dental_records')
		    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
				    ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
						->pluck('condition_id')
						->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#ff4000";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ffff00";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#00ff00";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#00ffff";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#0000ff";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_condition5, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
				->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
					->pluck('operation_id')
					->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#bf00ff";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ff0080";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#ff0000";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#808080";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#194d19";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_operation5, $dental_chart_results);
			}

			$stacks_condition6 = array();
			$stacks_operation6 = array();
			for ($x = 31; $x <= 38; $x++)
			{
		    $dental_chart_results = DB::table('dental_records')
		    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
				    ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
						->pluck('condition_id')
						->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#ff4000";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ffff00";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#00ff00";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#00ffff";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#0000ff";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_condition6, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
				->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
					->pluck('operation_id')
					->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#bf00ff";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ff0080";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#ff0000";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#808080";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#194d19";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_operation6, $dental_chart_results);
			}

			$stacks_condition7 = array();
			$stacks_operation7 = array();
			for ($x = 85; $x >= 81; $x--)
			{
		    $dental_chart_results = DB::table('dental_records')
		    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
				    ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
						->pluck('condition_id')
						->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#ff4000";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ffff00";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#00ff00";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#00ffff";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "0000ff";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_condition7, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
				->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
					->pluck('operation_id')
					->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#bf00ff";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ff0080";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#ff0000";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#808080";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#194d19";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_operation7, $dental_chart_results);
			}

			$stacks_condition8 = array();
			$stacks_operation8 = array();
			for ($x = 71; $x <= 75; $x++)
			{
		    $dental_chart_results = DB::table('dental_records')
		    		->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
				    ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
						->pluck('condition_id')
						->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#ff4000";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ffff00";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#00ff00";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#00ffff";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#0000ff";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_condition8, $dental_chart_results);


				$dental_chart_results = DB::table('dental_records')
				->join('dental_appointments', 'dental_records.appointment_id', '=', 'dental_appointments.id')
			    ->orderBy('dental_records.created_at', 'desc')
					->where([
							['teeth_id', '=', $x],
							['patient_id', '=', $patient_id],
						])
					->pluck('operation_id')
					->first();

				if($dental_chart_results == 1){
					$dental_chart_results = "#bf00ff";
				}
				elseif($dental_chart_results == 2){
					$dental_chart_results = "#ff0080";
				}
				elseif($dental_chart_results == 3){
					$dental_chart_results = "#ff0000";
				}
				elseif($dental_chart_results == 4){
					$dental_chart_results = "#808080";
				}
				elseif($dental_chart_results == 5){
					$dental_chart_results = "#194d19";
				}
				else{
					$dental_chart_results = "white";
				}
				array_push($stacks_operation8, $dental_chart_results);
			}

			$additional_dental_records = DB::table('additional_dental_records')
				->where('appointment_id', '=', $appointment_id)
				->first();

			$counter = 0;
			if(count($additional_dental_records) > 0){
				$counter = 1;
			}
					
			return view('staff.dental-dentist.adddentalrecord', $params, compact('patient_info', 'stacks_condition', 'stacks_operation', 'stacks_condition2', 'stacks_operation2', 'stacks_condition3', 'stacks_operation3', 'stacks_condition4', 'stacks_operation4', 'stacks_condition5', 'stacks_operation5', 'stacks_condition6', 'stacks_operation6', 'stacks_condition7', 'stacks_operation7', 'stacks_condition8', 'stacks_operation8', 'counter', 'additional_dental_records'));
		}

		public function updatedentalrecordmodal(Request $request)
		{
			$teeth_id = $request->teeth_id;
			$teeth_info_condition = DB::table('dental_records')
		    ->orderBy('created_at', 'desc')
				->where([
							['teeth_id', '=', $teeth_id]
						])
				->pluck('condition_id')
				->first();

			$teeth_info_operation = DB::table('dental_records')
		    ->orderBy('created_at', 'desc')
				->where([
							['teeth_id', '=', $teeth_id]
						])
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
	        $params['picture'] = $dentist->picture;
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
	    	if($request->updatepassword != "")
	        {
	            $user = Auth::user();
	            $user->password = bcrypt($request->updatepassword);
	            $user->update();
	        }
	        $dentist = Staff::find(Auth::user()->user_id);
	        $dentist->sex = $request->input('sex');
	        $dentist->birthday = $request->input('birthday');
	        $dentist->street = $request->input('street');
	        $dentist->position = $request->input('position');
	        $dentist->civil_status = $request->civil_status;
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
	                if($json['rows'][0]['elements'][0]['status'] == 'OK')
					{
						$distance=$json['rows'][0]['elements'][0]['distance']['value'];
						$town->distance_to_miagao = $distance/1000;
					}
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
	            if($json['rows'][0]['elements'][0]['status'] == 'OK')
				{
					$distance=$json['rows'][0]['elements'][0]['distance']['value'];
					$town->distance_to_miagao = $distance/1000;
				}
	            $town->save();
	            $dentist->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
	        }

	        if (Input::file('picture') != NULL) { 
            $path = '..\public\images';
						$file_name = Input::file('picture')->getClientOriginalName(); 
						$file_name_fin = $dentist->staff_id.'_'.$file_name;
						$image_type = pathinfo($file_name_fin,PATHINFO_EXTENSION);
						if($image_type == 'jpg' || $image_type == 'jpeg' || $image_type == 'png'){
							Input::file('picture')->move($path, $file_name_fin);
							$dentist->picture = $file_name_fin;
						}
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
			$params['patients'] = DentalAppointment::select('dental_appointments.patient_id', 'patient_info.patient_first_name', 'patient_info.patient_last_name')->distinct()->join('patient_info', 'patient_info.patient_id', 'dental_appointments.patient_id')->orderBy('patient_last_name', 'asc')->get();
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.dental-dentist.searchpatient', $params);
		}
		public function searchpatientnamerecorddental(Request $request){

			// To fix: when searching for first name and last name combination
			// already fixed chereettt
			// dd($request->search_string);
			if($request->search_string!='')
			{
				$counter = 0;
				$search_string = explode(" ",$request->search_string);
				for($i=0; $i < sizeof($search_string); $i++)
				{
					$search_patient_id_records = Patient::where('patient_first_name', 'like', '%'.$search_string[$i].'%')->orWhere('patient_middle_name', 'like', '%'.$search_string[$i].'%')->orWhere('patient_last_name', 'like', '%'.$search_string[$i].'%')->pluck('patient_id')->all();
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
		public function displaypatientrecordsearchdental(Request $request)
		{
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
			$params['records'] = DentalSchedule::join('dental_appointments', 'dental_appointments.dental_schedule_id', 'dental_schedules.id')->where('patient_id', $id)->get();
			// dd($params['records']);
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.dental-dentist.viewrecords', $params);
		}
		public function searchpatientbydate(){
			$params['patients'] = DentalAppointment::select('dental_appointments.patient_id', 'patient_info.patient_first_name', 'patient_info.patient_last_name')->distinct()->join('patient_info', 'patient_info.patient_id', 'dental_appointments.patient_id')->orderBy('patient_last_name', 'asc')->get();
			$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.dental-dentist.searchpatientbydate', $params);
		}

		public function searchpatientbydaterecorddental(Request $request){
			if($request->search_month!='00' || $request->search_date!='00' || $request->search_year!='00')
			{
				$counter = 0;
				if($request->search_month!='00' && $request->search_date=='00' && $request->search_year=='00')
				{
					$search_by_months = DentalSchedule::whereMonth('schedule_start', $request->search_month)->whereDay('schedule_start', '<=', date('d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_months)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_months as $search_by_month){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_month->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);
								array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month=='00' && $request->search_date!='00' && $request->search_year=='00')
				{
					$search_by_dates = DentalSchedule::whereDay('schedule_start', $request->search_date)->whereDay('schedule_start', '<=', date('d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_dates)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_dates as $search_by_date){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_date->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month=='00' && $request->search_date=='00' && $request->search_year!='00')
				{
					$sarch_by_years = DentalSchedule::whereYear('schedule_start', $request->search_year)->whereDay('schedule_start', '<=', date('d'))->orderBy('schedule_start', 'asc')->get();
					if(count($sarch_by_years)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($sarch_by_years as $sarch_by_year){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $sarch_by_year->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month!='00' && $request->search_date!='00' && $request->search_year=='00')
				{
					$search_by_month_dates = DentalSchedule::whereMonth('schedule_start', $request->search_month)->whereDay('schedule_start', $request->search_date)->whereDay('schedule_start', '<=', date('d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_month_dates)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_month_dates as $search_by_month_date){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_month_date->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month!='00' && $request->search_date!='00' && $request->search_year!='00')
				{
					$search_by_month_date_years = DentalSchedule::whereMonth('schedule_start', $request->search_month)->whereDay('schedule_start', $request->search_date)->whereYear('schedule_start', $request->search_year)->whereDay('schedule_start', '<=', date('d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_month_date_years)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_month_date_years as $search_by_month_date_year){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_month_date_year->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
					}
					else
					{
						return response()->json(['counter' => $counter]);
					}
				}
				if($request->search_month!='00' && $request->search_date=='00' && $request->search_year!='00')
				{
					$search_by_month_years = DentalSchedule::whereMonth('schedule_start', $request->search_month)->whereYear('schedule_start', $request->search_year)->whereDay('schedule_start', '<=', date('d'))->orderBy('schedule_start', 'asc')->get();
					if(count($search_by_month_years)>0)
					{
						$searchpatientnamearray = array();
						$searchpatientscheduledayarray = array();
						$searchpatientappointmentidyarray = array();
						$searchpatientscheduletimearray = array();
						foreach($search_by_month_years as $search_by_month_year){
							$get_appointment_ids = DentalAppointment::where('dental_schedule_id', $search_by_month_year->id)->get();
							foreach($get_appointment_ids as $get_appointment_id){
								
								array_push($searchpatientnamearray, Patient::find($get_appointment_id->patient_id)->patient_last_name.', '.Patient::find($get_appointment_id->patient_id)->patient_first_name);
								array_push($searchpatientscheduledayarray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'F j, Y'));
								array_push($searchpatientappointmentidyarray, $get_appointment_id->id);array_push($searchpatientscheduletimearray, date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_start), 'h:i A').' - '.date_format(date_create(DentalSchedule::find($get_appointment_id->dental_schedule_id)->schedule_end), 'h:i A'));
							}
						}
						$counter++;
						return response()->json(['searchpatientappointmentidyarray' => $searchpatientappointmentidyarray, 'searchpatientscheduledayarray' => $searchpatientscheduledayarray, 'searchpatientnamearray' => $searchpatientnamearray, 'searchpatientscheduletimearray' => $searchpatientscheduletimearray,'counter' => $counter]);
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
		public function addschedule(Request $request)
		{
				$schedules = $request->schedules;
				for($i=0; $i < sizeof($schedules); $i++){
					if($schedules[$i]!=''){
						$explode_schedules = explode(";;;", $schedules[$i]);
						$start = $explode_schedules[0];
						$end = $explode_schedules[1];
						$checker_if_exists = DentalSchedule::where('staff_id', Auth::user()->user_id)->where('schedule_start', $start)->where('schedule_end', $end)->first();
						if(count($checker_if_exists) == 0){
							$schedule = new DentalSchedule();
							$schedule->staff_id = Auth::user()->user_id;
							$schedule->schedule_start = $start;
							$schedule->schedule_end = $end;
							$schedule->save();
						}
					}
				}
				return response()->json(['success' => 'success']); 
		}

		public function hoverdentalchart(Request $request)
		{
				$teeth_id = $request->teeth_id;
				$type = $request->type;
				if($type == 'operation'){
					$dental_chart_hover_result = DB::table('dental_records')
			            ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $teeth_id],
						])
						->pluck('operation_id')
						->first();
				}
				else{
					$dental_chart_hover_result = DB::table('dental_records')
			            ->orderBy('dental_records.created_at', 'desc')
						->where([
							['teeth_id', '=', $teeth_id],
						])
						->pluck('condition_id')
						->first();
				}
	
				return response()->json(['id' => $dental_chart_hover_result, 'type' => $type]); 
		}

		public function additionaldentalrecord(Request $request)
		{
				$additional_dental_record = new AdditionalDentalRecord;
				$additional_dental_record->appointment_id = $request->appointment_id;
				$additional_dental_record->dental_caries = $request->dental_caries;
				$additional_dental_record->gingivitis = $request->gingivitis;
				$additional_dental_record->peridontal_pocket = $request->peridontal_pocket;
				$additional_dental_record->oral_debris = $request->oral_debris;
				$additional_dental_record->calculus = $request->calculus;
				$additional_dental_record->neoplasm = $request->neoplasm;
				$additional_dental_record->dental_facio_anomaly = $request->dental_facio_anomaly;
				$additional_dental_record->teeth_present = $request->teeth_present;
				$additional_dental_record->save();
		}
}
