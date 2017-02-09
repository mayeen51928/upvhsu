$(document).ready( function(){
$.ajaxSetup({
	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});



// ------------------DASHBOARD---------------
numOfClicksMedical_Diagnosis = 0;
percentageMedical_Diagnosis = 20;
$('#closeButtonMedicalDiagnosis, #xButtonMedicalDiagnosis').click(function(){
	$('#create-medical-record-modal').modal('hide');
	$('#requestsFromDoctor').load(location.href + " #requestsFromDoctor");
	setTimeout(function(){
		numOfClicksMedical_Diagnosis = 0;
		percentageMedical_Diagnosis = 20;
		if(numOfClicksMedical_Diagnosis == 0){
			$('#physicalexamination').show();
			$('#laboratoryresult').hide();
			$('#remarksDiv').hide();
			$('#prescriptionDiv').hide();
			$('#nextButtonMedicalDiagnosis').show();
			$('#backButtonMedicalDiagnosis').hide();
			$('#requestLabXrayDiv').hide();
			$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('1 of 5');
		}
	}, 1000);

});
$('#nextButtonMedicalDiagnosis').click(function(){
	numOfClicksMedical_Diagnosis ++;
	if(numOfClicksMedical_Diagnosis == 1){
		$('#physicalexamination').hide();
		$('#laboratoryresult').show();
		$('#backButtonMedicalDiagnosis').show();
		percentageMedical_Diagnosis += 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('2 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 2){
		$('#laboratoryresult').hide();
		$('#remarksDiv').show();
		percentageMedical_Diagnosis += 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('3 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 3){
		$('#remarksDiv').hide();
		$('#prescriptionDiv').show();
		percentageMedical_Diagnosis +=20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('4 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 4){
		$('#prescriptionDiv').hide();
		$('#requestLabXrayDiv').show();
		$('#nextButtonMedicalDiagnosis').hide();
		percentageMedical_Diagnosis +=20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('5 of 5');
	}
});
$('#backButtonMedicalDiagnosis').click(function() {
	numOfClicksMedical_Diagnosis --;
	if(numOfClicksMedical_Diagnosis == 3){
	   $('#prescriptionDiv').show();
		$('#requestLabXrayDiv').hide();
		$('#nextButtonMedicalDiagnosis').show();
		percentageMedical_Diagnosis -= 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('4 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 2){
		$('#remarksDiv').show();
		$('#prescriptionDiv').hide();
		percentageMedical_Diagnosis -= 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('3 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 1){
		$('#laboratoryresult').show();
		$('#remarksDiv').hide();
		percentageMedical_Diagnosis -= 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('2 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 0){
		$('#physicalexamination').show();
		$('#laboratoryresult').hide();
		$('#backButtonMedicalDiagnosis').hide();
		percentageMedical_Diagnosis -= 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('1 of 5');
	}
});
$('.addMedicalRecordButton').click(function() {
	// $('#confirmModal').modal();
	$('#requestsFromDoctor').load(location.href + " #requestsFromDoctor");
	if($(this).attr('id')){
		var appointment_id = $(this).attr('id').split("_")[1];
		
		$.post('/viewmedicaldiagnosis',
		{
			appointment_id: appointment_id,
		} , function(data){
			$('.personal-information-name').html("").append("<p>"+data['patient_name']+"</p>");
			$('.personal-information-reasons').html("").append("<p>"+data['reasons']+"</p>");

			if(data['hasRecord'] == 'no')
			{
				$('#height').val('');
				$('#weight').val('');
				$('#blood-pressure').val('');
				$('#pulse-rate').val('');
				$('#right-eye').val('');
				$('#left-eye').val('');
				$('#head').val('');
				$('#eent').val('');
				$('#neck').val('');
				$('#chest').val('');
				$('#heart').val('');
				$('#lungs').val('');
				$('#abdomen').val('');
				$('#back').val('');
				$('#skin').val('');
				$('#extremities').val('');
				$('#hemoglobin').val('');
				$('#hemasocrit').val('');
				$('#wbc').val('');
				$('#pus-cells').val('');
				$('#rbc').val('');
				$('#albumin').val('');
				$('#sugar').val('');
				$('#macroscopic').val('');
				$('#microscopic').val('');
				$('#drug-test').val('');
				$('#chest-xray').val('');
				$('#remarks').val('');
				$('#prescription').val('');
				$('.medical-button-container').html("").append("<button type='button' class='btn btn-success add-medical-record-button' id='add-medical-record-button_"+appointment_id+"'>Add</button>");
				$('.medical-button-container .add-medical-record-button').click(function(){
					if ($('#height').val() ||
						$('#weight').val() ||
						$('#blood-pressure').val() ||
						$('#pulse-rate').val() ||
						$('#right-eye').val() ||
						$('#left-eye').val() ||
						$('#head').val() ||
						$('#eent').val() ||
						$('#neck').val() ||
						$('#neck').val() ||
						$('#chest').val() ||
						$('#heart').val() ||
						$('#heart').val() ||
						$('#lungs').val() ||
						$('#abdomen').val() ||
						$('#back').val() ||
						$('#skin').val() ||
						$('#extremities').val()) {
							var appointment_id = $(this).attr('id').split("_")[1];
							var height = $('#height').val();
							var weight = $('#weight').val();
							var bloodPressure = $('#blood-pressure').val();
							var pulseRate = $('#pulse-rate').val();
							var rightEye = $('#right-eye').val();
							var leftEye = $('#left-eye').val();
							var head = $('#head').val();
							var eent = $('#eent').val();
							var neck = $('#neck').val();
							var chest = $('#chest').val();
							var heart = $('#heart').val();
							var lungs = $('#lungs').val();
							var abdomen = $('#abdomen').val();
							var back = $('#back').val();
							var skin = $('#skin').val();
							var extremities = $('#extremities').val();
							var remarks = $('#remarks').val();
							var prescription = $('#prescription').val();
							if($('#requestCBC').is(':checked')){
								var request_cbc='yes';
							}
							else
							{
								var request_cbc='no';
							}
							if($('#requestUrinalysis').is(':checked')){
								var request_urinalysis='yes';
							}
							else
							{
								var request_urinalysis='no';
							}
							if($('#requestFecalysis').is(':checked')){
								var request_fecalysis='yes';
							}
							else
							{
								var request_fecalysis='no';
							}
							if($('#requestDrugTest').is(':checked')){
								var request_drug_test='yes';
							}
							else
							{
								var request_drug_test='no';
							}
							if($('#requestXray').is(':checked')){
								var request_xray='yes';
							}
							else
							{
								var request_xray='no';
							}
							$.post('/addmedicaldiagnosis',
							{
								appointment_id: appointment_id,
								height: height,
								weight: weight,
								blood_pressure: bloodPressure,
								pulse_rate: pulseRate,
								right_eye: rightEye,
								left_eye: leftEye,
								head: head,
								eent: eent,
								neck: neck,
								chest: chest,
								heart: heart,
								lungs: lungs,
								abdomen: abdomen,
								back: back,
								skin: skin,
								extremities: extremities,
								remarks: remarks,
								prescription: prescription,
								request_cbc: request_cbc,
								request_urinalysis: request_urinalysis,
								request_fecalysis: request_fecalysis,
								request_drug_test: request_drug_test,
								request_xray: request_xray,
							} ,
							function(data){
								// console.log(data['appointment_id']);
								$('#create-medical-record-modal').modal("hide");
							}
						);
					}
				});
			}
			else
			{
				$('.requestCheckbox').addClass('checkbox disabled requestCheckbox');
				$('.requestCheckbox input').attr('disabled', 'disabled');
				if(data['physical_examination'])
				{
					$('#height').val(data['physical_examination']['height']);
					$('#weight').val(data['physical_examination']['weight']);
					$('#blood-pressure').val(data['physical_examination']['blood_pressure']);
					$('#pulse-rate').val(data['physical_examination']['pulse_rate']);
					$('#right-eye').val(data['physical_examination']['right_eye']);
					$('#left-eye').val(data['physical_examination']['left_eye']);
					$('#head').val(data['physical_examination']['head']);
					$('#eent').val(data['physical_examination']['eent']);
					$('#neck').val(data['physical_examination']['neck']);
					$('#chest').val(data['physical_examination']['chest']);
					$('#heart').val(data['physical_examination']['heart']);
					$('#lungs').val(data['physical_examination']['lungs']);
					$('#abdomen').val(data['physical_examination']['abdomen']);
					$('#back').val(data['physical_examination']['back']);
					$('#skin').val(data['physical_examination']['skin']);
					$('#extremities').val(data['physical_examination']['extremities']);
					$('#physicalexamination input').attr('disabled', 'disabled');
				}
				else
				{
					$('#height').val('');
					$('#weight').val('');
					$('#blood-pressure').val('');
					$('#pulse-rate').val('');
					$('#right-eye').val('');
					$('#left-eye').val('');
					$('#head').val('');
					$('#eent').val('');
					$('#neck').val('');
					$('#chest').val('');
					$('#heart').val('');
					$('#lungs').val('');
					$('#abdomen').val('');
					$('#back').val('');
					$('#skin').val('');
					$('#extremities').val('');
					$('#physicalexamination input').removeAttr('disabled');
				}
				if(data['cbc_result'])
				{
					$('#hemoglobin').val(data['cbc_result']['hemoglobin']);
					$('#hemasocrit').val(data['cbc_result']['hemasocrit']);
					$('#wbc').val(data['cbc_result']['wbc']);
					$('#requestCBC').attr('checked', 'checked').attr('disabled', 'disabled');
				}
				else
				{
					$('#hemoglobin').val('');
					$('#hemasocrit').val('');
					$('#wbc').val('');
				}
				if(data['urinalysis_result'])
				{
					$('#pus-cells').val(data['urinalysis_result']['pus_cells']);
					$('#rbc').val(data['urinalysis_result']['rbc']);
					$('#albumin').val(data['urinalysis_result']['albumin']);
					$('#sugar').val(data['urinalysis_result']['sugar']);
					$('#requestUrinalysis').attr('disabled', 'disabled').attr('checked', 'checked');
				}
				else
				{
					$('#pus-cells').val('');
					$('#rbc').val('');
					$('#albumin').val('');
					$('#sugar').val('');
				}
				if(data['fecalysis_result'])
				{
					$('#macroscopic').val(data['fecalysis_result']['macroscopic']);
					$('#microscopic').val(data['fecalysis_result']['microscopic']);
					$('#requestFecalysis').attr('disabled', 'disabled').attr('checked', 'checked');
				}
				else
				{
					$('#macroscopic').val('');
					$('#microscopic').val('');
				}
				if(data['drug_test_result'])
				{
					$('#drug-test').val(data['drug_test_result']['drug_test']).attr('checked', 'checked');
					$('#requestDrugTest').attr('disabled', 'disabled').attr('checked', 'checked');
				}
				else
				{
					$('#drug-test').val('');
				}
				if(data['chest_xray_result'])
				{
					$('#chest-xray').val(data['chest_xray_result']['xray_result']);
					$('#requestXray').attr('disabled', 'disabled').attr('checked', 'checked');
				}
				else
				{
					$('#chest-xray').val('');
				}
				if(data['remark'])
				{
					$('#remarks').val(data['remark']['remark']);
					$('#remarks').attr('disabled', 'disabled');
				}
				else
				{
					$('#remarks').val('');
					$('#remarks').removeAttr('disabled');
				}
				if(data['prescription'])
				{
					$('#prescription').val(data['prescription']['prescription']);
					$('#prescription').attr('disabled', 'disabled');
				}
				else
				{
					$('#prescription').val('');
					$('#prescription').removeAttr('disabled');
				}
				$('.medical-button-container').html("").append("<button type='button' class='btn btn-success update-medical-record-button' id='update-medical-record-button_"+appointment_id+"'>Update</button>");
				$('.medical-button-container .update-medical-record-button').click(function(){

							var appointment_id = $(this).attr('id').split("_")[1];
							var height = $('#height').val();
							var weight = $('#weight').val();
							var bloodPressure = $('#blood-pressure').val();
							var pulseRate = $('#pulse-rate').val();
							var rightEye = $('#right-eye').val();
							var leftEye = $('#left-eye').val();
							var head = $('#head').val();
							var eent = $('#eent').val();
							var neck = $('#neck').val();
							var chest = $('#chest').val();
							var heart = $('#heart').val();
							var lungs = $('#lungs').val();
							var abdomen = $('#abdomen').val();
							var back = $('#back').val();
							var skin = $('#skin').val();
							var extremities = $('#extremities').val();
							var remarks = $('#remarks').val();
							var prescription = $('#prescription').val();
							if($('#requestCBC').is(':checked')){
								var request_cbc='yes';
							}
							else
							{
								var request_cbc='no';
							}
							if($('#requestUrinalysis').is(':checked')){
								var request_urinalysis='yes';
							}
							else
							{
								var request_urinalysis='no';
							}
							if($('#requestFecalysis').is(':checked')){
								var request_fecalysis='yes';
							}
							else
							{
								var request_fecalysis='no';
							}
							if($('#requestDrugTest').is(':checked')){
								var request_drug_test='yes';
							}
							else
							{
								var request_drug_test='no';
							}
							if($('#requestXray').is(':checked')){
								var request_xray='yes';
							}
							else
							{
								var request_xray='no';
							}
							$.post('/updatemedicaldiagnosis',
							{
								appointment_id: appointment_id,
								height: height,
								weight: weight,
								blood_pressure: bloodPressure,
								pulse_rate: pulseRate,
								right_eye: rightEye,
								left_eye: leftEye,
								head: head,
								eent: eent,
								neck: neck,
								chest: chest,
								heart: heart,
								lungs: lungs,
								abdomen: abdomen,
								back: back,
								skin: skin,
								extremities: extremities,
								remarks: remarks,
								prescription: prescription,
								request_cbc: request_cbc,
								request_urinalysis: request_urinalysis,
								request_fecalysis: request_fecalysis,
								request_drug_test: request_drug_test,
								request_xray: request_xray,
							} ,
							function(data){
								if(data['status'] && data['status'] == 'done')
								{
									// $('#addMedicalRecordButton_'+appointment_id).closest("tr").remove();
								}
								$('#create-medical-record-modal').modal("hide");
							}
						);
					
				});
			}
			$('#create-medical-record-modal').modal().delay(500);
		});
	}
});


// ----------------------------- Manage Schedule -----------------------------


$('.addmoremedicalsched').click(function(){
    $(this).parents('.medical_manage').find('tbody').append('<tr class="schedule_tr"><td><input type="date" class="form-control"/></td><td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td></tr>');
    $('.removemedicalsched').click(function(){
    	$(this).closest('tr').remove();
    });
});
$('.removemedicalsched').click(function(){
	$(this).closest('tr').remove();
});
$('#addmedicalschedule').click(function(){
    var schedules = [];
    $('.schedule_tr').each(function(){
        if($(this).find('input[type="date"]')){
            schedules.push($(this).find('input[type="date"]').val());
            console.log(schedules);
        }
    });
    if(schedules.length > 0){
    	$.post('/addschedule_medical',{schedules: schedules} , function(data){
            $('button').attr('disabled', 'disabled');
            $('input').attr('disabled', 'disabled');
            $('#manageschedulepanel').css('background-color', '#d6e9c6');
        });
    }
    
}); 

// ----------------------------- End of Manage Schedule ----------------------




// ------------------PROFILE---------------

// ------------------BILLING---------------
$('.addBillingToMedical').click(function(){
	var id = $(this).attr('id').split("_");
	appointmentId = id[1];
	$.ajax({
		  type: "POST",
		  url: addBillingMedical,
		  data: {appointment_id:  appointmentId, _token: token},
		  success: function(data)
		  {
		  	console.log(data['checker']);
		  	output = '';
			$('.patient_name').html('<h4>'+ data['patient_name']+'</h4>');
			for(var i=0; i < data['servicenamearray'].length; i++)
			{
				if(data['servicetypearray'][i] == 'medical'){
					output += "<tr><td width='20%'><input type='checkbox' class='checkboxMedicalService' id="+data['serviceratearray'][i]+"_"+data['serviceidarray'][i]+"></td><td width='60%' class='medicalService'>"+data['servicenamearray'][i]+"</td><td width='60%' class='medicalServiceRate'>"+data['serviceratearray'][i]+"</td></tr>";
				}
				else{
					output += "<tr><td width='20%'><input type='checkbox' class='checkboxMedicalService' id="+data['serviceratearray'][i]+" disabled></td><td width='60%' class='medicalService'>"+data['servicenamearray'][i]+"</td><td width='60%' class='medicalServiceRate'>"+data['serviceratearray'][i]+"</td></tr>";
				}
				
			}
			$('.displayServices').html(output);
			if(data['checker'] == '0'){
				$(".displayServices :input").attr("disabled", true);
				$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled>");
				$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medicalBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
			}
			else if(data['checker'] == '1'){
				$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled>");
				$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medicalBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
			}
			else{
				$(".displayServices :input").attr("disabled", true);
				$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled value="+data['checker']+">");
				$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medicalBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
			}
			
			$("#medical-bill").val();
			var fin = 0;
			$('.checkboxMedicalService').click(function(){
				if ($(this).is(':checked')){
					var medicalBillRate = parseFloat($(this).attr('id'));
					console.log(medicalBillRate);
					fin = parseFloat(fin+medicalBillRate);
					console.log(fin);
					$("#medical-bill").val(fin);
				};
			});
			$('#medicalBillingModal').modal();
		  }
	  });
});

$(document).on('click', '.medical-bill-confirm', function(){
	var appointmentId = $(this).attr('id').split('_')[1];
		checked_services_array=[];
		$("input:checkbox").each(function(){
		    var $this = $(this);
		    if($this.is(":checked")){
		        checked_services_array.push($this.attr("id"));
		    }
		});
		$.ajax({
		  type: "POST",
		  url: confirmBillingMedical,
		  data: {appointment_id:  appointmentId, checked_services_array:  checked_services_array, _token: token},
		  success: function(data)
		  {
		  	console.log(data['success']);
		  	$('#medicalBillingModal').modal("hide");
		  }
	  });
	
	return false;
});








// ------------------SEARCH PATIENT---------------
$("#search_patient").keypress(function(){
	if($('#search_patient').val()){
		var searchString = $('#search_patient').val();
		$.post('/searchpatientrecord',
			{
				search_string: searchString
			}, function(data) {
				if(data['counter']>0)
				{
			  		output = '';
	  				for(var i=0; i < data['searchpatientidarray'].length; i++)
	  				{
	  					output += "<tr><td><a class='searchQueryResults' id='resultId_"+data['searchpatientidarray'][i]+"'>"+data['searchpatientfirstnamearray'][i]+" "+data['searchpatientlastnamearray'][i]+"</a></td></tr>";
	  				}
	  				$('#searchResults').html(output);
  					$('#searchTable').show();
  					$('.searchQueryResults').click(function()
  					{
  						var patientId = $(this).attr('id').split('_')[1];
  						$.post('/displaypatientrecordsearch',
  						{
  							patient_id: patientId
  						}, function(data) {
  							output = '';
  							var age = Math.floor((new Date() - new Date(data['patient_info']['birthday'])) / (365.25 * 24 * 60 * 60 * 1000));
  							$('#ageTd').html(age);
  							if(data['patient_info']['sex'] == 'F')
  							{
  								$('#sexTd').html('Female');
  							}
  							else
  							{
  								$('#sexTd').html('Male');
  							}
  							if(data['patient_info']['display_course_and_year_level'] == 1)
  							{
  								$('#courseRow').show();
  								$('#yearlevelRow').show();
  								$('#courseTd').html(data['patient_info']['degree_program_description']);
  								$('#yearlevelTd').html(data['patient_info']['year_level']);
  							}
  							$('#birthdateTd').html(data['patient_info']['birthday']);
  							$('#religionTd').html(data['patient_info']['religion']);
  							$('#nationalityTd').html(data['patient_info']['nationality']);
  							$('#fatherTd').html(data['patient_info']['father_first_name']+' '+data['patient_info']['father_last_name']);
  							$('#motherTd').html(data['patient_info']['mother_first_name'] + ' ' + data['patient_info']['mother_last_name']);
							$('#homeaddressTd').html(data['patient_info']['street'] + ', ' + data['patient_info']['town'] + ', ' + data['patient_info']['province']);
							$('#restelTd').html(data['patient_info']['residence_telephone_number']);
							$('#personalcontactnumberTd').html(data['patient_info']['personal_contact_number']);
							$('#guardiannameTd').html(data['patient_info']['guardian_first_name'] + ' ' +data['patient_info']['guardian_last_name']);
							$('#guardianaddressTd').html(data['patient_info']['guardian_street'] + ', ' + data['patient_info']['guardian_town'] + ', ' +data['patient_info']['guardian_province']);
							$('#guardianrelationshipTd').html(data['patient_info']['relationship']);
							$('#guardiantelTd').html(data['patient_info']['guardian_tel_number']);
							$('#guardiancpTd').html(data['patient_info']['guardian_cellphone']);
							$('#patientInfoModalFooter').html('<a href="/doctor/viewrecords/'+ patientId +'" class="btn btn-info" role="button">View Records</a>');
							$('#searchPatientRecordInfo').modal();
						});
  					});
  				}
  				else
  				{
  					$('#searchTable').hide();
  					$('#searchResults').html("");
  				}
  			});
	}
	else
	{
		$('#searchTable').hide();
		$('#searchResults').html("");
	}
});
});