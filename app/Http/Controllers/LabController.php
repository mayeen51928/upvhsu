<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Staff;
use App\Town;
use App\Province;
use App\CbcResult;
use App\ChestXrayResult;
use App\DrugTestResult;
use App\UrinalysisResult;
use App\FecalysisResult;
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
        $params['cbc_requests'] = DB::table('cbc_results')
        ->join('medical_appointments', 'cbc_results.medical_appointment_id', 'medical_appointments.id')
        ->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')
        ->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')
        ->join('staff_info', 'medical_schedules.staff_id', 'staff_info.staff_id')
        ->select('patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'cbc_results.*')
        ->where('status', '0')
        ->where('hemoglobin', null)
        ->where('hemasocrit', null)
        ->where('wbc', null)
        ->get();

        $params['drug_test_requests'] = DB::table('drug_test_results')
        ->join('medical_appointments', 'drug_test_results.medical_appointment_id', 'medical_appointments.id')
        ->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')
        ->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')
        ->join('staff_info', 'medical_schedules.staff_id', 'staff_info.staff_id')
        ->select('patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'drug_test_results.*')
        ->where('status', '0')
        ->where('drug_test_result', null)
        ->get();

        $params['fecalysis_requests'] = DB::table('fecalysis_results')
        ->join('medical_appointments', 'fecalysis_results.medical_appointment_id', 'medical_appointments.id')
        ->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')
        ->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')
        ->join('staff_info', 'medical_schedules.staff_id', 'staff_info.staff_id')
        ->select('patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'fecalysis_results.*')
        ->where('status', '0')
        ->where('macroscopic', null)
        ->where('microscopic', null)
        ->get();

        $params['urinalysis_requests'] = DB::table('urinalysis_results')
        ->join('medical_appointments', 'urinalysis_results.medical_appointment_id', 'medical_appointments.id')
        ->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')
        ->join('medical_schedules', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')
        ->join('staff_info', 'medical_schedules.staff_id', 'staff_info.staff_id')
        ->select('patient_info.patient_first_name', 'patient_info.patient_last_name', 'staff_info.staff_first_name', 'staff_info.staff_last_name', 'urinalysis_results.*')
        ->where('status', '0')
        ->where('pus_cells', null)
        ->where('rbc', null)
        ->where('albumin', null)
        ->where('sugar', null)
        ->get();

        // dd($params['cbc_requests']);
        $params['navbar_active'] = 'account';
    	$params['sidebar_active'] = 'dashboard';
    	return view('staff.medical-lab.dashboard', $params);
    }

    public function addcbcresult(Request $request)
    {
        $cbc = CbcResult::find($request->cbc_id);
        $cbc->lab_staff_id = Auth::user()->user_id;
        $cbc->hemoglobin = $request->hemoglobin;
        $cbc->hemasocrit = $request->hemasocrit;
        $cbc->wbc = $request->wbc;
        $cbc->update();
    }

    public function adddrugtestresult(Request $request)
    {
        $drug_test = DrugTestResult::find($request->drug_test_id);
        $drug_test->lab_staff_id = Auth::user()->user_id;
        $drug_test->drug_test_result = $request->drug_test_result;
        $drug_test->update();
    }

    public function addfecalysisresult(Request $request)
    {
        $fecalysis = FecalysisResult::find($request->fecalysis_id);
        $fecalysis->lab_staff_id = Auth::user()->user_id;
        $fecalysis->macroscopic = $request->macroscopic;
        $fecalysis->microscopic = $request->microscopic;
        $fecalysis->update();
    }

    public function addurinalysisresult(Request $request)
    {
        $urinalysis = UrinalysisResult::find($request->urinalysis_id);
        $urinalysis->lab_staff_id = Auth::user()->user_id;
        $urinalysis->pus_cells = $request->pus_cells;
        $urinalysis->rbc = $request->rbc;
        $urinalysis->albumin = $request->albumin;
        $urinalysis->sugar = $request->sugar;
        $urinalysis->update();
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
                $distance=$json['rows'][0]['elements'][0]['distance']['value'];
                $town->distance_to_miagao = $distance/1000;$town->save();
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
            $distance=$json['rows'][0]['elements'][0]['distance']['value'];
            $town->distance_to_miagao = $distance/1000;
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
