@extends('layouts.layout')
@section('title', 'Patient Records | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
    @include('layouts.sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="cashierSearchPatient">
      <div class="col-md-4 col-md-offset-4" style="text-align: center;">
        <h4>Search Patient Record</h4>
        <div class="accountOption">
        <a role="button" class="btn btn-success" href="{{ url('/dentist/searchpatient/date') }}">Click here to search by date</a>
        </div>
        <input class="form-control" type="text" name="search_patientdental" id="search_patientdental" placeholder="Enter patient's name here" />
        <br/>
        <img class="img-responsive center-block" src="{{asset('images/loading.gif')}}" id="searchloadingdental" style="display: none;"/>
        <table id="searchTabledental" class="table" style="display: none">
          <tr><th>Search Results</th></tr>
          <tbody id="searchResultsdental">
          </tbody>
        </table>
        <table class="table" id="searchlistofallpatientsdental">
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
            <div class="panel panel-info">
              <div class="panel-heading">Past Medical History</div>
              <div class="panel-body">
                <table class="table" style="margin-bottom: 0px;">
                  <tbody>
                    <tr><td>Past Illnesses Since Birth</td><td id="illnessesTd"></td></tr>
                    <tr><td>Operation Undergone Since Birth</td><td id="operationTd"></td></tr>
                    <tr><td>Allergies to Either Food or Drugs</td><td id="allergiesTd"></td></tr>
                    <tr><td>Family History of Diseases</td><td id="famhistoryTd"></td></tr>
                    <tr><td>Maintenance Medication</td><td id="maintenanceTd"></td></tr>
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