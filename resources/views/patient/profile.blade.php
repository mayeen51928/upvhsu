@extends('layouts.layout')
@section('title', 'Profile | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
    <div class="row">
    <div class="col-md-3">
          @if(is_null($picture))
        <img src="{{asset('images/blankprofpic.png')}}"  alt="Profile picture" class="img-circle center-block" height="220px" width="220px"/>
        @else
        <img src="{{ URL::asset('/images/' . $picture) }}"  alt="Profile picture" class="img-circle center-block" height="220px" width="220px"/>
        @endif
        <br/>
          </div>
          
          <div class="col-md-9">
            <div class="panel panel-info">
              <div class="panel-heading">Basic Information</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Age</td><td>{{$age}}</td></tr>
                  <tr><td>Sex</td><td>{{$sex}}</td></tr>
                  @if(Auth::user()->patient->patient_type_id==1)
                  <tr><td>Course</td><td>{{$degree_program}}</td></tr>
                  <tr><td>Year Level</td><td>{{$year_level}}</td></tr>
                  @endif
                </tbody>
              </table>
              </div>
            </div>
          </div>
          </div>
          <div class="row">
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Personal Data</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Date of Birth</td><td>@if(isset($birthday)) {{date_format(date_create($birthday), 'F j, Y')}} @endif</td></tr>
                  <tr><td>Religion</td><td>@if(isset($religion)) {{$religion}} @endif</td></tr>
                  <tr><td>Nationality</td><td>@if(isset($nationality)) {{$nationality}} @endif</td></tr>
                  <tr><td>Father</td><td>@if(isset($father)) {{$father}} @endif</td></tr>
                  <tr><td>Mother</td><td>@if(isset($mother)) {{$mother}} @endif </td></tr>
                  <tr><td>Home Address</td><td>@if(isset($street)) {{$street}} @endif @if(isset($town)) {{$town}} @endif @if(isset($province)) {{$province}} @endif</td></tr>
                  <tr><td>Residence Telephone Number</td><td>@if(isset($residence_telephone_number)) {{$residence_telephone_number}} @endif</td></tr>
                  <tr><td>Residence Contact Number</td><td>@if(isset($residence_contact_number)) {{$residence_contact_number}} @endif</td></tr>
                  <tr><td>Personal Contact Number</td><td>@if(isset($personal_contact_number)) {{$personal_contact_number}} @endif</td></tr>
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
                  <tr><td>Name</td><td>{{$guardian_first_name}} {{$guardian_middle_name}} {{$guardian_last_name}}</td></tr>
                  <tr><td>Address</td><td>{{$guardian_street}}, {{$guardian_town}}, {{$guardian_province}}</td></tr>
                  <tr><td>Relationship</td><td>{{$relationship}}</td></tr>
                  <tr><td>Residence Telephone Number</td><td>{{$guardian_tel_number}}</td></tr>
                  <tr><td>Cellphone Number</td><td>{{$guardian_cellphone}}</td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          </div>
          <div class="row">
          <div class="col-md-12">
          <div class="clearfix">
          <div class="pull-right">
          <a href="{{ url('account/profile/edit') }}" class="btn btn-primary" role="button">Edit Profile</a>
          </div>
          </div>
          </div>
          </div>
          </div>
	</div>
</div>

@endsection