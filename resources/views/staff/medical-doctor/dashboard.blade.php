@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<h1 class="page-header">{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</h1>
			<div class="row placeholders">
				<div class="col-xs-3 col-sm-3 col-md-3 placeholder">
					<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				</div>
				<div class="col-xs-9 col-sm-9 col-md-9 placeholder">
					Info here
				</div>
			</div>
			<h2 class="sub-header">Appointments</h2>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Reasons</th>
            </tr>
          </thead>
          <tbody>
          	<tr>
              <td>John Mission</td>
              <td>Heartache</td>
              <td><button class="btn btn-primary btn-xs addMedicalRecordButton">Update Diagnosis</button></td>
              <td><button class="btn btn-primary btn-xs addBillingToMedical">Add Billing</button></td>
            </tr>
          </tbody>
        </table>
      </div>
		</div>
	</div>
</div>

  <div class="modal fade" id="create-medical-record-modal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Patient Record</h4>
          <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" id="changeProgress_MedicalDiagnosis" style="width:20%">1 of 5</div>
          </div>
        </div>
        <div class="modal-body">

          <!-- PERSONAL INFORMATION -->
          <div class="personal-information">
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-6">
                <h4>Name</h4>
                <div class="personal-information-name"></div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <h4>Reasons</h4>
                <div class="personal-information-reasons"></div>
              </div>
            </div>
          </div>


          <!-- PHYSICAL EXAMINATION -->

          <div class="physical-examination" id="physicalexamination" style="background-color:#f8f8f8; padding:5px;">
            <h4>Physical Examination</h4>
            <form>

              <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="height">Height:</label>
                    <input type="text" class="form-control" id="height">
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="weight">Weight:</label>
                    <input type="text" class="form-control" id="weight">
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="blood-pressure">Blood Pressure:</label>
                    <input type="text" class="form-control" id="blood-pressure">
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="pulse-rate">Pulse Rate:</label>
                    <input type="text" class="form-control" id="pulse-rate">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <div class="form-group">
                    <label style="margin-top:10px; text-align:center">Vision Test</label>
                  </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="right-eye">Right Eye:</label>
                    <input type="text" class="form-control" id="right-eye">
                  </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="left-eye">Left Eye:</label>
                    <input type="text" class="form-control" id="left-eye">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="head">Head:</label>
                    <input type="text" class="form-control" id="head">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="eent">EENT:</label>
                    <input type="text" class="form-control" id="eent">
                  </div>
                </div>
              </div> 

              <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label for="neck">Neck:</label>
                    <input type="text" class="form-control" id="neck">
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label for="chest">Chest:</label>
                    <input type="text" class="form-control" id="chest">
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label for="heart">Heart:</label>
                    <input type="text" class="form-control" id="heart">
                  </div>
                </div>
              </div> 

              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="lungs">Lungs:</label>
                    <input type="text" class="form-control" id="lungs">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group">
                    <label for="abdomen">Abdomen:</label>
                    <input type="text" class="form-control" id="abdomen">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label for="back">Back:</label>
                    <input type="text" class="form-control" id="back">
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label for="skin">Skin:</label>
                    <input type="text" class="form-control" id="skin">
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label for="extremities">Extremities:</label>
                    <input type="text" class="form-control" id="extremities">
                  </div>
                </div>
              </div> 
            </form>
          </div>


          <!-- LABORATORY RESULT -->

          <div class="laboratory-result" id="laboratoryresult"  style="padding:5px;">
            <h4>Laboratory Result</h4>
            <form>

              <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <div class="form-group">
                    <label>CBC:</label>
                  </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="hemoglobin">Hemoglobin:</label>
                    <input type="text" class="form-control" id="hemoglobin" disabled>
                  </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="hemasocrit">Hemasocrit:</label>
                    <input type="text" class="form-control" id="hemasocrit" disabled>
                  </div>
                </div>
                <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-2">
                  <div class="form-group">
                    <label for="wbc">WBC:</label>
                    <input type="text" class="form-control" id="wbc" disabled>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <div class="form-group">
                    <label>Urinalysis:</label>
                  </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="pus-cells">Pus Cells:</label>
                    <input type="text" class="form-control" id="pus-cells" disabled>
                  </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="rbc">RBC:</label>
                    <input type="text" class="form-control" id="rbc" disabled>
                  </div>
                </div>
                <div class="col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 col-xs-5 col-xs-offset-2">
                  <div class="form-group">
                    <label for="albumin">Albumin:</label>
                    <input type="text" class="form-control" id="albumin" disabled>
                  </div>
                </div>
                 <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="sugar">Sugar:</label>
                    <input type="text" class="form-control" id="sugar" disabled>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <div class="form-group">
                    <label>Fecalysis:</label>
                  </div>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-10">
                  <div class="form-group">
                    <label for="macroscopic">Macroscopic:</label>
                    <input type="text" class="form-control" id="macroscopic" disabled>
                  </div>
                </div>
                <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-2">
                  <div class="form-group">
                    <label for="microscopic">Microscopic (Parasites):</label>
                    <input type="text" class="form-control" id="microscopic" disabled>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <div class="form-group">
                    <label>Drug Test:</label>
                  </div>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-10">
                  <div class="form-group">
                    <input type="text" class="form-control" id="drug-test" disabled>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <div class="form-group">
                    <label>Chest X-Ray:</label>
                  </div>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-10">
                  <div class="form-group">
                    <input type="text" class="form-control" id="chest-xray" disabled>
                  </div>
                </div>
              </div>
            </form>
          </div>


          <!-- REMARKS -->

          <div class="remarks" id="remarksDiv" style="background-color:#f8f8f8; padding:5px;">
            <h4>Remarks</h4>
              <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <div class="form-group">
                    <label>Remarks:</label>
                  </div>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-10">
                  <div class="form-group">
                    <textarea class="form-control" rows="10" id="remarks"></textarea>
                  </div>
                </div>
              </div>
          </div>


          <!-- PRESCRIPTION -->

          <div class="prescription" id="prescriptionDiv" style="padding:5px;">
            <h4>Prescription</h4>
            <form>
              <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <div class="form-group">
                    <label>Prescription:</label>
                  </div>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-10">
                  <div class="form-group">
                    <textarea class="form-control" rows="10" id="prescription"></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="requestLabXray" id="requestLabXrayDiv" style="padding:5px;">
            <h4>Request for Laboratory Examination and/or X-Ray</h4>
            <form>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>Please check the laboratory request you want to make:</label>
                  </div>
                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-2">
                      <label class="checkbox-inline"><input type="checkbox" id="requestLab">Laboratory</label>
                    </div>
                    <div class="col-md-4">
                      <label class="checkbox-inline"><input type="checkbox" id="requestXray">X-Ray</label>
                    </div>
                </div>
                </div>
                
              </div>
            </form>
          </div>

        </div>
        <div class="modal-footer">
         <span style="float: left; margin-right: 4px"><button type="button" class="btn btn-info" id="backButtonMedicalDiagnosis">Back</button></span>
          <span style="float: left"><button type="button" class="btn btn-info" id="nextButtonMedicalDiagnosis">Next</button></span>
          <span class="medical-button-container"></span>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <div id="medicalBillingModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <table class="displayServices"></table>
          <div class="medical-bill-input" id="medical-bill-input-text"></div> 
        </div>
        <div class="modal-footer">
          <div class="medical-bill-confirm" id="medical-bill-confirm-button" style="text-align:center; "></div>
        </div>
      </div>
    </div>
  </div>
@endsection