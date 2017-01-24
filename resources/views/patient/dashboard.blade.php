@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<h1 class="page-header">{{ Auth::user()->patient->patient_first_name }} {{ Auth::user()->patient->patient_last_name }}</h1>
			<div class="row placeholders">
				<div class="col-xs-3 col-sm-3 col-md-3 placeholder">
					<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				</div>
				<div class="col-xs-9 col-sm-9 col-md-9 placeholder">
					Info here
				</div>
			</div>
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
                  <td><a>{{$medical_appointment->schedule_day}}</a></td>
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
                  <td><a>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dental_appointment->schedule_start)->format('M d,Y') }}</a></td>
                  <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dental_appointment->schedule_start)->format('H:i:s') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dental_appointment->schedule_end)->format('H:i:s') }}</td>
                  <td>{{$dental_appointment->staff_first_name}} {{$dental_appointment->staff_last_name}}</td>
                </tr>
              @endforeach
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="prescriptionModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h2>Notes and Prescription from the Doctor</h2>
    </div>
    <div class="modal-body">
      <div class="well" id="remarkModal"></div>
      <div class="acountabilities" id="displayMedicalBillingStatus" style="color:red; font-style:italic; font-size:20px; "></div>
    </div>
    <div class="modal-footer">
      <p id="remarkModalFooter" style="float: right"></p>
    </div>
  </div>
  </div>
</div>


@endsection