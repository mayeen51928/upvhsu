@extends('layouts.layout')
@section('title', 'About | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid" style="background-color:#F0F0F0;">
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<img src="images/infirmary_about.jpg" class="img-responsive" alt="Cinque Terre">
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-8 col-md-offset-2" style="background-color:white;">
		<center>
			<br>
			<i class="fa fa-users fa-3x" aria-hidden="true"></i>
			<h2>About Us</h2>
			<p style="font-size: 20px;">University Of The Philippines Visayas Health Services Unit in Iloilo is a training center located in Iloilo, Philippines. 
			You can contact them on directly on phone-(033) 315 9632 or you can visit them at their physical address in Iloilo which is 
			University Of The Philippines Visayas, Quezon Street, Miagao, 5023, Iloilo.</p>
		</center>
		<br><br>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-8 col-md-offset-2" style="background-color:white;">
		<div class="col-md-3 col-sm-6 col-xs-6" id="about_medical">
			<br>
			<center><i class="fa fa-medkit fa-5x fa-border fa-align-center" aria-hidden="true"></i>
			<h4>Medical Services</h4></center>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-6" id="about_dental">
			<br>
			<center><i class="fa fa-asterisk fa-5x fa-border fa-align-center" aria-hidden="true" ></i>
			<h4>Dental Services</h4></center>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-6" id="about_lab">
			<br>
			<center><i class="fa fa-flask fa-5x fa-border fa-align-center" aria-hidden="true"></i>
			<h4>Lab Services</h4></center>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-6" id="about_xray">
			<br>
			<center><i class="fa fa-id-badge fa-5x fa-border fa-align-center" aria-hidden="true"></i>
			<h4>Xray Services</h4></center>
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-8 col-md-offset-2" style="background-color:white;">
		<center>
			<br>
			<i class="fa fa-phone fa-3x" aria-hidden="true"></i>
			<h3>Contact Us</h3>
			Tel : <b>+32(0) 1636 009</b><br>
			Fax : <b>+32(0) 1636 009</b><br>
			<div class="col-md-4 col-md-offset-4">
				<i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i>
				<i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i>
				<i class="fa fa-google-plus-square fa-2x" aria-hidden="true"></i>
				<i class="fa fa-youtube-square fa-2x" aria-hidden="true"></i>
			</div>
		</center>
	</div>
</div>

<div id="medicalServicesModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Medical Services</h4>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#studentmedicalservice">Student</a></li>
					<li><a data-toggle="tab" href="#facultymedicalservice">Faculty</a></li>
					<li><a data-toggle="tab" href="#staffmedicalservice">Staff</a></li>
					<li><a data-toggle="tab" href="#dependentmedicalservice">UPV Dependent</a></li>
					<li><a data-toggle="tab" href="#opdmedicalservice">OPD</a></li>
					<li><a data-toggle="tab" href="#seniormedicalservice">Senior Citizen</a></li>
				</ul>
				<div class="tab-content">
					<div class="table-responsive tab-pane fade in active" id="studentmedicalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($studentdisplaymedicalservices as $studentdisplaymedicalservice)
								<tr>
									<td>{{ $studentdisplaymedicalservice->service_description }}</td>
									<td>Php {{ $studentdisplaymedicalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="facultymedicalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($facultydisplaymedicalservices as $facultydisplaymedicalservice)
								<tr>
									<td>{{ $facultydisplaymedicalservice->service_description }}</td>
									<td>Php {{ $facultydisplaymedicalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="staffmedicalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($staffdisplaymedicalservices as $staffdisplaymedicalservice)
								<tr>
									<td>{{ $staffdisplaymedicalservice->service_description }}</td>
									<td>Php {{ $staffdisplaymedicalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="dependentmedicalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($dependentdisplaymedicalservices as $dependentdisplaymedicalservice)
								<tr>
									<td>{{ $dependentdisplaymedicalservice->service_description }}</td>
									<td>{{ $dependentdisplaymedicalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="opdmedicalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($opddisplaymedicalservices as $opddisplaymedicalservice)
								<tr>
									<td>{{ $opddisplaymedicalservice->service_description }}</td>
									<td>{{ $opddisplaymedicalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="seniormedicalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($seniordisplaymedicalservices as $seniordisplaymedicalservice)
								<tr>
									<td>{{ $seniordisplaymedicalservice->service_description }}</td>
									<td>{{ $seniordisplaymedicalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div id="dentalServicesModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Dental Services</h4>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#studentdentalservice">Student</a></li>
					<li><a data-toggle="tab" href="#facultydentalservice">Faculty</a></li>
					<li><a data-toggle="tab" href="#staffdentalservice">Staff</a></li>
					<li><a data-toggle="tab" href="#dependentdentalservice">UPV Dependent</a></li>
					<li><a data-toggle="tab" href="#opddentalservice">OPD</a></li>
					<li><a data-toggle="tab" href="#seniordentalservice">Senior Citizen</a></li>
				</ul>
				<div class="tab-content">
					<div class="table-responsive tab-pane fade in active" id="studentdentalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($studentdisplaydentalservices as $studentdisplaydentalservice)
								<tr>
									<td>{{ $studentdisplaydentalservice->service_description }}</td>
									<td>{{ $studentdisplaydentalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="facultydentalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($facultydisplaydentalservices as $facultydisplaydentalservice)
								<tr>
									<td>{{ $facultydisplaydentalservice->service_description }}</td>
									<td>{{ $facultydisplaydentalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="staffdentalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($staffdisplaydentalservices as $staffdisplaydentalservice)
								<tr>
									<td>{{ $staffdisplaydentalservice->service_description }}</td>
									<td>{{ $staffdisplaydentalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="dependentdentalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($dependentdisplaydentalservices as $dependentdisplaydentalservice)
								<tr>
									<td>{{ $dependentdisplaydentalservice->service_description }}</td>
									<td>{{ $dependentdisplaydentalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="opddentalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($opddisplaydentalservices as $opddisplaydentalservice)
								<tr>
									<td>{{ $opddisplaydentalservice->service_description }}</td>
									<td>{{ $opddisplaydentalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="seniordentalservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($seniordisplaydentalservices as $seniordisplaydentalservice)
								<tr>
									<td>{{ $seniordisplaydentalservice->service_description }}</td>
									<td>{{ $seniordisplaydentalservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="labServicesModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Lab Services</h4>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#studentlabservice">Student</a></li>
					<li><a data-toggle="tab" href="#facultylabservice">Faculty</a></li>
					<li><a data-toggle="tab" href="#stafflabservice">Staff</a></li>
					<li><a data-toggle="tab" href="#dependentlabservice">UPV Dependent</a></li>
					<li><a data-toggle="tab" href="#opdlabservice">OPD</a></li>
					<li><a data-toggle="tab" href="#seniorlabservice">Senior Citizen</a></li>
				</ul>
				<div class="tab-content">
					<div class="table-responsive tab-pane fade in active" id="studentlabservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($studentdisplaycbcservices as $studentdisplaycbcservice)
								<tr>
									<td>{{ $studentdisplaycbcservice->service_description }}</td>
									<td>{{ $studentdisplaycbcservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($studentdisplaydrugservices as $studentdisplaydrugservice)
								<tr>
									<td>{{ $studentdisplaydrugservice->service_description }}</td>
									<td>{{ $studentdisplaydrugservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($studentdisplayurinalysisservices as $studentdisplayurinalysisservice)
								<tr>
									<td>{{ $studentdisplayurinalysisservice->service_description }}</td>
									<td>{{ $studentdisplayurinalysisservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($studentdisplayfecalysisservices as $studentdisplayfecalysisservice)
								<tr>
									<td>{{ $studentdisplayfecalysisservice->service_description }}</td>
									<td>{{ $studentdisplayfecalysisservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="facultylabservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($facultydisplaycbcservices as $facultydisplaycbcservice)
								<tr>
									<td>{{ $facultydisplaycbcservice->service_description }}</td>
									<td>{{ $facultydisplaycbcservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($facultydisplaydrugservices as $facultydisplaydrugservice)
								<tr>
									<td>{{ $facultydisplaydrugservice->service_description }}</td>
									<td>{{ $facultydisplaydrugservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($facultydisplayurinalysisservices as $facultydisplayurinalysisservice)
								<tr>
									<td>{{ $facultydisplayurinalysisservice->service_description }}</td>
									<td>{{ $facultydisplayurinalysisservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($facultydisplayfecalysisservices as $facultydisplayfecalysisservice)
								<tr>
									<td>{{ $facultydisplayfecalysisservice->service_description }}</td>
									<td>{{ $facultydisplayfecalysisservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane fade in active" id="stafflabservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($staffdisplaycbcservices as $staffdisplaycbcservice)
								<tr>
									<td>{{ $staffdisplaycbcservice->service_description }}</td>
									<td>{{ $staffdisplaycbcservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($staffdisplaydrugservices as $staffdisplaydrugservice)
								<tr>
									<td>{{ $staffdisplaydrugservice->service_description }}</td>
									<td>{{ $staffdisplaydrugservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($staffdisplayurinalysisservices as $staffdisplayurinalysisservice)
								<tr>
									<td>{{ $staffdisplayurinalysisservice->service_description }}</td>
									<td>{{ $staffdisplayurinalysisservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($staffdisplayfecalysisservices as $staffdisplayfecalysisservice)
								<tr>
									<td>{{ $staffdisplayfecalysisservice->service_description }}</td>
									<td>{{ $staffdisplayfecalysisservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane fade in active" id="dependentlabservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($dependentdisplaycbcservices as $dependentdisplaycbcservice)
								<tr>
									<td>{{ $dependentdisplaycbcservice->service_description }}</td>
									<td>{{ $dependentdisplaycbcservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($dependentdisplaydrugservices as $dependentdisplaydrugservice)
								<tr>
									<td>{{ $dependentdisplaydrugservice->service_description }}</td>
									<td>{{ $dependentdisplaydrugservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($dependentdisplayurinalysisservices as $dependentdisplayurinalysisservice)
								<tr>
									<td>{{ $dependentdisplayurinalysisservice->service_description }}</td>
									<td>{{ $dependentdisplayurinalysisservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($dependentdisplayfecalysisservices as $dependentdisplayfecalysisservice)
								<tr>
									<td>{{ $dependentdisplayfecalysisservice->service_description }}</td>
									<td>{{ $dependentdisplayfecalysisservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane fade in active" id="opdlabservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($opddisplaycbcservices as $opddisplaycbcservice)
								<tr>
									<td>{{ $opddisplaycbcservice->service_description }}</td>
									<td>{{ $opddisplaycbcservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($opddisplaydrugservices as $opddisplaydrugservice)
								<tr>
									<td>{{ $opddisplaydrugservice->service_description }}</td>
									<td>{{ $opddisplaydrugservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($opddisplayurinalysisservices as $opddisplayurinalysisservice)
								<tr>
									<td>{{ $opddisplayurinalysisservice->service_description }}</td>
									<td>{{ $opddisplayurinalysisservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($opddisplayfecalysisservices as $opddisplayfecalysisservice)
								<tr>
									<td>{{ $opddisplayfecalysisservice->service_description }}</td>
									<td>{{ $opddisplayfecalysisservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane fade in active" id="seniorlabservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($seniordisplaycbcservices as $seniordisplaycbcservice)
								<tr>
									<td>{{ $seniordisplaycbcservice->service_description }}</td>
									<td>{{ $seniordisplaycbcservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($seniordisplaydrugservices as $seniordisplaydrugservice)
								<tr>
									<td>{{ $seniordisplaydrugservice->service_description }}</td>
									<td>{{ $seniordisplaydrugservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($seniordisplayurinalysisservices as $seniordisplayurinalysisservice)
								<tr>
									<td>{{ $seniordisplayurinalysisservice->service_description }}</td>
									<td>{{ $seniordisplayurinalysisservice->service_rate }}</td>
								</tr>
								@endforeach
								@foreach($seniordisplayfecalysisservices as $seniordisplayfecalysisservice)
								<tr>
									<td>{{ $seniordisplayfecalysisservice->service_description }}</td>
									<td>{{ $seniordisplayfecalysisservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="xrayServicesModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Xray Services</h4>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#studentxrayservice">Student</a></li>
					<li><a data-toggle="tab" href="#facultyxrayservice">Faculty</a></li>
					<li><a data-toggle="tab" href="#staffxrayservice">Staff</a></li>
					<li><a data-toggle="tab" href="#dependentxrayservice">UPV Dependent</a></li>
					<li><a data-toggle="tab" href="#opdxrayservice">OPD</a></li>
					<li><a data-toggle="tab" href="#seniorxrayservice">Senior Citizen</a></li>
				</ul>
				<div class="tab-content">
					<div class="table-responsive tab-pane fade in active" id="studentxrayservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($studentdisplayxrayservices as $studentdisplayxrayservice)
								<tr>
									<td>{{ $studentdisplayxrayservice->service_description }}</td>
									<td>{{ $studentdisplayxrayservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="facultyxrayservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($facultydisplayxrayservices as $facultydisplayxrayservice)
								<tr>
									<td>{{ $facultydisplayxrayservice->service_description }}</td>
									<td>{{ $facultydisplayxrayservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="staffxrayservice">
							<tbody>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
								@foreach($staffdisplayxrayservices as $staffdisplayxrayservice)
								<tr>
									<td>{{ $staffdisplayxrayservice->service_description }}</td>
									<td>{{ $staffdisplayxrayservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="dependentxrayservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($dependentdisplayxrayservices as $dependentdisplayxrayservice)
								<tr>
									<td>{{ $dependentdisplayxrayservice->service_description }}</td>
									<td>{{ $dependentdisplayxrayservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="opdxrayservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($opddisplayxrayservices as $opddisplayxrayservice)
								<tr>
									<td>{{ $opddisplayxrayservice->service_description }}</td>
									<td>{{ $opddisplayxrayservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="table-responsive tab-pane" id="seniorxrayservice">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Service Name</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach($seniordisplayxrayservices as $seniordisplayxrayservice)
								<tr>
									<td>{{ $seniordisplayxrayservice->service_description }}</td>
									<td>{{ $seniordisplayxrayservice->service_rate }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection