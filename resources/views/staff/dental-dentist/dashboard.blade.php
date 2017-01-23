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

<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
</script>

@endsection