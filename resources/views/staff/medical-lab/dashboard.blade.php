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
			<h2 class="sub-header">Requests for Laboratory Examination</h2>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Date</th>
              <th>Requestor</th>
              <th></th>
            </tr>

          </thead>
          <tbody>
            <tr>
              <td id="patient_name">John Mission</p></td>
              <td>December 13, 2016</td>
              <td>Patrick Garcia</td>
              <td><button class="btn btn-primary btn-xs addLaboratoryResult">Add Laboratory Result</button></td>
            </tr>
          </tbody>
        </table>
      </div>
		</div>
	</div>
</div>

<div class="modal fade" id="add-laboratory-result" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Laboratory Exam</h4>
        <div class="modal-body">
          <!-- LABORATORY RESULT -->
          <div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
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
                    <label for="hemoglobin-lab">Hemoglobin:</label>
                    <input type="text" class="form-control" id="hemoglobin-lab">
                  </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="hemasocrit-lab">Hemasocrit:</label>
                    <input type="text" class="form-control" id="hemasocrit-lab">
                  </div>
                </div>
                <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-2">
                  <div class="form-group">
                    <label for="wbc-lab">WBC:</label>
                    <input type="text" class="form-control" id="wbc-lab">
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
                    <label for="pus-cells-lab">Pus Cells:</label>
                    <input type="text" class="form-control" id="pus-cells-lab">
                  </div>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="rbc-lab">RBC:</label>
                    <input type="text" class="form-control" id="rbc-lab">
                  </div>
                </div>
                <div class="col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 col-xs-5 col-xs-offset-2">
                  <div class="form-group">
                    <label for="albumin-lab">Albumin:</label>
                    <input type="text" class="form-control" id="albumin-lab">
                  </div>
                </div>
                 <div class="col-md-5 col-sm-5 col-xs-5">
                  <div class="form-group">
                    <label for="sugar-lab">Sugar:</label>
                    <input type="text" class="form-control" id="sugar-lab">
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
                    <label for="macroscopic-lab">Macroscopic:</label>
                    <input type="text" class="form-control" id="macroscopic-lab">
                  </div>
                </div>
                <div class="col-md-10 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-2">
                  <div class="form-group">
                    <label for="microscopic-lab">Microscopic (Parasites):</label>
                    <input type="text" class="form-control" id="microscopic-lab">
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
                    <input type="text" class="form-control" id="drug-test-lab">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addLabResultButton">Add Laboratory Results</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection