@extends('layouts.layout')
@section('title', 'Edit Profile | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<form method="POST" action="/account/profile/update" enctype="multipart/form-data" id="patient-edit-profile">
				{{ csrf_field() }}
				<div class="col-md-9">
					<div class="panel panel-info">
						<div class="panel-heading">Basic Information</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										<tr>
											<td>Sex</td>
											<td>
												<select class="form-control" name="sex" id="sex" required>
													<option value="F" @if($sex=="F") selected @endif>F</option>
													<option value="M" @if($sex=="M") selected @endif>M</option>
												</select>
											</td>
										</tr>
										@if(Auth::user()->patient->patient_type_id == 1)
										<tr>
											<td>Course</td>
											<td>
												<select class="form-control" name="degree_program" id="degree_program" required title="Select your degree program.">
													<option disabled selected>select degree program</option>
													<optgroup label="College of Arts and Sciences">
														<option value="8" @if($degree_program=="8") selected @endif>BS Applied Mathematics</option>
														<option value="9" @if($degree_program=="9") selected @endif>BS Biology</option>
														<option value="10" @if($degree_program=="10") selected @endif>BS Chemistry</option>
														<option value="7" @if($degree_program=="7") selected @endif>BA Communication and Media Studies</option>
														<option value="1" @if($degree_program=="1") selected @endif>BA Community Development</option>
														<option value="11" @if($degree_program=="11") selected @endif>BS Computer Science</option>
														<option value="12" @if($degree_program=="12") selected @endif>BS Economics</option>
														<option value="2" @if($degree_program=="2") selected @endif>BA History</option>
														<option value="3" @if($degree_program=="3") selected @endif>BA Literature</option>
														<option value="4" @if($degree_program=="4") selected @endif>BA Political Science</option>
														<option value="5" @if($degree_program=="5") selected @endif>BA Psychology</option>
														<option value="13" @if($degree_program=="13") selected @endif>BS Public Health</option>
														<option value="6" @if($degree_program=="6") selected @endif>BA Sociology</option>
														<option value="14" @if($degree_program=="14") selected @endif>BS Statistics</option>
														<option value="15" @if($degree_program=="15") selected @endif>Master of Chemistry</option>
														<option value="16" @if($degree_program=="16") selected @endif>Master of Education (Biology)</option>
														<option value="17" @if($degree_program=="17") selected @endif>Master of Education (English as a Second Language)</option>
														<option value="18" @if($degree_program=="18") selected @endif>Master of Education (Filipino)</option>
														<option value="19" @if($degree_program=="19") selected @endif>Master of Education (Guidance)</option>
														<option value="20" @if($degree_program=="20") selected @endif>Master of Education (Mathematics)</option>
														<option value="21" @if($degree_program=="21") selected @endif>Master of Education (Physics)</option>
														<option value="22" @if($degree_program=="22") selected @endif>Master of Education (Reading)</option>
														<option value="23" @if($degree_program=="23") selected @endif>Master of Education (Social Studies)</option>
														<option value="24" @if($degree_program=="24") selected @endif>MS Biology</option>
													</optgroup>
													<optgroup label="College of Fisheries and Ocean Sciences">
														<option value="25" @if($degree_program=="25") selected @endif>BS Fisheries</option>
														<option value="26" @if($degree_program=="26") selected @endif>Master of Aquaculture</option>
														<option value="27" @if($degree_program=="27") selected @endif>Master of Marine Affairs</option>
														<option value="28" @if($degree_program=="28") selected @endif>MS Fisheries (Aquaculture)</option>
														<option value="29" @if($degree_program=="29") selected @endif>MS Fisheries (Fisheries Biology)</option>
														<option value="30" @if($degree_program=="30") selected @endif>MS Fisheries (Fish Processing Technology)</option>
														<option value="31" @if($degree_program=="31") selected @endif>MS Ocean Sciences</option>
														<option value="32" @if($degree_program=="32") selected @endif>Professional Masters in Tropical Marines</option>
														<option value="33" @if($degree_program=="33") selected @endif>PhD Fisheries</option>
													</optgroup>
													<optgroup label="College of Management">
														<option value="34" @if($degree_program=="34") selected @endif>BS Accountancy</option>
														<option value="35" @if($degree_program=="35") selected @endif>BS Business Administration (Marketing)</option>
														<option value="36" @if($degree_program=="36") selected @endif>BS Management</option>
														<option value="37" @if($degree_program=="37") selected @endif>Master of Management (Business Management)</option>
														<option value="38" @if($degree_program=="38") selected @endif>Master of Management (Public Management)</option>
														<option value="39" @if($degree_program=="39") selected @endif>Diploma in Urban and Regional Planning</option>
													</optgroup>
													<optgroup label="School of Technology">
														<option value="41" @if($degree_program=="41") selected @endif>BS Chemical Engineering</option>
														<option value="40" @if($degree_program=="40") selected @endif>BS Food Technology</option>
													</optgroup>
												</select>
											</td>
										</tr>
										{{-- <tr>
											<td>Year Level</td>
											<td><input type="number" class="form-control" value="{{$year_level}}" placeholder="Year Level" name="year_level" id="year_level" required/></td>
										</tr> --}}
										@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3">
						<label for="picture">Select Profile Picture</label>
						<input type="file" name="picture" id="picture" class="picture"/>
					</div>
					<div class="col-md-6">
						<div class="panel panel-info">
							<div class="panel-heading">Personal Data</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										{{-- <tr>
											<td>Date of Birth</td>
											<td><input type="date" class="form-control" value="{{$birthday}}" name="birthdate" id="birthdate" required/></td>
										</tr> --}}
										<tr>
											<td>Religion</td>
											<td><input type="text" maxlength="30" class="form-control" value="{{$religion}}" placeholder="Religion" name="religion" id="religion" required/></td>
										</tr>
										<tr>
											<td>Nationality</td>
											<td><input type="text" maxlength="30" class="form-control" value="{{$nationality}}" placeholder="Nationality" name="nationality" id="nationality" required/></td>
										</tr>
										<tr>
											<td>Father</td>
											<td>
												<input type="text" maxlength="30" class="form-control" value="{{$father_first_name}}" placeholder="Father's Given Name" name="father_first_name" id="father_first_name" required/>
												<input type="text" maxlength="30" class="form-control" value="{{$father_middle_name}}" placeholder="Father's Middle Name" name="father_middle_name" id="father_middle_name"/>
												<input type="text" maxlength="30" class="form-control" value="{{$father_last_name}}" placeholder="Father's Last Name" name="father_last_name" id="father_last_name" required/>
											</td>
										</tr>
										<tr>
											<td>Mother</td>
											<td>
												<input type="text" maxlength="30" class="form-control" value="{{$mother_first_name}}" placeholder="Mother's Given Name" name="mother_first_name" id="mother_first_name" required/>
												<input type="text" maxlength="30" class="form-control" value="{{$mother_middle_name}}" placeholder="Mother's Middle Name" name="mother_middle_name" id="mother_middle_name"/>
												<input type="text" maxlength="30" class="form-control" value="{{$mother_last_name}}" placeholder="Mother's Last Name" name="mother_last_name" id="mother_last_name" required/>
											</td>
										</tr>
										<tr>
											<td>Home Address</td>
											<td>
												<input type="text" maxlength="30" class="form-control" value="{{$street}}" name="street" id="street" placeholder="House No. / Street" required/>
												<input type="text" maxlength="30" class="form-control" value="{{$town}}" name="town" id="town" placeholder="Town / City" required/>
												<input type="text" maxlength="30" class="form-control" value="{{$province}}" name="province" id="province" placeholder="Province" required/>
											</td>
										</tr>
										<tr>
											<td>Residence Telephone Number</td>
											<td><input type="text" maxlength="30" class="form-control" value="{{$residence_telephone_number}}" name="residence_telephone_number" id="residence_telephone_number" placeholder="Residence Telephone Number" required/></td>
										</tr>
										<tr>
											<td>Residence Contact Number</td>
											<td><input type="text" maxlength="30" class="form-control" value="{{$residence_contact_number}}" name="residence_contact_number" id="residence_contact_number" placeholder="Residence Contact Number" required/></td>
										</tr>
										<tr>
											<td>Personal Contact Number</td>
											<td><input type="text" maxlength="30" class="form-control" value="{{$personal_contact_number}}" name="personal_contact_number" id="personal_contact_number" placeholder="Personal Contact Number" required/></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-info">
							<div class="panel-heading">Guardian/Person to be Contacted in Case of Emergency</div>
								<div class="panel-body">
									<table class="table" style="margin-bottom: 0px;">
										<tbody>
											<tr>
												<td>Name</td>
												<td>
													<input type="text" maxlength="30" class="form-control" value="{{$guardian_first_name}}" placeholder="Guardian's Given Name" name="guardian_first_name" id="guardian_first_name" required/>
													<input type="text" maxlength="30" class="form-control" value="{{$guardian_middle_name}}" placeholder="Guardian's Middle Name" name="guardian_middle_name" id="guardian_middle_name" />
													<input type="text" maxlength="30" class="form-control" value="{{$guardian_last_name}}" placeholder="Guardian's Last Name" name="guardian_last_name" id="guardian_last_name" required/>
												</td>
											</tr>
											<tr>
												<td>Address</td>
												<td>
													<input type="text" maxlength="30" class="form-control" value="{{$guardian_street}}" name="guardian_street" id="guardian_street" placeholder="House No. / Street" required/>
													<input type="text" maxlength="30" class="form-control" value="{{$guardian_town}}" name="guardian_town" id="guardian_town" placeholder="Town / City" required/>
													<input type="text" maxlength="30" class="form-control" value="{{$guardian_province}}" name="guardian_province" id="guardian_province" placeholder="Province" required/>
												</td>
											</tr>
											<tr>
												<td>Relationship</td>
												<td><input type="text" maxlength="30" class="form-control" value="{{$relationship}}" name="relationship" id="relationship" placeholder="Relationship" required/></td>
											</tr>
											<tr>
												<td>Residence Telephone Number</td>
												<td><input type="text" maxlength="30" class="form-control" value="{{$guardian_tel_number}}" name="guardian_tel_number" id="guardian_tel_number" placeholder="Telephone Number" required/></td>
											</tr>
											<tr>
												<td>Cellphone Number</td>
												<td><input type="text" maxlength="30" class="form-control" value="{{$guardian_cellphone}}" name="guardian_cellphone" id="guardian_cellphone" placeholder="Cellphone Number" required/></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-md-6">
						<div class="panel panel-info">
							<div class="panel-heading">Password Settings</div>
								<div class="panel-body">
									<small>Protect your account by changing your password regularly.</small>
									<input type="password" class="form-control" name="updatepassword" placeholder="Enter new password here" />
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="clearfix">
								<div class="pull-left">
									<button type="submit" class="btn btn-success">Save Changes</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
</div>

@endsection