@extends('layouts.layout')
@section('title', 'Manage Schedule | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Manage your schedule</div>
				<div class="panel-body" id="manageschedulepanel">
				<p>Note: The schedules displayed for the patients are 7 days from today.</p>
				{{-- <form class="form-inline"> --}}
					<div class="medical_manage">
					<button type="button" class="btn btn-success btn-xs addmoremedicalsched">Add more</button>
					<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Date</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr class="schedule_tr">
								<td><input class="form-control" type="date" value="{{ Carbon\Carbon::tomorrow()->format('Y-m-d')}}"/></td>
								<td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td>
							</tr>
							<tr class="schedule_tr">
								<td><input class="form-control" type="date" value="{{ Carbon\Carbon::tomorrow()->addDays(1)->format('Y-m-d')}}"/></td>
								<td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td>
							</tr>
							<tr class="schedule_tr">
								<td><input class="form-control" type="date" value="{{ Carbon\Carbon::tomorrow()->addDays(2)->format('Y-m-d')}}"/></td>
								<td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td>
							</tr>
							<tr class="schedule_tr">
								<td><input class="form-control" type="date" value="{{ Carbon\Carbon::tomorrow()->addDays(3)->format('Y-m-d')}}"/></td>
								<td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td>
							</tr>
							<tr class="schedule_tr">
								<td><input class="form-control" type="date" value="{{ Carbon\Carbon::tomorrow()->addDays(4)->format('Y-m-d')}}"/></td>
								<td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td>
							</tr>
							<tr class="schedule_tr">
								<td><input class="form-control" type="date" value="{{ Carbon\Carbon::tomorrow()->addDays(5)->format('Y-m-d')}}"/></td>
								<td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td>
							</tr>
							<tr class="schedule_tr">
								<td><input class="form-control" type="date" value="{{ Carbon\Carbon::tomorrow()->addDays(6)->format('Y-m-d')}}"/></td>
								<td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td>
							</tr>
						</tbody>
					</table>
					</div>
					</div>
				{{-- </form> --}}
				</div>
				<div class="panel-footer">
				<div class="clearfix">
				<button class="btn btn-success pull-right" id="addmedicalschedule">Add Schedule</button>
				</div>
				</div>
			</div>	
		</div>
		</div>
	</div>
</div>
@endsection