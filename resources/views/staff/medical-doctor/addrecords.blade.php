@extends('layouts.layout')
@section('title', 'Add New Record | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
  	@include('layouts.sidebar')
  	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="viewAllMedicalRecordsDiv">
      @if($has_existing_appointment==0)
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
  				<div class="physical-examination" id="physicalexamination">
  					<div class="panel-group" id="medicalaccordion">
  						<div class="panel panel-default">
  							<div class="panel-heading">
  								<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#medicalbillingaccordion"><span class="glyphicon glyphicon-chevron-down"></span> Tests Conducted</a></h4>
  							</div>
  							<div id="medicalbillingaccordion" class="panel-collapse collapse in">
  								<div class="panel-body">
  									<div class="row">
		                  <div id="patient_type_radio_medical" class="radio" style="margin-left:20px;display:none;">
                        <label><input type="radio" name="patient_type_radio" id="medical_radio_button_billing_opd" value="5" checked="checked">OPD</label>&nbsp;&nbsp;&nbsp;
                        <label><input type="radio" name="patient_type_radio" id="medical_radio_button_billing_senior" value="6">Senior Citizen</label>
                        <input type="text" placeholder="Senior Citizen ID" class="form-control" id="senior_id" class="senior_id" style="width:50%;display:inline-block;margin-left:10px;">
                      </div> 
		              		<div class="table-responsive col-md-6">
		                    <table class="table table-hover">
		                    @for ($i = 0; $i < ceil(count($medical_billing_services)/2); $i++)
												  <tr><td><input type='checkbox' name="medical_services_id[]" class='checkboxMedicalService' value='{{$medical_billing_services[$i]->id}}' id='{{$medical_billing_services[$i]->id}}'></td><td>{{$medical_billing_services[$i]->service_description}}</td></tr>
												@endfor
		                    </table>
		                  </div>
		                  <div class="table-responsive col-md-6">
		                    <table class="table table-hover">
		                    @for ($i = floor(count($medical_billing_services)/2)+1; $i < count($medical_billing_services); $i++)
												  <tr><td><input type='checkbox' name="medical_services_id[]" class='checkboxMedicalService' value='{{$medical_billing_services[$i]->id}}' id='{{$medical_billing_services[$i]->id}}'></td><td>{{$medical_billing_services[$i]->service_description}}</td></tr>
												@endfor
		                    </table>
		                  </div>
		              	</div>
                	</div>
                </div>
                <div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#physicalexamaccordion"><span class="glyphicon glyphicon-chevron-right"></span> Physical Exam</a>
								</h4>
							</div>
					<div id="physicalexamaccordion" class="panel-collapse collapse">
						<div class="panel-body" style="background-color:#f8f8f8; padding:5px;">
						<h4>Physical Examination</h4>
  					<div class="row">
  						<div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                	<label for="height">Height:</label>
                  <input type="text" class="form-control" disabled required id="height" name="height"/>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="weight">Weight:</label>
                  <input type="text" class="form-control" disabled required id="weight" name="weight"/>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="blood-pressure">Blood Pressure:</label>
                  <input type="text" class="form-control" disabled required id="bloodpressure" name="bloodpressure"/>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="pulse-rate">Pulse Rate:</label>
                  <input type="text" class="form-control" disabled required id="pulserate" name="pulserate"/>
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
                  <input type="text" class="form-control" disabled required id="righteye" name="righteye"/>
                </div>
              </div>
              <div class="col-md-5 col-sm-5 col-xs-5">
                <div class="form-group">
                  <label for="left-eye">Left Eye:</label>
                  <input type="text" class="form-control" disabled required id="lefteye" name="lefteye"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="head">Head:</label>
                  <input type="text" class="form-control" disabled required id="head" name="head"/>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="eent">EENT:</label>
                  <input type="text" class="form-control" disabled required id="eent" name="eent"/>
                </div>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="neck">Neck:</label>
                  <input type="text" class="form-control" disabled required id="neck" name="neck"/>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="chest">Chest:</label>
                  <input type="text" class="form-control" disabled required id="chest" name="chest"/>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="heart">Heart:</label>
                  <input type="text" class="form-control" disabled required id="heart" name="heart"/>
                </div>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="lungs">Lungs:</label>
                  <input type="text" class="form-control" disabled required id="lungs" name="lungs"/>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="abdomen">Abdomen:</label>
                  <input type="text" class="form-control" disabled required id="abdomen"  name="abdomen"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="back">Back:</label>
                  <input type="text" class="form-control" disabled required id="back" name="back"/>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="skin">Skin:</label>
                  <input type="text" class="form-control" disabled required id="skin" name="skin"/>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="form-group">
                  <label for="extremities">Extremities:</label>
                  <input type="text" class="form-control" disabled required id="extremities" name="extremities"/>
                </div>
              </div>
            </div> 
						</div></div>
						</div>
  					
          </div>
        </div>
        <br/>
        <span  id="addNewMedicalRecordWConfirmRequests" style="float: right; display: none;"><button type="button" class="btn btn-success" data-toggle="modal"data-target="#proceedToAddNewMedicalRecord">Add Record</button></span>

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
      @elseif($has_existing_appointment==2)
      <p>Not allowed! You have no schedule for today.</p>
      @else
      <p>This patient has an appointment with you today.</p>
      @endif
    </div>
  </div>
</div>
@endsection