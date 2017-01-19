@extends('layouts.layout')
@section('title', 'Schedule Appointment | UP Visayas Health Services Unit')
@section('content')
<div class="container">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default" style="margin-top: 20px;">
				<div class="panel-heading">Select Type of Appointment</div>
				<div class="panel-body">
				<form class="form-inline">
					<div class="checkbox col-md-6">
						<label><input type="checkbox" name="type_dental" id="typeDental"/> Dental</label>
					</div>
					<div class="checkbox col-md-6">
						<label><input type="checkbox" name="type_medical" id="typeMedical"/> Medical</label>
					</div>
				</form>
				</div>
			</div>	
		</div>
	</div>
	<div class="container">
		<div class="col-md-6 col-md-offset-3" id="dentalAppointment0">
			<div class="panel panel-default" id="dentalAppointment">
				<div class="panel-heading">Schedule Dental Appointment</div>
					<div class="panel-body" id="dentalAppointmentPanelBody">
						<!-- <form action="" method="POST"> -->
							<div class="form-group">
								<label id="dentalNotesErrorMsg" for="dentalNotes">Reasons (e.g. molar toothace):</label>
								<textarea class="form-control" rows="5" required name="dentalNotes" id="dentalNotes"></textarea>
							</div>
							<div class="form-group">
								<label for="selectdentaldate" id="selectdentaldateErrorMsg" >Date:</label>
								<select class="form-control" required id="selectdentaldate">
									<option disabled selected> -- select date of appointment -- </option>
									<option>{{ Carbon\Carbon::tomorrow()->format('Y-m-d') }}</option>
									<option>{{ Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}</option>
									<option>{{ Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}</option>
									<option>{{ Carbon\Carbon::now()->addDays(4)->format('Y-m-d') }}</option>
									<option>{{ Carbon\Carbon::now()->addDays(5)->format('Y-m-d') }}</option>
								</select>
							</div>
							<div class="form-group">
								<label id="selectdentaltimeErrorMsg">Doctor and Time:</label>
								<select disabled class="form-control" required id="selectdentaltime">
									<option disabled selected> -- select doctor and time -- </option>
								</select>
							</div>
							<button class="btn btn-success" name="submitdentalappointment" id="submitdentalappointment">Set Appointment</button>
						<!-- </form> -->
					</div>
			</div>	
		</div>
		<div class="col-md-6 col-md-offset-3" id="medicalAppointment0">
			<div class="panel panel-default" id="medicalAppointment">
				<div class="panel-heading">Schedule Medical Appointment</div>
				<div class="panel-body" id="medicalAppointmentPanelBody">
					<!-- <form action="" method="POST"> -->
					<div class="form-group">
						<label for="medicalNotes">Reasons (e.g. physical pain felt):</label>
						<textarea class="form-control" rows="5" id="medicalNotes"></textarea>
					</div>
					<div class="form-group">
						<label for="selectmedicaldate">Date:</label>
						<select class="form-control" required id="selectmedicaldate">
							<option disabled selected> -- select date of appointment -- </option>
							<option>{{ Carbon\Carbon::tomorrow()->format('Y-m-d') }}</option>
							<option>{{ Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}</option>
							<option>{{ Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}</option>
							<option>{{ Carbon\Carbon::now()->addDays(4)->format('Y-m-d') }}</option>
							<option>{{ Carbon\Carbon::now()->addDays(5)->format('Y-m-d') }}</option>
						</select>
					</div>
					<div class="form-group">
						<label>Doctor:</label>
						<select disabled class="form-control" required id="selectmedicaldoctor">
							<option disabled selected> -- select doctor -- </option>
						</select>
					</div>
					<p id="medicalFormNote"><i>Note: Medical appointment done online is for note-taking purposes of the doctor.  On-site visit will still be accommodated first.</i></p>
					<button class="btn btn-success" name="submitmedicalappointment" id="submitmedicalappointment">Set Appointment</button>
					<!-- </form> -->
				</div>
			</div>	
		</div>
	</div>

	<!-- SIGN UP MODAL FOR DENTAL APPOINTMENTS -->
	<div class="modal fade" id="loginmodaldental" role="dialog">
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
						<input type="text" class="form-control signup0_dental" name="user_name_modal_dental" id="user_name_modal_dental" placeholder="Username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control signup0_dental" name="password_modal_dental" id="password_modal_dental" placeholder="Password">
					</div>
					<div class="form-group signup">
						<input type="text" class="form-control signup1_dental" name="first_name_dental" id="first_name_dental" placeholder="First Name">
					</div>
					<div class="form-group signup">
						<input type="text" class="form-control signup1_dental" name="middle_name_dental" id="middle_name_dental" placeholder="Middle Name">
					</div>
					<div class="form-group signup">
						<input type="text" class="form-control signup1_dental" name="last_name_dental" id="last_name_dental" placeholder="Last Name">
					</div>
					<div class="form-group signup2_dental">
						<div class="form-group signup">
							<label>Type of patient:</label><br/>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_student">Student</label>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_faculty">Faculty</label>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_staff">Staff</label>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_dependent">Dependent</label>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_opd">Non-UPV / Out-patient</label>
						</div>
						<label>PERSONAL DATA</label><br/>
						<div class="">
							<div class="form-group signup">
								<label>Age:</label>
								<input type="text" class="form-control" placeholder="Enter age" name="age_dental" id="age_dental" placeholder="Enter age"/>
							</div>
							<div class="form-group signup">
								<label>Sex:</label>
								<label class="radio-inline"><input type="radio" name="sex_dental">Female</label>
								<label class="radio-inline"><input type="radio" name="sex_dental">Male</label>
							</div>
							<div class="form-group signup">
								<label>Year Level:</label>
								<input type="text" class="form-control" placeholder="Enter year level" name="yearlevel_dental" id="yearlevel_dental" placeholder="Enter year level"/>
							</div>
							<div class="form-group signup">
								<label>Degree Program:</label>
								<select class = "form-control" name="degree_program_dental" id="degree_program_dental" required title="Select the degree program you are currently enrolled in.">
									<option disabled selected> -- select degree program -- </option>
									<optgroup label="College of Arts and Sciences">
										<option value="9">BS Applied Mathematics</option>
										<option value="10">BS Biology</option>
										<option value="13">BS Chemistry</option>
										<option value="1">BA Communication and Media Studies</option>
										<option value="2">BA Community Development</option>
										<option value="14">BS Computer Science</option>
										<option value="15">BS Economics</option>
										<option value="3">BA History</option>
										<option value="4">BA Literature</option>
										<option value="5">BA Political Science</option>
										<option value="6">BA Psychology</option>
										<option value="19">BS Public Health</option>
										<option value="7">BA Sociology</option>
										<option value="20">BS Statistics</option>
										</optgroup>
									<optgroup label="College of Fisheries and Ocean Sciences">
										<option value="16">BS Fisheries</option>
									</optgroup>
									<optgroup label="College of Management">
										<option value="8">BS Accountancy</option>
										<option value="11">BS Business Administration (Marketing)</option>
										<option value="18">BS Management</option>
									</optgroup>
									<optgroup label="School of Technology">
										<option value="12">BS Chemical Engineering</option>
										<option value="17">BS Food Technology</option>
									</optgroup>
								</select>
							</div>
							<div class="form-group signup">
								<label>Date of Birth:</label>
								<input type="date" class="form-control" name="birthdate_dental" id="birthdate_dental"/>
							</div>
							<div class="form-group signup">
								<label>Religion:</label>
								<input type="text" class="form-control" placeholder="Enter religion" name="religion_dental" id="religion_dental"/>
							</div>
							<div class="form-group signup">
								<label>Nationality:</label>
								<input type="text" class="form-control" name="nationality_dental" placeholder="Enter nationality" id="nationality_dental"/>
							</div>
							<div class="form-group signup">
								<label>Father:</label>
								<input type="text" class="form-control" name="father_dental" placeholder="Enter father name" id="father_dental"/>
							</div>
							<div class="form-group signup">
								<label>Mother:</label>
								<input type="text" class="form-control" name="mother_dental" placeholder="Enter mother name" id="mother_dental"/>
							</div>
							<div class="form-group signup">
								<label>Home Address:</label>
								<div class="form-inline">
									<input type="text" class="form-control" name="street_dental" id="street_dental" placeholder="Street"/>
									<input type="text" class="form-control" name="town_dental" id="town_dental" placeholder="Town / City"/>
									<input type="text" class="form-control" name="province_dental" id="province_dental" placeholder="Province"/>
								</div>
							</div>
							<div class="form-inline">
								<label>Residence Telephone Number:</label>
								<input type="text" class="form-control" name="residencetelephonedentcal" id="residencetelephone_dental"/>
								<label>Residence Cellphone Number:</label>
								<input type="text" class="form-control" name="residencecellphone_dental" id="residencecellphone_dental"/>
								<label>Personal Contact Number:</label>
								<input type="text" class="form-control" name="personalcontactnumber_dental" id="personalcontactnumber_dental"/>
							</div>
						</div>
					</div>
					<div class="form-group signup3_dental">
						<label>GUARDIAN/PERSON TO BE CONTACTED IN CASE OF EMERGENCY (OTHER THAN PARENTS)</label><br/>
						<div class="form-group signup">
							<label>Name:</label>
							<input type="text" class="form-control" name="guardian_name_dental" placeholder="Enter guardian name" id="guardian_name_dental"/>
						</div>
						<div class="form-group signup">
							<label>Relationship:</label>
							<input type="text" class="form-control" name="guardian_relationship_dental" placeholder="Enter relationship with guardian" id="guardian_relationship_dental"/>
						</div>
						<div class="form-group signup">
							<label>Address:</label>
							<input type="text" class="form-control" name="guardian_address_dental" placeholder="Enter guardian address" id="guardian_address_dental"/>
						</div>
						<div class="form-group signup">
							<div class="form-inline">
								<label>Residence Telephone Number:</label>
								<input type="text" class="form-control" name="guardianresidencetelephone_dental" id="guardianresidencetelephone_dental"/>
								<label>Residence Cellphone Number:</label>
								<input type="text" class="form-control" name="guardianresidencecellphone_dental" id="guardianresidencecellphone_dental"/>
							</div>
						</div>
					</div>
					<div class="form-group signup4_dental">
						<label>PAST MEDICAL HISTORY</label><br/>
						<div class="form-group signup">
							<label>Past illnesses since birth:</label>
							<input type="text" class="form-control" name="illness_history_dental" placeholder="Enter past illnesses since birth" id="illness_history_dental"/>
						</div>
						<div class="form-group signup">
							<label>Operation undergone since birth:</label>
							<input type="text" class="form-control" name="operation_history_dental" placeholder="Enter operation undergone since birth" id="operation_history_dental"/>
						</div>
						<div class="form-group signup">
							<label>Allergies to either food or drugs:</label>
							<input type="text" class="form-control" name="allergies_history_dental" placeholder="Enter allergies to either food or drugs" id="allergies_history_dental"/>
						</div>
						<div class="form-group signup">
							<label>Family history of diseases:</label>
							<input type="text" class="form-control" name="family_history_dental" placeholder="Enter family history of diseases" id="family_history_dental"/>
						</div>
						<div class="form-group signup">
							<label>Maintenance medication:</label>
							<input type="text" class="form-control" name="maintenance_medication_history_dental" placeholder="Enter maintenance medication" id="maintenance_medication_history_dental"/>
						</div>
					</div>
					<p id="loginErrorMessage"></p>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success form-inline" name="login_modal_dental" id="login_modal_dental" value="Login">
					<input type="submit" class="btn btn-info form-inline" name="signupDental_modal" id="signupDental_modal" value="Create Patient Account"/>
					<input type="submit" class="btn btn-default" name="signupbackDental_modal" id="signupbackDental_modal" value="Back"/>
					<input type="submit" class="btn btn-info" name="signupnextDental_modal" id="signupnextDental_modal" value="Next"/>
					<input type="submit" class="btn btn-info" name="signupconfirmDental_modal" id="signupconfirmDental_modal" value="Confirm Sign Up"/>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- SIGN UP MODAL FOR MEDICAL APPOINTMENTS -->
	<div class="modal fade" id="loginmodalmedical" role="dialog">
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
						<input type="text" class="form-control signup0_dental" name="user_name_modal_dental" id="user_name_modal_dental" placeholder="Username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control signup0_dental" name="password_modal_dental" id="password_modal_dental" placeholder="Password">
					</div>
					<div class="form-group signup">
						<input type="text" class="form-control signup1_dental" name="first_name_dental" id="first_name_dental" placeholder="First Name">
					</div>
					<div class="form-group signup">
						<input type="text" class="form-control signup1_dental" name="middle_name_dental" id="middle_name_dental" placeholder="Middle Name">
					</div>
					<div class="form-group signup">
						<input type="text" class="form-control signup1_dental" name="last_name_dental" id="last_name_dental" placeholder="Last Name">
					</div>
					<div class="form-group signup2_dental">
						<div class="form-group signup">
							<label>Type of patient:</label><br/>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_student">Student</label>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_faculty">Faculty</label>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_staff">Staff</label>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_dependent">Dependent</label>
							<label class="radio-inline"><input type="radio" name="patient_type_dental" id="type_dental_opd">Non-UPV / Out-patient</label>
						</div>
						<label>PERSONAL DATA</label><br/>
						<div class="">
							<div class="form-group signup">
								<label>Age:</label>
								<input type="text" class="form-control" placeholder="Enter age" name="age_dental" id="age_dental" placeholder="Enter age"/>
							</div>
							<div class="form-group signup">
								<label>Sex:</label>
								<label class="radio-inline"><input type="radio" name="sex_dental">Female</label>
								<label class="radio-inline"><input type="radio" name="sex_dental">Male</label>
							</div>
							<div class="form-group signup">
								<label>Year Level:</label>
								<input type="text" class="form-control" placeholder="Enter year level" name="yearlevel_dental" id="yearlevel_dental" placeholder="Enter year level"/>
							</div>
							<div class="form-group signup">
								<label>Degree Program:</label>
								<select class = "form-control" name="degree_program_dental" id="degree_program_dental" required title="Select the degree program you are currently enrolled in.">
									<option disabled selected> -- select degree program -- </option>
									<optgroup label="College of Arts and Sciences">
										<option value="9">BS Applied Mathematics</option>
										<option value="10">BS Biology</option>
										<option value="13">BS Chemistry</option>
										<option value="1">BA Communication and Media Studies</option>
										<option value="2">BA Community Development</option>
										<option value="14">BS Computer Science</option>
										<option value="15">BS Economics</option>
										<option value="3">BA History</option>
										<option value="4">BA Literature</option>
										<option value="5">BA Political Science</option>
										<option value="6">BA Psychology</option>
										<option value="19">BS Public Health</option>
										<option value="7">BA Sociology</option>
										<option value="20">BS Statistics</option>
										</optgroup>
									<optgroup label="College of Fisheries and Ocean Sciences">
										<option value="16">BS Fisheries</option>
									</optgroup>
									<optgroup label="College of Management">
										<option value="8">BS Accountancy</option>
										<option value="11">BS Business Administration (Marketing)</option>
										<option value="18">BS Management</option>
									</optgroup>
									<optgroup label="School of Technology">
										<option value="12">BS Chemical Engineering</option>
										<option value="17">BS Food Technology</option>
									</optgroup>
								</select>
							</div>
							<div class="form-group signup">
								<label>Date of Birth:</label>
								<input type="date" class="form-control" name="birthdate_dental" id="birthdate_dental"/>
							</div>
							<div class="form-group signup">
								<label>Religion:</label>
								<input type="text" class="form-control" placeholder="Enter religion" name="religion_dental" id="religion_dental"/>
							</div>
							<div class="form-group signup">
								<label>Nationality:</label>
								<input type="text" class="form-control" name="nationality_dental" placeholder="Enter nationality" id="nationality_dental"/>
							</div>
							<div class="form-group signup">
								<label>Father:</label>
								<input type="text" class="form-control" name="father_dental" placeholder="Enter father name" id="father_dental"/>
							</div>
							<div class="form-group signup">
								<label>Mother:</label>
								<input type="text" class="form-control" name="mother_dental" placeholder="Enter mother name" id="mother_dental"/>
							</div>
							<div class="form-group signup">
								<label>Home Address:</label>
								<div class="form-inline">
									<input type="text" class="form-control" name="street_dental" id="street_dental" placeholder="Street"/>
									<input type="text" class="form-control" name="town_dental" id="town_dental" placeholder="Town / City"/>
									<input type="text" class="form-control" name="province_dental" id="province_dental" placeholder="Province"/>
								</div>
							</div>
							<div class="form-inline">
								<label>Residence Telephone Number:</label>
								<input type="text" class="form-control" name="residencetelephonedentcal" id="residencetelephone_dental"/>
								<label>Residence Cellphone Number:</label>
								<input type="text" class="form-control" name="residencecellphone_dental" id="residencecellphone_dental"/>
								<label>Personal Contact Number:</label>
								<input type="text" class="form-control" name="personalcontactnumber_dental" id="personalcontactnumber_dental"/>
							</div>
						</div>
					</div>
					<div class="form-group signup3_dental">
						<label>GUARDIAN/PERSON TO BE CONTACTED IN CASE OF EMERGENCY (OTHER THAN PARENTS)</label><br/>
						<div class="form-group signup">
							<label>Name:</label>
							<input type="text" class="form-control" name="guardian_name_dental" placeholder="Enter guardian name" id="guardian_name_dental"/>
						</div>
						<div class="form-group signup">
							<label>Relationship:</label>
							<input type="text" class="form-control" name="guardian_relationship_dental" placeholder="Enter relationship with guardian" id="guardian_relationship_dental"/>
						</div>
						<div class="form-group signup">
							<label>Address:</label>
							<input type="text" class="form-control" name="guardian_address_dental" placeholder="Enter guardian address" id="guardian_address_dental"/>
						</div>
						<div class="form-group signup">
							<div class="form-inline">
								<label>Residence Telephone Number:</label>
								<input type="text" class="form-control" name="guardianresidencetelephone_dental" id="guardianresidencetelephone_dental"/>
								<label>Residence Cellphone Number:</label>
								<input type="text" class="form-control" name="guardianresidencecellphone_dental" id="guardianresidencecellphone_dental"/>
							</div>
						</div>
					</div>
					<div class="form-group signup4_dental">
						<label>PAST MEDICAL HISTORY</label><br/>
						<div class="form-group signup">
							<label>Past illnesses since birth:</label>
							<input type="text" class="form-control" name="illness_history_dental" placeholder="Enter past illnesses since birth" id="illness_history_dental"/>
						</div>
						<div class="form-group signup">
							<label>Operation undergone since birth:</label>
							<input type="text" class="form-control" name="operation_history_dental" placeholder="Enter operation undergone since birth" id="operation_history_dental"/>
						</div>
						<div class="form-group signup">
							<label>Allergies to either food or drugs:</label>
							<input type="text" class="form-control" name="allergies_history_dental" placeholder="Enter allergies to either food or drugs" id="allergies_history_dental"/>
						</div>
						<div class="form-group signup">
							<label>Family history of diseases:</label>
							<input type="text" class="form-control" name="family_history_dental" placeholder="Enter family history of diseases" id="family_history_dental"/>
						</div>
						<div class="form-group signup">
							<label>Maintenance medication:</label>
							<input type="text" class="form-control" name="maintenance_medication_history_dental" placeholder="Enter maintenance medication" id="maintenance_medication_history_dental"/>
						</div>
					</div>
					<p id="loginErrorMessage"></p>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success form-inline" name="login_modal_dental" id="login_modal_dental" value="Login">
					<input type="submit" class="btn btn-info form-inline" name="signupDental_modal" id="signupDental_modal" value="Create Patient Account"/>
					<input type="submit" class="btn btn-default" name="signupbackDental_modal" id="signupbackDental_modal" value="Back"/>
					<input type="submit" class="btn btn-info" name="signupnextDental_modal" id="signupnextDental_modal" value="Next"/>
					<input type="submit" class="btn btn-info" name="signupconfirmDental_modal" id="signupconfirmDental_modal" value="Confirm Sign Up"/>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="loginMedicalModal" role="dialog">
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
						<input type="text" class="form-control" name="user_name_modal_medical" id="user_name_modal_medical" placeholder="Username">
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
					</div>
						<!-- HIDDEN -->
					<div class="form-group signup2_medical">
						<div class="form-group signup">
							<label>Type of patient:</label><br/>
							<label class="radio-inline"><input type="radio" id="type_medical_student" name="patient_type_medical" value="1"/>Student</label>
							<label class="radio-inline"><input type="radio" id="type_medical_faculty" name="patient_type_medical" value="2"/>Faculty</label>
							<label class="radio-inline"><input type="radio" id="type_medical_staff" name="patient_type_medical" value="3"/>Staff</label>
							<label class="radio-inline"><input type="radio" id="type_medical_dependent" name="patient_type_medical" value="4"/>Dependent</label>
							<label class="radio-inline"><input type="radio" id="type_medical_opd" name="type_medical_opd" value="5"/>Non-UPV / Out-patient</label>
						</div>
						<label>PERSONAL DATA</label><br/>
						<div class="">
							<div class="form-group signup">
								<label>Age:</label>
								<input type="text" class="form-control" name="age_medical" id="age_medical" placeholder="Enter age"/>
							</div>
							<div class="form-group signup">
								<label>Sex:</label>
								<label class="radio-inline"><input type="radio" value="Female" name="sex_medical">Female</label>
								<label class="radio-inline"><input type="radio" value="Male" name="sex_medical">Male</label>
							</div>
							<div class="form-group signup">
								<label>Year Level:</label>
								<input type="text" class="form-control" name="yearlevel_medical" id="yearlevel_medical" placeholder="Enter year level"/>
							</div>
							<div class="form-group signup">
								<label>Degree Program:</label>
								<select class = "form-control" name="degree_program_medical" id="degree_program_medical" required title="Select the degree program you are currently enrolled in.">
									<option disabled selected> -- select degree program -- </option>
									<optgroup label="College of Arts and Sciences">
										<option value="9">BS Applied Mathematics</option>
										<option value="10">BS Biology</option>
										<option value="13">BS Chemistry</option>
										<option value="1">BA Communication and Media Studies</option>
										<option value="2">BA Community Development</option>
										<option value="14">BS Computer Science</option>
										<option value="15">BS Economics</option>
										<option value="3">BA History</option>
										<option value="4">BA Literature</option>
										<option value="5">BA Political Science</option>
										<option value="6">BA Psychology</option>
										<option value="19">BS Public Health</option>
										<option value="7">BA Sociology</option>
										<option value="20">BS Statistics</option>
									</optgroup>
									<optgroup label="College of Fisheries and Ocean Sciences">
										<option value="16">BS Fisheries</option>
									</optgroup>
									<optgroup label="College of Management">
										<option value="8">BS Accountancy</option>
										<option value="11">BS Business Administration (Marketing)</option>
										<option value="18">BS Management</option>
									</optgroup>
									<optgroup label="School of Technology">
										<option value="12">BS Chemical Engineering</option>
										<option value="17">BS Food Technology</option>
									</optgroup>
								</select>
							</div>
							<div class="form-group signup">
								<label>Date of Birth:</label>
								<input type="date" class="form-control" name="birthdate_medical" id="birthdate_medical"/>
							</div>
							<div class="form-group signup">
								<label>Religion:</label>
								<input type="text" class="form-control" name="religion_medical" id="religion_medical"/>
							</div>
							<div class="form-group signup">
								<label>Nationality:</label>
								<input type="text" class="form-control" name="nationality_medical" id="nationality_medical"/>
							</div>
							<div class="form-group signup">
								<label>Father:</label>
								<input type="text" class="form-control" name="father_medical" id="father_medical"/>
							</div>
							<div class="form-group signup">
								<label>Mother:</label>
								<input type="text" class="form-control" name="mother_medical" id="mother_medical"/>
							</div>
							<div class="form-group signup">
								<label>Home Address:</label>
								<div class="form-inline">
									<input type="text" class="form-control" name="street_medical" id="street_medical" placeholder="Street"/>
									<input type="text" class="form-control" name="town_medical" id="town_medical" placeholder="Town / City"/>
									<input type="text" class="form-control" name="province_medical" id="province_medical" placeholder="Province"/>
								</div>
							</div>
							<div class="form-inline">
								<label>Residence Telephone Number:</label>
								<input type="text" class="form-control" name="residencetelephone_medical" id="residencetelephone_medical"/>
								<label>Residence Cellphone Number:</label>
								<input type="text" class="form-control" name="residencecellphone_medical" id="residencecellphone_medical"/>
								<label>Personal Contact Number:</label>
								<input type="text" class="form-control" name="personalcontactnumber_medical" id="personalcontactnumber_medical"/>
							</div>
						</div>
					</div>
					<div class="form-group signup3_medical">
						<label>GUARDIAN/PERSON TO BE CONTACTED IN CASE OF EMERGENCY (OTHER THAN PARENTS)</label><br/>
						<div class="form-group signup">
							<label>Name:</label>
							<input type="text" class="form-control" name="guardian_name_medical" id="guardian_name_medical"/>
						</div>
						<div class="form-group signup">
							<label>Relationship:</label>
							<input type="text" class="form-control" name="guardian_relationship_medical" id="guardian_relationship_medical"/>
						</div>
						<div class="form-group signup">
							<label>Address:</label>
							<input type="text" class="form-control" name="guardian_address_medical" id="guardian_address_medical"/>
						</div>
						<div class="form-group signup">
							<div class="form-inline">
								<label>Residence Telephone Number:</label>
								<input type="text" class="form-control" name="guardianresidencetelephone_medical" id="guardianresidencetelephone_medical"/>
								<label>Residence Cellphone Number:</label>
								<input type="text" class="form-control" name="guardianresidencecellphone_medical" id="guardianresidencecellphone_medical"/>
							</div>
						</div>
					</div>
					<div class="form-group signup4_medical">
						<label>PAST MEDICAL HISTORY</label><br/>
						<div class="form-group signup">
							<label>Past illnesses since birth:</label>
							<input type="text" class="form-control" name="illness_history_medical" id="illness_history_medical"/>
						</div>
						<div class="form-group signup">
							<label>Operation undergone since birth:</label>
							<input type="text" class="form-control" name="operation_history_medical" id="operation_history_medical"/>
						</div>
						<div class="form-group signup">
							<label>Allergies to either food or drugs:</label>
							<input type="text" class="form-control" name="allergies_history_medical" id="allergies_history_medical"/>
						</div>
						<div class="form-group signup">
							<label>Family history of diseases:</label>
							<input type="text" class="form-control" name="family_history_medical" id="family_history_medical"/>
						</div>
						<div class="form-group signup">
							<label>Maintenance medication:</label>
							<input type="text" class="form-control" name="maintenance_medication_history_medical" id="maintenance_medication_history_medical"/>
						</div>
					</div>
					<p id="loginErrorMessageMedical"></p>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-success" name="login_modal_medical" id="login_modal_medical" value="Login">
					<input type="submit" class="btn btn-info form-inline" name="signupMedical_modal" id="signupMedical_modal" value="Create Patient Account"/>
					<input type="submit" class="btn btn-default" name="signupbackMedical_modal" id="signupbackMedical_modal" value="Back"/>
					<input type="submit" class="btn btn-info" name="signupnextMedical_modal" id="signupnextMedical_modal" value="Next"/>
					<input type="submit" class="btn btn-info" name="signupconfirmMedical_modal" id="signupconfirmMedical_modal" value="Confirm Sign Up"/>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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