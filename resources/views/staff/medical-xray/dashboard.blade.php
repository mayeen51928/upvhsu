@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
      <h4 class="page-header">Welcome <i>{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</i>!</h4>
      <h3 class="sub-header">Requests for X-Ray Examination</h3>
      
      <div class="row">
        <div class="col-md-12">
          @if(count($xray_requests)>0)
          <p>The requests are sorted by time and date of requests, from the most recent requests.</p>
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
            @foreach($xray_requests as $xray_request)
            <tr>
              <td id="patient_name">{{$xray_request->patient_first_name}} {{$xray_request->patient_last_name}}</p></td>
              <td>{{date_format(date_create($xray_request->created_at), 'F j, Y')}}</td>
              <td>{{$xray_request->staff_first_name}} {{$xray_request->staff_last_name}}</td>
              <td><button class="btn btn-info btn-xs addXrayResult" id="addXrayResult_{{$xray_request->id}}">Diagnosis</button></td>
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

{{-- Xray Modal --}}
<div class="modal fade" id="add-xray-result" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Chest Xray</h4>
			</div>
			<div class="modal-body">
				<div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
					<div class="row">
						<div class="form-group col-md-12">
							<label for="chest-xray">Chest Xray:</label>
							<textarea class="form-control" rows="7" name="chest-xray" id="chest-xray" required></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="addXrayResultButton">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
@endsection