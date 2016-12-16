@extends('layouts.layout')
@section('title', 'Manage Schedule | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Manage your schedule</div>
				<div class="panel-body" id="manageschedulepanel">
				<p>Note: The schedules displayed for the patients are 7 days from today.</p>
				{{-- <form class="form-inline"> --}}
					<div class="dental_manage">
					<button type="button" class="btn btn-success btn-xs addmoredentalsched">Add more</button>
					<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Date</th>
								<th>Start Hour</th>
								<th>End Hour</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr class="schedule_tr">
								<td><input class="form-control" type="date" value="{{ Carbon\Carbon::tomorrow()->format('Y-m-d')}}"/></td>
								<td><input type="time" class="form-control starthour"/></td>
								<td><input type="time" class="form-control endhour"/></td>
								<td><button class="btn btn-danger btn-sm removedentalsched">Remove</button></td>
							</tr>
						</tbody>
					</table>
					</div>
					</div>
				{{-- </form> --}}
				</div>
				<div class="panel-footer">
				<div class="clearfix">
				<button class="btn btn-success pull-right" id="adddentalschedule">Add Schedule</button>
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
  var addDentalSchedule = '/addschedule_dental';
</script>
@endsection