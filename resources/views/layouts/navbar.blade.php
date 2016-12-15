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
				<li><a href="/">Home</a></li>
				<li><a href="about.php">About</a></li>
				<li><a href="announcements.php">Announcements</a></li>
				<li><a href="medicalstaff">Medical Staff</a></li>
				<li><a href="schedule-appointment.php">Schedule Appointment</a></li>
				@if(Auth::check())
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Account <span class="caret"></span></a>
					<ul class="dropdown-menu">
						@if(Auth::user()->user_type_id == 1)
						<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/account') }}">Dashboard</a></li>
						<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/account/profile') }}">Profile</a></li>
						<li @if(isset($sidebar_active) and $sidebar_active == 'visits')class="active" @endif><a href="{{ url('/account/visits') }}">Visits History</a></li>
						<li @if(isset($sidebar_active) and $sidebar_active == 'bills')class="active" @endif><a href="{{ url('/account/bills') }}">Billing Records</a></li>
						@elseif(Auth::user()->user_type_id == 2)
				  		{{-- If Dentist --}}
					  	@if(Auth::user()->staff->staff_type_id == 1 )
								<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/dentist') }}">Dashboard</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/dentist/profile') }}">Profile</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'manageschedule')class="active" @endif><a href="{{ url('/dentist/manageschedule') }}">Manage Schedule</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/dentist/searchpatient') }}">Search Patient</a></li>
							@endif
							{{-- If Cashier --}}
					  	@if(Auth::user()->staff->staff_type_id == 5 )
								<li @if(isset($sidebar_active) and $sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/cashier') }}">Dashboard</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'profile')class="active" @endif><a href="{{ url('/cashier/profile') }}">Profile</a></li>
								<li @if(isset($sidebar_active) and $sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/cashier/searchpatient') }}">Search Patient</a></li>
							@endif
						@endif
						<li><a href="{{ url('/logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();"
							><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
					</ul>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>