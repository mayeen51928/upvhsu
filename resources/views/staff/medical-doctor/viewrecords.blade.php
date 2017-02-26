@extends('layouts.layout')
@section('title', 'View Records | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
	@include('layouts.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="viewAllMedicalRecordsDiv">
        <div class="row">
          <div class="col-md-4 col-md-offset-4" style="text-align: center;">
            <h4>MEDICAL RECORDS HISTORY</h4>
            <table class="table table-hover viewrecordsfromsearch">
              <tr><thead>Date</thead></tr>
              @foreach($records as $record)
              <tr><td><a class="medicalrecorddate" id="medicalappointment_{{$record->id}}">{{date_format(date_create($record->schedule_day), 'F j, Y')}}</a></td></tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

<div class="modal fade" id="viewMedicalRecordBasedOnDateModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 id="viewMedicalRecordBasedOnDateModalTitle">Detailed Patient Record</h3>
			</div>
			<div class="modal-body">
				<div class="row" id="remarkModal">
					<!-- <div class="col-xs-3 col-sm-3 col-md-3">
					<img src="images/mayenne.jpg" width="220" height="220" class="img-responsive" alt="Generic placeholder thumbnail">
					</div> -->
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">Physical Examination</div>
							<div class="panel-body">
							<table class="table" style="margin-bottom: 0px;">
								<tbody>
									<tr><td>Height</td><td id="heightTd"></td></tr>
									<tr><td>Weight</td><td id="weightTd"></td></tr>
									<tr><td>Blood Pressure</td><td id="bpTd"></td></tr>
									<tr><td>Pulse Rate</td><td id="prTd"></td></tr>
									<tr><td>Right Eye</td><td id="righteyeTd"></td></tr>
									<tr><td>Left Eye</td><td id="lefteyeTd"></td></tr>
									<tr><td>Head</td><td id="headTd"></td></tr>
									<tr><td>EENT</td><td id="eentTd"></td></tr>
									<tr><td>Neck</td><td id="neckTd"></td></tr>
									<tr><td>Chest</td><td id="chestTd"></td></tr>
									<tr><td>Heart</td><td id="heartTd"></td></tr>
									<tr><td>Lungs</td><td id="lungsTd"></td></tr>
									<tr><td>Abdomen</td><td id="abdomenTd"></td></tr>
									<tr><td>Back</td><td id="backTd"></td></tr>
									<tr><td>Skin</td><td id="skinTd"></td></tr>
									<tr><td>Extremeties</td><td id="extremitiesTd"></td></tr>
								</tbody>
							</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">CBC Results</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										<tr><td>Hemoglobin</td><td id="hemoglobinTd"></td></tr>
										<tr><td>Hemasocrit</td><td id="hemasocritTd"></td></tr>
										<tr><td>WBC</td><td id="wbcTd"></td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">Urinalysis Results</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										<tr><td>Pus Cells</td><td id="puscellsTd"></td></tr>
										<tr><td>RBC</td><td id="rbcTd"></td></tr>
										<tr><td>Albumin</td><td id="albuminTd"></td></tr>
										<tr><td>Sugar</td><td id="sugarTd"></td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">Fecalysis Results</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										<tr><td>Macroscopic</td><td id="macroscopicTd"></td></tr>
										<tr><td>Microscopic (Parasites)</td><td id="microscopicTd"></td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">Drug Test</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										<tr><td id="drugtestTd"></td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">Chest X-Ray</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										<tr><td id="chestxrayTd"></td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">Remarks</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										<tr><td id="remarksTd"></td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
						<div class="panel-heading">Prescription</div>
						<div class="panel-body">
							<table class="table" style="margin-bottom: 0px;">
								<tbody>
									<tr><td id="prescriptionTd"></td></tr>
								</tbody>
							</table>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection