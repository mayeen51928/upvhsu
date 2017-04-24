<!DOCTYPE html>
<html lang="eng">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="_token" content="{!! csrf_token() !!}"/>
	<link rel="icon" href="{{asset('images/icon.jpg')}}"/>
	<title>@yield('title')</title>
	<link rel="stylesheet" href="{{asset('css/bootstrap/css/bootstrap.min.css')}}"/>
	<link rel="stylesheet" href="{{asset('css/custom.css')}}"/>
	<link rel="stylesheet" href="{{asset('css/dashboard.css')}}"/>
	<link rel="stylesheet" href="{{asset('css/font-awesome-4.7.0/css/font-awesome.min.css')}}"/>
	<script src="{{asset('js/jquery.min.js')}}"></script>
	<script src="{{asset('js/jquery-ui.min.js')}}"></script>
	<script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
	{{-- <script src="{{asset('js/dental-dentist/dental-dentist.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/medical-doctor/medical-doctor.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/medical-lab/medical-lab.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/medical-xray/medical-xray.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/cashier/cashier.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/patient/patient.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/admin/admin.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/custom.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/scheduleappointment.min.js')}}"></script> --}}
	{{-- <script src="{{asset('js/seemoreannouncements.min.js')}}"></script> --}}

	<script src="{{asset('js/dental-dentist/dental-dentist.js')}}"></script>
	<script src="{{asset('js/medical-doctor/medical-doctor.js')}}"></script>
	<script src="{{asset('js/medical-lab/medical-lab.js')}}"></script>
	<script src="{{asset('js/medical-xray/medical-xray.js')}}"></script>
	<script src="{{asset('js/cashier/cashier.js')}}"></script>
	<script src="{{asset('js/patient/patient.js')}}"></script>
	<script src="{{asset('js/admin/admin.js')}}"></script>
	<script src="{{asset('js/custom.js')}}"></script>
	<script src="{{asset('js/scheduleappointment.js')}}"></script>
	<script src="{{asset('js/seemoreannouncements.js')}}"></script>

	<script src="{{asset('js/jquery-tablesorter.js')}}"></script> 
	<script src="{{asset('js/highcharts.js')}}"></script> 
	<script src="{{asset('js/highcharts-3d.js')}}"></script> 
	<script src="{{asset('js/exporting.js')}}"></script> 	 
</head>
<body>
@include('layouts.navbar')
@yield('content')
</body>
</html>