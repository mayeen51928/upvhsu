@extends('layouts.layout')
@section('title', 'Profile | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<form method="POST" action="/updateprofile">
				{{ csrf_field() }}
				<div class="col-md-9">
					<div class="panel panel-info">
						<div class="panel-heading">Basic Information</div>
							<div class="panel-body">
								<table class="table" style="margin-bottom: 0px;">
									<tbody>
										<tr><td>Sex</td><td><select class="form-control" name="sex">
                    <option value="M" @if($sex=="M") selected @endif>M</option>
                    <option value="F" @if($sex=="F") selected @endif>F</option></select></td></tr>
										<tr><td>Course</td><td><select class="form-control" name="degree_program" id="degree_program" required title="Select your degree program.">
                      <option disabled selected>select degree program</option>
												<optgroup label="College of Arts and Sciences">
													<option value="8" @if($degree_program=="8") selected @endif>BS Applied Mathematics</option>
													<option value="9" @if($degree_program=="9") selected @endif>BS Biology</option>
													<option value="10" @if($degree_program=="10") selected @endif>BS Chemistry</option>
													<option value="7" @if($degree_program=="7") selected @endif>BA Communication and Media Studies</option>
													<option value="1" @if($degree_program=="1") selected @endif>BA Community Development</option>
													<option value="11" @if($degree_program=="11") selected @endif>BS Computer Science</option>
													<option value="12" @if($degree_program=="12") selected @endif>BS Economics</option>
													<option value="2" @if($degree_program=="2") selected @endif>BA History</option>
													<option value="3" @if($degree_program=="3") selected @endif>BA Literature</option>
													<option value="4" @if($degree_program=="4") selected @endif>BA Political Science</option>
													<option value="5" @if($degree_program=="5") selected @endif>BA Psychology</option>
													<option value="13" @if($degree_program=="13") selected @endif>BS Public Health</option>
													<option value="6" @if($degree_program=="6") selected @endif>BA Sociology</option>
													<option value="14" @if($degree_program=="14") selected @endif>BS Statistics</option>
													<option value="15" @if($degree_program=="15") selected @endif>Master of Chemistry</option>
													<option value="16" @if($degree_program=="16") selected @endif>Master of Education (Biology)</option>
													<option value="17" @if($degree_program=="17") selected @endif>Master of Education (English as a Second Language)</option>
													<option value="18" @if($degree_program=="18") selected @endif>Master of Education (Filipino)</option>
													<option value="19" @if($degree_program=="19") selected @endif>Master of Education (Guidance)</option>
													<option value="20" @if($degree_program=="20") selected @endif>Master of Education (Mathematics)</option>
													<option value="21" @if($degree_program=="21") selected @endif>Master of Education (Physics)</option>
													<option value="22" @if($degree_program=="22") selected @endif>Master of Education (Reading)</option>
													<option value="23" @if($degree_program=="23") selected @endif>Master of Education (Social Studies)</option>
													<option value="24" @if($degree_program=="24") selected @endif>MS Biology</option>
												</optgroup>
												<optgroup label="College of Fisheries and Ocean Sciences">
													<option value="25" @if($degree_program=="25") selected @endif>BS Fisheries</option>
													<option value="26" @if($degree_program=="26") selected @endif>Master of Aquaculture</option>
													<option value="27" @if($degree_program=="27") selected @endif>Master of Marine Affairs</option>
													<option value="28" @if($degree_program=="28") selected @endif>MS Fisheries (Aquaculture)</option>
													<option value="29" @if($degree_program=="29") selected @endif>MS Fisheries (Fisheries Biology)</option>
													<option value="30" @if($degree_program=="30") selected @endif>MS Fisheries (Fish Processing Technology)</option>
													<option value="31" @if($degree_program=="31") selected @endif>MS Ocean Sciences</option>
													<option value="32" @if($degree_program=="32") selected @endif>Professional Masters in Tropical Marines</option>
													<option value="33" @if($degree_program=="33") selected @endif>PhD Fisheries</option>
												</optgroup>
												<optgroup label="College of Management">
													<option value="34" @if($degree_program=="34") selected @endif>BS Accountancy</option>
													<option value="35" @if($degree_program=="35") selected @endif>BS Business Administration (Marketing)</option>
													<option value="36" @if($degree_program=="36") selected @endif>BS Management</option>
													<option value="37" @if($degree_program=="37") selected @endif>Master of Management (Business Management)</option>
													<option value="38" @if($degree_program=="38") selected @endif>Master of Management (Public Management)</option>
													<option value="39" @if($degree_program=="39") selected @endif>Diploma in Urban and Regional Planning</option>
												</optgroup>
												<optgroup label="School of Technology">
													<option value="41" @if($degree_program=="41") selected @endif>BS Chemical Engineering</option>
													<option value="40" @if($degree_program=="40") selected @endif>BS Food Technology</option>
												</optgroup>
											</select>
											</td></tr>
									</tbody>
								</table>
              </div>
            </div>
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3">
            Image here
            {{-- <img src="images/mayenne.jpg" width="220" height="220" class="img-responsive" alt="Generic placeholder thumbnail"> --}}
          </div>
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Personal Data</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Date of Birth</td><td><input type="date" class="form-control" value="{{$birthday}}"/></td></tr>
                  <tr><td>Religion</td><td><input type="text" class="form-control" value="{{$religion}}" placeholder="Religion" /></td></tr>
                  <tr><td>Nationality</td><td><input type="text" class="form-control" value="{{$nationality}}" placeholder="Nationality" /></td></tr>
                  <tr><td>Father</td><td><input type="text" class="form-control" value="{{$father_first_name}}" placeholder="Father's Given Name" /><input type="text" class="form-control" value="{{$father_middle_name}}" placeholder="Father's Middle Name" /><input type="text" class="form-control" value="{{$father_last_name}}" placeholder="Father's Last Name" /></td></tr>
                  <tr><td>Mother</td><td><input type="text" class="form-control" value="{{$mother_first_name}}" placeholder="Mother's Given Name" /><input type="text" class="form-control" value="{{$mother_middle_name}}" placeholder="Mother's Middle Name" /><input type="text" class="form-control" value="{{$mother_last_name}}" placeholder="Mother's Last Name" /></td></tr>
                  <tr><td>Home Address</td><td><input type="text" class="form-control" value="{{$street}}"/><input type="text" class="form-control" value="{{$town}}"/>
                  {{-- <select class="form-control" id="POBProvince" name="POBProvince" onchange="provinceChanged(this, '#POBMunicipality')"><option disabled="disabled" selected="selected" value="">Province</option>
                  <option value="1">Abra</option>
                  <option value="2">Agusan del Norte</option>
                  <option value="3">Agusan del Sur</option>
                  <option value="4">Aklan</option>
                  <option value="5">Albay</option>
                  <option value="6">Antique</option>
                  <option value="7">Apayao</option>
                  <option value="8">Aurora</option>
                  <option value="9">Basilan</option>
                  <option value="10">Bataan</option>
                  <option value="11">Batanes</option>
                  <option value="12">Batangas</option>
                  <option value="13">Benguet</option>
                  <option value="14">Biliran</option>
                  <option value="15">Bohol</option>
                  <option value="16">Bukidnon</option>
                  <option value="17">Bulacan</option>
                  <option value="18">Cagayan</option>
                  <option value="19">Camarines Norte</option>
                  <option value="20">Camarines Sur</option>
                  <option value="21">Camiguin</option>
                  <option value="22">Capiz</option>
                  <option value="23">Catanduanes</option>
                  <option value="24">Cavite</option>
                  <option value="25">Cebu</option>
                  <option value="26">Compostela Valley</option>
                  <option value="27">Davao del Norte</option>
                  <option value="28">Davao del Sur</option>
                  <option value="29">Davao Occidental</option>
                  <option value="30">Davao Oriental</option>
                  <option value="31">Eastern Samar</option>
                  <option value="32">Guimaras</option>
                  <option value="33">Ifugao</option>
                  <option value="34">Ilocos Norte</option>
                  <option value="35">Ilocos Sur</option>
                  <option value="36">Iloilo</option>
                  <option value="37">Isabela</option>
                  <option value="38">Kalinga</option>
                  <option value="39">Kalinga Apayao</option>
                  <option value="40">La Union</option>
                  <option value="41">Laguna</option>
                  <option value="42">Lanao del Norte</option>
                  <option value="43">Lanao del Sur</option>
                  <option value="44">Leyte</option>
                  <option value="45">Maguindanao</option>
                  <option value="46">Marinduque</option>
                  <option value="47">Masbate</option>
                  <option value="48">Metro Manila</option>
                  <option value="49">Misamis Occidental</option>
                  <option value="50">Misamis Oriental</option>
                  <option value="51">Mountain Province</option>
                  <option value="52">Negros Occidental</option>
                  <option value="53">Negros Oriental</option>
                  <option value="54">North Cotabato</option>
                  <option value="55">Northern Samar</option>
                  <option value="56">Nueva Ecija</option>
                  <option value="57">Nueva Vizcaya</option>
                  <option value="58">Occidental Mindoro</option>
                  <option value="59">Oriental Mindoro</option>
                  <option value="60">Palawan</option>
                  <option value="61">Pampanga</option>
                  <option value="62">Pangasinan</option>
                  <option value="63">Quezon</option>
                  <option value="64">Quirino</option>
                  <option value="65">Rizal</option>
                  <option value="66">Romblon</option>
                  <option value="67">Sarangani</option>
                  <option value="68">Shariff Kabunsuan</option>
                  <option value="69">Siquijor</option>
                  <option value="70">Sorsogon</option>
                  <option value="71">Sorsogon City</option>
                  <option value="72">South Cotabato</option>
                  <option value="73">Southern Leyte</option>
                  <option value="74">Sultan Kudarat</option>
                  <option value="75">Sulu</option>
                  <option value="76">Surigao del Norte</option>
                  <option value="77">Surigao del Sur</option>
                  <option value="78">Tarlac</option>
                  <option value="79">Tawi Tawi</option>
                  <option value="80">Tayabas</option>
                  <option value="81">Western Samar</option>
                  <option value="82">Zambales</option>
                  <option value="83">Zamboanga del Norte</option>
                  <option value="84">Zamboanga del Sur</option>
                  <option value="85">Zamboanga Sibugay</option>
                  </select> --}}<input type="text" class="form-control" value="{{$province}}"/></td></tr>
                  <tr><td>Residence Telephone Number</td><td><input type="text" class="form-control" value="{{$residence_telephone_number}}"/></td></tr>
                  <tr><td>Residence Contact Number</td><td><input type="text" class="form-control" value="{{$residence_contact_number}}"/></td></tr>
                  <tr><td>Personal Contact Number</td><td><input type="text" class="form-control" value="{{$personal_contact_number}}"/></td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Guardian/Person to be Contacted in Case of Emergency</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Name</td><td><input type="text" class="form-control" value="{{$guardian_first_name}}" placeholder="Guardian's First Name" /><input type="text" class="form-control" value="{{$guardian_middle_name}}" placeholder="Guardian's Middle Name" /><input type="text" class="form-control" value="{{$guardian_last_name}}" placeholder="Guardian's Last Name" /></td></tr>
                  <tr><td>Address</td><td><input type="text" class="form-control" value="{{$guardian_street}}"/><input type="text" class="form-control" value="{{$guardian_town}}"/><input type="text" class="form-control" value="{{$guardian_province}}"/></td></tr>
                  <tr><td>Relationship</td><td><input type="text" class="form-control" value="{{$relationship}}"/></td></tr>
                  <tr><td>Residence Telephone Number</td><td><input type="text" class="form-control" value="{{$guardian_tel_number}}"/></td></tr>
                  <tr><td>Cellphone Number</td><td><input type="text" class="form-control" value="{{$guardian_cellphone}}"/></td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          <div class="col-md-12">
          <div class="clearfix">
          <div class="pull-left">
          <a href="{{ url('account/profile/edit') }}" class="btn btn-primary" role="button">Edit Profile</a>
          </div>
          </div>
          </div>
          </form>
          </div>
	</div>
</div>

@endsection