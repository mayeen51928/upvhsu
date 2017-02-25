@extends('layouts.layout')
@section('title', 'Edit Profile | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="dentistDashboard">
      <form method="POST" action="/dentist/profile/update" enctype="multipart/form-data">
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
                <tr>
                  <td>Position</td>
                  <td><input type="text" class="form-control" value="{{$position}}" placeholder="Position" name="position" id="position"/></td>
                </tr>
                <tr>
                  <td>Birthday</td>
                  <td>
                    <input type="date" class="form-control" value="{{$birthday}}" name="birthday" id="birthday"/>
                  </td>
                </tr>
                <tr>
                  <td>Civil Status</td>
                  <td>
                    <select class="form-control" name="civil_status" id="civil_status" required>
                      <option  @if($civil_status=="Single") selected @endif value="Single">Single</option>
                      <option  @if($civil_status=="Married") selected @endif value="Married">Married</option>
                      <option  @if($civil_status=="Separated") selected @endif value="Separated">Separated</option>
                      <option  @if($civil_status=="Divorced") selected @endif value="Divorced">Divorced</option>
                      <option  @if($civil_status=="Widowed") selected @endif value="Widowed">Widowed</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>Address</td>
                  <td>
                    <input type="text" class="form-control" value="{{$street}}" name="street" id="street" placeholder="House No. / Street" />
                    <input type="text" class="form-control" value="{{$town}}" name="town" id="town" placeholder="Town / City" />
                    <input type="text" class="form-control" value="{{$province}}" name="province" id="province" placeholder="Province" /></td>
                </tr>
                <tr>
                  <td>Contact Number</td>
                  <td><input type="text" class="form-control" value="{{$personal_contact_number}}" name="personal_contact_number" id="personal_contact_number" placeholder="Contact Number" /></td>
                </tr>
            	</tbody>
          	</table>
          </div>
        </div>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3">
      	<label for="picture">Select Profile Picture</label>
        <input type="file" name="picture" id="picture" class="picture"/>
      </div>
      <div class="col-md-12">
          <div class="clearfix">
          <div class="pull-left">
          <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
          </div>
          </div>
          </form>
          </div>
		</div>
	</div>
</div>
@endsection