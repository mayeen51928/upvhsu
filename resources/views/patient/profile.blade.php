@extends('layouts.layout')
@section('title', 'Profile | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
          <div class="col-md-9">
            <div class="panel panel-info">
              <div class="panel-heading">Basic Information</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Age</td><td>{{$age}}</td></tr>
                  <tr><td>Sex</td><td>{{$sex}}</td></tr>
                  <tr><td>Course</td><td>{{$degree_program}}</td></tr>
                  <tr><td>Year Level</td><td>{{$year_level}}</td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3">
            Image here
            {{-- <img src="images/mayenne.jpg" width="220" height="220" class="img-responsive" alt="Generic placeholder thumbnail"> --}}
          </div>
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Personal Data</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Date of Birth</td><td>{{$birthday}}</td></tr>
                  <tr><td>Religion</td><td>{{$religion}}</td></tr>
                  <tr><td>Nationality</td><td>{{$nationality}}</td></tr>
                  <tr><td>Father</td><td>{{$father}}</td></tr>
                  <tr><td>Mother</td><td>{{$mother}}</td></tr>
                  <tr><td>Home Address</td><td>{{$address}}</td></tr>
                  <tr><td>Residence Telephone Number</td><td>09123456789</td></tr>
                  <tr><td>Personal Contact Number</td><td>09123456789</td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Guardian/Person to be Contacted in Case of Emergency</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Name</td><td>Natalie Mission</td></tr>
                  <tr><td>Address</td><td>Iloilo City</td></tr>
                  <tr><td>Relationship</td><td>Sister</td></tr>
                  <tr><td>Residence Telephone Number</td><td>09123456789</td></tr>
                  <tr><td>Cellphone Number</td><td>09123456789</td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          </div>
	</div>
</div>
@endsection