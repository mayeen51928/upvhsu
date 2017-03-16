@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
    @include('layouts.sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
      <h4 class="page-header">@if(!is_null(Auth::user()->staff->picture))
      <img src="{{asset('images/'.Auth::user()->staff->picture)}}" height="50" width="50" class="img-circle"/> 
      @else
      <img src="{{asset('images/blankprofpic.png')}}" height="50" width="50" class="img-circle"/> 
      @endif
      Welcome <i>{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</i>!</h4>

      <div class="row">
      <div class="col-md-3 col-sm-12 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-tint"></i></div>
            <div class="count">{{$cbc_request_count}}</div>
            <h3>CBC</h3>
            @if(isset($cbc_latest))
            <p title="Latest request"><span><i class="fa fa-calendar"></i></span> {{date_format(date_create($cbc_latest), 'F j, Y')}} <span><i class="fa fa-clock-o"></i></span> {{date_format(date_create($cbc_latest), 'h:i A')}}</p>
            @else
            <p>&nbsp;</p>
            @endif
          </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-filter"></i></div>
            <div class="count">{{$drug_test_request_count}}</div>
            <h3>Drug Test</h3>
            @if(isset($drug_test_latest))
            <p title="Latest request"><span><i class="fa fa-calendar"></i></span> {{date_format(date_create($drug_test_latest), 'F j, Y')}} <span><i class="fa fa-clock-o"></i></span> {{date_format(date_create($drug_test_latest), 'h:i A')}}</p>
             @else
            <p>&nbsp;</p>
            @endif
          </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-medkit"></i></div>
            <div class="count">{{$fecalysis_request_count}}</div>
            <h3>Fecalysis</h3>
            @if(isset($fecalysis_latest))
            <p title="Latest request"><span><i class="fa fa-calendar"></i></span> {{date_format(date_create($fecalysis_latest), 'F j, Y')}} <span><i class="fa fa-clock-o"></i></span> {{date_format(date_create($fecalysis_latest), 'h:i A')}}</p>
             @else
            <p>&nbsp;</p>
            @endif
          </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-flask"></i></div>
            <div class="count">{{$urinalysis_request_count}}</div>
            <h3>Urinalysis</h3>
            @if(isset($urinalysis_latest))
            <p title="Latest request"><span><i class="fa fa-calendar"></i></span> {{date_format(date_create($urinalysis_latest), 'F j, Y')}} <span><i class="fa fa-clock-o"></i></span> {{date_format(date_create($urinalysis_latest), 'h:i A')}}</p>
             @else
            <p>&nbsp;</p>
            @endif
          </div>
        </div>
      </div>



      <h3 class="sub-header">Requests for Laboratory Examination</h3>
      <p>The requests are sorted by time and date of requests, from the most recent requests.</p>
      <div class="row">
        <div class="col-md-12">

          <div>
            <div class="table-responsive" id="lab_requests">
              @if(count($lab_requests)>0)
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
                  @foreach($lab_requests as $lab_request)
                  <tr>
                    <td id="patient_name">{{$lab_request->patient_first_name}} {{$lab_request->patient_last_name}}</p></td>
                    <td>{{date_format(date_create($lab_request->schedule_day), 'F j, Y')}}</td>
                    <td>{{$lab_request->staff_first_name}} {{$lab_request->staff_last_name}}</td>
                    <td><button class="btn btn-info btn-xs addLabResult" id="addLabResult_{{$lab_request->id}}">Diagnosis</button></td>
                    <td><button class="btn btn-primary btn-xs addBillingToLab" id="addBillingToLab_{{$lab_request->id}}">Billing</button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @else
              <p>No requests as of the moment.</p>
              @endif
              <div class="text-center">{{ $lab_requests->links() }} </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- CBC Modal --}}
<div class="modal fade" id="add-lab-result" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lab Requests</h4>
      </div>
      <div class="modal-body">
        <div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
          <div class="row well" id="cbc_div">
          <div class="col-md-2">COMPLETE BLOOD COUNT</div>
          <div class="col-md-10">
          <div class="form-group">
            <label for="hemoglobin-lab">Hemoglobin:</label>
            <textarea class="form-control" rows="2" name="hemoglobin-lab" id="hemoglobin-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="hemasocrit-lab">Hemasocrit:</label>
            <textarea class="form-control" rows="2" name="hemasocrit-lab" id="hemasocrit-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="wbc-lab">WBC:</label>
            <textarea class="form-control" rows="2" name="wbc-lab" id="wbc-lab" required></textarea>
          </div>
          </div>
          </div>
          <div class="row well" id="drug_test_div">
          <div class="col-md-2">DRUG TEST</div>
          <div class="col-md-10">
          <div class="form-group">
            <label for="drug-test-lab">Drug Test:</label>
            <select class="form-control" required name="drug-test-lab" id="drug-test-lab">
              <option disabled selected>Select Drug Test Result</option>
              <option value="negative">Negative</option>
              <option value="positive">Positive</option>
            </select>
          </div>
          </div>
          </div>
          <div class="row well" id="fecalysis_div">
          <div class="col-md-2">FECALYSIS</div>
          <div class="col-md-10">
          <div class="form-group">
            <label for="macroscopic-lab">Macroscopic:</label>
            <textarea class="form-control" rows="2" name="macroscopic-lab" id="macroscopic-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="microscopic-lab">Microscopic (Parasites):</label>
            <textarea class="form-control" rows="2" name="microscopic-lab" id="microscopic-lab" required></textarea>
          </div>
          </div>
          </div>
          <div class="row well" id="urinalysis_div">
          <div class="col-md-2">URINALYSIS</div>
          <div class="col-md-10">
          <div class="form-group">
            <label for="pus-cells-lab">Pus Cells:</label>
            <textarea class="form-control" rows="2" name="pus-cells-lab" id="pus-cells-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="rbc-lab">RBC:</label>
            <textarea class="form-control" rows="2" name="rbc-lab" id="rbc-lab" required></textarea>
          </div>
          <div class="form-group">
            <label for="albumin-lab">Albumin:</label>
            <select class="form-control" required  name="albumin-lab" id="albumin-lab">
              <option disabled selected>Select Albumin Result</option>
              <option value="negative">Negative</option>
              <option value="positive">Positive</option>
            </select>
          </div>
          <div class="form-group">
            <label for="sugar-lab">Sugar:</label>
            <select class="form-control" required  name="sugar-lab" id="sugar-lab">
              <option disabled selected>Select Sugar Result</option>
              <option value="negative">Negative</option>
              <option value="positive">Positive</option>
            </select>
          </div>
          </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" id="add-lab-result-footer">
      </div>
    </div>
  </div>
</div>

{{-- <div id="cbcBillingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="patient_name"></div>
      </div>
      <div class="modal-body">
        <div class="medical_senior_checker_cbc">
          <div class="radio">
            <label><input type="radio" name="cbc_radio_button_medical" id="cbc_radio_button_cbc_billing_opd" value="5" checked="checked">OPD</label>&nbsp;&nbsp;&nbsp;
            <label><input type="radio" name="cbc_radio_button_medical" id="cbc_radio_button_cbc_billing_senior" value="6">Senior Citizen</label>
          </div>
        </div>
        <table class="table table-bordered displayServices"></table>
        <div class="cbc-bill-input" id="cbc-bill-input-text"></div> 
      </div>
      <div class="modal-footer">
        <div class="cbc-bill-confirm" id="cbc-bill-confirm-button" style="text-align:center; "></div>
      </div>
    </div>
  </div>
</div>

<div id="drugBillingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="patient_name"></div>
      </div>
      <div class="modal-body">
        <div class="drug_senior_checker_drug">
          <div class="radio">
            <label><input type="radio" name="drug_radio_button_medical" id="drug_radio_button_drug_billing_opd" value="5" checked="checked">OPD</label>&nbsp;&nbsp;&nbsp;
            <label><input type="radio" name="drug_radio_button_medical" id="drug_radio_button_drug_billing_senior" value="6">Senior Citizen</label>
          </div>
        </div>
        <table class="table table-bordered displayServices"></table>
        <div class="drug-bill-input" id="drug-bill-input-text"></div> 
      </div>
      <div class="modal-footer">
        <div class="drug-bill-confirm" id="drug-bill-confirm-button" style="text-align:center; "></div>
      </div>
    </div>
  </div>
</div>
<div id="fecalysisBillingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="patient_name"></div>
      </div>
      <div class="modal-body">
        <div class="medical_senior_checker_fecalysis">
          <div class="radio">
            <label><input type="radio" name="fecalysis_radio_button_medical" id="fecalysis_radio_button_fecalysis_billing_opd" value="5" checked="checked">OPD</label>&nbsp;&nbsp;&nbsp;
            <label><input type="radio" name="fecalysis_radio_button_medical" id="fecalysis_radio_button_fecalysis_billing_senior" value="6">Senior Citizen</label>
          </div>
        </div>
        <table class="table table-bordered  displayServices"></table>
        <div class="fecalysis-bill-input" id="fecalysis-bill-input-text"></div> 
      </div>
      <div class="modal-footer">
        <div class="fecalysis-bill-confirm" id="fecalysis-bill-confirm-button" style="text-align:center; "></div>
      </div>
    </div>
  </div>
</div>
<div id="urinalysisBillingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="patient_name"></div>
      </div>
      <div class="modal-body">
        <div class="medical_senior_checker_urinalysis">
          <div class="radio">
            <label><input type="radio" name="urinalysis_radio_button_medical" id="urinalysis_radio_button_urinalysis_billing_opd" value="5" checked="checked">OPD</label>&nbsp;&nbsp;&nbsp;
            <label><input type="radio" name="urinalysis_radio_button_medical" id="urinalysis_radio_button_urinalysis_billing_senior" value="6">Senior Citizen</label>
          </div>
        </div>
        <table class="table table-bordered displayServices"></table>
        <div class="urinalysis-bill-input" id="urinalysis-bill-input-text"></div> 
      </div>
      <div class="modal-footer">
        <div class="urinalysis-bill-confirm" id="urinalysis-bill-confirm-button" style="text-align:center; "></div>
      </div>
    </div>
  </div>
</div> --}}

<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var addBillingCbc = '/add_billing_cbc';
  var confirmBillingCbc = '/confirm_billing_cbc';
  var addBillingDrug = '/add_billing_drug';
  var confirmBillingDrug = '/confirm_billing_drug';
  var addBillingFecalysis = '/add_billing_fecalysis';
  var confirmBillingFecalysis = '/confirm_billing_fecalysis';
  var addBillingUrinalysis = '/add_billing_urinalysis';
  var confirmBillingUrinalysis = '/confirm_billing_urinalysis';
</script>

@endsection