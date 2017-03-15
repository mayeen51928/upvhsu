@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
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
<<<<<<< HEAD
            @foreach($unpaid_bills as $unpaid_bill)
=======
            @for ($i = 0; $i < sizeof($unpaid_bills_info); $i++)
>>>>>>> 9af02ce91d97d2ca0f30360fef392068609b900f
            <tr>
              @if ($counter>0)
                <td>{{ $unpaid_bill->patient_first_name }} {{ $unpaid_bill->patient_last_name }}</td>
                <td>{{ $unpaid_bill->staff_first_name }} {{ $unpaid_bill->staff_first_name }}</td>
                <td>{{ $unpaid_bill->amount }}</td>
                <td>{{ $unpaid_bill->schedule_day }}</td>
                <td><button class="btn btn-primary btn-xs addMedicalBilling" id="add_medical_billing_{{ $unpaid_bill->medical_appointment_id }}_{{ $unpaid_bill->amount }}">Pay Bill</button></td>
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
</div>

<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var confirmMedicalBilling = '/confirm_medical_billing';
  var displayMedicalBilling = '/display_medical_billing';
</script>
@endsection