@extends('layouts.layout')
@section('title', 'View Records | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
	@include('layouts.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="viewAllMedicalRecordsDiv">
        <div class="row">
          <div class="col-md-4 col-md-offset-4" style="text-align: center;">
            <h4>MEDICAL RECORDS HISTORY</h4>
            <table class="table table-hover">
              <tr><thead>Date</thead></tr>
              @foreach($records as $record)
              <tr><td><a>{{$record->schedule_day}}</a></td></tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection