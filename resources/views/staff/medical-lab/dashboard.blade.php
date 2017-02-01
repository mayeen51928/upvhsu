@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<h4 class="page-header">Welcome <i>{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</i>!</h4>
			<h3 class="sub-header">Requests for Laboratory Examination</h3>
      <p>The requests are sorted by time and date of requests, from the most recent requests.</p>
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#cbc_requests">CBC</a></li>
            <li><a data-toggle="pill" href="#drug_test_requests">Drug Test</a></li>
            <li><a data-toggle="pill" href="#fecalysis_requests">Fecalysis</a></li>
            <li><a data-toggle="pill" href="#urinalysis_requests">Urinalysis</a></li>
          </ul>
          <div class="tab-content">
            <div class="table-responsive tab-pane fade in active" id="cbc_requests">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Requestor</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cbc_requests as $cbc_request)
                  <tr>
                    <td id="patient_name">{{$cbc_request->patient_first_name}} {{$cbc_request->patient_last_name}}</p></td>
                    <td>{{date_format(date_create($cbc_request->created_at), 'F j, Y')}}</td>
                    <td>{{$cbc_request->staff_first_name}} {{$cbc_request->staff_last_name}}</td>
                    <td><button class="btn btn-primary btn-xs addLaboratoryResult">Laboratory Diagnosis</button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="table-responsive tab-pane fade" id="drug_test_requests">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Requestor</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($drug_test_requests as $drug_test_request)
                  <tr>
                    <td id="patient_name">{{$drug_test_request->patient_first_name}} {{$drug_test_request->patient_last_name}}</p></td>
                    <td>{{date_format(date_create($drug_test_request->created_at), 'F j, Y')}}</td>
                    <td>{{$drug_test_request->staff_first_name}} {{$drug_test_request->staff_last_name}}</td>
                    <td><button class="btn btn-primary btn-xs addLaboratoryResult">Laboratory Diagnosis</button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="table-responsive tab-pane fade" id="fecalysis_requests">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Patient</th>
                  <th>Date</th>
                  <th>Requestor</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($fecalysis_requests as $fecalysis_request)
                  <tr>
                    <td id="patient_name">{{$fecalysis_request->patient_first_name}} {{$fecalysis_request->patient_last_name}}</p></td>
                    <td>{{date_format(date_create($fecalysis_request->created_at), 'F j, Y')}}</td>
                    <td>{{$fecalysis_request->staff_first_name}} {{$fecalysis_request->staff_last_name}}</td>
                    <td><button class="btn btn-primary btn-xs addLaboratoryResult">Laboratory Diagnosis</button></td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          <div class="table-responsive tab-pane fade" id="urinalysis_requests">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Patient</th>
                  <th>Date</th>
                  <th>Requestor</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($urinalysis_requests as $urinalysis_request)
                  <tr>
                    <td id="patient_name">{{$urinalysis_request->patient_first_name}} {{$urinalysis_request->patient_last_name}}</p></td>
                    <td>{{date_format(date_create($urinalysis_request->created_at), 'F j, Y')}}</td>
                    <td>{{$urinalysis_request->staff_first_name}} {{$urinalysis_request->staff_last_name}}</td>
                    <td><button class="btn btn-primary btn-xs addLaboratoryResult">Laboratory Diagnosis</button></td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          </div>
        </div>
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