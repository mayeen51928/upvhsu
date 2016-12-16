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

<!-- MODALS -->
<div id="prescriptionModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2>Notes and Prescription from the Doctor</h2>
      </div>
      <div class="modal-body">
        <div class="well" id="remarkModal"></div>
        <div class="acountabilities" id="displayMedicalBillingStatus" style="color:red; font-style:italic; font-size:20px; "></div>
      </div>
      <div class="modal-footer">
        <p id="remarkModalFooter" style="float: right"></p>
      </div>
  	</div>
  </div>
</div>

<div class="modal fade" id="view-dental-record-modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="width:900px; ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Patient Record</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td>CONDITION</td>
                <td>
                  <select class="form-control condition_55" disabled>
                    <option value="condition_55" disabled selected>55</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_54" disabled>
                    <option value="condition_54" disabled selected>54</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_53" disabled>
                    <option value="condition_53" disabled selected>53</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                 <select class="form-control condition_52" disabled>
                    <option value="condition_52" disabled selected>52</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_51" disabled>
                    <option value="condition_51" disabled selected>51</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_61" disabled>
                    <option value="condition_61" disabled selected>61</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_62" disabled>
                    <option value="condition_62" disabled selected>62</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_63" disabled>
                    <option value="condition_63" disabled selected>63</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                  <select class="form-control condition_64" disabled>
                    <option value="condition_64" disabled selected>64</option>
                    <option value="1">Caries free</option>
                    <option value="2">Caries for filting</option>
                    <option value="3">Caries for extraction</option>
                    <option value="4">Root fragment</option>
                    <option value="5">Missing due to carries</option>
                  </select>
                </td>
                <td>
                 <select class="form-control condition_65" disabled>
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
                  <select class="form-control operation_55" disabled>
                    <option value="operation_55" disabled selected>55</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_54" disabled>
                    <option value="operation_54" disabled selected>54</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_53" disabled>
                    <option value="operation_53" disabled selected>53</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_52" disabled>
                    <option value="operation_52" disabled selected>52</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_51" disabled>
                    <option value="operation_51" disabled selected>51</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_61" disabled>
                    <option value="operation_61" disabled selected>61</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_62" disabled>
                    <option value="operation_62" disabled selected>62</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_63" disabled>
                    <option value="operation_63" disabled selected>63</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_64" disabled>
                    <option value="operation_64" disabled selected>64</option>
                    <option value="1">Amalgam filling</option>
                    <option value="2">Silicate filling</option>
                    <option value="3">Extraction due to caries</option>
                    <option value="4">Extraction due to other causes</option>
                    <option value="5">Cement filling</option>
                  </select>
                </td>
                <td>
                  <select class="form-control operation_65" disabled>
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
    </div>
  </div>
</div>
@endsection