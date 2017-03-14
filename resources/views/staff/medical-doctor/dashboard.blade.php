@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<h4 class="page-header">@if(!is_null(Auth::user()->staff->picture))
      <img src="{{asset('images/'.Auth::user()->staff->picture)}}" height="50" width="50" class="img-circle"/> 
      @else
      <img src="{{asset('images/blankprofpic.png')}}" height="50" width="50" class="img-circle"/> 
      @endif
      Welcome <i>{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</i>!</h4>
      <h3 class="sub-header">Appointments</h3>
      <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#pastappointment">Past</a></li>
        <li class="active"><a data-toggle="tab" href="#todayappointment">Today</a></li>
        <li><a data-toggle="tab" href="#futureappointment">Future</a></li>
      </ul>
      <div class="tab-content">
        <div class="table-responsive tab-pane fade in active" id="todayappointment">
        @if(count($medical_appointments_today) > 0)
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Reasons</th>
              </tr>
            </thead>
            <tbody>
              @foreach($medical_appointments_today as $medical_appointment_today)
            	<tr>
                <td>{{$medical_appointment_today->patient_first_name}} {{$medical_appointment_today->patient_last_name}}</td>
                <td>{{$medical_appointment_today->reasons}}</td>
                <td><button class="btn btn-info btn-xs addMedicalRecordButton" id="addMedicalRecordButton_{{$medical_appointment_today->id}}">Diagnosis</button></td>
                <td><button class="btn btn-primary btn-xs addBillingToMedical" id="addBillingToMedical_{{$medical_appointment_today->id}}">Billing</button></td>
              </tr>
              @endforeach
            </tbody>
          </table>
           @else
          <p>There are no online appointments as of the moment.</p>
        @endif
        </div>
        <div class="table-responsive tab-pane fade" id="pastappointment">
        @if(count($medical_appointments_past) > 0)
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Scheduled Date</th>
                <th>Reasons</th>
              </tr>
            </thead>
            <tbody>
              @foreach($medical_appointments_past as $medical_appointment_past)
              <tr>
                <td>{{$medical_appointment_past->patient_first_name}} {{$medical_appointment_past->patient_last_name}}</td>
                <td>{{date_format(date_create($medical_appointment_past->schedule_day), 'F j, Y')}}</td>
                <td>{{$medical_appointment_past->reasons}}</td>
                <td><button class="btn btn-info btn-xs addMedicalRecordButton" id="addMedicalRecordButton_{{$medical_appointment_past->id}}">Diagnosis</button></td>
                <td><button class="btn btn-primary btn-xs addBillingToMedical" id="addBillingToMedical_{{$medical_appointment_past->id}}">Billing</button></td>
              </tr>
              @endforeach
            </tbody>
          </table>
           @else
          <p>There are no online appointments as of the moment.</p>
        @endif
        </div>
        <div class="table-responsive tab-pane fade" id="futureappointment">
        @if(count($medical_appointments_future) > 0)
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Scheduled Date</th>
                <th>Reasons</th>
              </tr>
            </thead>
            <tbody>
              @foreach($medical_appointments_future as $medical_appointment_future)
              <tr>
                <td>{{$medical_appointment_future->patient_first_name}} {{$medical_appointment_future->patient_last_name}}</td>
                <td>{{date_format(date_create($medical_appointment_future->schedule_day), 'F j, Y')}}</td>
                <td>{{$medical_appointment_future->reasons}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
           @else
          <p>There are no online appointments as of the moment.</p>
        @endif
        </div>
      </div>
		</div>
	</div>
</div>
<div class="modal fade" id="create-medical-record-modal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="xButtonMedicalDiagnosis" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Patient Record</h4>
        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" id="changeProgress_MedicalDiagnosis" style="width:20%">1 of 5</div>
        </div>
      </div>
      <div class="modal-body">
        {{-- PERSONAL INFORMATION --}}
        <div class="personal-information">
          <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12">
              <h4>Name</h4>
              <div class="personal-information-name"></div>
            </div>
            <div class="col-md-9 col-sm-12 col-xs-12">
              <h4>Reasons</h4>
              <div class="personal-information-reasons"></div>
            </div>
          </div>
        </div>
        {{-- PHYSICAL EXAMINATION --}}
        <div class="physical-examination" id="physicalexamination" style="background-color:#f8f8f8; padding:5px;">
          <h4>Physical Examination</h4>
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="height">Height:</label>
                <input type="text" class="form-control" id="height" autofocus/>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" class="form-control" id="weight">
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="blood-pressure">Blood Pressure:</label>
                <input type="text" class="form-control" id="blood-pressure">
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="pulse-rate">Pulse Rate:</label>
                <input type="text" class="form-control" id="pulse-rate">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="form-group">
                <label style="margin-top:10px; text-align:center">Vision Test</label>
              </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
              <div class="form-group">
                <label for="right-eye">Right Eye:</label>
                <input type="text" class="form-control" id="right-eye">
              </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
              <div class="form-group">
                <label for="left-eye">Left Eye:</label>
                <input type="text" class="form-control" id="left-eye">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="head">Head:</label>
                <input type="text" class="form-control" id="head">
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="eent">EENT:</label>
                <input type="text" class="form-control" id="eent">
              </div>
            </div>
          </div> 
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4">
              <div class="form-group">
                <label for="neck">Neck:</label>
                <input type="text" class="form-control" id="neck">
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <div class="form-group">
                <label for="chest">Chest:</label>
                <input type="text" class="form-control" id="chest">
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <div class="form-group">
                <label for="heart">Heart:</label>
                <input type="text" class="form-control" id="heart">
              </div>
            </div>
          </div> 
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="lungs">Lungs:</label>
                <input type="text" class="form-control" id="lungs">
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <label for="abdomen">Abdomen:</label>
                <input type="text" class="form-control" id="abdomen">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4">
              <div class="form-group">
                <label for="back">Back:</label>
                <input type="text" class="form-control" id="back">
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <div class="form-group">
                <label for="skin">Skin:</label>
                <input type="text" class="form-control" id="skin">
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <div class="form-group">
                <label for="extremities">Extremities:</label>
                <input type="text" class="form-control" id="extremities">
              </div>
            </div>
          </div> 
        </div>
        {{-- LABORATORY RESULT --}}
        <div class="laboratory-result" id="laboratoryresult"  style="padding:5px;">
          <h4>Laboratory Result</h4>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="form-group">
                <label>CBC:</label>
              </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
              <div class="form-group">
                <label for="hemoglobin">Hemoglobin:</label>
                <input type="text" class="form-control" id="hemoglobin" disabled="disabled"/>
              </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
              <div class="form-group">
                <label for="hemasocrit">Hemasocrit:</label>
                <input type="text" class="form-control" id="hemasocrit" disabled>
              </div>
            </div>
            <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-2">
              <div class="form-group">
                <label for="wbc">WBC:</label>
                <input type="text" class="form-control" id="wbc" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="form-group">
                <label>Urinalysis:</label>
              </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
              <div class="form-group">
                <label for="pus-cells">Pus Cells:</label>
                <input type="text" class="form-control" id="pus-cells" disabled>
              </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
              <div class="form-group">
                <label for="rbc">RBC:</label>
                <input type="text" class="form-control" id="rbc" disabled>
              </div>
            </div>
            <div class="col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 col-xs-5 col-xs-offset-2">
              <div class="form-group">
                <label for="albumin">Albumin:</label>
                <input type="text" class="form-control" id="albumin" disabled>
              </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
              <div class="form-group">
                <label for="sugar">Sugar:</label>
                <input type="text" class="form-control" id="sugar" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="form-group">
                <label>Fecalysis:</label>
              </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="form-group">
                <label for="macroscopic">Macroscopic:</label>
                <input type="text" class="form-control" id="macroscopic" disabled>
              </div>
            </div>
            <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-2">
              <div class="form-group">
                <label for="microscopic">Microscopic (Parasites):</label>
                <input type="text" class="form-control" id="microscopic" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="form-group">
                <label>Drug Test:</label>
              </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="form-group">
                <input type="text" class="form-control" id="drug-test" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="form-group">
                <label>Chest X-Ray:</label>
              </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="form-group">
                <input type="text" class="form-control" id="chest-xray" disabled>
              </div>
            </div>
          </div>
        </div>
        {{-- REMARKS --}}
        <div class="remarks" id="remarksDiv" style="background-color:#f8f8f8; padding:5px;">
          <h4>Remarks</h4>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="form-group">
                <label>Remarks:</label>
              </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="form-group">
                <textarea class="form-control" rows="10" id="remarks"></textarea>
              </div>
            </div>
          </div>
        </div>
        {{-- PRESCRIPTION --}}
        <div class="prescription" id="prescriptionDiv" style="padding:5px;">
          <h4>Prescription</h4>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2">
              <div class="form-group">
                <label>Prescription:</label>
              </div>
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="form-group">
                <textarea class="form-control" rows="10" id="prescription"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="requestLabXray" id="requestLabXrayDiv" style="padding:5px;">
          <h4>Request for Laboratory Examination and/or X-Ray</h4>
          <label>Please check the laboratory request you want to make:</label>
          <div class="row">
            <div class="col-md-12 col-md-offset-5 col-sm-12 col-sm-offset-4 col-xs-12 col-xs-offset-4 ">
              <div class="form-group" id="requestsFromDoctor">
                <div class="checkbox requestCheckbox">
                  <label><input type="checkbox" id="requestCBC">CBC</label>
                </div>
                <div class="checkbox requestCheckbox">
                  <label><input type="checkbox" id="requestUrinalysis">Urinalysis</label>
                </div>
                <div class="checkbox requestCheckbox">
                  <label><input type="checkbox" id="requestFecalysis">Fecalysis</label>
                </div>
                <div class="checkbox requestCheckbox">
                  <label><input type="checkbox" id="requestDrugTest">Drug Test</label>
                </div>
                <div class="checkbox requestCheckbox">
                  <label><input type="checkbox" id="requestXray">X-Ray</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <span style="float: left; margin-right: 4px"><button type="button" class="btn btn-info" id="backButtonMedicalDiagnosis">Back</button></span>
        <span style="float: left"><button type="button" class="btn btn-info" id="nextButtonMedicalDiagnosis">Next</button></span>
        <span class="medical-button-container"></span>
        <button type="button" id="closeButtonMedicalDiagnosis" class="btn btn-danger">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="medicalBillingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="patient_name"></div>
      </div>
      <div class="modal-body">
        <div class="medical_senior_checker_medical" style="display:none;">
          <div class="radio">
            <label><input type="radio" name="medical_radio_button_medical" id="medical_radio_button_medical_billing_opd" value="5" checked="checked">OPD</label>&nbsp;&nbsp;&nbsp;
            <label><input type="radio" name="medical_radio_button_medical" id="medical_radio_button_medical_billing_senior" value="6">Senior Citizen</label>
          </div>
        </div>
        <table class="table table-bordered displayServices"></table>
        <div class="medical-bill-input" id="medical-bill-input-text"></div> 
      </div>
      <div class="modal-footer">
        <div class="medical-bill-confirm" id="medical-bill-confirm-button" style="text-align:center; "></div>
      </div>
    </div>
  </div>
</div>


<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var addBillingMedical = '/add_billing_medical';
  var confirmBillingMedical = '/confirm_billing_medical';
</script>
@endsection