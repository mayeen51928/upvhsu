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
			<div class="row">
				<div class="col-md-6">
					<div class="tile-stats">
						<div id="dentistcontainer" style="min-width: 310px; height: 350px; max-width: 600px; margin: 0 auto"></div>
						<input type="hidden" id="dentistdashboard" value="1"/>
					</div>
				</div>
					<div class="col-md-6">
						<div class="panel panel-default" id="stickynotespanel">
							<div class="panel-heading">Side Notes</div>
							<div class="panel-body"><textarea id="staffnotesdentist" placeholder="Enter your notes here..." class="form-control" rows="11">{{$staff_notes}}</textarea></div>
							<div class="panel-footer" id="savingstatus">&nbsp;</div>
						</div>
				</div>
			</div>
			<h3 class="sub-header">Appointments</h3>
			<ul class="nav nav-tabs nav-justified">
				<li class="active"><a data-toggle="tab" href="#todayappointment">Today</a></li>
				<li><a data-toggle="tab" href="#futureappointment">Future</a></li>
			</ul>
			<div class="tab-content">
				<div class="table-responsive tab-pane fade in active" id="todayappointment">
					@if(count($dental_appointments_today) > 0)
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Scheduled Time</th>
								<th>Reasons</th>
							</tr>
						</thead>
						<tbody>
								@foreach ($dental_appointments_today as $dental_appointment_today)
							<tr>

								<td>{{ $dental_appointment_today->patient_first_name }} {{ $dental_appointment_today->patient_last_name }}</td>
								<td>{{date_format(date_create($dental_appointment_today->schedule_start), 'F j, Y')}} {{date_format(date_create($dental_appointment_today->schedule_start), 'h:i A')}} - {{date_format(date_create($dental_appointment_today->schedule_end), 'h:i A')}}</td>
								<td>{{ $dental_appointment_today->reasons }}</td>
								<td><a href="/dentist/updatedentalrecord/{{ $dental_appointment_today->id }}" class="btn btn-info btn-xs addDentalRecordButton" role="button">Details</a></td>
								{{-- <td><button class="btn btn-primary btn-xs addBillingToDental" id="addBillingToDental_{{$dental_appointment_today->id}}">Billing</button></td> --}}
							</tr>
							@endforeach
						</tbody>
					</table>
					 @else
					<p>There are no online appointments as of the moment.</p>
				@endif
				<div class="text-center">{{ $dental_appointments_today->links() }} </div>
				</div>
				<div class="table-responsive tab-pane fade" id="futureappointment">
				@if(count($dental_appointments_future) > 0)
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Scheduled Date</th>
								<th>Reasons</th>
							</tr>
						</thead>
						<tbody>
								@foreach ($dental_appointments_future as $dental_appointment_future)
							<tr>
								<td>{{ $dental_appointment_future->patient_first_name }} {{ $dental_appointment_future->patient_last_name }}</td>
								<td>{{date_format(date_create($dental_appointment_future->schedule_start), 'F j, Y')}} {{date_format(date_create($dental_appointment_future->schedule_start), 'h:i A')}} - {{date_format(date_create($dental_appointment_future->schedule_end), 'h:i A')}}</td>
								<td>{{ $dental_appointment_future->reasons }}</td>
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

<div id="dentalBillingModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="patient_name"></div>
			</div>
			<div class="modal-body">
				<div class="dental_senior_checker_medical" style="display:none;">
					<div class="radio">
						<label><input type="radio" name="dental_radio_button_medical" id="dental_radio_button_billing_opd" value="5" checked="checked">OPD</label>&nbsp;&nbsp;&nbsp;
						<label><input type="radio" name="dental_radio_button_medical" id="dental_radio_button_billing_senior" value="6">Senior Citizen</label>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-hover displayServices"></table>
				</div>
				<div class="dental-bill-input" id="dental-bill-input-text"></div> 
			</div>
			<div class="modal-footer">
				<div class="dental-bill-confirm" id="dental-bill-confirm-button" style="text-align:center; "></div>
			</div>
		</div>
	</div>
</div>
@endsection