@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<h1 class="page-header">{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</h1>
			<div class="row placeholders">
				<div class="col-xs-3 col-sm-3 col-md-3 placeholder">
					<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				</div>
				<div class="col-xs-9 col-sm-9 col-md-9 placeholder">
					Info here
				</div>
			</div>
			<h2 class="sub-header">Appointments</h2>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Time</th>
							<th>Reasons</th>
						</tr>
					</thead>
					<tbody>
            @foreach ($dental_appointments_fin as $dental_appointment_fin)
						<tr>
							<td>{{ $dental_appointment_fin->patient_first_name }} {{ $dental_appointment_fin->patient_last_name }}</td>
							<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dental_appointment_fin->schedule_start)->format('H:i:s') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dental_appointment_fin->schedule_end)->format('H:i:s') }}</td>
							<td>{{ $dental_appointment_fin->reasons }}</td>
							<td><form action="/dentist/updatedentalrecord" method="POST">{{ csrf_field() }}<input type="hidden" value="{{ $dental_appointment_fin->id }}" name="addDentalRecord"><input type="submit" class="btn btn-primary btn-xs addDentalRecordButton" id="{{ $dental_appointment_fin->id }}" value="Update Diagnosis"></form></td>
						</tr>
            @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="create-dental-record-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="width:900px; ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Patient Record</h4>
        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" id="changeProgress_DentalDiagnosis" style="width:50%">1 of 2</div>
        </div>
      </div>
      <div class="modal-body">
        <!-- PERSONAL INFORMATION -->
        <div class="personal-information">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Name</h4>
              <div class="personal-information-name"></div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Time</h4>
              <div class="personal-information-time"></div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Reasons</h4>
              <div class="personal-information-reasons"></div>
            </div>
          </div>
        </div>
        <div>
          <img src="images/number_chart.jpg" class="img-responsive" width="867" height="522" alt="Generic placeholder thumbnail" usemap="#planetmap" style="margin-top: 30px;">
          <map name="planetmap">
            <area shape="rect" coords="226, 22, 272, 101" class="dental-chart" id="55">
            <area shape="rect" coords="283, 26, 317, 96" class="dental-chart" id="54">
            <area shape="rect" coords="337, 20, 355, 91" class="dental-chart" id="53">
          </map>
        </div>
      </div>
      <div class="modal-footer">
       <span style="float: left; margin-right: 4px"><button type="button" class="btn btn-info" id="backButtonMedicalDiagnosis">Back</button></span>
        <span style="float: left"><button type="button" class="btn btn-info" id="nextButtonMedicalDiagnosis">Next</button></span>
        <span class="dental-button-container"></span>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="create-dental-record-per-tooth-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="width:900px; ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="add-dental-record">
          <select class="form-control condition">
            <option value="condition" disabled selected>--options--</option>
            <option value="1">Caries free</option>
            <option value="2">Caries for filting</option>
            <option value="3">Caries for extraction</option>
            <option value="4">Root fragment</option>
            <option value="5">Missing due to carries</option>
          </select>
          <select class="form-control operation">
            <option value="operation" disabled selected>--options--</option>
            <option value="1">Amalgam filling</option>
            <option value="2">Silicate filling</option>
            <option value="3">Extraction due to caries</option>
            <option value="4">Extraction due to other causes</option>
            <option value="5">Cement filling</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="updateDentalRecord">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var addDentalRecord = '/addrecord_dental';
</script>

@endsection