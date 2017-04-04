@extends('layouts.layout')
@section('title', 'Add Staff Account | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
    @include('layouts.sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="adminDashboard">
      <h1 class="page-header">Admin</h1>
      <div class="col-md-9 col-md-offset-1">
        @if (session('status'))
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('status') }}
        </div>
        @endif
        <div class="panel panel-info">
          <div class="panel-heading">Add Patient Account</div>
          <div class="panel-body" id="addapatientaccountpanel">
            <form role="form" method="POST" action="{{ url('/admin/createpatientaccount') }}">
              {{ csrf_field() }}
			        <div class="form-group">
			          <input required type="text" class="form-control" name="user_name" id="user_name" autofocus placeholder="User ID (201312345)"/>
			        </div>
			        <div class="form-group">
			          <input required type="password" class="form-control" name="password" id="password" placeholder="Password"/>
			        </div>
			        <div class="form-group">
			          <input required type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name"/>
			        </div>
			        <div class="form-group">
			          <input required type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle Name"/>
			        </div>
			        <div class="form-group">
			          <input required type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name"/>
			        </div>
			        <div class="form-group">
			          <div class="form-group">
			            <label>Type of patient:</label><br/>
			            <label class="radio-inline"><input required type="radio" name="patient_type_medical" value="1">Student</label>
			            <label class="radio-inline"><input required type="radio" name="patient_type_medical" value="2">Faculty</label>
			            <label class="radio-inline"><input required type="radio" name="patient_type_medical" value="3">Staff</label>
			            <label class="radio-inline"><input required type="radio" name="patient_type_medical" value="4">Dependent</label>
			            <label class="radio-inline"><input required type="radio" name="patient_type_medical" value="5">Non-UPV / Out-patient</label>
			          </div>
			          <label>PERSONAL DATA</label><br/>
			          <div class="">
			            <div class="form-group">
			              <label>Sex:</label>
			              <label class="radio-inline"><input required type="radio" value="F" name="sex">Female</label>
			              <label class="radio-inline"><input required type="radio" value="M" name="sex">Male</label>
			            </div>
			            <div class="form-group">
			              <label>Year Level:</label>
			              <input type="text" class="form-control" name="yearlevel_medical" id="yearlevel_medical" placeholder="Enter year level" disabled/>
			            </div>
			            <div class="form-group">
			              <label>Degree Program:</label>
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
			            <div class="form-group">
			              <label>Date of Birth:</label>
			              <input required type="date" class="form-control" name="birthdate_medical" id="birthdate_medical"/>
			            </div>
			            <div class="form-group" id="senior_citizen">
			              <label>Senior Citizen ID # (For out-patients only):</label>
			              <input type="text" class="form-control" name="senior_citizen_id_medical" id="senior_citizen_id_medical" placeholder="Enter senior citizen ID number" disabled/>
			            </div>
			            <div class="form-group">
			              <label>Civil Status:</label>
			              <select class="form-control" name="civil_status" id="civil_status" required>
			                <option value="Single">Single</option>
			                <option value="Married">Married</option>
			                <option value="Separated">Separated</option>
			                <option value="Divorced">Divorced</option>
			                <option value="Widowed">Widowed</option>
			              </select>
			            </div>
			            <div class="form-group">
			              <label>Religion:</label>
			              <input required type="text" class="form-control" placeholder="Enter religion" name="religion" id="religion"/>
			            </div>
			            <div class="form-group">
			              <label>Nationality:</label>
			              <input required type="text" class="form-control" name="nationality" placeholder="Enter nationality" id="nationality"/>
			            </div>
			            <div class="form-group">
			              <label>Father:</label>
			              <input required type="text" class="form-control" name="father_first" placeholder="Enter father's given name" id="father_first"/>
			              <input required type="text" class="form-control" name="father_middle" placeholder="Enter father's middle name" id="father_middle"/>
			              <input required type="text" class="form-control" name="father_last" placeholder="Enter father's last name" id="father_last"/>
			            </div>
			            <div class="form-group">
			              <label>Mother:</label>
			              <input required type="text" class="form-control" name="mother_first" placeholder="Enter mother's first name" id="mother_first"/>
			              <input required type="text" class="form-control" name="mother_middle" placeholder="Enter mother's middle name" id="mother_middle"/>
			              <input required type="text" class="form-control" name="mother_last" placeholder="Enter mother's last name" id="mother_last"/>
			            </div>
			            <div class="form-group">
			              <label>Home Address:</label>
			              <div class="form-inline">
			                <input required type="text" class="form-control" name="street" id="street" placeholder="Street"/>
			                <input required type="text" class="form-control" name="town" id="town" placeholder="Town / City"/>
			                <input required type="text" class="form-control" name="province" id="province" placeholder="Province"/>
			              </div>
			            </div>
			            <div class="form-inline">
			              <label>Residence Telephone Number:</label>
			              <input required type="text" class="form-control" name="residencetelephonedentcal" id="residencetelephone"/>
			              <label>Residence Cellphone Number:</label>
			              <input required type="text" class="form-control" name="residencecellphone" id="residencecellphone"/>
			              <label>Personal Contact Number:</label>
			              <input required type="text" class="form-control" name="personalcontactnumber" id="personalcontactnumber"/>
			            </div>
			          </div>
			        </div>
			        <div class="form-group">
			          <label>GUARDIAN/PERSON TO BE CONTACTED IN CASE OF EMERGENCY (OTHER THAN PARENTS)</label><br/>
			          <div class="form-group">
			            <label>Name:</label>
			            <input required type="text" class="form-control" name="guardian_first" placeholder="Enter guardian's first name" id="guardian_first"/>
			            <input required type="text" class="form-control" name="guardian_middle" placeholder="Enter guardian's middle name" id="guardian_middle"/>
			            <input required type="text" class="form-control" name="guardian_last" placeholder="Enter guardian's last name" id="guardian_last"/>
			          </div>
			          <div class="form-group">
			            <label>Relationship:</label>
			            <input required type="text" class="form-control" name="guardian_relationship" placeholder="Enter relationship with guardian" id="guardian_relationship"/>
			          </div>
			          <div class="form-inline">
			            <label>Address:</label>
			            <input required type="text" class="form-control" name="guardian_street" placeholder="Street" id="guardian_street"/>
			            <input required type="text" class="form-control" name="guardian_town" placeholder="Town / City" id="guardian_town"/>
			            <input required type="text" class="form-control" name="guardian_province" placeholder="Province" id="guardian_province"/>
			          </div>
			          <div class="form-group">
			            <div class="form-inline">
			              <label>Residence Telephone Number:</label>
			              <input required type="text" class="form-control" name="guardianresidencetelephone" id="guardianresidencetelephone"/>
			              <label>Residence Cellphone Number:</label>
			              <input required type="text" class="form-control" name="guardianresidencecellphone" id="guardianresidencecellphone"/>
			            </div>
			          </div>
			        </div>
			        <div class="form-group">
			          <label>PAST MEDICAL HISTORY</label><br/>
			          <div class="form-group">
			            <label>Past illnesses since birth:</label>
			            <input required type="text" class="form-control" name="illness_history" placeholder="Enter past illnesses since birth" id="illness_history"/>
			          </div>
			          <div class="form-group">
			            <label>Operation undergone since birth:</label>
			            <input required type="text" class="form-control" name="operation_history" placeholder="Enter operation undergone since birth" id="operation_history"/>
			          </div>
			          <div class="form-group">
			            <label>Allergies to either food or drugs:</label>
			            <input required type="text" class="form-control" name="allergies_history" placeholder="Enter allergies to either food or drugs" id="allergies_history"/>
			          </div>
			          <div class="form-group">
			            <label>Family history of diseases:</label>
			            <input required type="text" class="form-control" name="family_history" placeholder="Enter family history of diseases" id="family_history"/>
			          </div>
			          <div class="form-group">
			            <label>Maintenance medication:</label>
			            <input required type="text" class="form-control" name="maintenance_medication_history" placeholder="Enter maintenance medication" id="maintenance_medication_history"/>
			          </div>
			        </div>
			        <button type="submit" class="btn btn-primary">Add Patient</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection