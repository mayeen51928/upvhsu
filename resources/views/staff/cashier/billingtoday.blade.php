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
	            <tr>
                <td>{{ $unpaid_bill_medical_today->patient_first_name }} {{ $unpaid_bill_medical_today->patient_last_name }}</td>
                <td>{{ $unpaid_bill_medical_today->staff_first_name }} {{ $unpaid_bill_medical_today->staff_first_name }}</td>
                <td>{{ $unpaid_bill_medical_today->amount }}</td>
                <td>{{ $unpaid_bill_medical_today->schedule_day }}</td>
                <td><button class="btn btn-primary btn-xs addMedicalBilling" id="add_medical_billing_{{ $unpaid_bill_medical_today->medical_appointment_id }}_{{ $unpaid_bill_medical_today->amount }}">Pay Bill</button></td>
	            </tr>
	            @endforeach
	          </tbody>
	        </table>
	      </div>
			</div>
			<div class="tab-pane" id="dentalbilling">
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
	            <tr>
                <td>First Name</td>
                <td>Staff Name</td>
                <td>400</td>
                <td>March 31, 1996</td>
                <td><button class="btn btn-primary btn-xs addMedicalBilling" id="add_medical_billing">Pay Bill</button></td>
	            </tr>
	          </tbody>
	        </table>
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