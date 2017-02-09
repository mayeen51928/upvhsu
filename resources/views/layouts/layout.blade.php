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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
	{{-- <script src="{{asset('js/bootstrap-timepicker.js')}}"></script> --}}
	<script src="{{asset('js/dental-dentist/dental-dentist.js')}}"></script>
	<script src="{{asset('js/medical-doctor/medical-doctor.js')}}"></script>
	<script src="{{asset('js/medical-lab/medical-lab.js')}}"></script>
	<script src="{{asset('js/medical-xray/medical-xray.js')}}"></script>
	<script src="{{asset('js/cashier/cashier.js')}}"></script>
	{{-- <script src="{{asset('js/custom1.js')}}"></script> --}}
	<script src="{{asset('js/custom.js')}}"></script>
	<script src="{{asset('js/scheduleappointment.js')}}"></script>
	<script src="{{asset('js/seemoreannouncements.js')}}"></script>


	
</head>
<body>
@include('layouts.navbar')
@yield('content')
</body>
</html>