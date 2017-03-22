@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
  <div class="row">
    @include('layouts.sidebar')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="adminDashboard">
      <h1 class="page-header">Admin</h1>
      <div class="row">
        <div class="col-md-4">
          <div class="tile-stats" id="cbccount">
            <div class="icon"><i class="fa fa-money"></i></div>
            <div class="count">1000.00</div>
            <h3>Received Payments</h3>
          </div>
          <div class="tile-stats" id="cbccount">
            <div class="icon"><i class="fa fa-rub"></i></div>
            <div class="count">500.00</div>
            <h3>Accounts Receivable</h3>
          </div>
        </div>
        <input type="hidden" id="admingraphtrigger" value="1"/>
        <div class="col-md-8 tile-stats">

          <div id="admingraph"></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection