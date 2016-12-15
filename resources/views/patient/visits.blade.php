@extends('layouts.layout')
@section('title', 'Visits History | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
	@include('layouts.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
		<div class="col-md-5">
			<div class="panel panel-info">
				<div class="panel-heading">Medical</div>
				<div class="panel-body">
					<table class="table" style="margin-bottom: 0px;">
						<tbody>
							<tr>
								<td style="text-align: center;">
									<a class="view_medical_history" id="view_medical_history_appointmentid">Date here</a>
								</td>
							</tr>
							{{-- <p>No record yet.</p> --}}
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="panel panel-info">
				<div class="panel-heading">Dental</div>
				<div class="panel-body">
					<table class="table" style="margin-bottom: 0px;">
						<tbody>
							<tr>
								<td style="text-align: center;">
									<a class="view_dental_history" id="view_dental_history_appointmentid">Date here</a>
								</td>
							</tr>
							{{-- <p>No record yet.</p> --}}
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>
  </div>
</div>
@endsection