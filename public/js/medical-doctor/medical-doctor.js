$(document).ready( function(){

$.ajaxSetup({
	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});



// ------------------DASHBOARD---------------
numOfClicksMedical_Diagnosis = 0;
percentageMedical_Diagnosis = 20;
$('#closeButtonMedicalDiagnosis').click(function(){
	$('#create-medical-record-modal').modal('hide');
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
	$('#requestsFromDoctor').load(location.href + " #requestsFromDoctor");
	if($(this).attr('id')){
		var appointment_id = $(this).attr('id').split("_")[1];
		
		$.post('/addorupdatediagnosis',
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
				// $('#requestCBC').removeAttr('disabled').removeAttr('checked');
				// $('#requestUrinalysis').removeAttr('disabled').removeAttr('checked');
				// $('#requestFecalysis').removeAttr('disabled').removeAttr('checked');
				// $('#requestDrugTest').removeAttr('disabled').removeAttr('checked');
				// $('#requestXray').removeAttr('disabled').removeAttr('checked');
				$('.medical-button-container').html("").append("<button type='button' class='btn btn-primary add-medical-record-button' id='add-medical-record-button'>Submit</button>");
				
			}
			else
			{
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
				}
				if(data['cbc_result'])
				{

					$('#hemoglobin').val(data['cbc_result']['hemoglobin']);
					$('#hemasocrit').val(data['cbc_result']['hemasocrit']);
					$('#wbc').val(data['cbc_result']['wbc']);
					$('#requestCBC').attr('checked', 'checked').attr('disabled', 'disabled');
					$('#requestUrinalysis').attr('disabled', 'disabled');
					$('#requestFecalysis').attr('disabled', 'disabled');
					$('#requestDrugTest').attr('disabled', 'disabled');
					$('#requestXray').attr('disabled', 'disabled');
					$('.requestCheckbox').addClass('checkbox disabled requestCheckbox');

				}
				else
				{
					$('#hemoglobin').val('');
					$('#hemasocrit').val('');
					$('#wbc').val('');
					console.log('cbc_result');
					// $('#requestCBC').removeAttr('checked');
				}
				if(data['urinalysis_result'])
				{
					$('#pus-cells').val(data['urinalysis']['pus_cells']);
					$('#rbc').val(data['urinalysis']['rbc']);
					$('#albumin').val(data['urinalysis']['albumin']);
					$('#sugar').val(data['urinalysis']['sugar']);
					$('#requestCBC').attr('disabled', 'disabled');
					$('#requestUrinalysis').attr('disabled', 'disabled').attr('checked', 'checked');
					$('#requestFecalysis').attr('disabled', 'disabled');
					$('#requestDrugTest').attr('disabled', 'disabled');
					$('#requestXray').attr('disabled', 'disabled');
					$('.requestCheckbox').addClass('checkbox disabled requestCheckbox');
				}
				else
				{
					$('#pus-cells').val('');
					$('#rbc').val('');
					$('#albumin').val('');
					$('#sugar').val('');
					// $('#requestUrinalysis').removeAttr('checked');
				}
				if(data['fecalysis_result'])
				{
					$('#macroscopic').val(data['fecalysis_result']['macroscopic']);
					$('#microscopic').val(data['fecalysis_result']['microscopic']);
					$('#requestCBC').attr('disabled', 'disabled');
					$('#requestUrinalysis').attr('disabled', 'disabled');
					$('#requestFecalysis').attr('disabled', 'disabled').attr('checked', 'checked');
					$('#requestDrugTest').attr('disabled', 'disabled');
					$('#requestXray').attr('disabled', 'disabled');
					$('.requestCheckbox').addClass('checkbox disabled requestCheckbox');
				}
				else
				{
					$('#macroscopic').val('');
					$('#microscopic').val('');
					// $('#requestFecalysis').removeAttr('checked');
				}
				if(data['drug_test_result'])
				{
					$('#drug-test').val(data['drug_test_result']['drug_test']).attr('checked', 'checked');
					$('#chest-xray').val(data['chest_xray_result']['xray_result']);
					$('#requestCBC').attr('disabled', 'disabled');
					$('#requestUrinalysis').attr('disabled', 'disabled');
					$('#requestFecalysis').attr('disabled', 'disabled');
					$('#requestDrugTest').attr('disabled', 'disabled').attr('checked', 'checked');
					$('#requestXray').attr('disabled', 'disabled');
					$('.requestCheckbox').addClass('checkbox disabled requestCheckbox');
				}
				else
				{
					$('#drug-test').val('');
					// $('#requestDrugTest').removeAttr('checked');
				}
				if(data['chest_xray_result'])
				{
					$('#chest-xray').val(data['chest_xray_result']['xray_result']);
					$('#requestCBC').attr('disabled', 'disabled');
					$('#requestUrinalysis').attr('disabled', 'disabled');
					$('#requestFecalysis').attr('disabled', 'disabled');
					$('#requestDrugTest').attr('disabled', 'disabled');
					$('#requestXray').attr('disabled', 'disabled').attr('checked', 'checked');
					$('.requestCheckbox').addClass('checkbox disabled requestCheckbox');
				}
				else
				{
					$('#chest-xray').val('');
					// $('#requestXray').removeAttr('checked');
				}
				if(data['remark'])
				{
					$('#remarks').val(data['remark']['remark']);
				}
				else
				{
					$('#remarks').val('');
				}
				if(data['prescription'])
				{
					$('#prescription').val(data['prescription']['prescription']);
				}
				else
				{
					$('#prescription').val('');
				}
				$('.medical-button-container').html("").append("<button type='button' class='btn btn-primary update-medical-record-button' id='update-medical-record-button'>Update</button>");
			}
			$('#create-medical-record-modal').modal().delay(500);
		});
	}
});

	// $(document).on('click', '.medical-button-container #add-medical-record-button', function(){ 
	// 	if ($('#height').val() || $('#weight').val() || $('#blood-pressure').val() || $('#pulse-rate').val() || $('#right-eye').val() || $('#left-eye').val() || $('#head').val() || $('#eent').val() || $('#neck').val() || $('#neck').val() || $('#chest').val() || $('#heart').val() || $('#heart').val() || $('#lungs').val() || $('#abdomen').val() || $('#back').val() || $('#skin').val() || $('#extremities').val()) {
	// 		var patient_id = create_record_patient_id;
	// 		var appointment_id_fin = appointment_id;
	// 		var height = $('#height').val();
	// 		var weight = $('#weight').val();
	// 		var bloodPressure = $('#blood-pressure').val();
	// 		var pulseRate = $('#pulse-rate').val();
	// 		var rightEye = $('#right-eye').val();
	// 		var leftEye = $('#left-eye').val();
	// 		var head = $('#head').val();
	// 		var eent = $('#eent').val();
	// 		var neck = $('#neck').val();
	// 		var chest = $('#chest').val();
	// 		var heart = $('#heart').val();
	// 		var lungs = $('#lungs').val();
	// 		var abdomen = $('#abdomen').val();
	// 		var back = $('#back').val();
	// 		var skin = $('#skin').val();
	// 		var extremities = $('#extremities').val();
	// 		var hemoglobin = $('#hemoglobin').val();
	// 		var hemasocrit = $('#hemasocrit').val();
	// 		var wbc = $('#wbc').val();
	// 		var pusCells = $('#pus-cells').val();
	// 		var rbc = $('#rbc').val();
	// 		var albumin = $('#albumin').val();
	// 		var sugar = $('#sugar').val();
	// 		var macroscopic = $('#macroscopic').val();
	// 		var microscopic = $('#microscopic').val();
	// 		var drugTest = $('#drug-test').val();
	// 		var chestXray = $('#chest-xray').val();
	// 		var remarks = $('#remarks').val();
	// 		var prescription = $('#prescription').val();
	// 		var num_of_request = 0;
	// 		if($('#requestLab').is(':checked')){
	// 			num_of_request=1;
	// 		}
	// 		if($('#requestXray').is(':checked')){
	// 			num_of_request =2;
	// 		}
	// 		if($('#requestLab').is(':checked')){
	// 			if($('#requestXray').is(':checked')){
	// 				num_of_request =3;
	// 			}
	// 		}
	// 		$.ajax({
	// 				type: "POST",
	// 				url: "add-medical-record-modal.php",
	// 				async: true,
	// 				data: 
	// 				{   'create_record_patient_id':patient_id,
	// 						'appointment_id':appointment_id_fin,
	// 						'height':height,
	// 						'weight':weight,
	// 						'blood-pressure':bloodPressure,
	// 						'pulse-rate':pulseRate,
	// 						'right-eye':rightEye,
	// 						'left-eye':leftEye,
	// 						'head':head,
	// 						'eent':eent,
	// 						'neck':neck,
	// 						'chest':chest,
	// 						'heart':heart,
	// 						'lungs':lungs,
	// 						'abdomen':abdomen,
	// 						'back':back,
	// 						'skin':skin,
	// 						'extremities':extremities,
	// 						'hemoglobin':hemoglobin,
	// 						'hemasocrit':hemasocrit,
	// 						'wbc':wbc,
	// 						'pus-cells':pusCells,
	// 						'rbc':rbc,
	// 						'albumin':albumin,
	// 						'sugar':sugar,
	// 						'macroscopic':macroscopic,
	// 						'microscopic':microscopic,
	// 						'drug-test':drugTest,
	// 						'chest-xray':chestXray,
	// 						'remarks':remarks,
	// 						'prescription':prescription,
	// 						'request_number':num_of_request
	// 				},
	// 				success: function(response)
	// 				{
	// 					message = JSON.parse(response);
	// 					console.log(message);
	// 					if(message==1){
	// 						console.log("Success!");
	// 						$('#create-medical-record-modal').modal("hide");
	// 					}  
	// 				}
	// 			});
	// 		}
	// 		return false;
	// });

	// numOfClicksMedical_Diagnosis = 0;
	// percentageMedical_Diagnosis = 20;
	// $('#nextButtonMedicalDiagnosis').click(function(){
	// 	numOfClicksMedical_Diagnosis ++;
	// 			if(numOfClicksMedical_Diagnosis == 1){
	// 					$('#physicalexamination').hide();
	// 					$('#laboratoryresult').show();
	// 					$('#backButtonMedicalDiagnosis').show();
	// 					percentageMedical_Diagnosis += 20;
	// 					$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('2 of 5');
	// 			}
	// 			if(numOfClicksMedical_Diagnosis == 2){
	// 					$('#laboratoryresult').hide();
	// 					$('#remarksDiv').show();
	// 					percentageMedical_Diagnosis += 20;
	// 					$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('3 of 5');
	// 			}
	// 			if(numOfClicksMedical_Diagnosis == 3){
	// 					$('#remarksDiv').hide();
	// 					$('#prescriptionDiv').show();
	// 					percentageMedical_Diagnosis +=20;
	// 					$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('4 of 5');
	// 			}
	// 			if(numOfClicksMedical_Diagnosis == 4){
	// 					$('#prescriptionDiv').hide();
	// 					$('#requestLabXrayDiv').show();
	// 					$('#nextButtonMedicalDiagnosis').hide();
	// 					percentageMedical_Diagnosis +=20;
	// 					$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('5 of 5');
	// 			}
	// 			console.log(numOfClicksMedical_Diagnosis);
	// });

	// $('#backButtonMedicalDiagnosis').click(function() {
	// 			numOfClicksMedical_Diagnosis --;
	// 			if(numOfClicksMedical_Diagnosis == 3){
	// 				 $('#prescriptionDiv').show();
	// 					$('#requestLabXrayDiv').hide();
	// 					$('#nextButtonMedicalDiagnosis').show();
	// 					percentageMedical_Diagnosis -= 20;
	// 					$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('4 of 5');
	// 			}
	// 			if(numOfClicksMedical_Diagnosis == 2){
	// 					$('#remarksDiv').show();
	// 					$('#prescriptionDiv').hide();
	// 					percentageMedical_Diagnosis -= 20;
	// 					$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('3 of 5');
	// 			}
	// 			if(numOfClicksMedical_Diagnosis == 1){
	// 					$('#laboratoryresult').show();
	// 					$('#remarksDiv').hide();
	// 					percentageMedical_Diagnosis -= 20;
	// 					$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('2 of 5');
	// 			}
	// 			if(numOfClicksMedical_Diagnosis == 0){
	// 					$('#physicalexamination').show();
	// 					$('#laboratoryresult').hide();
	// 					$('#backButtonMedicalDiagnosis').hide();
	// 					percentageMedical_Diagnosis -= 20;
	// 					$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('1 of 5');
	// 			}
	// 	});

	// 	$(document).on('click', '.medical-button-container #update-medical-record-button', function(){ 
	// 			if ($('#height').val() || $('#weight').val() || $('#blood-pressure').val() || $('#pulse-rate').val() || $('#right-eye').val() || $('#left-eye').val() || $('#head').val() || $('#eent').val() || $('#neck').val() || $('#neck').val() || $('#chest').val() || $('#heart').val() || $('#heart').val() || $('#lungs').val() || $('#abdomen').val() || $('#back').val() || $('#skin').val() || $('#extremities').val() || $('#hemoglobin').val() || $('#hemasocrit').val() || $('#wbc').val() || $('#pus-cells').val() || $('#rbc').val() || $('#albumin').val() || $('#sugar').val() || $('#macroscopic').val() || $('#microscopic').val() || $('#drug-test').val() || $('#chest-xray').val() || $('#remarks').val() || $('#prescription').val()) {
	// 					var patient_id = create_record_patient_id;
	// 					var appointment_id_fin = appointment_id;
	// 					var height = $('#height').val();
	// 					var weight = $('#weight').val();
	// 					var bloodPressure = $('#blood-pressure').val();
	// 					var pulseRate = $('#pulse-rate').val();
	// 					var rightEye = $('#right-eye').val();
	// 					var leftEye = $('#left-eye').val();
	// 					var head = $('#head').val();
	// 					var eent = $('#eent').val();
	// 					var neck = $('#neck').val();
	// 					var chest = $('#chest').val();
	// 					var heart = $('#heart').val();
	// 					var lungs = $('#lungs').val();
	// 					var abdomen = $('#abdomen').val();
	// 					var back = $('#back').val();
	// 					var skin = $('#skin').val();
	// 					var extremities = $('#extremities').val();
	// 					var remarks = $('#remarks').val();
	// 					var prescription = $('#prescription').val();
	// 					$.ajax({
	// 							type: "POST",
	// 							url: "update-medical-record-modal.php",
	// 							async: true,
	// 							data: 
	// 							{   'create_record_patient_id':patient_id,
	// 									'appointment_id':appointment_id_fin,
	// 									'height':height,
	// 									'weight':weight,
	// 									'blood-pressure':bloodPressure,
	// 									'pulse-rate':pulseRate,
	// 									'right-eye':rightEye,
	// 									'left-eye':leftEye,
	// 									'head':head,
	// 									'eent':eent,
	// 									'neck':neck,
	// 									'chest':chest,
	// 									'heart':heart,
	// 									'lungs':lungs,
	// 									'abdomen':abdomen,
	// 									'back':back,
	// 									'skin':skin,
	// 									'extremities':extremities,
	// 									'remarks':remarks,
	// 									'prescription':prescription,
	// 							},
	// 							success: function(response)
	// 							{
	// 									message = JSON.parse(response);
	// 									console.log(message);
	// 									if(message==1){
	// 											console.log("Success!");
	// 											 $('#create-medical-record-modal').modal("hide");

	// 									}  
	// 							}
	// 					});
	// 			}
	// 			return false;
	// 	});


	// $('.addBillingToMedical').click(function() {
	// 			if($(this).attr('id')){
	// 					var medicalBillingId = $(this).attr('id');
	// 					var medical_billing_id = medicalBillingId.split("_");
	// 					medical_billing_patient_id = medical_billing_id[1];
	// 					medical_billing_appointment_id = medical_billing_id[2];
	// 					console.log(medical_billing_patient_id);
	// 					console.log(medical_billing_appointment_id);
	// 					$.ajax({
	// 							type: "POST",
	// 							url: "medical-check-billing.php",
	// 							async: true,
	// 							data: {'medical_billing_patient_id':medical_billing_patient_id, 'medical_billing_appointment_id':medical_billing_appointment_id},
	// 							success: function(response)
	// 							{
	// 									output = '';
	// 									message = JSON.parse(response);
	// 									console.log(message);
	// 									for(i=0; i<message.length; i++) {
	// 											var splitMessage = message[i].split("(;;)");
	// 											var counter = splitMessage[0];
	// 											var medicalService = splitMessage[1];
	// 											var medicalServiceRate = splitMessage[2];
	// 											output += "<tr><td><input type='checkbox' class='checkboxMedicalService' id="+medicalServiceRate+"></td><td class='medicalService' style='padding-left:15px; '>"+medicalService+"</td><td class='medicalServiceRate' style='padding-left:15px; '>"+medicalServiceRate+"</td></tr>";
	// 									}
	// 									$('.displayServices').html(output);
	// 									if(counter=="null"){
	// 											$(".displayServices :input").attr("disabled", true);
	// 											$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled>");
	// 											$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medical-bill-confirm-button' disabled>Confirm</button>");
	// 									}
	// 									else if(counter=="not_null"){
	// 											$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled>");
	// 											$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medical-bill-confirm-button'>Confirm</button>");
	// 									}
	// 									else{
	// 											$(".displayServices :input").attr("disabled", true);
	// 											$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled value="+splitMessage[0]+">");
	// 											$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medical-bill-confirm-button' disabled>Confirm</button>");
	// 									}
	// 									$("#medical-bill").val();
	// 									var fin = 0;
	// 									$('.checkboxMedicalService').click(function(){
	// 											if ($(this).is(':checked')){
	// 													var medicalBillRate = parseFloat($(this).attr('id'));
	// 													console.log(medicalBillRate);
	// 													fin = parseFloat(fin+medicalBillRate);
	// 													console.log(fin);
	// 													$("#medical-bill").val(fin);
	// 											};
	// 									});
	// 									$('#medicalBillingModal').modal();

	// 							}
	// 					});
	// 			}
	// 			return false;
	// 	});


	// $(document).on('click', '.medical-bill-confirm #medical-bill-confirm-button', function(){
	// 	if($('#medical-bill').val()){
	// 			var patient_id = medical_billing_patient_id;
	// 			var appointment_id = medical_billing_appointment_id;
	// 			var medical_billing_amount = $('#medical-bill').val();
	// 			console.log(patient_id);
	// 			console.log(appointment_id);
	// 			console.log(medical_billing_amount);
	// 			$.ajax({
	// 					type: "POST",
	// 					url: "add-medical-billing.php",
	// 					async: true,
	// 					data:
	// 					{   'patient_id':patient_id,
	// 							'appointment_id':appointment_id,
	// 							'medical_billing_amount':medical_billing_amount,
	// 					},
	// 					success: function(response)
	// 					{
	// 							message = JSON.parse(response);
	// 							console.log(message);
	// 							if(message==1){
	// 									console.log("Success!");
	// 									$('#medicalBillingModal').modal("hide");
	// 							}  
	// 					}
	// 			});
	// 	} 
	// 	return false;
	// });



// ----------------------------- Manage Schedule -----------------------------


$('.addmoremedicalsched').click(function(){
    $(this).parents('.medical_manage').find('tbody').append('<tr class="schedule_tr"><td><input type="date" class="form-control"/></td><td><button class="btn btn-danger btn-sm removemedicalsched">Remove</button></td></tr>');
    $('.removemedicalsched').click(function(){
        // console.log($(this).closest('tr'));
        $(this).closest('tr').remove();
    });
});
$('.removemedicalsched').click(function(){
    // console.log($(this).closest('tr'));
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

        // $.ajax({
        //     url: addMedicalSchedule,
        //     type: 'POST',
        //     dataType: 'json',
        //     data: {schedules:  schedules, _token: token},
        //     success: function(data) {
        //         $('button').attr('disabled', 'disabled');
        //         $('input').attr('disabled', 'disabled');
        //         $('#manageschedulepanel').css('background-color', '#d6e9c6');
        //     },
        //     error: function(xhr, textStatus, errorThrown) {
        //     }
        // });
    }
    
}); 

// ----------------------------- End of Manage Schedule ----------------------







// ------------------PROFILE---------------
// ------------------SEARCH PATIENT---------------

	// $('#searchPatient').keyup(function() {
	// 	if($('#searchPatient').val()){
	// 		$.ajax({
	// 			url: 'search-patient.php',
	// 			type: 'POST',
	// 			async: true,
	// 			data: {
	// 				'search_string': $('#searchPatient').val()
	// 			},
	// 			success:function(response){
	// 				output = '';
	// 				message=JSON.parse(response);
	// 				console.log(message);
	// 				if(message=='null'){
	// 					$('#searchResults').html("");
	// 					$('#searchTable').hide();
	// 				}
	// 				else{
	// 					for(i=0; i<message.length; i++) {
	// 						messageSplit = message[i].split("(;;)");
	// 						output += "<tr><td><a class='searchQueryResults' id='resultId_"+messageSplit[0]+"'>"+messageSplit[1]+"</a></td></tr>";
	// 					}
	// 					$('#searchResults').html(output);
	// 					$('#searchTable').show();
	// 					$('.searchQueryResults').click(function() {
	// 						var patientId = $(this).attr('id').split('_')[1];
	// 						console.log(patientId);
	// 						$.ajax({
	// 							url: 'search-patient-get-info.php',
	// 							type: 'POST',
	// 							async: true,
	// 							data: {
	// 								'patient_id': patientId
	// 							},
	// 							success:function(response){
	// 								output = '';
	// 								message=jQuery.parseJSON(response);
	// 								$('#ageTd').html(message.age);
	// 								$('#sexTd').html(message.sex);
	// 								$('#courseTd').html(message.degree_program);
	// 								$('#yearlevelTd').html(message.year_level);
	// 								$('#birthdateTd').html(message.birthdate);
	// 								$('#religionTd').html(message.religion);
	// 								$('#nationlityTd').html(message.nationality);
	// 								$('#fatherTd').html(message.father);
	// 								$('#motherTd').html(message.mother);
	// 								$('#homeaddressTd').html(message.street + ', ' + message.town + ', ' + message.province);
	// 								$('#restelTd').html(message.residence_telephone);
	// 								$('#perosnalcontactnumberTd').html(message.personal_contact_number);
	// 								$('#guardiannameTd').html(message.guardian_name);
	// 								$('#guardianaddressTd').html(message.guardian_address);
	// 								$('#guardianrelationshipTd').html(message.guardian_relationship);
	// 								$('#guardiantelTd').html(message.guardian_residence_telephone);
	// 								$('#guardiancpTd').html(message.guardian_residence_cellphone);
	// 								if($('#determine-view-record-button').val()==1){
	// 										$('#patientInfoModalFooter').html('<a href="view-medical-records.php?patient_id=' + patientId +'" class="btn btn-info" role="button">View Medical Records</a><a href="add-new-medical-record-no-appointment.php?patient_id=' + patientId +'" class="btn btn-info" role="button">Add New Record</a>');
	// 								}
	// 								if($('#determine-view-record-button').val()==2){
	// 										$('#patientInfoModalFooter').html('<a href="view-medical-records.php?patient_id=' + patientId +'" class="btn btn-info" role="button">View medical Records</a><a href="add-new-medical-record-no-appointment.php?patient_id=' + patientId +'" class="btn btn-info" role="button">Add New Record</a>');
	// 								}
	// 							}
	// 						});
	// 						$('#searchPatientRecordInfo').modal();
	// 					});
	// 				}
	// 			}
	// 		});
	// 	}
	// 	else{
	// 		$('#searchTable').hide();
	// 		$('#searchResults').html("");
	// 	}
	// });

	// $('.viewMedicalRecordBasedOnDate').click(function(){
	// 	var date=$(this).attr('id');
	// 	console.log(date);
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: 'view-medical-records-ajax.php',
	// 		async: true,
	// 		data:{
	// 			'patient_id': $('#patient_id').val(),
	// 			'date': date
	// 		},
	// 		success: function(response){
	// 			message=jQuery.parseJSON(response);
	// 			$('#heightTd').html(message.height);
	// 			$('#weightTd').html(message.weight);
	// 			$('#bpTd').html(message.blood_pressure);
	// 			$('#prTd').html(message.pulse_rate);
	// 			$('#righteyeTd').html(message.right_eye);
	// 			$('#lefteyeTd').html(message.left_eye);
	// 			$('#headTd').html(message.head);
	// 			$('#eentTd').html(message.eent);
	// 			$('#neckTd').html(message.neck);
	// 			$('#chestTd').html(message.chest);
	// 			$('#heartTd').html(message.heart);
	// 			$('#lungsTd').html(message.lungs);
	// 			$('#abdomenTd').html(message.abdomen);
	// 			$('#backTd').html(message.back);
	// 							$('#skinTd').html(message.skin);
	// 			$('#extremitiesTd').html(message.extremities);
	// 			$('#hemoglobinTd').html(message.hemoglobin);
	// 			$('#hemasocritTd').html(message.hemasocrit);
	// 			$('#wbcTd').html(message.wbc);
	// 			$('#puscellsTd').html(message.pus_cells);
	// 			$('#rbcTd').html(message.rbc);
	// 			$('#albuminTd').html(message.albumin);
	// 			$('#sugarTd').html(message.sugar);
	// 			$('#macroscopicTd').html(message.macroscopic);
	// 			$('#microscopicTd').html(message.microscopic);
	// 			$('#drugtestTd').html(message.drug_test_result);
	// 			$('#chestxrayTd').html(message.chest_xray_result);
	// 			$('#remarksTd').html(message.remark);
	// 			$('#prescriptionTd').html(message.prescription);
	// 			$('#viewMedicalRecordBasedOnDateModalTitle').html('Detailed Patient Record ('+ date +')')
	// 			$('#viewMedicalRecordBasedOnDateModal').modal();
	// 		}
	// 	});
	// });
});