$(document).ready( function(){
$.ajaxSetup({
	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
// ------------------DASHBOARD---------------
// 

$('input:radio[name="cbc_radio"]').change(function(){
	if ($(this).val() == 'outside') {
		// console.log("outside");
		$('.checkboxLabService').attr('disabled', 'disabled');
		$('.checkboxLabService').removeAttr('checked');
		$('#hemoglobin-lab').removeAttr('disabled');
		$('#hemasocrit-lab').removeAttr('disabled');
		$('#wbc-lab').removeAttr('disabled');
	}
	else{
		// console.log("inside");
		$('.checkboxLabService').removeAttr('disabled');
		$('#hemoglobin-lab').val('');
		$('#hemasocrit-lab').val('');
		$('#wbc-lab').val('');
		$('#hemoglobin-lab').attr('disabled', 'disabled');
		$('#hemasocrit-lab').attr('disabled', 'disabled');
		$('#wbc-lab').attr('disabled', 'disabled');
	}
});

var checkboxLabServiceCounter = 0;
$('.checkboxLabService').click(function(){
	if($(this).is(':checked'))
	{
		checkboxLabServiceCounter++;
	}
	else
	{
		checkboxLabServiceCounter--;
	}
	if(checkboxLabServiceCounter>0)
	{
		$('#hemoglobin-lab').removeAttr('disabled');
		$('#hemasocrit-lab').removeAttr('disabled');
		$('#wbc-lab').removeAttr('disabled');
		// $('.cbc_radio').removeAttr('disabled');
	}
	else
	{
		$('#hemoglobin-lab').val('');
		$('#hemasocrit-lab').val('');
		$('#wbc-lab').val('');
		$('#hemoglobin-lab').attr('disabled', 'disabled');
		$('#hemasocrit-lab').attr('disabled', 'disabled');
		$('#wbc-lab').attr('disabled', 'disabled');
		// $('.cbc_radio').attr('disabled', 'disabled');
	}
});
$('.addLabResult').click(function(){
	$('#labdiagnosisaccordion textarea, #labdiagnosisaccordion select').removeAttr('disabled');
	$('input[value="inside"]').prop("checked",true)
	$('.cbc_radio').removeAttr('disabled');
	$('.drug_radio').removeAttr('disabled');
	$('.fecalysis_radio').removeAttr('disabled');
	$('.urinalysis_radio').removeAttr('disabled');
	$('.checkboxLabService').removeAttr('disabled').removeAttr('checked');
	// $('#labbillingaccordion').load(location.href + " #labbillingaccordionbody");
	var medical_appointment_id = $(this).attr('id').split("_")[1];
	$('#laboratoryresult-lab #cbc_div, #laboratoryresult-lab #drug_test_div, #laboratoryresult-lab #fecalysis_div, #laboratoryresult-lab #urinalysis_div').hide();
	$('#hemoglobin-lab, #hemasocrit-lab, #wbc-lab, #macroscopic-lab, #microscopic-lab, #rbc-lab, #pus-cells-lab').val('');
	$('#drug-test-lab option').prop('selected', function()
	{
		return this.defaultSelected;
	});
	$('#albumin-lab option, #sugar-lab option').prop('selected', function()
	{
		return this.defaultSelected;
	});
	$('#cbcaccordion').hide();
	$('#add-lab-result-footer').html('');
	$.post('/viewlabdiagnosis', {medical_appointment_id: medical_appointment_id}, function(data, textStatus, xhr) {
		if(data['cbc_result'])
		{
			$('#cbcaccordion').show();
			$('#hemoglobin-lab').val(data['cbc_result']['hemoglobin']);
			if(data['cbc_result']['hemoglobin'])
			{
				$('#hemoglobin-lab').attr('disabled', 'disabled');
			}
			// else
			// {
			// 	$('#hemoglobin-lab').removeAttr('disabled');
			// }

			$('#hemasocrit-lab').val(data['cbc_result']['hemasocrit']);
			if(data['cbc_result']['hemasocrit'])
			{
				$('#hemasocrit-lab').attr('disabled', 'disabled');
			}
			// else
			// {
			// 	$('#hemasocrit-lab').removeAttr('disabled');
			// }

			$('#wbc-lab').val(data['cbc_result']['wbc']);
			if(data['cbc_result']['wbc'])
			{
				$('#wbc-lab').attr('disabled', 'disabled');
			}
			// else
			// {
			// 	$('#wbc-lab').removeAttr('disabled');
			// }

			if(data['cbc_result']['hemoglobin'] || data['cbc_result']['hemasocrit'] || data['cbc_result']['wbc']){
				$('.checkboxLabService').prop('disabled', true);
				$('.cbc_radio').prop('disabled', true);
			}
			$('#laboratoryresult-lab #cbc_div').show();
			if(data['cbc_billing_status']){
				for (var i = 0; i < data['cbc_billing_status'].length; i++){
					$('#'+data['cbc_billing_status'][i].medical_service_id+'.checkboxLabService').prop('checked', true);
					$('.checkboxLabService').prop('disabled', true);
					$('#patient_type_radio_lab').prop('disabled', true);
				}
			}
		}

		if(data['drug_test_result'])
		{
			$('#drug-test-lab').val(data['drug_test_result']['drug_test_result']);
			if(data['drug_test_result']['drug_test_result'])
			{
				$('#drug-test-lab').attr('disabled', 'disabled');
				$('.checkboxLabService').prop('disabled', true);
				$('.drug_radio').prop('disabled', true);
			}
			else
			{
				$('#drug-test-lab').removeAttr('disabled');
				$('#drug-test-lab option').prop('selected', function()
				{
					return this.defaultSelected;
				});
			}
			$('#laboratoryresult-lab #drug_test_div').show();
		}

		if(data['fecalysis_result'])
		{
			$('#macroscopic-lab').val(data['fecalysis_result']['macroscopic']);
			if(data['fecalysis_result']['macroscopic'])
			{
				$('#macroscopic-lab').attr('disabled', 'disabled');
			}
			else
			{
				$('#macroscopic-lab').removeAttr('disabled');
			}
			$('#microscopic-lab').val(data['fecalysis_result']['microscopic']);
			if(data['fecalysis_result']['microscopic'])
			{
				$('#microscopic-lab').attr('disabled', 'disabled');
			}
			else
			{
				$('#microscopic-lab').removeAttr('disabled');
			}
			$('#laboratoryresult-lab #fecalysis_div').show();
			if(data['fecalysis_result']['macroscopic'] || data['fecalysis_result']['microscopic']){
				$('.checkboxLabService').prop('disabled', true);
				$('.fecalysis_radio').prop('disabled', true);
			}
		}
		if(data['urinalysis_result'])
		{
			$('#pus-cells-lab').val(data['urinalysis_result']['pus_cells']);
			if(data['urinalysis_result']['pus_cells'])
			{
				$('#pus-cells-lab').attr('disabled', 'disabled');
			}
			else
			{
				$('#pus-cells-lab').removeAttr('disabled');
			}
			$('#rbc-lab').val(data['urinalysis_result']['rbc']);
			if(data['urinalysis_result']['rbc'])
			{
				$('#rbc-lab').attr('disabled', 'disabled');
			}
			else
			{
				$('#rbc-lab').removeAttr('disabled');
			}
			$('#albumin-lab').val(data['urinalysis_result']['albumin']);
			if(data['urinalysis_result']['albumin'])
			{
				$('#albumin-lab').attr('disabled', 'disabled');
			}
			else
			{
				$('#albumin-lab').removeAttr('disabled');
				$('#albumin-lab option').prop('selected', function()
				{
					return this.defaultSelected;
				});
			}
			$('#sugar-lab').val(data['urinalysis_result']['sugar']);
			if(data['urinalysis_result']['sugar'])
			{
				$('#sugar-lab').attr('disabled', 'disabled');
			}
			else
			{
				$('#sugar-lab').removeAttr('disabled');
				$('#sugar-lab option').prop('selected', function()
				{
					return this.defaultSelected;
				});
			}
			$('#laboratoryresult-lab #urinalysis_div').show();
			if(data['urinalysis_result']['pus_cells'] || data['urinalysis_result']['rbc'] || data['urinalysis_result']['albumin'] || data['urinalysis_result']['sugar']){
				$('.checkboxLabService').prop('disabled', true);
				$('.urinalysis_radio').prop('disabled', true);
			}
		}
		$('#add-lab-result-footer').append('<button type="button" class="btn btn-success addLabResultButton" id="addLabResultButton_'+medical_appointment_id+'">Save</button><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>')
		$('.addLabResultButton').click(function(){
			var medical_appointment_id = $(this).attr('id').split("_")[1];
			cbc_services_id=[];
			$("input:checkbox.checkboxLabService").each(function(){
					if($(this).is(":checked") && !$(this).attr("disabled")){
							cbc_services_id.push($(this).attr("id"));
					}
			});
			$.post('/updatelabdiagnosis',
				{
					medical_appointment_id: medical_appointment_id,
					hemoglobin: $('#hemoglobin-lab').val(),
					hemasocrit: $('#hemasocrit-lab').val(),
					wbc: $('#wbc-lab').val(),
					cbc_radio: $("input[name='cbc_radio']:checked").val(),

					drug_test: $('#drug-test-lab').val(),
					drug_radio: $("input[name='drug_radio']:checked").val(),

					macroscopic: $('#macroscopic-lab').val(),
					microscopic: $('#microscopic-lab').val(),
					fecalysis_radio: $("input[name='fecalysis_radio']:checked").val(),

					pus_cells: $('#pus-cells-lab').val(),
					rbc: $('#rbc-lab').val(),
					albumin: $('#albumin-lab').val(),
					sugar: $('#sugar-lab').val(),
					urinalysis_radio: $("input[name='urinalysis_radio']:checked").val(),

					cbc_services_id: cbc_services_id,
					drug_service_id: data['drug_billing_service'].id,
					fecalysis_service_id: data['fecalysis_billing_service'].id,
					urinalysis_service_id: data['urinalysis_billing_service'].id,

			}, function(data, textStatus, xhr) {
				$('#cbccountpanel').load(location.href + " #cbccount");
				$('#drugtestcountpanel').load(location.href + " #drugtestcount");
				$('#fecalysiscountpanel').load(location.href + " #fecalysiscount");
				$('#urinalysiscountpanel').load(location.href + " #urinalysiscount");
				if(data['delete'] == 'yes'){
					$('#addLabResult_'+medical_appointment_id).closest("tr").remove();
				}
				$('#add-lab-result').modal('hide');
			});
	});
		$('#add-lab-result').modal();
	});
});







// ------------------PROFILE---------------
// ------------------SEARCH PATIENT---------------
	// $('#searchPatient').keyup(function() {
	//   if($('#searchPatient').val()){
	//     $.ajax({
	//         url: 'search-patient.php',
	//         type: 'POST',
	//         async: true,
	//         data: {
	//             'search_string': $('#searchPatient').val()
	//         },
	//         success:function(response){
	//             output = '';
	//             message=JSON.parse(response);
	//             console.log(message);
	//             // patientId=[];
	//             if(message=='null'){
	//               $('#searchResults').html("");
	//               $('#searchTable').hide();
	//             }
	//             else{
	//               for(i=0; i<message.length; i++) {
	//                 messageSplit = message[i].split("(;;)");
	//                 output += "<tr><td><a class='searchQueryResults' id='resultId_"+messageSplit[0]+"'>"+messageSplit[1]+"</a></td></tr>";
	//               }
	//               $('#searchResults').html(output);
	//               $('#searchTable').show();
	//               $('.searchQueryResults').click(function() {
	//                 var patientId = $(this).attr('id').split('_')[1];
	//                 console.log(patientId);
	//                 $.ajax({
	//                     url: 'search-patient-get-info.php',
	//                     type: 'POST',
	//                     async: true,
	//                     data: {
	//                       'patient_id': patientId
	//                     },
	//                     success:function(response){
	//                         output = '';
	//                         message=jQuery.parseJSON(response);
	//                         $('#ageTd').html(message.age);
	//                         $('#sexTd').html(message.sex);
	//                         $('#courseTd').html(message.degree_program);
	//                         $('#yearlevelTd').html(message.year_level);
	//                         $('#birthdateTd').html(message.birthdate);
	//                         $('#religionTd').html(message.religion);
	//                         $('#nationlityTd').html(message.nationality);
	//                         $('#fatherTd').html(message.father);
	//                         $('#motherTd').html(message.mother);
	//                         $('#homeaddressTd').html(message.street + ', ' + message.town + ', ' + message.province);
	//                         $('#restelTd').html(message.residence_telephone);
	//                         $('#perosnalcontactnumberTd').html(message.personal_contact_number);
	//                         $('#guardiannameTd').html(message.guardian_name);
	//                         $('#guardianaddressTd').html(message.guardian_address);
	//                         $('#guardianrelationshipTd').html(message.guardian_relationship);
	//                         $('#guardiantelTd').html(message.guardian_residence_telephone);
	//                         $('#guardiancpTd').html(message.guardian_residence_cellphone);
	//                         if($('#determine-view-record-button').val()==1){
	//                           $('#patientInfoModalFooter').html('<a href="view-medical-records.php?patient_id=' + patientId +'" class="btn btn-info" role="button">View Medical Records</a><a href="add-new-medical-record-no-appointment.php?patient_id=' + patientId +'" class="btn btn-info" role="button">Add New Record</a>');
	//                         }
	//                         if($('#determine-view-record-button').val()==2){
	//                           $('#patientInfoModalFooter').html('<a href="view-dental-records.php?patient_id=' + patientId +'" class="btn btn-info" role="button">View Dental Records</a><a href="add-new-dental-record-no-appointment.php?patient_id=' + patientId +'" class="btn btn-info" role="button">Add New Record</a>');
	//                         }
	//                     }
	//                 });
	//                 $('#searchPatientRecordInfo').modal();
	//               });
	//             }
	//         }
	//     });
	//   }
	//   else{
	//     $('#searchTable').hide();
	//     $('#searchResults').html("");
	//   }
	// });
});