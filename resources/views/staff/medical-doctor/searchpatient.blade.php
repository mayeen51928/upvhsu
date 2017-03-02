@extends('layouts.layout')
@section('title', 'Search Patient | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="cashierSearchPatient">
			<div class="col-md-4 col-md-offset-4" style="text-align: center;">
				<h4>Search Patient Record</h4>
        <p><i>You can also search by <a href="{{ url('/doctor/searchpatient/date') }}">date</a>.</i></p>
				<input class="form-control" type="text" name="search_patient" id="search_patient" placeholder="Enter patient's name here" />
        <br/>
        <img class="img-responsive" src="{{asset('images/loading.gif')}}" id="searchloading" style="display: none;"/>
				<table id="searchTable" class="table" style="display: none">
          <tr><th>Search Results</th></tr>
          <tbody id="searchResults">
          </tbody>
				</table>
        <table class="table" id="searchlistofallpatients">
        <tr><th>List of All Patients Who Have Existing Medical Records</th></tr>
          <tbody>
            @foreach($patients as $patient)
              <tr><td><a class="listofallpatients" id="resultId_{{$patient->patient_id}}">{{$patient->patient_last_name}}, {{$patient->patient_first_name}}</a></td></tr>
            @endforeach
          </tbody>
        </table>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="searchPatientRecordInfo" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="text-align:center; ">Patient Information</h3><img class="img-circle center-block" id="searchPatientRecordInfoImg" height="100" width="100" src="{{asset('images/blankprofpic.png')}}"/>
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
<!-- <div class="modal fade" id="viewMedicalRecordBasedOnDateModal" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h3 id="viewMedicalRecordBasedOnDateModalTitle">Detailed Patient Record</h3>
    </div>
    <div class="modal-body">
      <div class="row" id="remarkModal">
      <div class="col-xs-3 col-sm-3 col-md-3">
        <img src="images/mayenne.jpg" width="220" height="220" class="img-responsive" alt="Generic placeholder thumbnail">
      </div>
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Physical Examination</div>
          <div class="panel-body">
          <table class="table" style="margin-bottom: 0px;">
            <tbody>
               <tr><td>Height</td><td id="heightTd"></td></tr>
              <tr><td>Weight</td><td id="weightTd"></td></tr>
              <tr><td>Blood Pressure</td><td id="bpTd"></td></tr>
              <tr><td>Pulse Rate</td><td id="prTd"></td></tr>
              <tr><td>Right Eye</td><td id="righteyeTd"></td></tr>
              <tr><td>Left Eye</td><td id="lefteyeTd"></td></tr>
              <tr><td>Head</td><td id="headTd"></td></tr>
              <tr><td>EENT</td><td id="eentTd"></td></tr>
              <tr><td>Neck</td><td id="neckTd"></td></tr>
              <tr><td>Chest</td><td id="chestTd"></td></tr>
              <tr><td>Heart</td><td id="heartTd"></td></tr>
              <tr><td>Lungs</td><td id="lungsTd"></td></tr>
              <tr><td>Abdomen</td><td id="abdomenTd"></td></tr>
              <tr><td>Back</td><td id="backTd"></td></tr>
              <tr><td>Skin</td><td id="skinTd"></td></tr>
              <tr><td>Extremeties</td><td id="extremitiesTd"></td></tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">CBC Results</div>
          <div class="panel-body">
          <table class="table" style="margin-bottom: 0px;">
            <tbody>
              <tr><td>Hemoglobin</td><td id="hemoglobinTd"></td></tr>
              <tr><td>Hemasocrit</td><td id="hemasocritTd"></td></tr>
              <tr><td>WBC</td><td id="wbcTd"></td></tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Urinalysis Results</div>
          <div class="panel-body">
          <table class="table" style="margin-bottom: 0px;">
            <tbody>
              <tr><td>Pus Cells</td><td id="puscellsTd"></td></tr>
              <tr><td>RBC</td><td id="rbcTd"></td></tr>
              <tr><td>Albumin</td><td id="albuminTd"></td></tr>
              <tr><td>Sugar</td><td id="sugarTd"></td></tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Fecalysis Results</div>
          <div class="panel-body">
          <table class="table" style="margin-bottom: 0px;">
            <tbody>
              <tr><td>Macroscopic</td><td id="macroscopicTd"></td></tr>
              <tr><td>Microscopic (Parasites)</td><td id="microscopicTd"></td></tr>
            </tbody>
          </table>
          </div>
        </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Drug Test</div>
          <div class="panel-body">
          <table class="table" style="margin-bottom: 0px;">
            <tbody>
              <tr><td id="drugtestTd"></td></tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Chest X-Ray</div>
          <div class="panel-body">
          <table class="table" style="margin-bottom: 0px;">
            <tbody>
              <tr><td id="chestxrayTd"></td></tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Remarks</div>
          <div class="panel-body">
          <table class="table" style="margin-bottom: 0px;">
            <tbody>
              <tr><td id="remarksTd"></td></tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">Prescription</div>
          <div class="panel-body">
          <table class="table" style="margin-bottom: 0px;">
            <tbody>
              <tr><td id="prescriptionTd"></td></tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      </div>
      </div>
    </div>
  </div>
</div> -->
@endsection