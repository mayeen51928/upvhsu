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
				<div class="col-md-3" id="xraycountpanel">
					<div class="tile-stats" id="xraycount">
            <div class="icon"><i class="fa fa-id-badge"></i></div>
            <div class="count">{{$xray_request_count}}</div>
            <h3>Chest X-ray</h3>
            @if(isset($xray_latest))
            <p title="Latest request"><span><i class="fa fa-calendar"></i></span> {{date_format(date_create($xray_latest), 'F j, Y')}} <span><i class="fa fa-clock-o"></i></span> {{date_format(date_create($xray_latest), 'h:i A')}}</p>
             @else
            <p>&nbsp;</p>
            @endif
          </div>
				</div>
				<div class="col-md-9">
				<h3 class="sub-header">Requests for X-Ray Examination</h3>
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
							<td><button class="btn btn-info btn-xs addXrayResult" id="addXrayResult_{{$xray_request->id}}">Details</button></td>
							{{-- <td><button class="btn btn-primary btn-xs addBillingToXray" id="addBillingToXray_{{$xray_request->id}}">Billing</button></td> --}}
						</tr>
						@endforeach
					</tbody>
				</table>
				@else
				<p>No requests as of the moment.</p>
				@endif
				<div class="text-center">{{ $xray_requests->links() }} </div>
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
				<div class="panel-group" id="xrayaccordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#xraybillingaccordion">Tests Conducted</a>
							</h4>
						</div>
						<div id="xraybillingaccordion" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="xraybilling row">
								<div class="table-responsive col-md-6">
										<table class="table displayServices">
											<tbody>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="39"></td>
													<td class="xrayService">Lumbo Sacral Apl</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="40"></td>
													<td class="xrayService">Skull Apl/View</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="41"></td>
													<td class="xrayService">Critical/View</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="42"></td>
													<td class="xrayService">Pelvis</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="43"></td>
													<td class="xrayService">Hip</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="44"></td>
													<td class="xrayService">Foot Apl</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="45"></td>
													<td class="xrayService">Leg</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="46"></td>
													<td class="xrayService">Knee Apl</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="47"></td>
													<td class="xrayService">Thigh Apl</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="48"></td>
													<td class="xrayService">Ankle</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="49"></td>
													<td class="xrayService">Chest Pa-ap</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="50"></td>
													<td class="xrayService">Chest Lateral</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="table-responsive col-md-6">
										<table class="table displayServices">
											<tbody>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="51"></td>
													<td class="xrayService">Apico-Lordotic</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="52"></td>
													<td class="xrayService">Chest Bucky</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="53"></td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="54"></td>
													<td class="xrayService">Hand</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="55"></td>
													<td class="xrayService">Wrist</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="56"></td>
													<td class="xrayService">Forearm Apl</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="57"></td>
													<td class="xrayService">Elbow Apl</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="58"></td>
													<td class="xrayService">Upper Arm</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="59"></td>
													<td class="xrayService">Shoulder</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="60"></td>
													<td class="xrayService">Clavicle</td>
												</tr>
												<tr>
													<td><input type="checkbox" class="checkboxXrayService" id="61"></td>
													<td class="xrayService">Scapula</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#diagnosisaccordion">Diagnosis</a>
							</h4>
						</div>
						<div id="diagnosisaccordion" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="laboratory-result-lab" id="laboratoryresult-lab"  style="padding:5px;">
									<div class="row">
										<div class="form-group col-md-12">
											<label for="chest-xray">Chest Xray:</label>
											<textarea class="form-control" rows="7" name="chest-xray" id="chest-xray" required></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
			<div class="modal-footer" id="add-xray-result-footer">
				{{-- <button type="button" class="btn btn-success" id="addXrayResultButton">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> --}}
			</div>
		</div>
	</div>
</div>

<div id="xrayBillingModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="patient_name"></div>
			</div>
			<div class="modal-body">
				<div class="medical_senior_checker_xray" style="display:none;">
					<div class="radio">
						<label><input type="radio" name="xray_radio_button_medical" id="xray_radio_button_medical_billing_opd" value="5" checked="checked">OPD</label>&nbsp;&nbsp;&nbsp;
						<label><input type="radio" name="xray_radio_button_medical" id="xray_radio_button_medical_billing_senior" value="6">Senior Citizen</label>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-hover displayServices"></table>
				</div>
				<div class="xray-bill-input" id="xray-bill-input-text"></div> 
			</div>
			<div class="modal-footer">
				<div class="xray-bill-confirm" id="xray-bill-confirm-button" style="text-align:center; "></div>
			</div>
		</div>
	</div>
</div>

<script>
	// token and createPostUrl are needed to be passed to AJAX method call
	var token = '{{csrf_token()}}';
	var addBillingXray = '/add_billing_xray';
	var confirmBillingXray = '/confirm_billing_xray';
</script>
@endsection