@extends('layouts.layout')
@section('title', 'Announcements | UP Visayas Health Services Unit')
@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<table class="table" id="announcements_table">
			<thead>
		    <tr>
		      <th><h1>Announcements</h1>@if (session('status'))
		      	<div class="alert alert-success alert-dismissable">
		      		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		      		{{ session('status') }}
		      		<div><a href="/admin"><span class="glyphicon glyphicon-arrow-left"></span> Back</a></div>
		      	</div>
		  @endif</th>
		      
		    </tr>
		  </thead> 
		  <tbody>
		  	@foreach($announcements as $announcement)
		    <tr>
		      <td>
		      	<h3>{{ $announcement->announcement_title }}</h3><br/>
		      	posted on <span class="announcement_date">{{ Carbon\Carbon::parse($announcement->created_at)->toDayDateTimeString() }}</span><br/><br/>
		      	<p style="text-align:justify; width:120%; " class="announcement_body" id="announcement_body_{{ $announcement->id }}">{!! nl2br(e($announcement->announcement_body)) !!}</p>
		      	@if(Auth::check() and $user->user_type_id == '3')
		      	<form action="/announcement/edit" method="POST">{{ csrf_field() }}<input type="hidden" value="{{ $announcement->id }}" name="announcementId"><input type="submit" class="btn btn-primary btn-sm" id="{{ $announcement->id }}" value="Edit Announcement" style="margin-top:5px; "></form>
		      	<form action="/announcement/delete" method="POST">{{ csrf_field() }}<input type="hidden" value="{{ $announcement->id }}" name="announcementId"><input type="submit" class="btn btn-danger btn-sm" id="{{ $announcement->id }}" value="Delete" style="margin-top:5px; "></form>
		      	@endif
		      </td>
		      <td>
		      	<a class="see_more_announcement" id="see_more_announcement_{{ $announcement->id }}"><br/>See more <i class="fa fa-caret-down"></i></a>
		      	<a class="hide_announcement" id="hide_announcement_{{ $announcement->id }}" style="display:none; "><br/>See more <i class="fa fa-caret-up"></i></a>
		      </td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
	</div>
</div>

@endsection