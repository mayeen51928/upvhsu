@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
    @include('layouts.sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="adminDashboard">
      <h1 class="page-header">Admin</h1>
      <div class="col-md-9 col-md-offset-1">
        <div class="panel panel-info">
          <div class="panel-heading">Add Announcment</div>
          <div class="panel-body">
            <form method="POST" action="{{ url('/admin/postannouncement') }}">
              {{ csrf_field() }}
            <div class="form-group">
            <input type="text" class="form-control" name="announcement_title" id="announcement_title" placeholder="Title" required autofocus/>
            </div>
            <div class="form-group">
              <textarea class="form-control" rows="10" name="announcement_body" id="announcement_body" placeholder="Body" required></textarea>
            </div>
            <input type="submit" class="btn btn-success" name="createannouncment" value="Post Announcment" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection