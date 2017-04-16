@extends('layouts.layout')
@section('title', 'Announcements | UP Visayas Health Services Unit')
@section('content')
<div class="container" id="announcementScreen" style="background-color:#F0F0F0;height:100%;">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@if(count($announcements)>0)
			<table class="table borderless" id="announcements_table">
				<thead>
			    <tr class="borderless">
			      <th>
			      	<br>
			      	<center>
			      		<h1>Announcements</h1>
			      		<h4>Today is {{  Carbon\Carbon::now()->formatLocalized('%A %B %d, %Y') }}</h4>
			      		<i class="fa fa-bullhorn fa-4x"></i>
			      		
			      	</center>
				      @if (session('status'))
				      	<div class="alert alert-success alert-dismissable">
				      		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				      		{{ session('status') }}
				      		<div><a href="/admin"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></div>
				      	</div>
				  		@endif
			  		</th>  
			    </tr>
			  </thead> 
			  <tbody>
			  	@foreach($announcements as $announcement)
			    <tr class="borderless">
			    	<td class="borderless">
			    		<div class="panel panel-default">
							  <div class="panel-body">
							  	<div style="float:right;">
					      		<a class="see_more_announcement btn btn-info" id="see_more_announcement_{{ $announcement->id }}" style="background-color:#990000;border-color:#800000;"><i class="fa fa-caret-down fa-2x"></i></a>
					      		<a class="hide_announcement btn btn-info" id="hide_announcement_{{ $announcement->id }}" style="display:none;background-color:#990000;border-color:#800000;"><i class="fa fa-caret-up fa-2x"></i></a>
					      	</div>
					      	<h3>{{ $announcement->announcement_title }}</h3><br/>
					      	posted on <span class="announcement_date">{{ Carbon\Carbon::parse($announcement->created_at)->toDayDateTimeString() }}</span><br/><br/>
					      	@if($announcement->announcement_title == 'Schedule for Upperclassmen Physical Exam')
					      		<div class="announcement_body" id="announcement_body_{{ $announcement->id }}">
					      		<div class="col-md-7 col-md-offset-2">
					      		{!! $announcement->announcement_body !!}
					      		</div>
					      		</div>
					      	@else
					      	<p style="text-align:justify; width:100%; " class="announcement_body" id="announcement_body_{{ $announcement->id }}">{!! nl2br(e($announcement->announcement_body)) !!}</p>
					      	@endif
					      </div>
					      @if(Auth::check() and $user->user_type_id == '3')
					      <div class="panel-footer">
					      	<form class="form-announcement" action="/announcement/edit" method="POST">{{ csrf_field() }}<input type="hidden" value="{{ $announcement->id }}" name="announcementId"><input type="submit" class="btn btn-primary btn-sm" id="{{ $announcement->id }}" value="Edit" style="margin-top:5px; "></form>
					      	<form class="form-announcement" action="/announcement/delete" method="POST">{{ csrf_field() }}<input type="hidden" value="{{ $announcement->id }}" name="announcementId"><input type="submit" class="btn btn-danger btn-sm" id="{{ $announcement->id }}" value="Delete" style="margin-top:5px; "></form>
							  </div>
							  @endif
							</div> 
			    	</td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
			@else
			<div class="row">
			<br/><br/><br/><br/>
			<p class="center-block">There are no announcements as of the moment.</p>
			</div>
			@endif
		</div>
	</div>
</div>

@endsection