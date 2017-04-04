<div class="col-sm-3 col-md-2 sidebar">
	@if(Auth::user()->user_type_id == 1)
	<ul class="nav nav-sidebar">
		<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/account') }}"><i class="fa fa-dashboard"></i> Dashboard <span class="sr-only">(current)</span></a></li>
  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/account/profile') }}"><i class="fa fa-id-card"></i> Profile</a></li>
  		<li id="visitHistory" @if($sidebar_active == 'visits')class="active" @endif><a href="{{ url('/account/visits') }}"><i class="fa fa-history"></i> Visits History</a></li>
  	</ul>
  	<ul class="nav nav-sidebar">
  		<li @if($sidebar_active == 'scheduleappointment')class="active" @endif><a href="{{url('/scheduleappointment')}}"><i class="fa fa-calendar-plus-o"></i> Schedule Appointment</a></li>
  	</ul>
  	@elseif(Auth::user()->user_type_id == 2)
  		{{-- If Dentist --}}
  		@if(Auth::user()->staff->staff_type_id == 1 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/dentist') }}"><i class="fa fa-dashboard"></i> Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/dentist/profile') }}"><i class="fa fa-id-card"></i> Profile</a></li>
		  		<li id="manageSched" @if($sidebar_active == 'manageschedule')class="active" @endif><a href="{{ url('/dentist/manageschedule') }}"><i class="fa fa-calendar"></i> Manage Schedule</a></li>
		  	</ul>
		  	<ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/dentist/searchpatient') }}"><i class="fa fa-file-text"></i> Patient Records</a></li>
		  	</ul>
	  	@endif
	  	{{-- If Doctor --}}
  		@if(Auth::user()->staff->staff_type_id == 2 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/doctor') }}"><i class="fa fa-dashboard"></i> Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/doctor/profile') }}"><i class="fa fa-id-card"></i> Profile</a></li>
		  		<li id="manageSched" @if($sidebar_active == 'manageschedule')class="active" @endif><a href="{{ url('/doctor/manageschedule') }}"><i class="fa fa-calendar"></i> Manage Schedule</a></li>
		  	</ul>
		  	<ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/doctor/searchpatient') }}"><i class="fa fa-file-text"></i> Patient Records</a></li>
		  	</ul>
	  	@endif
	  	{{-- If Laboratory --}}
  		@if(Auth::user()->staff->staff_type_id == 3 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/lab') }}"><i class="fa fa-dashboard"></i> Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/lab/profile') }}"><i class="fa fa-id-card"></i> Profile</a></li>
		  	</ul>
		  	{{-- <ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/lab/searchpatient') }}">Patient Records</a></li>
		  	</ul> --}}
	  	@endif
	  	{{-- If Xray --}}
  		@if(Auth::user()->staff->staff_type_id == 4 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/xray') }}"><i class="fa fa-dashboard"></i> Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/xray/profile') }}"><i class="fa fa-id-card"></i> Profile</a></li>
		  	</ul>
		  	{{-- <ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/xray/searchpatient') }}">Patient Records</a></li>
		  	</ul> --}}
	  	@endif
	  	{{-- If Cashier --}}
  		@if(Auth::user()->staff->staff_type_id == 5 )
				<ul class="nav nav-sidebar">
					<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/cashier') }}"><i class="fa fa-dashboard"></i> Dashboard <span class="sr-only">(current)</span></a></li>
		  		<li id="profileNav" @if($sidebar_active == 'profile')class="active" @endif><a href="{{ url('/cashier/profile') }}"><i class="fa fa-id-card"></i> Profile</a></li>
		  	</ul>
		  	{{-- <ul class="nav nav-sidebar">
		  		<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/cashier/searchpatient') }}">Patient Records</a></li>
		  	</ul> --}}
	  	@endif
  	
  	@elseif(Auth::user()->user_type_id == 3)
  		{{-- If Admin --}}
  		<ul class="nav nav-sidebar">
  			<li id="dashboardNav" @if($sidebar_active == 'dashboard')class="active" @endif><a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard <span class="sr-only">(current)</span></a></li>
  			<li id="postAnnouncement" @if($sidebar_active == 'postannouncement')class="active" @endif><a href="{{ url('/admin/announcement') }}"><i class="fa fa-bullhorn"></i> Post Announcement</a></li>
  			<li id="addAccount" @if($sidebar_active == 'addstaffaccount')class="active" @endif><a href="{{ url('/admin/addstaffaccount') }}"><i class="fa fa-user-md"></i> Add Staff Account</a></li>
  			<li id="addStudentNumber" @if($sidebar_active == 'addstudentnumber')class="active" @endif><a href="{{ url('/admin/addstudent') }}"><i class="fa fa-user-plus"></i> Add Student Number to Database</a></li>
  			<li id="addPatientAccount" @if($sidebar_active == 'addpatientaccount')class="active" @endif><a href="{{ url('/admin/addpatientaccount') }}"><i class="fa fa-hospital-o"></i> Add Patient Account</a></li>
  			<li id="editServices" @if($sidebar_active == 'editservices')class="active" @endif><a href="{{ url('/admin/editservices') }}"><i class="fa fa-money"></i> Edit Services' Rates</a></li>
  			<li id="generateSched" @if($sidebar_active == 'generateschedule')class="active" @endif><a href="{{ url('/admin/generateschedule') }}"><i class="fa fa-calendar"></i> Generate Upperclassmen Physical Examination Schedule</a></li>
  		</ul>
  		{{-- <ul class="nav nav-sidebar">
  			<li id="searchPatient" @if($sidebar_active == 'searchpatient')class="active" @endif><a href="{{ url('/admin/searchpatient') }}">Patient Records</a></li>
  		</ul> --}}
	  	@endif
</div>