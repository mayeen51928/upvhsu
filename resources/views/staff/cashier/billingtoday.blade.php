@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	@include('layouts.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="todayBilling">
		<h2 class="sub-header">Today's Billings</h2>
		<ul class="nav nav-tabs">
      <li  class="active"><a data-toggle="tab" href="#medicalbilling">Medical Billings</a></li>
      <li><a data-toggle="tab" href="#dentalbilling">Dental Billings</a></li>
    </ul>
    <br>
    <div class="tab-content">
    	<div class="tab-pane fade in active" id="medicalbilling">
    		<div class="table-responsive">
	       	<table class="table table-striped">
	          <thead>
	            <tr>
	              <th>Patient</th>
	              <th>Doctor</th>
	              <th>Amount</th>
	              <th>Consultation Date</th>
	              <th></th>
	            </tr>
	          </thead>
	          <tbody>
	          	@foreach($unpaid_bills_medical_today as $unpaid_bill_medical_today)
							<tr id="add_medical_billing_tr_{{$unpaid_bill_medical_today->medical_appointment_id}}">
								@if ($counter_medical_today>0)
									<td>{{ $unpaid_bill_medical_today->patient_first_name }} {{ $unpaid_bill_medical_today->patient_last_name }}</td>
									<td>{{ $unpaid_bill_medical_today->staff_first_name }} {{ $unpaid_bill_medical_today->staff_last_name }}</td>
									<td>{{ $unpaid_bill_medical_today->amount }}</td>
									<td>{{ date_format(date_create($unpaid_bill_medical_today->schedule_day ), 'F j, Y')}}</td>
									<td><button class="btn btn-primary btn-xs addMedicalBilling" id="add_medical_billing_{{$unpaid_bill_medical_today->medical_appointment_id}}_{{$unpaid_bill_medical_today->amount}}">Pay Bill</button></td>
								@else
									<td>No billing record at this moment.</td>
								@endif
							</tr>
							@endforeach
	          </tbody>
	        </table>
	      </div>
			</div>
			<div class="tab-pane" id="dentalbilling">
				<div class="table-responsive">
					<table class="table table-striped">
	          <thead>
	            <tr>
	              <th>Patient</th>
	              <th>Doctor</th>
	              <th>Amount</th>
	              <th>Consultation Date</th>
	              <th></th>
	            </tr>
	          </thead>
	          <tbody>
	          	@foreach($unpaid_bills_dental_today as $unpaid_bill_dental_today)
							<tr id="add_dental_billing_tr_{{$unpaid_bill_dental_today->appointment_id}}">
								@if ($counter_dental_today>0)
									<td>{{ $unpaid_bill_dental_today->patient_first_name }} {{ $unpaid_bill_dental_today->patient_last_name }}</td>
									<td>{{ $unpaid_bill_dental_today->staff_first_name }} {{ $unpaid_bill_dental_today->staff_last_name }}</td>
									<td>{{ $unpaid_bill_dental_today->amount }}</td>
									<td>{{date_format(date_create($unpaid_bill_dental_today->schedule_start), 'F j, Y')}} {{date_format(date_create($unpaid_bill_dental_today->schedule_start), 'H:i A')}} - {{date_format(date_create($unpaid_bill_dental_today->end), 'H:i A')}} </td>
									<td><button class="btn btn-primary btn-xs addDentalBilling" id="add_dental_billing_{{$unpaid_bill_dental_today->appointment_id}}_{{$unpaid_bill_dental_today->amount}}">Pay Bill</button></td>
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
					<input type="text" id="display_amount_modal_medical" class="form-control" disabled>
				</div>
			</div>
			</div>
			<div class="modal-footer text-center">
				<button type="button" class="btn btn-primary" id="addMedicalBillingButton">Confirm</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm_dental_billing" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Confirm Payment?</h4>
			</div>
			<div class="modal-body">
				<table id="displayDentalBillingTableModal" class="table" style="display: none">
					<tbody id="displayDentalBillingModal">
					</tbody>
				</table>
			<div class="row">
				<div class="col-md-6 col-md-offset-6">
					<label>Total</label>
					<input type="text" id="display_amount_modal_dental" class="form-control" disabled>
				</div>
			</div>
			</div>
			<div class="modal-footer text-center">
				<button type="button" class="btn btn-primary" id="addDentalBillingButton">Confirm</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script>
	// token and createPostUrl are needed to be passed to AJAX method call
	var token = '{{csrf_token()}}';
	var confirmMedicalBilling = '/confirm_medical_billing';
	var displayMedicalBilling = '/display_medical_billing';
	var confirmDentalBilling = '/confirm_dental_billing';
	var displayDentalBilling = '/display_dental_billing';
</script>
@endsection