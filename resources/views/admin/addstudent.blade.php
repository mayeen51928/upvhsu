@extends('layouts.layout')
@section('title', 'Add Student | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
    @include('layouts.sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="adminDashboard">
      <h1 class="page-header">Admin</h1>
      <div class="col-md-9 col-md-offset-1">
        @if (session('status'))
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          {{ session('status') }}
        </div>
        @endif
        <div class="panel panel-info">
          <div class="panel-heading">Add Student Number to Database</div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/createstudent') }}">
              {{ csrf_field() }}
              <p>Note: The added student numbers will be used to verify students who are registering to the system.</p>
              <div class="form-group">
                <label for="student_number" class="col-md-4 control-label">Student Number</label>
                <div class="col-md-6">
                  <input id="student_number" type="text" class="form-control" name="student_number" required autofocus placeholder="20xxxxxxx"/>
                </div>
              </div>
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