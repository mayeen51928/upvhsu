@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="personal-information">
          <div class="row">
            @foreach($patient_infos as $patient_info)
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Name</h4>
              <div>{{ $patient_info->patient_first_name }} {{ $patient_info->patient_last_name }}</div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Time</h4>
              <div>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $patient_info->schedule_start)->format('H:i:s') }} - {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $patient_info->schedule_end)->format('H:i:s') }}</div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Reasons</h4>
              <div>{{ $patient_info->reasons }}</div>
            </div>
            @endforeach
          </div>
        </div>    
        @foreach ($appointment_ids as $appointment_id)
        <button type="button" class="btn btn-info updateDentalDiagnosis" id="updateDentalDiagnosis_{{ $appointment_id->id }}"><i class="fa fa-caret-left" aria-hidden="true"></i>  Update Diagnosis</button>    
        @endforeach
        <svg height="522" width="867">
          <polygon class="dental_chart" id="condition_55" points="234, 78, 244, 74, 256, 75, 262, 76, 267, 79, 269, 84, 271, 92, 271, 102, 271, 108, 266, 113, 260, 113, 256, 112, 253, 110, 246, 112, 237, 111, 233, 105, 230, 97, 230, 89, 232, 82, 233, 79" style="fill:{{ $stacks_condition[0] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="operation_55" points="234, 78, 244, 74, 256, 75, 262, 76, 267, 79, 267, 69, 268, 62, 270, 55, 273, 48, 275, 41, 274, 33, 273, 26, 270, 24, 268, 26, 267, 33, 267, 40, 266, 44, 261, 51, 257, 56, 255, 59, 254, 64, 250, 71, 245, 64, 240, 57, 238, 47, 236, 39, 234, 29, 232, 24, 229, 23, 227, 26, 227, 36, 229, 46, 231, 54, 234, 62, 235, 69, 234, 77" style="fill:{{ $stacks_operation[0] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="condition_54" points="285, 73, 291, 70, 298, 70, 303, 71, 310, 73, 315, 76, 316, 81, 319, 88, 319, 97, 315, 104, 308, 107, 302, 105, 298, 103, 292, 103, 285, 99, 281, 94, 281, 87, 281, 79, 283, 75" style="fill:{{ $stacks_condition[1] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="operation_54" points="285, 73, 291, 70, 298, 70, 303, 71, 310, 73, 315, 76, 316, 68, 319, 60, 321, 51, 321, 43, 321, 35, 318, 30, 315, 33, 312, 41, 308, 54, 304, 61, 299, 66, 296, 63, 293, 57, 290, 50, 290, 40, 289, 35, 285, 30, 282, 34, 282, 41, 284, 46, 285, 55, 285, 65, 285, 70" style="fill:{{ $stacks_operation[1] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="condition_53" points="332, 72, 337, 68, 343, 68, 349, 69, 355, 73, 356, 84, 356, 93, 351, 99, 346, 102, 340, 102, 334, 99, 331, 95, 332, 84, 331, 76, 331, 74" style="fill:{{ $stacks_condition[2] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="operation_53" points="332, 72, 337, 68, 343, 68, 349, 69, 355, 73, 354, 65, 353, 55, 353, 44, 352, 33, 351, 23, 347, 15, 343, 17, 342, 25, 340, 30, 338, 36, 336, 45, 336, 56, 334, 63, 333, 67" style="fill:{{ $stacks_operation[2] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="condition_52" points="371, 72, 375, 69, 380, 69, 385, 71, 386, 77, 388, 85, 390, 93, 389, 100, 386, 104, 379, 105, 372, 103, 369, 99, 367, 93, 369, 84, 370, 77, 370, 73" style="fill:{{ $stacks_condition[3] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="operation_52" points="371, 72, 375, 69, 380, 69, 385, 71, 385, 65, 385, 56, 385, 51, 383, 43, 381, 36, 379, 27, 377, 22, 373, 19, 371, 20, 371, 26, 372, 33, 373, 41, 373, 51, 373, 61, 371, 68" style="fill:{{ $stacks_operation[3] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="condition_51" points="410, 70, 418, 69, 422, 68, 426, 72, 428, 75, 431, 76, 433, 79, 434, 88, 435, 96, 434, 104, 428, 110, 422, 110, 414, 107, 409, 105, 406, 102, 406, 94, 406, 85, 408, 78, 410, 72" style="fill:{{ $stacks_condition[4] }};stroke:black;stroke-width:3" />
          <polygon class="dental_chart" id="operation_51" points="410, 70, 418, 69, 422, 68, 426, 72, 428, 75, 431, 76, 433, 79, 431, 70, 431, 62, 431, 55, 429, 45, 428, 37, 427, 29, 426, 24, 423, 20, 420, 16, 417, 22, 415, 27, 413, 34, 412, 38, 412, 46, 412, 58, 411, 65, 411, 67" style="fill:{{ $stacks_operation[4] }};stroke:black;stroke-width:3" />
        </svg>
      </div>
	</div>
</div>
<div class="modal fade update-dental-record-modal" id="update-dental-record-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="add-dental-record">
          <select class="form-control condition" id="condition">
            <option disabled selected value="0">--options--</option>
            <option value="1">Caries free</option>
            <option value="2">Caries for filting</option>
            <option value="3">Caries for extraction</option>
            <option value="4">Root fragment</option>
            <option value="5">Missing due to carries</option>
          </select>
          <select class="form-control operation" id="operation">
            <option disabled selected value="0">--options--</option>
            <option value="1">Amalgam filling</option>
            <option value="2">Silicate filling</option>
            <option value="3">Extraction due to caries</option>
            <option value="4">Extraction due to other causes</option>
            <option value="5">Cement filling</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        @foreach ($appointment_ids as $appointment_id)
        <input type="hidden" value="{{ $appointment_id->id }}" class="appointment"/>
        @endforeach
        <button type="button" class="btn btn-info updateDentalRecord" id="updateDentalRecord">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var updateDentalRecordModal = '/update_dental_record_modal';
  var insertDentalRecordModal = '/insert_dental_record_modal';
  var updateDentalDiagnosis = '/update_dental_diagnosis';
</script>

@endsection