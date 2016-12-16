@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
			<h1 class="page-header">{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</h1>
			<div class="row placeholders">
				<div class="col-xs-3 col-sm-3 col-md-3 placeholder">
					<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				</div>
				<div class="col-xs-9 col-sm-9 col-md-9 placeholder">
					Info here
				</div>
			</div>
			<h2 class="sub-header">Appointments</h2>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Name</th>
							<th>Time</th>
							<th>Reasons</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td id="patient_name"><p class="createNewRecordModalDental">John Mission</p></td>
							<td>9:00 PM</td>
							<td>Wisdom tooth.</td>
							<td><button class="btn btn-primary btn-xs addDentalRecordButton">Update Diagnosis</button></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="create-dental-record-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="width:900px; ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Patient Record</h4>
        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" id="changeProgress_DentalDiagnosis" style="width:50%">1 of 2</div>
        </div>
      </div>
      <div class="modal-body">
        <!-- PERSONAL INFORMATION -->
        <div class="personal-information">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Name</h4>
              <div class="personal-information-name"></div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Time</h4>
              <div class="personal-information-time"></div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <h4>Reasons</h4>
              <div class="personal-information-reasons"></div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td>CONDITION</td>
                <td>
                  <select class="form-control condition_55">
                    <option value="condition_55" disabled selected>55</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_54">
                    <option value="condition_54" disabled selected>54</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_53">
                    <option value="condition_53" disabled selected>53</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                 <select class="form-control condition_52">
                    <option value="condition_52" disabled selected>52</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_51">
                    <option value="condition_51" disabled selected>51</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_61">
                    <option value="condition_61" disabled selected>61</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_62">
                    <option value="condition_62" disabled selected>62</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_63">
                    <option value="condition_63" disabled selected>63</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_64">
                    <option value="condition_64" disabled selected>64</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                 <select class="form-control condition_65">
                    <option value="condition_65" disabled selected>65</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
              </tr>

              <tr>
                <td>OPERATION</td>
                <td>
                  <select class="form-control operation_55">
                    <option value="operation_55" disabled selected>55</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_54">
                    <option value="operation_54" disabled selected>54</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_53">
                    <option value="operation_53" disabled selected>53</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_52">
                    <option value="operation_52" disabled selected>52</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_51">
                    <option value="operation_51" disabled selected>51</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_61">
                    <option value="operation_61" disabled selected>61</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_62">
                    <option value="operation_62" disabled selected>62</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_63">
                    <option value="operation_63" disabled selected>63</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_64">
                    <option value="operation_64" disabled selected>64</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_65">
                    <option value="operation_65" disabled selected>65</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
       <span style="float: left; margin-right: 4px"><button type="button" class="btn btn-info" id="backButtonMedicalDiagnosis">Back</button></span>
        <span style="float: left"><button type="button" class="btn btn-info" id="nextButtonMedicalDiagnosis">Next</button></span>
        <span class="dental-button-container"></span>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection