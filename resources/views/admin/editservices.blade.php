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
						<select class="form-control" id="typeOfMedicalService">
							<option selected disabled>Select type of Service</option>
							<option value="medical">Medical</option>
							<option value="cbc">Cbc</option>
							<option value="drugtest">Drugtest</option>
							<option value="fecalysis">Fecalysis</option>
							<option value="urinalysis">Urinalysis</option>
							<option value="xray">X-ray</option>
						</select>
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
						<button type="button" class="btn btn-success btn-block editDentalServicesButton" data-toggle="modal">Add/Edit Record</button>
						<br/>
						<table id="displayDentalServicesTable" class="table">
							<tbody id="displayDentalServices">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="editMedicalServices" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Medical Services</h4>
			</div>
			<div class="modal-body">
				<div class="add-more-medical">
					<button type="button" class="btn btn-success btn-xs addmoremedicalservices" style="display:none">Add more services</button>
					<br/><br/>
					<table id="displayMedicalServicesTableModal" class="table table-responsive" style="display: none">
						<tbody id="displayMedicalServicesModal">
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer" id="savechangesbuttonmedical">
				<div class="error_msg_medical" style="color:red; float:left;">Please fill all fields.</div>
			</div>
		</div>
	</div>
</div>

<div id="editDentalServices" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Dental Services</h4>
			</div>
			<div class="modal-body">
				<div class="add-more-dental">
					<button type="button" class="btn btn-success btn-xs addmoredentalservices">Add more services</button>
					<br/><br/>
					<table id="displayDentalServicesTableModal" class="table table-responsive" style="display: none">
						<tbody id="displayDentalServicesModal">
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer" id="savechangesbuttondental">
				<div class="error_msg_dental" style="color:red; float:left;">Please fill all fields.</div>
			</div>
		</div>
	</div>
</div>
@endsection