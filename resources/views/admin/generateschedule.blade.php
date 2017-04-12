@extends('layouts.layout')
@section('title', 'Generate PE Schedule | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="adminDashboard">
			<div class="col-md-9 col-md-offset-1">
				<div id="printReport">
					<p style="text-align: center"><img src="{{asset('images/upvweb_logo.png')}}"></p>
					<h3>University of the Philippines Visayas - Health Services Unit</h3>
					<h4>Miagao, Iloilo</h4><br/>
					<h4>Schedule for Upperclassmen Physical Exam</h4>
					<table class="table">
						<?php $day_counter=1;
						$day_accommodate=1; ?>
						<tr><th colspan="3" class="info" style="text-align: center;">Day {{$day_counter}}</th></tr>
						@foreach($schedules as $schedule)
						@if($day_accommodate>15)
						<?php $day_counter ++; ?>
							<tr><th colspan="3" class="info" style="text-align: center;">Day {{$day_counter}}</th></tr>
						<?php  $day_accommodate=1; ?>
						@endif
						@if($day_accommodate<=15)
						<tr>
							<td>{{$schedule->patient_last_name}}, {{$schedule->patient_first_name}}</td>
							<td>{{$schedule->town_name}}, {{$schedule->province_name}}</td>
							<td>{{$schedule->distance_to_miagao}} km</td>
						</tr>
						<?php $day_accommodate ++; ?>
						
						@endif
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
	@endsection