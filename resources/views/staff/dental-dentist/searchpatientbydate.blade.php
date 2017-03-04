@extends('layouts.layout')
@section('title', 'Search Patient | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="cashierSearchPatient">
    <div class="row">
      <div class="col-md-12" style="text-align: center;">
      <h4>Search Patient Record</h4>
        <p><i>You can also search by <a href="{{ url('/dentist/searchpatient') }}">name</a>.</i></p>
      </div>
    </div>
    <div class="row">
			<div class="col-md-3 col-md-offset-1">
        <label>Month</label>
        <select class="form-control" name="search_month" id="search_month">
          <option value="00" selected></option>
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
        <label>Day</label>
        <select class="form-control" name="search_date" id="search_date" disabled>
          <option value="00" selected></option>
          <option value="01">1</option>
          <option value="02">2</option>
          <option value="03">3</option>
          <option value="04">4</option>
          <option value="05">5</option>
          <option value="06">6</option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
        <label>Year</label>
        <select class="form-control" name="search_year" id="search_year">
          {{-- <option selected disabled>Select year</option> --}}
          <option value="0000" selected></option>
          <option value="1996">1996</option>
          <option value="2017">2017</option>
        </select>
        <br/>
        <button type="button" class="form-control btn btn-info" id="searchbydatebuttondental">Search</button>
				{{-- <input class="form-control" type="text" name="search_month" id="search_month" placeholder="Month" /> --}}
        
			</div>
      <div class="col-md-7">
      <img class="img-responsive" src="{{asset('images/loading.gif')}}" id="searchloading" style="display: none;"/>
        <table id="searchTable" class="table" style="display: none">
          <tr><th colspan="3">Search Results</th></tr>
          <tbody id="searchResults">
          </tbody>
        </table>
        <table class="table" id="searchlistofallpatients">
        <tr><th>List of All Patients Who Have Existing Dental Records</th></tr>
          <tbody>
            @foreach($patients as $patient)
              <tr><td><a class="listofallpatientsdental" id="resultId_{{$patient->patient_id}}">{{$patient->patient_last_name}}, {{$patient->patient_first_name}}</a></td></tr>
            @endforeach
          </tbody>
        </table>
      </div>
      </div>
		</div>
	</div>
</div>
<div class="modal fade" id="searchPatientRecordInfoDental" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="text-align:center; ">Patient Information</h3><img class="img-circle center-block" id="searchPatientRecordInfoImg" height="100" width="100" src="{{asset('images/blankprofpic.png')}}"/>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Personal Data</div>
              <div class="panel-body">
                <table class="table" style="margin-bottom: 0px;">
                  <tbody>
                    <tr><td>Age</td><td id="ageTd"></td></tr>
                    <tr><td>Sex</td><td id="sexTd"></td></tr>
                    <tr id="courseRow" style="display: none;"><td>Course</td><td id="courseTd"></td></tr>
                    <tr id="yearlevelRow" style="display: none;"><td>Year Level</td><td id="yearlevelTd"></td></tr>
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
<div class="modal fade" id="viewDentalRecordBasedOnDateModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 id="viewDentalRecordBasedOnDateModalTitle">Detailed Patient Record</h3>
      </div>
      <div class="modal-body">












      </div>
    </div>
  </div>
</div>
@endsection