@extends('layouts.layout')
@section('title', 'Schedule Appointment | UP Visayas Health Services Unit')
@section('content')
<div class="container">
@if(isset($sidebar_active))
	@include('layouts.sidebar')
@endif
	<div 
		@if(Auth::check() && Auth::user()->user_type_id == 1)
			class="col-md-4 col-md-offset-5"
		@else
			class="col-md-4 col-md-offset-4"
		@endif
	>
		<div class="panel panel-default" style="margin-top: 20px;">
			<div class="panel-heading">Select Type of Appointment</div>
			<div class="panel-body">
				<form class="form-inline">
					<div class="checkbox col-md-6 @if(Auth::check())
							@if(Auth::user()->user_type_id == 2 or Auth::user()->user_type_id == 3)
							disabled
							@endif
						@endif ">
						<label><input type="checkbox" @if((Auth::check() and Auth::user()->user_type_id == 1) or !Auth::check()) name="type_dental" id="typeDental" @endif
						@if(Auth::check())
							@if(Auth::user()->user_type_id == 2 or Auth::user()->user_type_id == 3)
							disabled
							@endif
						@endif 
						/> Dental</label>
					</div>
					<div class="checkbox col-md-6 @if(Auth::check())
							@if(Auth::user()->user_type_id == 2 or Auth::user()->user_type_id == 3)
							disabled
							@endif
						@endif ">
						<label><input type="checkbox" @if((Auth::check() and Auth::user()->user_type_id == 1) or !Auth::check()) name="type_medical" id="typeMedical" @endif
						@if(Auth::check())
							@if(Auth::user()->user_type_id == 2 or Auth::user()->user_type_id == 3)
							disabled
							@endif
						@endif
						/> Medical</label>
					</div>
				</form>
			</div>
		</div>	
	</div>
</div>
<div class="container">
	@if(Auth::check() && Auth::user()->user_type_id == 1)
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
	@endif
	<div class="col-md-6" id="dentalAppointment0">
		<div class="panel panel-default" id="dentalAppointment">
			<div class="panel-heading">Schedule Dental Appointment</div>
			<div class="panel-body" id="dentalAppointmentPanelBody">
				<div class="form-group">
					<label id="dentalNotesErrorMsg" for="dentalNotes">Reasons (e.g. molar toothache):</label>
					<textarea class="form-control" rows="5" required name="dentalNotes" id="dentalNotes"></textarea>
				</div>
				<div class="form-group">
					<label for="selectdentaldate" id="selectdentaldateErrorMsg" >Date:</label>
					<select class="form-control" required id="selectdentaldate">
						<option disabled selected>Select date of appointment</option>
						<option value="{{ Carbon\Carbon::tomorrow()->format('Y-m-d') }}">{{ Carbon\Carbon::tomorrow()->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(2)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(3)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(4)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(4)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(5)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(5)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(6)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(6)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(7)->format('F j, Y') }}</option>
					</select>
				</div>
				<div class="form-group">
					<label id="selectdentaltimeErrorMsg">Doctor and Time:</label>
					<select disabled class="form-control" required id="selectdentaltime">
						<option disabled selected>Select dentist and time</option>
					</select>
				</div>
				<button class="btn btn-success" name="submitdentalappointment" id="submitdentalappointment">Set Appointment</button>
			</div>
		</div>	
	</div>
	<div class="col-md-6" id="medicalAppointment0">
		<div class="panel panel-default" id="medicalAppointment">
			<div class="panel-heading">Schedule Medical Appointment</div>
			<div class="panel-body" id="medicalAppointmentPanelBody">
				<div class="form-group">
					<label for="medicalNotes" id="medicalNotesErrorMsg">Reasons (e.g. physical pain felt):</label>
					<textarea class="form-control" rows="5" id="medicalNotes"></textarea>
				</div>
				<div class="form-group">
					<label for="selectmedicaldate" id="selectmedicaldateErrorMsg">Date:</label>
					<select class="form-control" required id="selectmedicaldate">
						<option disabled selected>Select date of appointment</option>
						<option value="{{ Carbon\Carbon::tomorrow()->format('Y-m-d') }}">{{ Carbon\Carbon::tomorrow()->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(2)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(3)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(4)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(4)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(5)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(5)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(6)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(6)->format('F j, Y') }}</option>
						<option value="{{ Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}">{{ Carbon\Carbon::now()->addDays(7)->format('F j, Y') }}</option>
					</select>
				</div>
				<div class="form-group">
					<label id="selectmedicaldoctorErrorMsg">Doctor:</label>
					<select disabled class="form-control" required id="selectmedicaldoctor">
						<option disabled selected>Select doctor</option>
					</select>
				</div>
				{{-- <p id="medicalFormNote"><i>Note: Medical appointment done online is for note-taking purposes of the doctor.  On-site visit will still be accommodated first.</i></p> --}}
				<button class="btn btn-success" name="submitmedicalappointment" id="submitmedicalappointment">Set Appointment</button>
			</div>
		</div>	
	</div>
	@if(Auth::check() && Auth::user()->user_type_id == 1)
	</div>
	@endif
</div>

{{-- ///////////////////////////////////////////////////////////////////////////////////////// --}}
{{-- SIGN UP MODAL FOR DENTAL APPOINTMENTS --}}
<div class="modal fade" id="loginmodaldental" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Enter your login credentials</h4>
			</div>
			<div class="modal-body">
				<div class="progress signup_progressbar_dental">
					<div class="progress-bar progress-bar-striped active" role="progressbar" id="changeProgressDental" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
				</div>
				<div class="form-group">
					<input type="text" class="form-control signup0_dental" name="user_name_modal_dental" id="user_name_modal_dental" autofocus placeholder="User ID (Enter 9-digit ID)" maxlength="9"/>
				</div>
				<div class="form-group">
					<input type="password" class="form-control signup0_dental" name="password_modal_dental" id="password_modal_dental" placeholder="Password"/>
				</div>
				<div class="form-group signup">
					<input type="text" class="form-control signup1_dental" name="first_name_dental" id="first_name_dental" placeholder="First Name"/>
				</div>
				<div class="form-group signup">
					<input type="text" class="form-control signup1_dental" name="middle_name_dental" id="middle_name_dental" placeholder="Middle Name"/>
				</div>
				<div class="form-group signup">
					<input type="text" class="form-control signup1_dental" name="last_name_dental" id="last_name_dental" placeholder="Last Name"/>
				</div>
				<div class="form-group signup2_dental">
					<div class="form-group signup">
						<label>Type of patient:  <i class="fa fa-asterisk required-asterisk"></i></label></label><br/>
						<label class="radio-inline"><input type="radio" name="patient_type_dental" value="1">Student</label>
						<label class="radio-inline"><input type="radio" name="patient_type_dental" value="2">Faculty</label>
						<label class="radio-inline"><input type="radio" name="patient_type_dental" value="3">Staff</label>
						<label class="radio-inline"><input type="radio" name="patient_type_dental" value="4">Dependent</label>
						<label class="radio-inline"><input type="radio" name="patient_type_dental" value="5">Non-UPV / Out-patient</label>
					</div>
					<label>PERSONAL DATA</label><br/>
					<div class="">
						<div class="form-group signup">
							<label>Sex: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<label class="radio-inline"><input type="radio" value="F" name="sex_dental">Female</label>
							<label class="radio-inline"><input type="radio" value="M" name="sex_dental">Male</label>
						</div>
						<div class="form-group signup">
							<label>Year Level: <i class="fa fa-asterisk not-required-asterisk"></i></label></label>
							<input type="number" min="1" max="5" class="form-control" name="yearlevel_dental" id="yearlevel_dental" placeholder="Enter year level" disabled/>
						</div>
						<div class="form-group signup">
							<label>Degree Program: <i class="fa fa-asterisk not-required-asterisk"></i></label></label>
							<select class="form-control" name="degree_program_dental" id="degree_program_dental" title="Select the degree program you are currently enrolled in." disabled="">
								<option disabled selected value="default">select degree program</option>
								<optgroup label="College of Arts and Sciences">
									<option value="8">BS Applied Mathematics</option>
  									<option value="9">BS Biology</option>
  									<option value="10">BS Chemistry</option>
  									<option value="7">BA Communication and Media Studies</option>
  									<option value="1">BA Community Development</option>
  									<option value="11">BS Computer Science</option>
  									<option value="12">BS Economics</option>
  									<option value="2">BA History</option>
  									<option value="3">BA Literature</option>
  									<option value="4">BA Political Science</option>
  									<option value="5">BA Psychology</option>
  									<option value="13">BS Public Health</option>
  									<option value="6">BA Sociology</option>
  									<option value="14">BS Statistics</option>
  									<option value="15">Master of Chemistry</option>
  									<option value="16">Master of Education (Biology)</option>
  									<option value="17">Master of Education (English as a Second Language)</option>
  									<option value="18">Master of Education (Filipino)</option>
  									<option value="19">Master of Education (Guidance)</option>
  									<option value="20">Master of Education (Mathematics)</option>
  									<option value="21">Master of Education (Physics)</option>
  									<option value="22">Master of Education (Reading)</option>
  									<option value="23">Master of Education (Social Studies)</option>
  									<option value="24">MS Biology</option>
  								</optgroup>
  								<optgroup label="College of Fisheries and Ocean Sciences">
  									<option value="25">BS Fisheries</option>
  									<option value="26">Master of Aquaculture</option>
  									<option value="27">Master of Marine Affairs</option>
  									<option value="28">MS Fisheries (Aquaculture)</option>
  									<option value="29">MS Fisheries (Fisheries Biology)</option>
  									<option value="30">MS Fisheries (Fish Processing Technology)</option>
  									<option value="31">MS Ocean Sciences</option>
  									<option value="32">Professional Masters in Tropical Marines</option>
  									<option value="33">PhD Fisheries</option>
  								</optgroup>
  								<optgroup label="College of Management">
  									<option value="34">BS Accountancy</option>
  									<option value="35">BS Business Administration (Marketing)</option>
  									<option value="36">BS Management</option>
  									<option value="37">Master of Management (Business Management)</option>
  									<option value="38">Master of Management (Public Management)</option>
  									<option value="39">Diploma in Urban and Regional Planning</option>
  								</optgroup>
  								<optgroup label="School of Technology">
  									<option value="41">BS Chemical Engineering</option>
  									<option value="40">BS Food Technology</option>
  								</optgroup>
							</select>
						</div>
						<div class="form-group signup">
							<label>Date of Birth: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="date" class="form-control" name="birthdate_dental" id="birthdate_dental"/>
						</div>
						<div class="form-group signup" id="senior_citizen_dental">
							<label>Senior Citizen ID # (For out-patients only):</label>
							<input type="text" class="form-control" name="senior_citizen_id_dental" id="senior_citizen_id_dental" placeholder="Enter senior citizen ID number" disabled/>
						</div>
						<div class="form-group signup">
							<label>Civil Status: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<select class="form-control" name="civil_status_dental" id="civil_status_dental" required>
								<option value="Single">Single</option>
								<option value="Married">Married</option>
								<option value="Separated">Separated</option>
								<option value="Divorced">Divorced</option>
								<option value="Widowed">Widowed</option>
							</select>
						</div>
						<div class="form-group signup">
							<label>Religion: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" placeholder="Enter religion" name="religion_dental" id="religion_dental" maxlength="30" />
						</div>
						<div class="form-group signup">
							<label>Nationality: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="nationality_dental" placeholder="Enter nationality" id="nationality_dental" maxlength="20" />
						</div>
						<div class="form-group signup">
							<label>Father: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="father_first_dental" placeholder="Enter father's given name" id="father_first_dental"/>
							<input type="text" class="form-control" name="father_middle_dental" placeholder="Enter father's middle name" id="father_middle_dental"/>
							<input type="text" class="form-control" name="father_last_dental" placeholder="Enter father's last name" id="father_last_dental"/>
						</div>
						<div class="form-group signup">
							<label>Mother: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="mother_first_dental" placeholder="Enter mother's first name" id="mother_first_dental"/>
							<input type="text" class="form-control" name="mother_middle_dental" placeholder="Enter mother's middle name" id="mother_middle_dental"/>
							<input type="text" class="form-control" name="mother_last_dental" placeholder="Enter mother's last name" id="mother_last_dental"/>
						</div>
						<div class="form-group signup">
							<label>Home Address: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<div class="form-inline">
								<input type="text" class="form-control" name="street_dental" id="street_dental" placeholder="Street"/>
								<input type="text" class="form-control" name="town_dental" id="town_dental" placeholder="Town / City"/>
								<input type="text" class="form-control" name="province_dental" id="province_dental" placeholder="Province"/>
							</div>
						</div>
						<div class="form-inline">
							<label>Residence Telephone Number: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="residencetelephonedental" id="residencetelephone_dental"/>
							<label>Residence Cellphone Number: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="residencecellphone_dental" id="residencecellphone_dental"/>
							<label>Personal Contact Number: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="personalcontactnumber_dental" id="personalcontactnumber_dental"/>
						</div>
					</div>
				</div>
				<div class="form-group signup3_dental">
					<label>GUARDIAN/PERSON TO BE CONTACTED IN CASE OF EMERGENCY (OTHER THAN PARENTS)</label><br/>
					<div class="form-group signup">
						<label>Name: <i class="fa fa-asterisk required-asterisk"></i></label></label>
						<input type="text" class="form-control" name="guardian_first_dental" placeholder="Enter guardian's first name" id="guardian_first_dental"/>
						<input type="text" class="form-control" name="guardian_middle_dental" placeholder="Enter guardian's middle name" id="guardian_middle_dental"/>
						<input type="text" class="form-control" name="guardian_last_dental" placeholder="Enter guardian's last name" id="guardian_last_dental"/>
					</div>
					<div class="form-group signup">
						<label>Relationship: <i class="fa fa-asterisk required-asterisk"></i></label></label>
						<input type="text" class="form-control" name="guardian_relationship_dental" placeholder="Enter relationship with guardian" id="guardian_relationship_dental"/>
					</div>
					<div class="form-inline signup">
						<label>Address: <i class="fa fa-asterisk required-asterisk"></i></label></label>
						<input type="text" class="form-control" name="guardian_street_dental" placeholder="Street" id="guardian_street_dental"/>
						<input type="text" class="form-control" name="guardian_town_dental" placeholder="Town / City" id="guardian_town_dental"/>
						<input type="text" class="form-control" name="guardian_province_dental" placeholder="Province" id="guardian_province_dental"/>
					</div>
					<div class="form-group signup">
						<div class="form-inline">
							<label>Residence Telephone Number:</label>
							<input type="text" class="form-control" name="guardianresidencetelephone_dental" id="guardianresidencetelephone_dental"/>
							<label>Residence Cellphone Number: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="guardianresidencecellphone_dental" id="guardianresidencecellphone_dental"/>
						</div>
					</div>
				</div>
				<div class="form-group signup4_dental">
					<label>PAST MEDICAL HISTORY</label><br/>
					<div class="form-group signup">
						<label>Past illnesses since birth: <i class="fa fa-asterisk required-asterisk"></i></label></label>
						<input type="text" class="form-control" name="illness_history_dental" placeholder="Enter past illnesses since birth" id="illness_history_dental"/>
					</div>
					<div class="form-group signup">
						<label>Operation undergone since birth: <i class="fa fa-asterisk required-asterisk"></i></label></label>
						<input type="text" class="form-control" name="operation_history_dental" placeholder="Enter operation undergone since birth" id="operation_history_dental"/>
					</div>
					<div class="form-group signup">
						<label>Allergies to either food or drugs: <i class="fa fa-asterisk required-asterisk"></i></label></label>
						<input type="text" class="form-control" name="allergies_history_dental" placeholder="Enter allergies to either food or drugs" id="allergies_history_dental"/>
					</div>
					<div class="form-group signup">
						<label>Family history of diseases: <i class="fa fa-asterisk required-asterisk"></i></label></label>
						<input type="text" class="form-control" name="family_history_dental" placeholder="Enter family history of diseases" id="family_history_dental"/>
					</div>
					<div class="form-group signup">
						<label>Maintenance medication: <i class="fa fa-asterisk required-asterisk"></i></label></label>
						<input type="text" class="form-control" name="maintenance_medication_history_dental" placeholder="Enter maintenance medication" id="maintenance_medication_history_dental"/>
					</div>
				</div>
				<p id="login_dental_error"></p>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-success form-inline" name="login_modal_dental" id="login_modal_dental" value="Login"/>
				<input type="submit" class="btn btn-info form-inline" name="signupDental_modal" id="signupDental_modal" value="Create Patient Account"/>
				<input type="submit" class="btn btn-default" name="signupbackDental_modal" id="signupbackDental_modal" value="Back"/>
				<input type="submit" class="btn btn-info" name="signupnextDental_modal" id="signupnextDental_modal" value="Next" disabled/>
				<input type="submit" class="btn btn-info" name="signupconfirmDental_modal" id="signupconfirmDental_modal" value="Confirm Sign Up" disabled />
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>


{{-- ///////////////////////////////////////////////////////////////////////////////////// --}}
{{-- SIGN UP MODAL FOR MEDICAL APPOINTMENTS --}}
<div class="modal fade" id="loginmodalmedical" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Enter your login credentials</h4>
				</div>
				<div class="modal-body">
					<div class="progress signup_progressbar">
						<div class="progress-bar progress-bar-striped active" role="progressbar" id="changeProgress" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
					</div>
					<div class="form-group signup0_medical">
						<input type="text" class="form-control" name="user_name_modal_medical" id="user_name_modal_medical" autofocus placeholder="User ID (Enter 9-digit ID)" maxlength="9">
					</div>
					<div class="form-group signup0_medical">
						<input type="password" class="form-control" name="password_modal_medical" id="password_modal_medical" placeholder="Password">
					</div>
					
					<div class="form-group signup1_medical">
						<input type="text" class="form-control" name="first_name_medical" id="first_name_medical" placeholder="First Name">
					</div>
					<div class="form-group signup1_medical">
						<input type="text" class="form-control" name="middle_name_medical" id="middle_name_medical" placeholder="Middle Name">
					</div>
					<div class="form-group signup1_medical">
						<input type="text" class="form-control" name="last_name_medical" id="last_name_medical" placeholder="Last Name">
					</div><div class="form-group signup2_medical">
					<div class="form-group signup">
						<label>Type of patient: <i class="fa fa-asterisk required-asterisk"></i></label><br/>
						<label class="radio-inline"><input type="radio" name="patient_type_medical" value="1">Student</label>
						<label class="radio-inline"><input type="radio" name="patient_type_medical" value="2">Faculty</label>
						<label class="radio-inline"><input type="radio" name="patient_type_medical" value="3">Staff</label>
						<label class="radio-inline"><input type="radio" name="patient_type_medical" value="4">Dependent</label>
						<label class="radio-inline"><input type="radio" name="patient_type_medical" value="5">Non-UPV / Out-patient</label>
					</div>
					<label>PERSONAL DATA</label><br/>
					<div class="">
						<div class="form-group signup">
							<label>Sex: <i class="fa fa-asterisk required-asterisk"></i></label>
							<label class="radio-inline"><input type="radio" value="F" name="sex_medical">Female</label>
							<label class="radio-inline"><input type="radio" value="M" name="sex_medical">Male</label>
						</div>
						<div class="form-group signup">
							<label>Year Level: <i class="fa fa-asterisk not-required-asterisk"></i></label>
							<input type="number" min="1" max="5" class="form-control" name="yearlevel_medical" id="yearlevel_medical" placeholder="Enter year level" disabled/>
						</div>
						<div class="form-group signup">
							<label>Degree Program: <i class="fa fa-asterisk not-required-asterisk"></i></label>
							<select class="form-control" name="degree_program_medical" id="degree_program_medical" title="Select the degree program you are currently enrolled in." disabled="">
								<option disabled selected value="default">select degree program</option>
								<optgroup label="College of Arts and Sciences">
									<option value="8">BS Applied Mathematics</option>
  									<option value="9">BS Biology</option>
  									<option value="10">BS Chemistry</option>
  									<option value="7">BA Communication and Media Studies</option>
  									<option value="1">BA Community Development</option>
  									<option value="11">BS Computer Science</option>
  									<option value="12">BS Economics</option>
  									<option value="2">BA History</option>
  									<option value="3">BA Literature</option>
  									<option value="4">BA Political Science</option>
  									<option value="5">BA Psychology</option>
  									<option value="13">BS Public Health</option>
  									<option value="6">BA Sociology</option>
  									<option value="14">BS Statistics</option>
  									<option value="15">Master of Chemistry</option>
  									<option value="16">Master of Education (Biology)</option>
  									<option value="17">Master of Education (English as a Second Language)</option>
  									<option value="18">Master of Education (Filipino)</option>
  									<option value="19">Master of Education (Guidance)</option>
  									<option value="20">Master of Education (Mathematics)</option>
  									<option value="21">Master of Education (Physics)</option>
  									<option value="22">Master of Education (Reading)</option>
  									<option value="23">Master of Education (Social Studies)</option>
  									<option value="24">MS Biology</option>
  								</optgroup>
  								<optgroup label="College of Fisheries and Ocean Sciences">
  									<option value="25">BS Fisheries</option>
  									<option value="26">Master of Aquaculture</option>
  									<option value="27">Master of Marine Affairs</option>
  									<option value="28">MS Fisheries (Aquaculture)</option>
  									<option value="29">MS Fisheries (Fisheries Biology)</option>
  									<option value="30">MS Fisheries (Fish Processing Technology)</option>
  									<option value="31">MS Ocean Sciences</option>
  									<option value="32">Professional Masters in Tropical Marines</option>
  									<option value="33">PhD Fisheries</option>
  								</optgroup>
  								<optgroup label="College of Management">
  									<option value="34">BS Accountancy</option>
  									<option value="35">BS Business Administration (Marketing)</option>
  									<option value="36">BS Management</option>
  									<option value="37">Master of Management (Business Management)</option>
  									<option value="38">Master of Management (Public Management)</option>
  									<option value="39">Diploma in Urban and Regional Planning</option>
  								</optgroup>
  								<optgroup label="School of Technology">
  									<option value="41">BS Chemical Engineering</option>
  									<option value="40">BS Food Technology</option>
  								</optgroup>
							</select>
						</div>
						<div class="form-group signup">
							<label>Date of Birth: <i class="fa fa-asterisk required-asterisk"></i></label>
							<input type="date" class="form-control" name="birthdate_medical" id="birthdate_medical"/>
						</div>
						<div class="form-group signup" id="senior_citizen_medical">
							<label>Senior Citizen ID # (For out-patients only):</label>
							<input type="text" class="form-control" name="senior_citizen_id_medical" id="senior_citizen_id_medical" placeholder="Enter senior citizen ID number" disabled/>
						</div>
						<div class="form-group signup">
							<label>Civil Status: <i class="fa fa-asterisk required-asterisk"></i></label>
							<select class="form-control" name="civil_status_medical" id="civil_status_medical" required>
								<option value="Single">Single</option>
								<option value="Married">Married</option>
								<option value="Separated">Separated</option>
								<option value="Divorced">Divorced</option>
								<option value="Widowed">Widowed</option>
							</select>
						</div>
						<div class="form-group signup">
							<label>Religion: <i class="fa fa-asterisk required-asterisk"></i></label>
							<input type="text" class="form-control" placeholder="Enter religion" name="religion_medical" id="religion_medical" maxlength="30" />
						</div>
						<div class="form-group signup">
							<label>Nationality: <i class="fa fa-asterisk required-asterisk"></i></label>
							<input type="text" class="form-control" name="nationality_medical" placeholder="Enter nationality" id="nationality_medical" maxlength="20" />
						</div>
						<div class="form-group signup">
							<label>Father: <i class="fa fa-asterisk required-asterisk"></i></label>
							<input type="text" class="form-control" name="father_first_medical" placeholder="Enter father's given name" id="father_first_medical"/>
							<input type="text" class="form-control" name="father_middle_medical" placeholder="Enter father's middle name" id="father_middle_medical"/>
							<input type="text" class="form-control" name="father_last_medical" placeholder="Enter father's last name" id="father_last_medical"/>
						</div>
						<div class="form-group signup">
							<label>Mother: <i class="fa fa-asterisk required-asterisk"></i></label>
							<input type="text" class="form-control" name="mother_first_medical" placeholder="Enter mother's first name" id="mother_first_medical"/>
							<input type="text" class="form-control" name="mother_middle_medical" placeholder="Enter mother's middle name" id="mother_middle_medical"/>
							<input type="text" class="form-control" name="mother_last_medical" placeholder="Enter mother's last name" id="mother_last_medical"/>
						</div>
						<div class="form-group signup">
							<label>Home Address: <i class="fa fa-asterisk required-asterisk"></i></label>
							<div class="form-inline">
								<input type="text" class="form-control" name="street_medical" id="street_medical" placeholder="Street"/>
								<input type="text" class="form-control" name="town_medical" id="town_medical" placeholder="Town / City"/>
								<input type="text" class="form-control" name="province_medical" id="province_medical" placeholder="Province"/>
							</div>
						</div>
						<div class="form-inline">
							<label>Residence Telephone Number: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="residencetelephone_medical" id="residencetelephone_medical"/>
							<label>Residence Cellphone Number: <i class="fa fa-asterisk required-asterisk"></i></label></label>
							<input type="text" class="form-control" name="residencecellphone_medical" id="residencecellphone_medical"/>
							<label>Personal Contact Number: <i class="fa fa-asterisk required-asterisk"></i></label>
							<input type="text" class="form-control" name="personalcontactnumber_medical" id="personalcontactnumber_medical"/>
						</div>
					</div>
				</div>
				<div class="form-group signup3_medical">
					<label>GUARDIAN/PERSON TO BE CONTACTED IN CASE OF EMERGENCY (OTHER THAN PARENTS)</label><br/>
					<div class="form-group signup">
						<label>Name: <i class="fa fa-asterisk required-asterisk"></i></label>
						<input type="text" class="form-control" name="guardian_first_medical" placeholder="Enter guardian's first name" id="guardian_first_medical"/>
						<input type="text" class="form-control" name="guardian_middle_medical" placeholder="Enter guardian's middle name" id="guardian_middle_medical"/>
						<input type="text" class="form-control" name="guardian_last_medical" placeholder="Enter guardian's last name" id="guardian_last_medical"/>
					</div>
					<div class="form-group signup">
						<label>Relationship: <i class="fa fa-asterisk required-asterisk"></i></label>
						<input type="text" class="form-control" name="guardian_relationship_medical" placeholder="Enter relationship with guardian" id="guardian_relationship_medical"/>
					</div>
					<div class="form-inline signup">
						<label>Address: <i class="fa fa-asterisk required-asterisk"></i></label>
						<input type="text" class="form-control" name="guardian_street_medical" placeholder="Street" id="guardian_street_medical"/>
						<input type="text" class="form-control" name="guardian_town_medical" placeholder="Town / City" id="guardian_town_medical"/>
						<input type="text" class="form-control" name="guardian_province_medical" placeholder="Province" id="guardian_province_medical"/>
					</div>
					<div class="form-group signup">
						<div class="form-inline">
							<label>Residence Telephone Number:</label>
							<input type="text" class="form-control" name="guardianresidencetelephone_medical" id="guardianresidencetelephone_medical"/>
							<label>Residence Cellphone Number: <i class="fa fa-asterisk required-asterisk"></i></label>
							<input type="text" class="form-control" name="guardianresidencecellphone_medical" id="guardianresidencecellphone_medical"/>
						</div>
					</div>
				</div>
				<div class="form-group signup4_medical">
					<label>PAST MEDICAL HISTORY</label><br/>
					<div class="form-group signup">
						<label>Past illnesses since birth: <i class="fa fa-asterisk required-asterisk"></i></label>
						<input type="text" class="form-control" name="illness_history_medical" placeholder="Enter past illnesses since birth" id="illness_history_medical"/>
					</div>
					<div class="form-group signup">
						<label>Operation undergone since birth: <i class="fa fa-asterisk required-asterisk"></i></label>
						<input type="text" class="form-control" name="operation_history_medical" placeholder="Enter operation undergone since birth" id="operation_history_medical"/>
					</div>
					<div class="form-group signup">
						<label>Allergies to either food or drugs: <i class="fa fa-asterisk required-asterisk"></i></label>
						<input type="text" class="form-control" name="allergies_history_medical" placeholder="Enter allergies to either food or drugs" id="allergies_history_medical"/>
					</div>
					<div class="form-group signup">
						<label>Family history of diseases: <i class="fa fa-asterisk required-asterisk"></i></label>
						<input type="text" class="form-control" name="family_history_medical" placeholder="Enter family history of diseases" id="family_history_medical"/>
					</div>
					<div class="form-group signup">
						<label>Maintenance medication: <i class="fa fa-asterisk required-asterisk"></i></label>
						<input type="text" class="form-control" name="maintenance_medication_history_medical" placeholder="Enter maintenance medication" id="maintenance_medication_history_medical"/>
					</div>
				</div>
				<p id="login_medical_error"></p>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" name="login_modal_medical" id="login_modal_medical" value="Login">
					<input type="submit" class="btn btn-info form-inline" name="signupMedical_modal" id="signupMedical_modal" value="Create Patient Account"/>
					<input type="submit" class="btn btn-default" name="signupbackMedical_modal" id="signupbackMedical_modal" value="Back"/>
					<input type="submit" class="btn btn-info" name="signupnextMedical_modal" id="signupnextMedical_modal" value="Next" disabled/>
					<input type="submit" class="btn btn-info" name="signupconfirmMedical_modal" id="signupconfirmMedical_modal" value="Confirm Sign Up" disabled />
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
<div class="modal fade" id="appointment_success" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Success!</h4>
			</div>
			<div class="modal-body">
				<p>Your appointment has been set! <a href="{{ url('/account') }}">Go to account dashboard</a>.</p>
			</div>
		</div>
	</div>
</div>
<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var displayDentalSchedule = '/displayschedule_dental';
  var displayMedicalSchedule = '/displayschedule_medical';
  var createDentalAppointment = '/createappointment_dental';
  var createMedicalAppointment = '/createappointment_medical';
</script>

@endsection