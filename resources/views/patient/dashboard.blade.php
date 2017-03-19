@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<h4 class="page-header">
			@if(!is_null(Auth::user()->patient->picture))
			<img src="{{asset('images/'.Auth::user()->patient->picture)}}" height="50" width="50" class="img-circle"/> 
			@else
			<img src="{{asset('images/blankprofpic.png')}}" height="50" width="50" class="img-circle"/> 
			@endif
			Welcome <i>{{ Auth::user()->patient->patient_first_name }} {{ Auth::user()->patient->patient_last_name }}</i>!</h4>
			{{-- <div class="row placeholders">
			</div> --}}
			<div class="col-md-6">
				<h3 class="sub-header h3Title">Medical Appointments</h3>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Date</th>
								<th>Doctor</th>
							</tr>
            </thead>
						<tbody>
							@foreach($medical_appointments as $medical_appointment)
							<tr>
								<td><a class="medical_appointments_prescription" id="medicalappointmentid_{{$medical_appointment->id}}">{{date_format(date_create($medical_appointment->schedule_day), 'F j, Y')}}</a></td>
								<td>{{$medical_appointment->staff_first_name}} {{$medical_appointment->staff_last_name}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6">
				<h3 class="sub-header h3Title">Dental Appointments</h3>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Date</th>
								<th>Time</th>
								<th>Dentist</th>
							</tr>
						</thead>
						<tbody>
							@foreach($dental_appointments as $dental_appointment)
							<tr>
								<td><a class="dental_appointments_prescription" id="dentalappointmentid_{{ $dental_appointment->patient_id }}_{{ $dental_appointment->id }}">{{date_format(date_create($dental_appointment->schedule_start), 'F j, Y')}}</a></td>
								<td>{{date_format(date_create($dental_appointment->schedule_start), 'h:i A')}} - {{date_format(date_create($dental_appointment->schedule_end), 'h:i A')}}</td>
								<td>{{$dental_appointment->staff_first_name}} {{$dental_appointment->staff_last_name}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div  class="modal fade" id="prescriptionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h2>Notes and Prescription from the Doctor</h2>
    </div>
    <div class="modal-body">
    	<ul class="nav nav-pills nav-justified">
        <li class="active"><a data-toggle="pill" href="#medicalPrescription">Prescription</a></li>
        <li><a data-toggle="pill" href="#medical_billing_dashboard">Medical Billing Record</a></li>
      </ul>
      <br/>
	      <div class="tab-content">
	      	<div class="table-responsive tab-pane fade in active" id="medicalPrescription">
	      		<div class="well" id="remarkModal"></div>
	      		<p id="remarkModalFooter" style="float: right"></p>
	      	</div>
	      	<div class="table-responsive tab-pane" id="medical_billing_dashboard">
	      		<div class="panel-group">
					    <div class="panel panel-success">
					      <div class="panel-heading">
					      	<h5 class="text-center">Medical Billing Record</h5>
					      </div>
					      <div class="panel-body">
					      	<table class="table" id="medical_billing_record_dashboard_table"  style="display: none">
								    <tbody id="medical_billing_record_dashboard">    
								    </tbody>
								  </table>
								  <div class="row">
								  	<div class="col-md-6 col-md-offset-6">
								  		<label>Total</label>
								  		<input type="text" id="total_medical_billing" class="form-control" disabled>
								  	</div>
								  </div>
					      </div>
					      <div class="panel-footer" id="print_medical_receipt">
					      </div>
					    </div>
					  </div>
	      	</div>
	      </div>
    </div>
  </div>
  </div>
</div>


<div class="modal fade" id="view-dental-record-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="width:900px; ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Patient Record</h4>
      </div>
      <div class="modal-body">
      	<ul class="nav nav-pills nav-justified">
	        <li class="active"><a data-toggle="pill" href="#dental_chart_dashboard">Dental Chart</a></li>
	        <li><a data-toggle="pill" href="#additional_dental_record_dashboard">Additional Dental Record</a></li>
	        <li><a data-toggle="pill" href="#dental_billing_dashboard">Dental Billing Record</a></li>
	      </ul>
	      <br/>
	      <div class="tab-content">
      		<div class="table-responsive tab-pane fade in active" id="dental_chart_dashboard">
      			<div id="view-dental-record-modal-body">
      			</div>
      			<div class="row">
      			</div>
      		</div>

      		<div class="table-responsive tab-pane" id="additional_dental_record_dashboard">
      			<div class="panel-group">
      				<div class="panel panel-success">
        				<div class="panel-heading">
        					<h5 class="text-center">Additional Dental Record</h5>
        				</div>
			  				<div class="panel-body" id="additionalDentalRecordPanelBody" style="background-color:#d6e9c6; ">
			  					<div class="row" style="background-color:#f8f8f8; padding:5px">
			  						<div class="col-md-7 col-sm-7 col-xs-12">
			  							<h4>Presence of dental caries</h4>
			  						</div>
			  						<div class="col-md-5 col-sm-5 col-xs-12">
			  							<select class="form-control" id="selDentalCaries" disabled>
			  							</select>
			  						</div>
			  					</div>
			  					<div class="row" style="padding:5px">
			  						<div class="col-md-7 col-sm-7 col-xs-12">
			  							<h4>Presence of gingivitis</h4>
			  						</div>
			  						<div class="col-md-5 col-sm-5 col-xs-12">
			  							<select class="form-control" id="selGingivitis" disabled>
			  							</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of peridontal pocket</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selPeridontalPocket" disabled>
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of oral debris</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selOralDebris" disabled>
											</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of calculus</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selCalculus" disabled>
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of neoplasm</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selNeoplasm" disabled>
											</select>
										</div>
									</div>
									<div class="row" style="background-color:#f8f8f8; padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Presence of dental-facio anomaly</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<select class="form-control" id="selDentalFacioAnomaly" disabled>
											</select>
										</div>
									</div>
									<div class="row" style="padding:5px">
										<div class="col-md-7 col-sm-7 col-xs-12">
											<h4>Number of teeth present</h4>
										</div>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<input type="text" class="form-control" id="teethPresent" disabled>
										</div>
									</div>
								</div>
						  </div>
      			</div>
      		</div>

      		<div class="table-responsive tab-pane fade in active" id="dental_billing_dashboard">
      			<div class="panel-group">
					    <div class="panel panel-success">
					      <div class="panel-heading">
					      	<h5 class="text-center">Dental Billing Record</h5>
					      </div>
					      <div class="panel-body">
					      	<table class="table" id="dental_billing_record_dashboard">
								    <thead>
								      <tr>
								        <th>Date</th>
								        <th>Doctor</th>
								        <th>Status</th>
								        <th>Print Receipt</th>
								      </tr>
								    </thead>
								    <tbody>    
								    </tbody>
								  </table>
					      </div>
					    </div>
					  </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>
<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var viewDentalRecordDashboard = '/view_dental_record_dashboard';
  var printMedicalReceipt = '/print_medical_receipt';
</script>

@endsection