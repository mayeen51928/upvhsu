@extends('layouts.layout')
@section('title', 'View Records | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
	@include('layouts.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="viewAllDentalRecordsDiv">
        <div class="row">
          <div class="col-md-4 col-md-offset-4" style="text-align: center;">
            <h4>DENTAL RECORDS HISTORY</h4>
            <table class="table table-hover viewrecordsfromsearch">
              <tr><thead>Date</thead></tr>
              @foreach($records as $record)
              <tr><td><a class="dentalrecorddate" id="dentalappointment_{{$record->id}}">{{date_format(date_create($record->schedule_start), 'F j, Y')}}</a></td></tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

<div class="modal fade" id="viewDentalRecordBasedOnDateModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 id="viewDentalRecordBasedOnDateModalTitle">Detailed Patient Record</h3>
			</div>
			<div class="modal-body">


			{{-- INSERT DENTAL RECORDS HERE --}}




			</div>
		</div>
	</div>
</div>
@endsection