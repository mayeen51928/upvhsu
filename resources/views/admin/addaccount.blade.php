@extends('layouts.layout')
@section('title', 'Add Staff Account | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
    @include('layouts.sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="adminDashboard">
      <h1 class="page-header">Admin</h1>
      <div class="col-md-9 col-md-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">Add Account</div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/createstaffaccount') }}">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="staff_id" class="col-md-4 control-label">Staff ID</label>
                <div class="col-md-6">
                  <input id="staff_id" type="text" class="form-control" name="staff_id" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="staff_first_name" class="col-md-4 control-label">First Name</label>
                <div class="col-md-6">
                  <input id="staff_first_name" type="text" class="form-control" name="staff_first_name" required>
                </div>
              </div>
              <div class="form-group">
                <label for="staff_middle_name" class="col-md-4 control-label">Middle Name</label>
                <div class="col-md-6">
                  <input id="staff_middle_name" type="text" class="form-control" name="staff_middle_name" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="staff_last_name" class="col-md-4 control-label">Last Name</label>
                <div class="col-md-6">
                  <input id="staff_last_name" type="text" class="form-control" name="staff_last_name" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="staff_type_id" class="col-md-4 control-label">Staff Type</label>
                <div class="col-md-6">
                  <select class="form-control" name="staff_type_id" id="staff_type_id" required>
                    <option disabled selected>Select the staff type.</option>
                    <option value="1">Dentist</option>
                    <option value="2">Doctor</option>
                    <option value="3">Lab</option>
                    <option value="4">X-Ray</option>
                    <option value="5">Cashier</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="password" class="col-md-4 control-label">Password</label>
                <div class="col-md-6">
                  <input id="staff_password" type="password" class="form-control" name="staff_password" required>
                </div>
              </div>
              {{-- <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
              </div> --}}
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">Add Account to Database</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection