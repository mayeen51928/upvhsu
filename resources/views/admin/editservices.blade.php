@extends('layouts.layout')
@section('title', 'Edit Services Rates | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Admin</h1>
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Edit Medical Services Rate</div>
					<div class="panel-body">
						<div>
							<select class="form-control" id="typeOfPatientMedical">
								<option selected disabled>--- select type of patient ---</option>
								<option value="1">Student</option>
								<option value="2">Faculty</option>
								<option value="3">Staff</option>
								<option value="4">Dependent</option>
								<option value="5">OPD</option>
								<option value="6">Senior Citizen</option>
							</select>
						</div>
						<br/>
						<table id="displayMedicalServicesTable" class="table" style="display: none">
							<tbody id="displayMedicalServices">
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Edit Dental Services Rate</div>
					<div class="panel-body">
						<div>
							<select class="form-control" id="typeOfPatientDental">
								<option selected disabled>--- select type of patient ---</option>
								<option value="1">Student</option>
								<option value="2">Faculty</option>
								<option value="3">Staff</option>
								<option value="4">Dependent</option>
								<option value="5">OPD</option>
								<option value="6">Senior Citizen</option>
							</select>
						</div>
						<br/>
						<div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="editMedicalServices" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Medical Services</h4>
			</div>
			<div class="modal-body">
				<div class="dental_manage">
					<button type="button" class="btn btn-success btn-xs addmoremedicalservices">Add more services</button>
					<br/><br/>
					<table id="displayMedicalServicesTableModal" class="table" style="display: none">
						<tbody id="displayMedicalServicesModal">
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer" id="savechangesbuttonmedical">
				
			</div>
		</div>
	</div>
	</div>
<script>
	// token and createPostUrl are needed to be passed to AJAX method call
	var token = '{{csrf_token()}}';
	var displayMedicalServices = '/display_medical_services';
	var displayDentalServices = '/display_dental_services';
	var editMedicalServices = '/edit_medical_services';
	var updateMedicalServices = '/update_medical_services';
</script>
@endsection