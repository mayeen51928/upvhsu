@extends('layouts.layout')
@section('title', 'Manage Accounts | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
	@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="adminDashboard">
			<h1 class="page-header">Admin</h1>
			<div class="col-md-9 col-md-offset-1">
				<div class="panel panel-info">
					<div class="panel-heading">Manage Accounts</div>
					<div class="panel-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
				          			<th></th>
				          			<th>Name</th>
				          			<th>User type</th>
				          			<th>User ID</th>
				          			<th></th>
				          		</tr>
				          	</thead>
				          	<tbody>
				          		<?php $row_number = 1; ?>
				          		@foreach($users as $user)
					          	<tr>
					          		<td>{{$row_number}}.</td>
				          			<td>{{$user->user_last_name}}, {{$user->user_first_name}}</td>
				          			<td>{{$user->user_type_description}}</td>
				          			<td>{{$user->user_id}}</td>
				          			<td><button type="button" class="btn btn-xs changepwbutton" id="changepw_{{$user->user_id}}">Change Password</button></td>
				          		</tr>
				          		<?php $row_number++; ?>
				          		@endforeach
			          		</tbody>
			          	</table>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="changepwmodal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Change Password</h4>
			</div>
			<div class="modal-body">
				<p><i>Enter the new password of the user <span id="changepwmodaluser"></span>.</i></p>
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">New password</span>
					<input type="password" class="form-control" id="newpassword" placeholder="Enter new password" aria-describedby="basic-addon1">
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">Confirm new password</span>
					<input type="password" class="form-control" id="confirmnewpassword" placeholder="Confirm new password" aria-describedby="basic-addon1">
				</div>
			</div>
			<div class="modal-footer">
				<div class="pull-left">
					<p id="changepwerrormessage"></p>
				</div>
				<button type="button" class="btn btn-success" id="savepwbutton">Save Password</button>
			</div>
		</div>
	</div>
</div>
@endsection