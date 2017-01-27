<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Patient;
use App\MedicalSchedule;
use App\MedicalAppointment;
use App\Staff;
use App\Town;
use App\Province;
use App\PhysicalExamination;
use App\CbcResult;
use App\ChestXrayResult;
use App\DrugTestResult;
use App\Prescription;
use App\Remark;
use App\UrinalysisResult;
use App\FecalysisResult;

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
        $params['medical_appointments'] = DB::table('medical_schedules')->join('medical_appointments', 'medical_appointments.medical_schedule_id', 'medical_schedules.id')->join('patient_info', 'medical_appointments.patient_id', 'patient_info.patient_id')->where('status', '0')->where('medical_schedules.staff_id', '=', Auth::user()->user_id)->get();
        // dd($params['medical_appointments']);
        $params['navbar_active'] = 'account';
        $params['sidebar_active'] = 'dashboard';
        return view('staff.medical-doctor.dashboard', $params);
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
        $doctor = Staff::find(Auth::user()->user_id);
        $doctor->sex = $request->input('sex');
        $doctor->birthday = $request->input('birthday');
        $doctor->street = $request->input('street');
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
                $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
                $json = json_decode(file_get_contents($url), true);
                $distance=$json['rows'][0]['elements'][0]['distance']['value'];
                $town->distance_to_miagao = $distance/1000;
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
            $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='. $location . '&destinations=UPV+Infirmary&key=AIzaSyAa72KwU64zzaPldwLWFMpTeVLsxw2oWpc';
            $json = json_decode(file_get_contents($url), true);
            $distance=$json['rows'][0]['elements'][0]['distance']['value'];
            $town->distance_to_miagao = $distance/1000;
            $town->save();
            $doctor->town_id = Town::where('town_name', $request->input('town'))->where('province_id', Province::where('province_name', $request->input('province'))->first()->id)->first()->id;
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
            $checker_if_exists = MedicalSchedule::where('staff_id', Auth::user()->user_id)->where('schedule_day', $schedules[$i])->first();
            if(count($checker_if_exists) == 0){
                $schedule = new MedicalSchedule();
                $schedule->staff_id = Auth::user()->user_id;
                $schedule->schedule_day = $schedules[$i];
                $schedule->save();
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
}
