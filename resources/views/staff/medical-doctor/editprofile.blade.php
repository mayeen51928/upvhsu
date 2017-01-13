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
                <tr>
                  <td>Sex</td>
                  <td>
                    <select class="form-control" name="sex" id="sex">
                          <option value="F" @if($sex=="F") selected @endif>F</option>
                          <option value="M" @if($sex=="M") selected @endif>M</option>
                        </select>
                      </td>
                </tr>
                <tr><td>Position</td><td>Dentist</td></tr>
                <tr><td>Birthday</td><td>July 1, 1954</td></tr>
                <tr><td>Civil Status</td><td>Widowed</td></tr>
                <tr><td>Address</td><td>UPV Village, Oton</td></tr>
                <tr><td>Contact Number</td><td>09109101010</td></tr>
            	</tbody>
          	</table>
          </div>
        </div>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3">
      	Image here
      	{{-- <img src="images/mayenne.jpg" width="220" height="220" class="img-responsive" alt="Generic placeholder thumbnail"> --}}
      </div>
      <div class="col-md-12">
          <div class="clearfix">
          <div class="pull-left">
          <a href="{{ url('doctor/profile/edit') }}" class="btn btn-primary" role="button">Edit Profile</a>
          </div>
          </div>
          </div>
		</div>
	</div>
</div>
@endsection