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
		      	<p style="width: 120%; text-align:justify" class="announcement_body" id="announcement_body_{{ $announcement->id }}">{!! nl2br(e($announcement->announcement_body)) !!}</p>
		      </td>
		      <td class="see_more_button"><a class="see_more_announcements" id="see_more_announcements_{{ $announcement->id }}"><br/>See more <i class="fa fa-caret-down"></i></a></td>
		    </tr>
		    @endforeach
		  </tbody>
		</table>
	</div>
</div>

@endsection