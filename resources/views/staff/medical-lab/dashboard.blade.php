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
              @if(count($cbc_requests)>0)
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
                    <td><button class="btn btn-info btn-xs addCbcResult" id="addCbcResult_{{$cbc_request->id}}">Diagnosis</button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @else
              <p>No requests as of the moment.</p>
              @endif
            </div>
            <div class="table-responsive tab-pane fade" id="drug_test_requests">
              @if(count($drug_test_requests)>0)
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
                    <td><button class="btn btn-info btn-xs addDrugTestResult" id="addDrugTestResult_{{$drug_test_request->id}}">Diagnosis</button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @else
              <p>No requests as of the moment.</p>
              @endif
            </div>
            <div class="table-responsive tab-pane fade" id="fecalysis_requests">
              @if(count($fecalysis_requests)>0)
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
                    <td><button class="btn btn-info btn-xs addFecalysisResult">Diagnosis</button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @else
              <p>No requests as of the moment.</p>
              @endif
            </div>
            <div class="table-responsive tab-pane fade" id="urinalysis_requests">
              @if(count($urinalysis_requests)>0)
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
                    <td><button class="btn btn-info btn-xs addUrinalysisResult">Diagnosis</button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @else
              <p>No requests as of the moment.</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- CBC Modal --}}
<div class="modal fade" id="add-cbc-result" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">CBC Diagnosis</h4>
      </div>
      <div class="modal-body">
        <div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
          <div class="form-group">
            <label for="hemoglobin-lab">Hemoglobin:</label>
            <textarea class="form-control" rows="5" name="hemoglobin-lab" id="hemoglobin-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="hemasocrit-lab">Hemasocrit:</label>
            <textarea class="form-control" rows="5" name="hemasocrit-lab" id="hemasocrit-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="wbc-lab">WBC:</label>
            <textarea class="form-control" rows="5" name="wbc-lab" id="wbc-lab" required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="addCbcResultButton">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

{{-- Drug Test Modal --}}
<div class="modal fade" id="add-drug-test-result" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Drug Test Diagnosis</h4>
      </div>
      <div class="modal-body">
        <div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
          <div class="form-group">
            <label for="drug-test-lab">Drug Test:</label>
            <textarea class="form-control" rows="7" name="drug-test-lab" id="drug-test-lab" required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="addDrugTestResultButton">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

{{-- Fecalysis Modal --}}
<div class="modal fade" id="add-fecalysis-result" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Fecalysis Diagnosis</h4>
      </div>
      <div class="modal-body">
        <div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
          <div class="form-group">
            <label for="macroscopic-lab">Macroscopic:</label>
            <textarea class="form-control" rows="7" name="macroscopic-lab" id="macroscopic-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="microscopic-lab">Microscopic (Parasites):</label>
            <textarea class="form-control" rows="7" name="microscopic-lab" id="microscopic-lab" required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="addFecalysisResultButton">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

{{-- Urinalysis Modal --}}
<div class="modal fade" id="add-urinalysis-result" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Urinalysis Diagnosis</h4>
      </div>
      <div class="modal-body">
        <div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
          <div class="form-group">
            <label for="pus-cells-lab">Pus Cells:</label>
            <textarea class="form-control" rows="7" name="pus-cells-lab" id="pus-cells-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="rbc-lab">RBC:</label>
            <textarea class="form-control" rows="7" name="rbc-lab" id="rbc-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="albumin-lab">Albumin:</label>
            <textarea class="form-control" rows="7" name="albumin-lab" id="albumin-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="sugar-lab">Sugar:</label>
            <textarea class="form-control" rows="7" name="sugar-lab" id="sugar-lab" required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="addUrinalysisResultButton">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection