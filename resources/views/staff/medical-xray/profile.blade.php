@extends('layouts.layout')
@section('title', 'Profile | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
    @include('layouts.sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="dentistDashboard">
      <div class="col-md-9">
        <div class="panel panel-info">
          <div class="panel-heading">Basic Information</div>
          <div class="panel-body">
            <table class="table" style="margin-bottom: 0px;">
              <tbody>
                <tr><td>Sex</td><td>{{$sex}}</td></tr>
                <tr><td>Position</td><td>{{$position}}</td></tr>
                <tr><td>Birthday</td><td>{{$birthday}}</td></tr>
                <tr><td>Civil Status</td><td>{{$civil_status}}</td></tr>
                <tr><td>Address</td><td>{{$street}}, {{$town}}, {{$province}}</td></tr>
                <tr><td>Contact Number</td><td>{{$personal_contact_number}}</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3">
        <img src="{{ URL::asset('/images/' . $picture) }}"  alt="Profile picture" height="200px" width="200px">
      </div>
      <div class="col-md-12">
          <div class="clearfix">
          <div class="pull-left">
          <a href="{{ url('xray/profile/edit') }}" class="btn btn-primary" role="button">Edit Profile</a>
          </div>
          </div>
          </div>
    </div>
  </div>
</div>
@endsection