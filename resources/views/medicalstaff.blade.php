@extends('layouts.layout')
@section('title', 'Schedule Appointment | UP Visayas Health Services Unit')
@section('content')
<div class="container">
<br/>
<br/>
<div class="row staffInfoDiv">
	@foreach($staffs as $staff)
	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
		<div class="medicalStaff">
			<div class="medicalStaffImg">
				@if(is_null($staff->picture))
				<img class="img-circle img-responsive center-block" src="{{asset('images/medicalstaff.png')}}"/>
				@else
				<img class="img-circle img-responsive center-block" src="{{asset('images/'.$staff->picture)}}"/>
				@endif
				</div>
				<dl class="medicalStaffInfo">
					<dt>{{$staff->staff_last_name}}, {{$staff->staff_first_name}}</dt>
					<dd>{{$staff->position}}</dd>
				</dl>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection