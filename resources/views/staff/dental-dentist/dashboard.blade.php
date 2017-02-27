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
      <ul class="nav nav-pills nav-justified">
        <li class="active"><a data-toggle="pill" href="#todayappointment">Today</a></li>
        <li><a data-toggle="pill" href="#futureappointment">Future</a></li>
      </ul>
			<div class="tab-content">
        <div class="table-responsive tab-pane fade in active" id="todayappointment">
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
								<td><form action="/dentist/updatedentalrecord" method="POST">{{ csrf_field() }}<input type="hidden" value="{{ $dental_appointment_fin->id }}" name="addDentalRecord"><input type="hidden" value="{{ $dental_appointment_fin->patient_id }}" name="addDentalRecord2"><input type="submit" class="btn btn-primary btn-xs addDentalRecordButton" id="{{ $dental_appointment_fin->id }}" value="Update Diagnosis"></form></td>
							</tr>
	            		@endforeach
						</tbody>
					</table>
				</div>
				<div class="table-responsive tab-pane fade" id="futureappointment">
					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
</script>

@endsection