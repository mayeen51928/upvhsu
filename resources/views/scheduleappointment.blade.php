@extends('layouts.layout')
@section('title', 'Schedule Appointment | UP Visayas Health Services Unit')
@section('content')
<div class="container">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default" style="margin-top: 20px;">
				<div class="panel-heading">Select Type of Appointment</div>
				<div class="panel-body">
				<form class="form-inline">
					<div class="checkbox col-md-6">
						<label><input type="checkbox" name="type_dental" id="typeDental"/> Dental</label>
					</div>
					<div class="checkbox col-md-6">
						<label><input type="checkbox" name="type_medical" id="typeMedical"/> Medical</label>
					</div>
				</form>
				</div>
			</div>	
		</div>
	</div>
	<div class="container">
		<div class="col-md-6 col-md-offset-3" id="dentalAppointment0">
			<div class="panel panel-default" id="dentalAppointment">
				<div class="panel-heading">Schedule Dental Appointment</div>
					<div class="panel-body" id="dentalAppointmentPanelBody">
						<!-- <form action="" method="POST"> -->
							<div class="form-group">
								<label for="dentalNotes">Reasons (e.g. molar toothace):</label>
								<textarea class="form-control" rows="5" required name="dentalNotes" id="dentalNotes"></textarea>
							</div>
							<div class="form-group">
								<label for="selDentalDate">Date:</label>
								<select class="form-control" required id="selDentalDate">
									<option disabled selected> -- select date of appointment -- </option>
									<option>{{ Carbon\Carbon::tomorrow()->format('Y-m-d') }}</option>
									<option>{{ Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}</option>
									<option>{{ Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}</option>
									<option>{{ Carbon\Carbon::now()->addDays(4)->format('Y-m-d') }}</option>
									<option>{{ Carbon\Carbon::now()->addDays(5)->format('Y-m-d') }}</option>
								</select>
							</div>
							<div class="form-group">
								<label>Doctor and Time:</label>
								<select disabled class="form-control" required id="selDentalTime">
									<option disabled selected> -- select doctor and time -- </option>
								</select>
							</div>
							<input type="submit" class="form-control btn btn-success" name="submitDentalAppointment" id="submitDentalAppointment" value="Set Appointment"/>
						<!-- </form> -->
					</div>
			</div>	
		</div>
		<div class="col-md-6 col-md-offset-3" id="medicalAppointment0">
			<div class="panel panel-default" id="medicalAppointment">
				<div class="panel-heading">Schedule Medical Appointment</div>
				<div class="panel-body" id="medicalAppointmentPanelBody">
					<!-- <form action="" method="POST"> -->
					<div class="form-group">
						<label for="medicalNotes">Reasons (e.g. physical pain felt):</label>
						<textarea class="form-control" rows="5" id="medicalNotes"></textarea>
					</div>
					<div class="form-group">
						<label for="selMedicalDate">Date:</label>
						<select class="form-control" required id="selMedicalDate">
							<option disabled selected> -- select date of appointment -- </option>
							<option>{{ Carbon\Carbon::tomorrow()->format('Y-m-d') }}</option>
							<option>{{ Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}</option>
							<option>{{ Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}</option>
							<option>{{ Carbon\Carbon::now()->addDays(4)->format('Y-m-d') }}</option>
							<option>{{ Carbon\Carbon::now()->addDays(5)->format('Y-m-d') }}</option>
						</select>
					</div>
					<div class="form-group">
						<label>Doctor:</label>
						<select disabled class="form-control" required id="selMedicalDoctor">
							<option disabled selected> -- select doctor -- </option>
						</select>
					</div>
					<p id="medicalFormNote"><i>Note: Medical appointment done online is for note-taking purposes of the doctor.  On-site visit will still be accommodated first.</i></p>
					<input type="submit" class="form-control btn btn-success" name="submitMedicalAppointment" id="submitMedicalAppointment" value="Set Appointment"/>
					<!-- </form> -->
				</div>
			</div>	
		</div>
	</div>
<script>
  // token and createPostUrl are needed to be passed to AJAX method call
  var token = '{{csrf_token()}}';
  var displayDentalSchedule = '/displayschedule_dental';
  var displayMedicalSchedule = '/displayschedule_medical';
</script>

@endsection