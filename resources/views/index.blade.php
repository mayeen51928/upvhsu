@extends('layouts.layout')
@section('title', 'Home | UP Visayas Health Services Unit')
@section('content')
<div class="jumbotron" id="homeJumbotron">
	<div class="container">
		<div class="col-md-6 col-md-offset-6">
			<div class="col-md-12 homeForm">
				<div class="panel-heading">
					<img class="img-responsive" src="{{asset('images/upvweb_logo.png')}}"/>
				</div>
				<div class="panel-content homeFormBtn">
					<p>Miagao Campus, Iloilo 5023</p>
					<a href="{{ url('/scheduleappointment') }}" id="setAppointmentBtn">
						<button class="form-control btn-primary" id="setAppointment">Schedule an Appointment</button>
					</a>
				</div>
			</div>
			<div class="col-md-12 homeForm">
				<div class="panel-heading">
					<img class="img-responsive" src="{{asset('images/upvweb_logo.png')}}"/>
				</div>
				@if(!Auth::check())
				<div class="panel-content homeFormBtn">
					<form  method="POST" action="{{ url('/login') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<input id="user_id" type="user_id" class="form-control" name="user_id" value="{{ old('email') }}" required autofocus placeholder="Username" />
						</div>
						<div class="form-group">
							<input id="password" type="password" class="form-control" name="password" required placeholder="Password"/>
						</div>
						@if ($errors->has('user_id'))
						<span class="help-block">
							<strong>{{ $errors->first('user_id') }}</strong>
						</span>
						@endif
						@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
						@endif
						<small>To register, please schedule an appointment first.</small>
						<br/><br/>
						<div class="form-group">
							<button type="submit" class="btn btn-success">Login</button>
						</div>
					</form>
				</div>
				@else
					@if(Auth::user()->user_type_id == 1)
						<p>Hello {{ Auth::user()->patient->patient_first_name }}</p>
						<div class="col-md-4 accountOption">
							<a href="{{ url('/account') }}" class="btn btn-info btn-sm" role="button">View Account</a>
						</div>
						<div class="col-md-4 accountOption">
							<a href="{{ url('/account/visits') }}" class="btn btn-info btn-sm" role="button">Visits History</a>
						</div>
						<div class="col-md-4 accountOption">
							<a href="{{ url('/account/bills') }}" class="btn btn-info btn-sm" role="button">Billing Records</a>
						</div>
					@elseif(Auth::user()->user_type_id == 2)
						@if(Auth::user()->staff->staff_type_id == 1)
							<p>Hello {{ Auth::user()->staff->staff_first_name }}</p>
							<div class="col-md-4 accountOption">
								<a href="{{ url('/dentist') }}" class="btn btn-info btn-sm" role="button">View Account</a>
							</div>
							<div class="col-md-4 accountOption">
								<a href="{{ url('/dentist/searchpatient') }}" class="btn btn-info btn-sm" role="button">Patient Records</a>
							</div>
							<div class="col-md-4 accountOption">
								<a href="{{ url('/dentist/manageschedule') }}" class="btn btn-info btn-sm" role="button">Manage Schedule</a>
							</div>
						@endif
						@if(Auth::user()->staff->staff_type_id == 2)
							<p>Hello {{ Auth::user()->staff->staff_first_name }}</p>
							<div class="col-md-4 accountOption">
								<a href="{{ url('/doctor') }}" class="btn btn-info btn-sm" role="button">View Account</a>
							</div>
							<div class="col-md-4 accountOption">
								<a href="{{ url('/doctor/searchpatient') }}" class="btn btn-info btn-sm" role="button">Patient Records</a>
							</div>
							<div class="col-md-4 accountOption">
								<a href="{{ url('/doctor/manageschedule') }}" class="btn btn-info btn-sm" role="button">Manage Schedule</a>
							</div>
						@endif
						@if(Auth::user()->staff->staff_type_id == 3)
							<p>Hello {{ Auth::user()->staff->staff_first_name }}</p>
							<div class="col-md-4 col-md-offset-1 accountOption">
								<a href="{{ url('/lab') }}" class="btn btn-info btn-sm" role="button">View Account</a>
							</div>
							<div class="col-md-4 col-md-offset-2 accountOption">
								<a href="{{ url('/lab/searchpatient') }}" class="btn btn-info btn-sm" role="button">Patient Records</a>
							</div>
						@endif
						@if(Auth::user()->staff->staff_type_id == 4)
							<p>Hello {{ Auth::user()->staff->staff_first_name }}</p>
							<div class="col-md-4 col-md-offset-1 accountOption">
								<a href="{{ url('/xray') }}" class="btn btn-info btn-sm" role="button">View Account</a>
							</div>
							<div class="col-md-4 col-md-offset-2 accountOption">
								<a href="{{ url('/xray/searchpatient') }}" class="btn btn-info btn-sm" role="button">Patient Records</a>
							</div>
						@endif
						@if(Auth::user()->staff->staff_type_id == 5)
							<p>Hello {{ Auth::user()->staff->staff_first_name }}</p>
							<div class="col-md-4 col-md-offset-4 accountOption">
								<a href="{{ url('/cashier') }}" class="btn btn-info btn-sm" role="button">View Account</a>
							</div>
						@endif

					@endif
					@if(Auth::user()->user_type_id == 3)
						<p>Hello Admin</p>
						<div class="col-md-4 accountOption">
							<a href="{{ url('/admin') }}" class="btn btn-info btn-sm" role="button">Dashboard</a>
						</div>
						<div class="col-md-4 accountOption">
							<a href="{{ url('/admin/addaccount') }}" class="btn btn-info btn-sm" role="button">Add Staff Account</a>
						</div>
						<div class="col-md-4 accountOption">
							<a href="{{ url('/admin/generateschedule') }}" class="btn btn-info btn-sm" role="button">Generate PE Schedule</a>
						</div>
					@endif
				@endif
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="col-md-6 fadeShow">
		<h1 class="h3Title"><span class="glyphicon glyphicon-bullhorn h3Icon"></span> Announcements</h1>
		<div class="panel-content">
			<ul>
				@foreach($announcements as $announcement)
				<li><a href="">{{ $announcement->announcement_title }}</a> (posted on {{ Carbon\Carbon::parse($announcement->created_at)->toDayDateTimeString() }})</li>
				@endforeach
				<a href="{{ url('/announcements') }}">View more...</a>
			</ul>
		</div>
	</div>
	<div class="col-md-6">
		<div class="col-md-6 fadeShow">
			<h3 class="h3Title"><span class="glyphicon glyphicon-plus-sign h3Icon"></span> Services</h3>
			<div class="panel-content">
				<ul>
					<li>Medical consultation and treatments</li>
					<li>Dental consultation and treatments</li>
					<li>Blood Chemistry</li>
					<li>Urinalysis</li>
					<li>Fecalysis</li>
					<li>X-Ray</li>
				</ul>
			</div>
		</div>
		<div class="col-md-6 fadeShow">
			<h3 class="h3Title"><span class="glyphicon glyphicon-user h3Icon"></span> Medical Staff</h3>
			<div class="panel-content">
				<ul>
					<li>Rolly Manalo, DMD</li>
					<li>Mayenne Catuiran, MD</li>
					<li>Eiman Mission, RN</li>
					<a href="medical-staff.php">View more...</a>
				</ul>
			</div>
		</div>
		<div class="col-md-12 fadeShow">
			<h3 class="h3Title"><span class="glyphicon glyphicon-map-marker h3Icon"></span> Location</h3>
			<iframe id="map" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7842.285803765714!2d122.2301799153447!3d10.646004606670068!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc19cd3690ea64d5f!2sUPV+Infirmary!5e0!3m2!1sen!2sph!4v1476282280584" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
</div>
<div class="container" id="pageFooter">
	<div class="col-md-8">
		<p class="text-muted">Copyright © 2017. All Rights Reserved.</p>
		<p class="text-muted">Health Services Unit, University of the Philippines Visayas, Miagao, Iloilo, Philippines, 5023</p>
		<p class="text-muted">Phone/Fax: +63 (33) 315 8556  |  E-mail: crs.upvisayas@up.edu.ph </p>
		<p class="text-muted">Developers: Mayenne Joi R. Catuiran | John Eiman S. Mission</p>
	</div>
	<div class="col-md-4 text-muted">
		<a class="text-muted">CRSIS</a> | 
		<a class="text-muted">eUP</a> | 
		<a class="text-muted">GDP</a> | 
		<a class="text-muted">GDO</a> | 
		<a class="text-muted">Library</a> | 
		<a class="text-muted">STS</a> | 
		<a class="text-muted">UP System</a> | 
		<a class="text-muted">UP Visayas</a> | 
		<a class="text-muted">UPCAT</a>
	</div>
</div>
@endsection