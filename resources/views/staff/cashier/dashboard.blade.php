@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	@include('layouts.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
		<h4 class="page-header">
		@if(!is_null(Auth::user()->staff->picture))
		<img src="{{asset('images/'.Auth::user()->staff->picture)}}" height="50" width="50" class="img-circle"/> 
		@else
		<img src="{{asset('images/blankprofpic.png')}}" height="50" width="50" class="img-circle"/> 
		@endif
		Welcome <i>{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</i>!</h4>
		<div class="row placeholders">
			<div class="col-xs-3 col-sm-3 col-md-3 placeholder">
				<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
			</div>
			<div class="col-xs-9 col-sm-9 col-md-9 placeholder">
				Info here
			</div>
		</div>
		<h2 class="sub-header">Billings</h2>
		<ul class="nav nav-tabs">
      <li><a data-toggle="tab" href="#pastappointment">Past</a></li>
      <li class="active"><a data-toggle="tab" href="#todayappointment">Today</a></li>
    </ul>
    <br>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="todayappointment">
				<form action="/cashier/billingtoday" method="POST">{{ csrf_field() }}<input type="submit" class="btn btn-primary" value="View Today's Patient"></form>
			</div>
			<div class="tab-pane" id="pastappointment">
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-success">
				      <div class="panel-heading">Medical Billing</div>
				      <div class="panel-body">
				      	<h4>Receivable Amount:	<b>{{ $receivable_medical->amount }}</b></h4>
				      	<hr>
				      	<table class="table table-striped">
									<thead>
										<tr>
											<th>Patient</th>
											<th>Consultation Date</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($unpaid_bills_medical as $unpaid_bill_medical)
										<tr>
											@if ($counter_medical>0)
												<td>{{ $unpaid_bill_medical->patient_first_name }} {{ $unpaid_bill_medical->patient_last_name }}</td>
												<td>{{ $unpaid_bill_medical->schedule_day }}</td>
												<td><button class="btn btn-primary btn-xs addMedicalBilling" id="add_medical_billing_{{ $unpaid_bill_medical->medical_appointment_id }}_{{ $unpaid_bill_medical->amount }}">Pay Bill</button></td>
											@else
												<td>No billing record at this moment.</td>
											@endif
										</tr>
										@endforeach
									</tbody>
								</table>
				      </div>
				    </div>
					</div>
					<div class="col-md-6">
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<!-- MODALS -->
<div class="modal fade" id="confirm_medical_billing" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Confirm Payment?</h4>
		</div>
		<div class="modal-body">
			<table id="displayMedicalBillingTableModal" class="table" style="display: none">
				<tbody id="displayMedicalBillingModal">
				</tbody>
			</table>
		<div class="row">
			<div class="col-md-6 col-md-offset-6">
				<label>Total</label>
				<input type="text" id="display_amount_modal" class="form-control" disabled>
			</div>
		</div>
		</div>
		<div class="modal-footer text-center">
			<button type="button" class="btn btn-primary" id="addMedicalBillingButton">Confirm</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		</div>
	</div>
</div>

<script>
	// token and createPostUrl are needed to be passed to AJAX method call
	var token = '{{csrf_token()}}';
	var confirmMedicalBilling = '/confirm_medical_billing';
	var displayMedicalBilling = '/display_medical_billing';
</script>
@endsection