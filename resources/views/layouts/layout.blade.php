<!DOCTYPE html>
<html lang="eng">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{asset('images/icon.jpg')}}">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="{{asset('css/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" href="{{asset('css/custom.css')}}"/>
	<link rel="stylesheet" href="{{asset('css/dashboard.css')}}"/>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
	<script src="{{asset('js/custom.js')}}"></script>
	
</head>
<body>
@include('layouts.navbar')
@yield('content')
</body>
</html>