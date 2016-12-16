@extends('layouts.layout')
@section('title', 'Search Patient | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="cashierSearchPatient">
			<div class="col-md-4 col-md-offset-4" style="text-align: center;">
				<h4>Search Patient Record</h4>
				<input class="form-control" type="text" name="searchPatient" id="searchPatient"/>
				<table id="searchTable" class="table" style="display: none">
					<tr><th>Search Results</th></tr>
					<tbody id="searchResults" >
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="searchPatientRecordInfo" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Patient Information</h3>
      </div>
      <div class="modal-body">
        <div class="row" id="remarkModal">
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Personal Data</div>
              <div class="panel-body">
                <table class="table" style="margin-bottom: 0px;">
                  <tbody>
                    <tr><td>Age</td><td id="ageTd"></td></tr>
                    <tr><td>Sex</td><td id="sexTd"></td></tr>
                    <tr><td>Course</td><td id="courseTd"></td></tr>
                    <tr><td>Year Level</td><td id="yearlevelTd"></td></tr>
                    <tr><td>Date of Birth</td><td id="birthdateTd"></td></tr>
                    <tr><td>Religion</td><td id="religionTd"></td></tr>
                    <tr><td>Nationality</td><td id="nationalityTd"></td></tr>
                    <tr><td>Father</td><td id="fatherTd"></td></tr>
                    <tr><td>Mother</td><td id="motherTd"></td></tr>
                    <tr><td>Home Address</td><td id="homeaddressTd"></td></tr>
                    <tr><td>Residence Telephone Number</td><td id="restelTd"></td></tr>
                    <tr><td>Personal Contact Number</td><td id="personalcontactnumberTd"></td></tr>
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
                    <tr><td>Name</td><td id="guardiannameTd"></td></tr>
                    <tr><td>Address</td><td id="guardianaddressTd"></td></tr>
                    <tr><td>Relationship</td><td id="guardianrelationshipTd"></td></tr>
                    <tr><td>Residence Telephone Number</td><td id="guardiantelTd"></td></tr>
                    <tr><td>Cellphone Number</td><td id="guardiancpTd"></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" id="patientInfoModalFooter">
      </div>
    </div>
  </div>
</div>
@endsection