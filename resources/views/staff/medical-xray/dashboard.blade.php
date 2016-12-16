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
			<h2 class="sub-header">Requests for X-Ray Examination</h2>
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
              <td id="patient_name">John Mission></p></td>
              <td>December 16, 2016</td>
              <td>Patrick Garcia</td>
              <td><button class="btn btn-primary btn-xs addXrayResult">Add X-Ray Result</button></td>
            </tr>
          </tbody>
        </table>
      </div>
	</div>
</div>


<div class="modal fade" id="add-xray-result" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Laboratory Exam</h4>
      </div>
      <div class="modal-body">

        <!-- XRAY RESULT -->
        <div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
          <h4>X-Ray Result</h4>
          <form>
            <div class="row">
              <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="form-group">
                  <label>Chest X-Ray:</label>
                </div>
              </div>
              <div class="col-md-10 col-sm-10 col-xs-10">
                <div class="form-group">
                  <input type="text" class="form-control" id="chest-xray-xray">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addXrayResultButton">Add X-Ray Results</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection