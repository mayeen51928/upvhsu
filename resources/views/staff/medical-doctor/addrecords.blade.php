@extends('layouts.layout')
@section('title', 'Add New Record | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
  	@include('layouts.sidebar')
  	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="viewAllMedicalRecordsDiv">
  		<form action="/doctor/addrecord" method="POST">
  			{{csrf_field()}}
        <input type="hidden" name="patient_id" value="{{$patient_info['patient_id']}}"/>
  			<div class="row">
  				<div class="col-md-4 col-md-offset-4" style="text-align: center;">
  					<h4>ADD NEW MEDICAL RECORD</h4>
  				</div>

  			</div>
        @if (session('status'))
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('status') }}
        </div>
        @endif
  			<div class="row">
  				<div class="personal-information">
  					<div class="row">
  						<div class="col-md-6 col-sm-6 col-xs-6">
  							<h4>Name: {{$patient_info['patient_first_name']}} {{$patient_info['patient_last_name']}}</h4>
  						</div>
  					</div>
  				</div>
  				<br/>
  				{{-- PHYSICAL EXAMINATION --}}
  				<div class="physical-examination" id="physicalexamination" style="background-color:#f8f8f8; padding:5px;">
  					<h4>Physical Examination</h4>
  					<div class="row">
  						<div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                	<label for="height">Height:</label>
                  <input type="text" class="form-control" id="height" name="height"/>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="weight">Weight:</label>
                  <input type="text" class="form-control" id="weight" name="weight"/>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="blood-pressure">Blood Pressure:</label>
                  <input type="text" class="form-control" id="bloodpressure" name="bloodpressure"/>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="pulse-rate">Pulse Rate:</label>
                  <input type="text" class="form-control" id="pulserate" name="pulserate"/>
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
                  <input type="text" class="form-control" id="righteye" name="righteye"/>
                </div>
              </div>
              <div class="col-md-5 col-sm-5 col-xs-5">
                <div class="form-group">
                  <label for="left-eye">Left Eye:</label>
                  <input type="text" class="form-control" id="lefteye" name="lefteye"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="head">Head:</label>
                  <input type="text" class="form-control" id="head" name="head"/>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="eent">EENT:</label>
                  <input type="text" class="form-control" id="eent" name="eent"/>
                </div>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="neck">Neck:</label>
                  <input type="text" class="form-control" id="neck" name="neck"/>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="chest">Chest:</label>
                  <input type="text" class="form-control" id="chest" name="chest"/>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="heart">Heart:</label>
                  <input type="text" class="form-control" id="heart" name="heart"/>
                </div>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="lungs">Lungs:</label>
                  <input type="text" class="form-control" id="lungs" name="lungs"/>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="abdomen">Abdomen:</label>
                  <input type="text" class="form-control" id="abdomen"  name="abdomen"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="back">Back:</label>
                  <input type="text" class="form-control" id="back" name="back"/>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="skin">Skin:</label>
                  <input type="text" class="form-control" id="skin" name="skin"/>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="extremities">Extremities:</label>
                  <input type="text" class="form-control" id="extremities" name="extremities"/>
                </div>
              </div>
            </div> 
          </div>
          {{-- LABORATORY RESULT --}}
          {{-- <div class="laboratory-result" id="laboratoryresult1"  style="padding:5px;">
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
                  <input type="text" class="form-control" id="hemoglobin">
                </div>
              </div>
              <div class="col-md-5 col-sm-5 col-xs-5">
                <div class="form-group">
                  <label for="hemasocrit">Hemasocrit:</label>
                  <input type="text" class="form-control" id="hemasocrit">
                </div>
              </div>
              <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-2">
                <div class="form-group">
                  <label for="wbc">WBC:</label>
                  <input type="text" class="form-control" id="wbc">
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
                  <input type="text" class="form-control" id="pus-cells">
                </div>
              </div>
              <div class="col-md-5 col-sm-5 col-xs-5">
                <div class="form-group">
                  <label for="rbc">RBC:</label>
                  <input type="text" class="form-control" id="rbc">
                </div>
              </div>
              <div class="col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 col-xs-5 col-xs-offset-2">
                <div class="form-group">
                  <label for="albumin">Albumin:</label>
                  <input type="text" class="form-control" id="albumin">
                </div>
              </div>
              <div class="col-md-5 col-sm-5 col-xs-5">
                <div class="form-group">
                  <label for="sugar">Sugar:</label>
                  <input type="text" class="form-control" id="sugar">
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
                  <input type="text" class="form-control" id="macroscopic">
                </div>
              </div>
              <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-2">
                <div class="form-group">
                  <label for="microscopic">Microscopic (Parasites):</label>
                  <input type="text" class="form-control" id="microscopic">
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
                  <input type="text" class="form-control" id="drug-test">
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
                  <input type="text" class="form-control" id="chest-xray">
                </div>
              </div>
            </div>
          </div> --}}




          {{-- REMARKS --}}
          {{-- <div class="remarks" id="remarksDiv1" style="background-color:#f8f8f8; padding:5px;">
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
          PRESCRIPTION
          <div class="prescription" id="prescriptionDiv1" style="padding:5px;">
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
          </div> --}}
        </div>
        <br/>
        <span style="float: right"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#proceedToAddNewMedicalRecord">Add Record</button></span>

        <div id="proceedToAddNewMedicalRecord" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	        <div class="modal-dialog">
		        <div class="modal-content">
		        <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Request for Laboratory/X-Ray Examination</h4>
		        </div>
		        <div class="modal-body">
		        	<label>Please check the laboratory request you want to make. If none, just click Add Record:</label>
			        	<div class="row">
			        	<div class="col-md-12 col-md-offset-4 col-sm-12 col-sm-offset-4 col-xs-12 col-xs-offset-4 ">
			        		<div class="form-group" id="requestsFromDoctor">
			        			<div class="checkbox requestCheckbox">
			        				<label><input type="checkbox" id="requestCBC" name="requestCBC">CBC</label>
		                </div>
		                <div class="checkbox requestCheckbox">
		                	<label><input type="checkbox" id="requestUrinalysis" name="requestUrinalysis">Urinalysis</label>
		                </div>
		                <div class="checkbox requestCheckbox">
		                	<label><input type="checkbox" id="requestFecalysis" name="requestFecalysis">Fecalysis</label>
		                </div>
		                <div class="checkbox requestCheckbox">
		                	<label><input type="checkbox" id="requestDrugTest" name="requestDrugTest">Drug Test</label>
		                </div>
		                <div class="checkbox requestCheckbox">
		                	<label><input type="checkbox" id="requestXray" name="requestXray">X-Ray</label>
	                	</div>
	                </div>
	              </div>
	            </div>
	          </div>
		        <div class="modal-footer">
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
			        <input type="submit" class="btn btn-success" value="Add Record" name="addnewrecordsubmit" id="addnewrecordsubmit"/>
			       </div>
		        </div>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection