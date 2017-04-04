@extends('layouts.layout')
@section('title', 'Staff | UP Visayas Health Services Unit')
@section('content')
<div class="container">

<div class="row staffInfoDiv">
	@foreach($staffs as $staff)
	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
		<div class="medicalStaff">
			<div class="medicalStaffImg @if($staff->staff_type_id == 1 or $staff->staff_type_id==2) clickToShowSchedule @endif" id="medicalStaffImg_{{$staff->staff_id}}">
				@if(is_null($staff->picture))
				<img height="220px" width="220px" class="img-circle center-block" src="{{asset('images/medicalstaff.png')}}"/>
				@else
				<img height="220px" width="220px" class="img-circle center-block" src="{{asset('images/'.$staff->picture)}}"/>
				@endif
				</div>
				<dl class="medicalStaffInfo">
					<dt>{{$staff->staff_last_name}}, {{$staff->staff_first_name}}</dt>
					<dd>@if(!is_null($staff->position)) {{$staff->position}} @else &nbsp; @endif</dd>
				</dl>
			</div>
		</div>
		@endforeach
	</div>
</div>
<div id="staffinfomodal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="staff-modal-title"></h4>
			</div>
			<div class="modal-body" id="staff-modal-body">
				<table class="table table-condensed">
					
				</table>
			</div>
		</div>
	</div>
</div>
@endsection