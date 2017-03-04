<div id="navigationBar">
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-left" href="/"><img src="{{asset('images/upvweb_logo.png')}}"/></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li @if(isset($navbar_active) and $navbar_active == 'home') class="active " @endif><a href="/">Home</a></li>
				<li @if(isset($navbar_active) and $navbar_active == 'about') class="active " @endif><a href="{{ url('/about') }}">About</a></li>
				<li @if(isset($navbar_active) and $navbar_active == 'announcements') class="active " @endif><a href="{{ url('/announcements') }}">Announcements</a></li>
				<li @if(isset($navbar_active) and $navbar_active == 'medicalstaff') class="active " @endif><a href="{{ url('/medicalstaff') }}">Staff</a></li>
				<li @if(isset($navbar_active) and $navbar_active == 'scheduleappointment') class="active " @endif><a href="{{ url('/scheduleappointment') }}">Schedule Appointment</a></li>
				@if(Auth::check())
				<li class="dropdown @if(isset($navbar_active) and $navbar_active == 'account') active @endif">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Account <span class="caret"></span></a>
					<ul class="dropdown-menu">
						@if(Auth::user()->user_type_id == 1)
						<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/account') }}">Dashboard</a></li>
						<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/account/profile') }}">Profile</a></li>
						<li @if(isset($sidebar_active) and $sidebar_active == 'visits')class="active" @endif><a href="{{ url('/account/visits') }}">Visits History</a></li>
						@elseif(Auth::user()->user_type_id == 2)
				  		{{-- If Dentist --}}
					  	@if(Auth::user()->staff->staff_type_id == 1 )
								<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/dentist') }}">Dashboard</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/dentist/profile') }}">Profile</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'manageschedule')class="active" @endif><a href="{{ url('/dentist/manageschedule') }}">Manage Schedule</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/dentist/searchpatient') }}">Search Patient</a></li>
							@endif
							{{-- If Doctor --}}
					  	@if(Auth::user()->staff->staff_type_id == 2 )
								<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/doctor') }}">Dashboard</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/doctor/profile') }}">Profile</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'manageschedule')class="active" @endif><a href="{{ url('/doctor/manageschedule') }}">Manage Schedule</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/doctor/searchpatient') }}">Search Patient</a></li>
							@endif
							{{-- If Laboratory --}}
					  	@if(Auth::user()->staff->staff_type_id == 3 )
								<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/lab') }}">Dashboard</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/lab/profile') }}">Profile</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/lab/searchpatient') }}">Search Patient</a></li>
							@endif
							{{-- If Xray --}}
					  	@if(Auth::user()->staff->staff_type_id == 4 )
								<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/xray') }}">Dashboard</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/xray/profile') }}">Profile</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/xray/searchpatient') }}">Search Patient</a></li>
							@endif
							{{-- If Cashier --}}
					  	@if(Auth::user()->staff->staff_type_id == 5 )
								<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/cashier') }}">Dashboard</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/cashier/profile') }}">Profile</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/cashier/searchpatient') }}">Search Patient</a></li>
							@endif
						@elseif(Auth::user()->user_type_id == 3)
								<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/admin') }}">Dashboard</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'addstaffaccount')class="active" @endif><a href="{{ url('/admin/addaccount') }}">Add Staff Account</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'addstudentnumber')class="active" @endif><a href="{{ url('/admin/addstudent') }}">Add Student Number to Database</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'editservices')class="active" @endif><a href="{{ url('/admin/editservices') }}">Edit Services' Rates</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'generateschedule')class="active" @endif><a href="{{ url('/admin/generateschedule') }}">Generate PE Schedule</a></li>
						@endif
						<li>
							<a href="{{ url('/logout') }}" 
								onclick="event.preventDefault();
									document.getElementById('logout-form').submit();"
							><form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;"> <input type="hidden" name="_token" value="{{{ csrf_token() }}}" /></form>
							<span class="glyphicon glyphicon-log-out"></span> Logout</a>
						</li>
						
					</ul>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>
</div>