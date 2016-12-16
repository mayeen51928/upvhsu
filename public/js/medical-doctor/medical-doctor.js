$(document).ready( function(){


// ------------------DASHBOARD---------------
	$('.addMedicalRecordButton').click(function() {
		if($(this).attr('id')){
			var patient_id = $(this).attr('id');
			console.log(patient_id);
			var patientIdSplit = patient_id.split("_");
			create_record_patient_id = patientIdSplit[1];
			console.log("Patient id is..." + create_record_patient_id);
			appointment_id = patientIdSplit[2];
			console.log("Appointment is..." + appointment_id)
			$.ajax({
					type: "POST",
					url: "display-medical-info-modal.php",
					async: true,
					data: {'create_record_patient_id':create_record_patient_id, 'appointment_id':appointment_id},
					success: function(response)
					{
							message = JSON.parse(response);
							console.log(message);
							var splitMessage = message.split("(;;)");
							$('.personal-information-name').html("").append("<p>"+splitMessage[1]+" "+splitMessage[1]+"</p>");
							$('.personal-information-reasons').html("").append("<p>"+splitMessage[3]+"</p>");
							if (splitMessage[5]==0){
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
									$('#requestLab').removeAttr('disabled');
									$('#requestXray').removeAttr('disabled');
									$('.medical-button-container').html("").append("<button type='button' class='btn btn-primary add-medical-record-button' id='add-medical-record-button'>Submit</button>");
							}
							else{
									$('#height').val(splitMessage[13]);
									$('#weight').val(splitMessage[14]);
									$('#blood-pressure').val(splitMessage[15]);
									$('#pulse-rate').val(splitMessage[16]);
									$('#right-eye').val(splitMessage[17]);
									$('#left-eye').val(splitMessage[18]);
									$('#head').val(splitMessage[19]);
									$('#eent').val(splitMessage[20]);
									$('#neck').val(splitMessage[21]);
									$('#chest').val(splitMessage[22]);
									$('#heart').val(splitMessage[23]);
									$('#lungs').val(splitMessage[24]);
									$('#abdomen').val(splitMessage[25]);
									$('#back').val(splitMessage[26]);
									$('#skin').val(splitMessage[27]);
									$('#extremities').val(splitMessage[26]);
									$('#hemoglobin').val(splitMessage[6]);
									$('#hemasocrit').val(splitMessage[7]);
									$('#wbc').val(splitMessage[8]);
									$('#pus-cells').val(splitMessage[31]);
									$('#rbc').val(splitMessage[32]);
									$('#albumin').val(splitMessage[33]);
									$('#sugar').val(splitMessage[34]);
									$('#macroscopic').val(splitMessage[11]);
									$('#microscopic').val(splitMessage[12]);
									$('#drug-test').val(splitMessage[10]);
									$('#chest-xray').val(splitMessage[9]);
									$('#remarks').val(splitMessage[30]);
									$('#prescription').val(splitMessage[29]);
									$('#requestLab').attr('disabled', 'disabled');
									$('#requestXray').attr('disabled', 'disabled');
									$('.medical-button-container').html("").append("<button type='button' class='btn btn-primary update-medical-record-button' id='update-medical-record-button'>Update</button>");
							}
							$('#create-medical-record-modal').modal();
					}
			});
		}
		return false;
	});

	$(document).on('click', '.medical-button-container #add-medical-record-button', function(){ 
		if ($('#height').val() || $('#weight').val() || $('#blood-pressure').val() || $('#pulse-rate').val() || $('#right-eye').val() || $('#left-eye').val() || $('#head').val() || $('#eent').val() || $('#neck').val() || $('#neck').val() || $('#chest').val() || $('#heart').val() || $('#heart').val() || $('#lungs').val() || $('#abdomen').val() || $('#back').val() || $('#skin').val() || $('#extremities').val()) {
			var patient_id = create_record_patient_id;
			var appointment_id_fin = appointment_id;
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
			var hemoglobin = $('#hemoglobin').val();
			var hemasocrit = $('#hemasocrit').val();
			var wbc = $('#wbc').val();
			var pusCells = $('#pus-cells').val();
			var rbc = $('#rbc').val();
			var albumin = $('#albumin').val();
			var sugar = $('#sugar').val();
			var macroscopic = $('#macroscopic').val();
			var microscopic = $('#microscopic').val();
			var drugTest = $('#drug-test').val();
			var chestXray = $('#chest-xray').val();
			var remarks = $('#remarks').val();
			var prescription = $('#prescription').val();
			var num_of_request = 0;
			if($('#requestLab').is(':checked')){
				num_of_request=1;
			}
			if($('#requestXray').is(':checked')){
				num_of_request =2;
			}
			if($('#requestLab').is(':checked')){
				if($('#requestXray').is(':checked')){
					num_of_request =3;
				}
			}
			$.ajax({
					type: "POST",
					url: "add-medical-record-modal.php",
					async: true,
					data: 
					{   'create_record_patient_id':patient_id,
							'appointment_id':appointment_id_fin,
							'height':height,
							'weight':weight,
							'blood-pressure':bloodPressure,
							'pulse-rate':pulseRate,
							'right-eye':rightEye,
							'left-eye':leftEye,
							'head':head,
							'eent':eent,
							'neck':neck,
							'chest':chest,
							'heart':heart,
							'lungs':lungs,
							'abdomen':abdomen,
							'back':back,
							'skin':skin,
							'extremities':extremities,
							'hemoglobin':hemoglobin,
							'hemasocrit':hemasocrit,
							'wbc':wbc,
							'pus-cells':pusCells,
							'rbc':rbc,
							'albumin':albumin,
							'sugar':sugar,
							'macroscopic':macroscopic,
							'microscopic':microscopic,
							'drug-test':drugTest,
							'chest-xray':chestXray,
							'remarks':remarks,
							'prescription':prescription,
							'request_number':num_of_request
					},
					success: function(response)
					{
						message = JSON.parse(response);
						console.log(message);
						if(message==1){
							console.log("Success!");
							$('#create-medical-record-modal').modal("hide");
						}  
					}
				});
			}
			return false;
	});

	numOfClicksMedical_Diagnosis = 0;
	percentageMedical_Diagnosis = 20;
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
				console.log(numOfClicksMedical_Diagnosis);
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

		$(document).on('click', '.medical-button-container #update-medical-record-button', function(){ 
				if ($('#height').val() || $('#weight').val() || $('#blood-pressure').val() || $('#pulse-rate').val() || $('#right-eye').val() || $('#left-eye').val() || $('#head').val() || $('#eent').val() || $('#neck').val() || $('#neck').val() || $('#chest').val() || $('#heart').val() || $('#heart').val() || $('#lungs').val() || $('#abdomen').val() || $('#back').val() || $('#skin').val() || $('#extremities').val() || $('#hemoglobin').val() || $('#hemasocrit').val() || $('#wbc').val() || $('#pus-cells').val() || $('#rbc').val() || $('#albumin').val() || $('#sugar').val() || $('#macroscopic').val() || $('#microscopic').val() || $('#drug-test').val() || $('#chest-xray').val() || $('#remarks').val() || $('#prescription').val()) {
						var patient_id = create_record_patient_id;
						var appointment_id_fin = appointment_id;
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
						$.ajax({
								type: "POST",
								url: "update-medical-record-modal.php",
								async: true,
								data: 
								{   'create_record_patient_id':patient_id,
										'appointment_id':appointment_id_fin,
										'height':height,
										'weight':weight,
										'blood-pressure':bloodPressure,
										'pulse-rate':pulseRate,
										'right-eye':rightEye,
										'left-eye':leftEye,
										'head':head,
										'eent':eent,
										'neck':neck,
										'chest':chest,
										'heart':heart,
										'lungs':lungs,
										'abdomen':abdomen,
										'back':back,
										'skin':skin,
										'extremities':extremities,
										'remarks':remarks,
										'prescription':prescription,
								},
								success: function(response)
								{
										message = JSON.parse(response);
										console.log(message);
										if(message==1){
												console.log("Success!");
												 $('#create-medical-record-modal').modal("hide");

										}  
								}
						});
				}
				return false;
		});


	$('.addBillingToMedical').click(function() {
				if($(this).attr('id')){
						var medicalBillingId = $(this).attr('id');
						var medical_billing_id = medicalBillingId.split("_");
						medical_billing_patient_id = medical_billing_id[1];
						medical_billing_appointment_id = medical_billing_id[2];
						console.log(medical_billing_patient_id);
						console.log(medical_billing_appointment_id);
						$.ajax({
								type: "POST",
								url: "medical-check-billing.php",
								async: true,
								data: {'medical_billing_patient_id':medical_billing_patient_id, 'medical_billing_appointment_id':medical_billing_appointment_id},
								success: function(response)
								{
										output = '';
										message = JSON.parse(response);
										console.log(message);
										for(i=0; i<message.length; i++) {
												var splitMessage = message[i].split("(;;)");
												var counter = splitMessage[0];
												var medicalService = splitMessage[1];
												var medicalServiceRate = splitMessage[2];
												output += "<tr><td><input type='checkbox' class='checkboxMedicalService' id="+medicalServiceRate+"></td><td class='medicalService' style='padding-left:15px; '>"+medicalService+"</td><td class='medicalServiceRate' style='padding-left:15px; '>"+medicalServiceRate+"</td></tr>";
										}
										$('.displayServices').html(output);
										if(counter=="null"){
												$(".displayServices :input").attr("disabled", true);
												$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled>");
												$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medical-bill-confirm-button' disabled>Confirm</button>");
										}
										else if(counter=="not_null"){
												$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled>");
												$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medical-bill-confirm-button'>Confirm</button>");
										}
										else{
												$(".displayServices :input").attr("disabled", true);
												$('.medical-bill-input').html("").append("<input type='text' class='form-control' id='medical-bill' disabled value="+splitMessage[0]+">");
												$('.medical-bill-confirm').html("").append("<button type='button' class='btn btn-primary medical-bill-confirm' id='medical-bill-confirm-button' disabled>Confirm</button>");
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
				}
				return false;
		});


	$(document).on('click', '.medical-bill-confirm #medical-bill-confirm-button', function(){
		if($('#medical-bill').val()){
				var patient_id = medical_billing_patient_id;
				var appointment_id = medical_billing_appointment_id;
				var medical_billing_amount = $('#medical-bill').val();
				console.log(patient_id);
				console.log(appointment_id);
				console.log(medical_billing_amount);
				$.ajax({
						type: "POST",
						url: "add-medical-billing.php",
						async: true,
						data:
						{   'patient_id':patient_id,
								'appointment_id':appointment_id,
								'medical_billing_amount':medical_billing_amount,
						},
						success: function(response)
						{
								message = JSON.parse(response);
								console.log(message);
								if(message==1){
										console.log("Success!");
										$('#medicalBillingModal').modal("hide");
								}  
						}
				});
		} 
		return false;
	});
// ------------------MANAGE SCHEDULE---------------
// ------------------PROFILE---------------
// ------------------SEARCH PATIENT---------------

	$('#searchPatient').keyup(function() {
		if($('#searchPatient').val()){
			$.ajax({
				url: 'search-patient.php',
				type: 'POST',
				async: true,
				data: {
					'search_string': $('#searchPatient').val()
				},
				success:function(response){
					output = '';
					message=JSON.parse(response);
					console.log(message);
					if(message=='null'){
						$('#searchResults').html("");
						$('#searchTable').hide();
					}
					else{
						for(i=0; i<message.length; i++) {
							messageSplit = message[i].split("(;;)");
							output += "<tr><td><a class='searchQueryResults' id='resultId_"+messageSplit[0]+"'>"+messageSplit[1]+"</a></td></tr>";
						}
						$('#searchResults').html(output);
						$('#searchTable').show();
						$('.searchQueryResults').click(function() {
							var patientId = $(this).attr('id').split('_')[1];
							console.log(patientId);
							$.ajax({
								url: 'search-patient-get-info.php',
								type: 'POST',
								async: true,
								data: {
									'patient_id': patientId
								},
								success:function(response){
									output = '';
									message=jQuery.parseJSON(response);
									$('#ageTd').html(message.age);
									$('#sexTd').html(message.sex);
									$('#courseTd').html(message.degree_program);
									$('#yearlevelTd').html(message.year_level);
									$('#birthdateTd').html(message.birthdate);
									$('#religionTd').html(message.religion);
									$('#nationlityTd').html(message.nationality);
									$('#fatherTd').html(message.father);
									$('#motherTd').html(message.mother);
									$('#homeaddressTd').html(message.street + ', ' + message.town + ', ' + message.province);
									$('#restelTd').html(message.residence_telephone);
									$('#perosnalcontactnumberTd').html(message.personal_contact_number);
									$('#guardiannameTd').html(message.guardian_name);
									$('#guardianaddressTd').html(message.guardian_address);
									$('#guardianrelationshipTd').html(message.guardian_relationship);
									$('#guardiantelTd').html(message.guardian_residence_telephone);
									$('#guardiancpTd').html(message.guardian_residence_cellphone);
									if($('#determine-view-record-button').val()==1){
											$('#patientInfoModalFooter').html('<a href="view-medical-records.php?patient_id=' + patientId +'" class="btn btn-info" role="button">View Medical Records</a><a href="add-new-medical-record-no-appointment.php?patient_id=' + patientId +'" class="btn btn-info" role="button">Add New Record</a>');
									}
									if($('#determine-view-record-button').val()==2){
											$('#patientInfoModalFooter').html('<a href="view-dental-records.php?patient_id=' + patientId +'" class="btn btn-info" role="button">View Dental Records</a><a href="add-new-dental-record-no-appointment.php?patient_id=' + patientId +'" class="btn btn-info" role="button">Add New Record</a>');
									}
								}
							});
							$('#searchPatientRecordInfo').modal();
						});
					}
				}
			});
		}
		else{
			$('#searchTable').hide();
			$('#searchResults').html("");
		}
	});

	$('.viewMedicalRecordBasedOnDate').click(function(){
		var date=$(this).attr('id');
		console.log(date);
		$.ajax({
			type: 'POST',
			url: 'view-medical-records-ajax.php',
			async: true,
			data:{
				'patient_id': $('#patient_id').val(),
				'date': date
			},
			success: function(response){
				message=jQuery.parseJSON(response);
				$('#heightTd').html(message.height);
				$('#weightTd').html(message.weight);
				$('#bpTd').html(message.blood_pressure);
				$('#prTd').html(message.pulse_rate);
				$('#righteyeTd').html(message.right_eye);
				$('#lefteyeTd').html(message.left_eye);
				$('#headTd').html(message.head);
				$('#eentTd').html(message.eent);
				$('#neckTd').html(message.neck);
				$('#chestTd').html(message.chest);
				$('#heartTd').html(message.heart);
				$('#lungsTd').html(message.lungs);
				$('#abdomenTd').html(message.abdomen);
				$('#backTd').html(message.back);
								$('#skinTd').html(message.skin);
				$('#extremitiesTd').html(message.extremities);
				$('#hemoglobinTd').html(message.hemoglobin);
				$('#hemasocritTd').html(message.hemasocrit);
				$('#wbcTd').html(message.wbc);
				$('#puscellsTd').html(message.pus_cells);
				$('#rbcTd').html(message.rbc);
				$('#albuminTd').html(message.albumin);
				$('#sugarTd').html(message.sugar);
				$('#macroscopicTd').html(message.macroscopic);
				$('#microscopicTd').html(message.microscopic);
				$('#drugtestTd').html(message.drug_test_result);
				$('#chestxrayTd').html(message.chest_xray_result);
				$('#remarksTd').html(message.remark);
				$('#prescriptionTd').html(message.prescription);
				$('#viewMedicalRecordBasedOnDateModalTitle').html('Detailed Patient Record ('+ date +')')
				$('#viewMedicalRecordBasedOnDateModal').modal();
			}
		});
	});
});