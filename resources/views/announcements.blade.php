@extends('layouts.layout')
@section('title', 'Schedule Appointment | UP Visayas Health Services Unit')
@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<table class="table" id="announcements_table">
			<thead>
		    <tr>
		      <th><h1>Announcements</h1></th>
		    </tr>
		  </thead> 
		  <tbody>
		  	@foreach($announcements as $announcement)
		    <tr>
		      <td>
		      	<h3>{{ $announcement->announcement_title }}</h3><br/>
		      	posted on <span class="announcement_date">{{ Carbon\Carbon::parse($announcement->created_at)->toDayDateTimeString() }}</span><br/><br/>
		      	<p style="width: 120%; text-align:justify" class="announcement_body" id="announcement_body_{{ $announcement->id }}">{{ $announcement->announcement_body }}</p>
		      </td>
		      <td><a class="see_more_announcements" id="{{ $announcement->id }}"><br/>See more <i class="fa fa-caret-down"></i></a></td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
	</div>
</div>

@endsection