<div class="col-sm-3 col-md-2 sidebar">
	@if(Auth::user()->user_type_id == 1)
	<ul class="nav nav-sidebar">
		<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/account') }}">Dashboard <span class="sr-only">(current)</span></a></li>
  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/account/profile') }}">Profile</a></li>
  		<li id="visitHistory" @if($sidebar_active == 'visits')class="active" @endif><a href="{{ url('/account/visits') }}">Visits History</a></li>
  	</ul>
  	<ul class="nav nav-sidebar">
  		<li><a href="{{url('/scheduleappointment')}}">Schedule Appointment</a></li>
  	</ul>
  	@elseif(Auth::user()->user_type_id == 2)
  		{{-- If Dentist --}}
  		@if(Auth::user()->staff->staff_type_id == 1 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/dentist') }}">Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/dentist/profile') }}">Profile</a></li>
		  		<li id="manageSched" @if($sidebar_active == 'manageschedule')class="active" @endif><a href="{{ url('/dentist/manageschedule') }}">Manage Schedule</a></li>
		  	</ul>
		  	<ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/dentist/searchpatient') }}">Patient Records</a></li>
		  	</ul>
	  	@endif
	  	{{-- If Doctor --}}
  		@if(Auth::user()->staff->staff_type_id == 2 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/doctor') }}">Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/doctor/profile') }}">Profile</a></li>
		  		<li id="manageSched" @if($sidebar_active == 'manageschedule')class="active" @endif><a href="{{ url('/doctor/manageschedule') }}">Manage Schedule</a></li>
		  	</ul>
		  	<ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/doctor/searchpatient') }}">Patient Records</a></li>
		  	</ul>
	  	@endif
	  	{{-- If Laboratory --}}
  		@if(Auth::user()->staff->staff_type_id == 3 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/lab') }}">Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/lab/profile') }}">Profile</a></li>
		  	</ul>
		  	{{-- <ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/lab/searchpatient') }}">Patient Records</a></li>
		  	</ul> --}}
	  	@endif
	  	{{-- If Xray --}}
  		@if(Auth::user()->staff->staff_type_id == 4 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/xray') }}">Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/xray/profile') }}">Profile</a></li>
		  	</ul>
		  	{{-- <ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/xray/searchpatient') }}">Patient Records</a></li>
		  	</ul> --}}
	  	@endif
	  	{{-- If Cashier --}}
  		@if(Auth::user()->staff->staff_type_id == 5 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/cashier') }}">Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/cashier/profile') }}">Profile</a></li>
		  	</ul>
		  	{{-- <ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/cashier/searchpatient') }}">Patient Records</a></li>
		  	</ul> --}}
	  	@endif
  	
  	@elseif(Auth::user()->user_type_id == 3)
  		{{-- If Admin --}}
  		<ul class="nav nav-sidebar">
  			<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/admin') }}">Dashboard <span class="sr-only">(current)</span></a></li>
  			<li id="postAnnouncement" @if($sidebar_active == 'postannouncement')class="active" @endif><a href="{{ url('/admin/announcement') }}">Post Announcement</a></li>
  			<li id="addAccount" @if($sidebar_active == 'addstaffaccount')class="active" @endif><a href="{{ url('/admin/addaccount') }}">Add Staff Account</a></li>
  			<li id="addStudentNumber" @if($sidebar_active == 'addstudentnumber')class="active" @endif><a href="{{ url('/admin/addstudent') }}">Add Student Number to Database</a></li>
  			<li id="editServices" @if($sidebar_active == 'editservices')class="active" @endif><a href="{{ url('/admin/editservices') }}">Edit Services' Rates</a></li>
  			<li id="generateSched" @if($sidebar_active == 'generateschedule')class="active" @endif><a href="{{ url('/admin/generateschedule') }}">Generate Upperclassmen Physical Examination Schedule</a></li>
  		</ul>
  		{{-- <ul class="nav nav-sidebar">
  			<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/admin/searchpatient') }}">Patient Records</a></li>
  		</ul> --}}
	  	@endif
</div>