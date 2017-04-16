
						
						@extends('layouts.layout')
@section('title', 'Generate PE Schedule | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="adminDashboard">
			<div class="col-md-9 col-md-offset-1">
				<div id="printReport">
					<p class="text-center"><img src="{{asset('images/upvweb_logo.png')}}"></p>
					<h3 class="text-center">University of the Philippines Visayas - Health Services Unit</h3>
					<h4 class="text-center">Miagao, Iloilo</h4><br/>
					<h4 class="text-center">Schedule for Upperclassmen Physical Exam</h4>
					<?php $day_counter = $schedules->currentPage(); ?>
					<h1 class="text-center">Day {{$day_counter}}</h1>
					<table class="table" id="generatescheduletable">
						<thead>
							<tr class="info">
								<th><a>Name</a></th>
								<th>Hometown</th>
								<th><a>Travel Distance</a></th>
							</tr>
						</thead>
						<tbody>
							@foreach($schedules as $schedule)
							<tr>
								<td>{{$schedule->patient_last_name}}, {{$schedule->patient_first_name}}</td>
								<td>{{$schedule->town_name}}, {{$schedule->province_name}}</td>
								<td>{{$schedule->distance_to_miagao}} km</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="text-center">{{ $schedules->links() }} </div>
					<div class="text-center"><button type="button" id="postpeschedule" class="btn btn-success btn-xs">Post</button></div>
				</div>
			</div>
		</div>
	</div>
	@endsection