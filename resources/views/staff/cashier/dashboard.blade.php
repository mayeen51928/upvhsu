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
			<h2 class="sub-header">Billings</h2>
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
            @foreach ($unpaid_bills as $unpaid_bill)
            <tr>
              <td>{{ $unpaid_bill->patient_first_name }} {{ $unpaid_bill->patient_last_name }}</td>
              <td>{{ $unpaid_bill->staff_first_name }} {{ $unpaid_bill->staff_last_name }}</td>
              <td>{{ $unpaid_bill->amount }}</td>
              <td>{{ $unpaid_bill->schedule_day }}</td>
              <td><button class="btn btn-primary btn-xs addMedicalBilling" id="add_medical_billing_{{ $unpaid_bill->medical_appointment_id }}">Pay Bill</button></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
		</div>
	</div>
</div>

<!-- MODALS -->
<div class="modal fade" id="confirm_medical_billing" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirm Payment?</h4>
      </div>
      <div class="modal-body" style="text-align:center; ">
        <button type="button" class="btn btn-primary" id="addMedicalBillingButton">Confirm</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var confirmMedicalBilling = '/confirm_medical_billing';
</script>
@endsection