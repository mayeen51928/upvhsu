$(document).ready( function(){
$.ajaxSetup({
	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});



// ------------------DASHBOARD---------------
function highchartsfunc(){
	$.post('/totalnumberofpatients', {}, function(data, textStatus, xhr) {
    if(data)
    {
       Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Finished vs. Unfinished Appointments'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Appointments',
            colorByPoint: true,
            data: [{
                name: 'Finished',
                y: data['finished'],
                sliced: false,
                selected: true
            },
            {
                name: 'Unfinished',
                y: data['unfinished']
            }]
        }]
    }); 
    }

});
}
if($('#doctordashboard').val() == 1)
{
	highchartsfunc();
}
$('#staffnotesdoctor').keyup(function() {
	// if($('#staffnotesdoctor').val())
	// {
		$('#savingstatus').html('Saving...');
		$.post('/doctor/updatestaffnotes',
			{note: $('#staffnotesdoctor').val()}, function(data, textStatus, xhr) {
				// console.log(xhr);
				$('#savingstatus').html('&nbsp;');
		});
	// }
});

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
		$('#requestLabXrayDiv').show();
		
		$('#backButtonMedicalDiagnosis').show();
		percentageMedical_Diagnosis += 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('2 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 2){
		$('#requestLabXrayDiv').hide();
		$('#laboratoryresult').show();
		
		percentageMedical_Diagnosis += 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('3 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 3){
		$('#laboratoryresult').hide();
		$('#remarksDiv').show();
		
		percentageMedical_Diagnosis +=20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('4 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 4){
		$('#remarksDiv').hide();
		// $('#prescriptionDiv').hide();
		$('#prescriptionDiv').show();
		$('#nextButtonMedicalDiagnosis').hide();
		percentageMedical_Diagnosis +=20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('5 of 5');
	}
});
$('#backButtonMedicalDiagnosis').click(function() {
	numOfClicksMedical_Diagnosis --;
	if(numOfClicksMedical_Diagnosis == 3){
	   $('#prescriptionDiv').hide();
		$('#remarksDiv').show();
		$('#nextButtonMedicalDiagnosis').show();
		percentageMedical_Diagnosis -= 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('4 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 2){
		$('#remarksDiv').hide();
		$('#laboratoryresult').show();
		percentageMedical_Diagnosis -= 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('3 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 1){
		$('#laboratoryresult').hide();
		$('#requestLabXrayDiv').show();
		percentageMedical_Diagnosis -= 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('2 of 5');
	}
	if(numOfClicksMedical_Diagnosis == 0){
		$('#requestLabXrayDiv').hide();
		$('#physicalexamination').show();
		
		$('#backButtonMedicalDiagnosis').hide();
		percentageMedical_Diagnosis -= 20;
		$('#changeProgress_MedicalDiagnosis').attr('aria-valuenow', percentageMedical_Diagnosis).css('width', percentageMedical_Diagnosis+'%').html('1 of 5');
	}
});
$("a[data-toggle='collapse']").click(function(){
	if($(this).find('span').hasClass('glyphicon glyphicon-chevron-right')){
		$(this).find('span').removeClass('glyphicon glyphicon-chevron-right').addClass('glyphicon glyphicon-chevron-down');
	}
	else
	{
		$(this).find('span').removeClass('glyphicon glyphicon-chevron-down').addClass('glyphicon glyphicon-chevron-right');
	}
});
$('.addMedicalRecordButton').click(function() {
	// $('#confirmModal').modal();
	// $('#requestsFromDoctor').load(location.href + " #requestsFromDoctor");
	$('#create-medical-record-modal input').removeAttr('disabled');
	$('#create-medical-record-modal textarea').removeAttr('disabled');
	$('#create-medical-record-modal #hemoglobin, #create-medical-record-modal #hemasocrit, #create-medical-record-modal #wbc, #create-medical-record-modal #pus-cells, #create-medical-record-modal #rbc, #create-medical-record-modal #albumin, #create-medical-record-modal #sugar, #create-medical-record-modal #macroscopic, #create-medical-record-modal #microscopic, #create-medical-record-modal #drug-test, #create-medical-record-modal #chest-xray').attr('disabled', 'disabled');
	$('#create-medical-record-modal #height').focus();
	$('.medical-button-container').html("");
	$('.checkboxMedicalService').removeAttr('checked').removeAttr('disabled');
	$('#physicalexamaccordion input').attr('disabled', 'disabled');
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
					medical_services_id=[];
					$("input:checkbox.checkboxMedicalService").each(function(){
							if($(this).is(":checked") && !$(this).attr("disabled")){
									medical_services_id.push($(this).attr("id"));
							}
					});
					// patient_type_id_radio = $('input[name=patient_type_radio]:checked').val()
					// senior_id = $('#senior_id').val();
			
					if ($('#height').val() &&
						$('#weight').val() &&
						$('#blood-pressure').val() &&
						$('#pulse-rate').val() &&
						$('#right-eye').val() &&
						$('#left-eye').val() &&
						$('#head').val() &&
						$('#eent').val() &&
						$('#neck').val() &&
						$('#neck').val() &&
						$('#chest').val() &&
						$('#heart').val() &&
						$('#heart').val() &&
						$('#lungs').val() &&
						$('#abdomen').val() &&
						$('#back').val() &&
						$('#skin').val() &&
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
								medical_services_id: medical_services_id,
								// patient_type_id_radio: patient_type_id_radio,
								// senior_id: senior_id,
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
					$('.checkboxMedicalService').removeAttr('disabled');

					for (var i = 0; i < data['medical_billing_status'].length; i++){
						$('#'+data['medical_billing_status'][i].medical_service_id+'.checkboxMedicalService').prop('checked', true);
						$('.checkboxMedicalService').prop('disabled', true);
						$('#patient_type_radio_lab').prop('disabled', true);
					}
					// if(data['patient_type_checker']['patient_type_id'] == 5){
					// 	$('#patient_type_radio_medical').css('display', 'block');
					// 	if(data['medical_billing_status'][1].senior_citizen_id != null){
					// 		$(":radio[value=6]").attr('checked',true); 
					// 		$("#senior_id").val(data['medical_billing_status'][1].senior_citizen_id).css("disabled","disabled");
					// 	}
					// 	else{
					// 		$(":radio[value=5]").attr('checked',true); 
					// 		$("#senior_id").css("disabled","disabled").removeAttr('placeholder');
					// 	}
					// }
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
					if(data['cbc_result']['hemoglobin']==null || data['cbc_result']['hemasocrit']==null || data['cbc_result']['wbc']==null)
					{
						$('#remarks').attr('disabled', 'disabled');
						$('#prescription').attr('disabled', 'disabled');
					}
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
					if(data['urinalysis_result']['pus_cells']==null || data['urinalysis_result']['rbc']==null || data['urinalysis_result']['albumin']==null || data['urinalysis_result']['sugar']==null)
					{
						$('#remarks').attr('disabled', 'disabled');
						$('#prescription').attr('disabled', 'disabled');
					}

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
					if(data['fecalysis_result']['macroscopic']==null || data['fecalysis_result']['microscopic']==null)
					{
						$('#remarks').attr('disabled', 'disabled');
						$('#prescription').attr('disabled', 'disabled');
					}
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
					if(data['drug_test_result']['drug_test_result']==null)
					{
						$('#remarks').attr('disabled', 'disabled');
						$('#prescription').attr('disabled', 'disabled');
					}
					$('#drug-test').val(data['drug_test_result']['drug_test_result']);
					$('#requestDrugTest').attr('disabled', 'disabled').attr('checked', 'checked');
				}
				else
				{
					$('#drug-test').val('');
				}
				if(data['chest_xray_result'])
				{
					if(data['chest_xray_result']['xray_result']==null)
					{
						$('#remarks').attr('disabled', 'disabled');
						$('#prescription').attr('disabled', 'disabled');
					}
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
				// else
				// {
				// 	$('#remarks').val('');
				// 	$('#remarks').removeAttr('disabled');
				// }
				if(data['prescription'])
				{
					$('#prescription').val(data['prescription']['prescription']);
					$('#prescription').attr('disabled', 'disabled');
				}
				// else
				// {
				// 	$('#prescription').val('');
				// 	$('#prescription').removeAttr('disabled');
				// }
				if(!data['prescription'] || !data['prescription'])
				{
					$('.medical-button-container').append("<button type='button' class='btn btn-success update-medical-record-button' id='update-medical-record-button_"+appointment_id+"'>Update</button>");
				}
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
									highchartsfunc();
									$('#addMedicalRecordButton_'+appointment_id).closest("tr").remove();
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

var requestCheckboxCounter = 0;
$('.requestCheckbox input').click(function(){

	if($(this).is(':checked'))
	{
		requestCheckboxCounter++;
	}
	else
	{
		requestCheckboxCounter--;
	}
	if(requestCheckboxCounter>0)
	{
		// $('#addNewMedicalRecordWConfirmRequests').show();
		$('#remarksDiv textarea').attr('disabled', 'disabled');
		$('#prescriptionDiv textarea').attr('disabled', 'disabled');
	}
	else
	{
		$('#remarksDiv textarea').val('');
		$('#prescriptionDiv textarea').val('');
		$('#remarksDiv textarea').removeAttr('disabled');
		$('#prescriptionDiv textarea').removeAttr('disabled');
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


// ------------------SEARCH PATIENT---------------
function leapYear(year)
{
  return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
}
$("#search_month").change(function(){
	var month = $(this).find(':selected')[0].value;
	// console.log(month);
	
	$('#search_date').html('');
	$('#search_date').removeAttr('disabled');
	$('#search_date').append('<option value="00" selected></option>');
	if(month==0)
	{
		// for(var i=1; i<32; i++)
		// {
		// 	$('#search_date').append('<option value="'+i+'">' + i + '</option>');
		// }
		$('#search_date').attr('disabled', 'disabled');
	}
	if(month == 01 || month == 03 || month == 05 || month == 07|| month == 08 || month == 10|| month == 12)
	{
		
		for(var i=1; i<32; i++)
		{
			$('#search_date').append('<option value="'+i+'">' + i + '</option>');
		}
	}
	else if(month == 02)
	{
		if(leapYear($('#search_year').find(':selected')[0].value))
		{
			for(var i=1; i<30; i++)
			{
				$('#search_date').append('<option value="'+i+'">' + i + '</option>');
			}
		}
		else
		{
			for(var i=1; i<29; i++)
			{
				$('#search_date').append('<option value="'+i+'">' + i + '</option>');
			}
		}
		
	}
	else if(month==04 || month==06 || month==09 || month == 11)
	{
		for(var i=1; i<31; i++)
		{
			$('#search_date').append('<option value="'+i+'">' + i + '</option>');
		}
	}
});
$("#search_year").change(function(){
	var year = $(this).find(':selected')[0].value;
	var month = $('#search_month').find(':selected')[0].value;
	if(leapYear(year) == true && month==02)
	{
		$('#search_date').html('');
		$('#search_date').append('<option value="00" selected></option>');
		// $('#search_date').append('<option value="00">none</option>');
		for(var i=1; i<30; i++)
		{
			$('#search_date').append('<option value="'+i+'">' + i + '</option>');
		}
	}
	if(leapYear(year) == false && month==02)
	{
		$('#search_date').html('');
		$('#search_date').append('<option value="00" selected></option>');
		// $('#search_date').append('<option value="00">none</option>');
		for(var i=1; i<29; i++)
		{
			$('#search_date').append('<option value="'+i+'">' + i + '</option>');
		}
	}
});
$('#searchbydatebutton').click(function() {
	console.log($('#search_month').find(':selected')[0].value);
	console.log($('#search_date').find(':selected')[0].value);
	console.log($('#search_year').find(':selected')[0].value);
	$('#searchlistofallpatients').hide();
		$('#searchTable').hide();
		// $('#searchResults').html("");
		$('#searchloading').show();
	$.post('/searchpatientbydaterecord',
			{
				search_month: $('#search_month').find(':selected')[0].value,
				search_date: $('#search_date').find(':selected')[0].value,
				search_year: $('#search_year').find(':selected')[0].value,
			}, function(data) {
				// $('#searchlistofallpatients').hide();
				$('#searchResults').html("");
				// $('#searchTable').hide();
				if(data['counter']>0)
				{
			  		output = '';
	  				for(var i=0; i < data['searchpatientappointmentidyarray'].length; i++)
	  				{
	  					output += "<tr><td>" + data['searchpatientscheduledayarray'][i] + "</td><td><a class='searchQueryResults medicalrecorddate' id='medicalrecorddate_"+data['searchpatientappointmentidyarray'][i]+"'>"+data['searchpatientnamearray'][i]+"</a></td></tr>";
	  				}
	  				$('#searchlistofallpatients').hide();
	  				$('#searchloading').hide();
	  				$('#searchResults').html(output);
  					$('#searchTable').show();
	  				$('.medicalrecorddate').click(function() {
						var medicalAppointmentId = $(this).attr('id').split('_')[1];
						$.post('/viewindividualrecordfromsearch',
							{
								medical_appointment_id: medicalAppointmentId}, function(data, textStatus, xhr)
							{
								if(data['physical_examination'])
									{
										$('#heightTd').html(data['physical_examination']['height']);
										$('#weightTd').html(data['physical_examination']['weight']);
										$('#bpTd').html(data['physical_examination']['blood_pressure']);
										$('#prTd').html(data['physical_examination']['pulse_rate']);
										$('#righteyeTd').html(data['physical_examination']['right_eye']);
										$('#lefteyeTd').html(data['physical_examination']['left_eye']);
										$('#headTd').html(data['physical_examination']['head']);
										$('#eentTd').html(data['physical_examination']['eent']);
										$('#neckTd').html(data['physical_examination']['neck']);
										$('#chestTd').html(data['physical_examination']['chest']);
										$('#heartTd').html(data['physical_examination']['heart']);
										$('#lungsTd').html(data['physical_examination']['lungs']);
										$('#abdomenTd').html(data['physical_examination']['abdomen']);
										$('#backTd').html(data['physical_examination']['back']);
										$('#skinTd').html(data['physical_examination']['skin']);
										$('#extremitiesTd').html(data['physical_examination']['extremities']);
									}
									else
									{
										$('#heightTd').html('');
										$('#weightTd').html('');
										$('#bpTd').html('');
										$('#prTd').html('');
										$('#righteyeTd').html('');
										$('#lefteyeTd').html('');
										$('#headTd').html('');
										$('#eentTd').html('');
										$('#neckTd').html('');
										$('#chestTd').html('');
										$('#heartTd').html('');
										$('#lungsTd').html('');
										$('#abdomenTd').html('');
										$('#backTd').html('');
										$('#skinTd').html('');
										$('#extremitiesTd').html('');
									}
									if(data['cbc_result'])
									{
										$('#hemoglobinTd').html(data['cbc_result']['hemoglobin']);
										$('#hemasocritTd').html(data['cbc_result']['hemasocrit']);
										$('#wbcTd').html(data['cbc_result']['wbc']);
									}
									else
									{
										$('#hemoglobinTd').html('');
										$('#hemasocritTd').html('');
										$('#wbcTd').html('');
									}
									if(data['urinalysis_result'])
									{
										$('#puscellsTd').html(data['urinalysis_result']['pus_cells']);
										$('#rbcTd').html(data['urinalysis_result']['rbc']);
										$('#albuminTd').html(data['urinalysis_result']['albumin']);
										$('#sugarTd').html(data['urinalysis_result']['sugar']);
									}
									else
									{
										$('#puscellsTd').html('');
										$('#rbcTd').html('');
										$('#albuminTd').html('');
										$('#sugarTd').html('');
									}
									if(data['fecalysis_result'])
									{
										$('#macroscopicTd').html(data['fecalysis_result']['macroscopic']);
										$('#microscopicTd').html(data['fecalysis_result']['microscopic']);
									}
									else
									{
										$('#macroscopicTd').html('');
										$('#microscopicTd').html('');
									}
									if(data['drug_test_result'])
									{
										$('#drugtestTd').html(data['drug_test_result']['drug_test'])
									}
									else
									{
										$('#drugtestTd').html('');
									}
									if(data['chest_xray_result'])
									{
										$('#chestxrayTd').html(data['chest_xray_result']['xray_result']);
									}
									else
									{
										$('#cchestxrayTd').html('');
									}
									if(data['remark'])
									{
										$('#remarksTd').html(data['remark']['remark']);
									}
									else
									{
										$('#remarksTd').html('');
									}
									if(data['prescription'])
									{
										$('#prescriptionTd').html(data['prescription']['prescription']);
									}
									else
									{
										$('#prescriptionTd').html('');
									}

								$('#viewMedicalRecordBasedOnDateModal').modal();
						});
					});
					
  				}
  				else if(data['counter'] == 'blankstring')
  				{
  					$('#searchloading').hide();
					$('#searchTable').hide();
					$('#searchResults').html("");
					$('#searchlistofallpatients').show();
  				}
  				else
  				{
  					$('#searchloading').hide();
  					$('#searchlistofallpatients').hide();
  					$('#searchTable').show();
  					$('#searchResults').html("<tr><td>No results found.</td></tr>");
  				}
  			});
});
$("#search_patient").keyup(function(){
	// if($('#search_patient').val()){
		$('#searchlistofallpatients').hide();
		$('#searchTable').hide();
		// $('#searchResults').html("");
		$('#searchloading').show();
		var searchString = $('#search_patient').val();
		$.post('/searchpatientnamerecord',
			{
				search_string: searchString
			}, function(data) {
				// $('#searchlistofallpatients').hide();
				$('#searchResults').html("");
				// $('#searchTable').hide();
				if(data['counter']>0)
				{
			  		output = '';
	  				for(var i=0; i < data['searchpatientidarray'].length; i++)
	  				{
	  					output += "<tr><td><a class='searchQueryResults' id='resultId_"+data['searchpatientidarray'][i]+"'>"+data['searchpatientlastnamearray'][i]+", "+data['searchpatientfirstnamearray'][i]+"</a></td></tr>";
	  				}
	  				$('#searchloading').hide();
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
  							// var age = Math.floor((new Date() - new Date(data['patient_info']['birthday'])) / (365.25 * 24 * 60 * 60 * 1000));
  							$('#ageTd').html(data['patient_info']['age']);
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
  								$('#courseTd').html(data['patient_info']['degree_program_description']);
  								$('#yearlevelTd').html(data['patient_info']['year_level']);
  								$('#courseRow').show();
  								$('#yearlevelRow').show();
  							}
  							else{
  								$('#courseTd').html('');
  								$('#yearlevelTd').html('');
  								$('#courseRow').hide();
  								$('#yearlevelRow').hide();
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
							$('#illnessesTd').html(data['patient_info']['illness']);
							$('#operationTd').html(data['patient_info']['operation']);
							$('#allergiesTd').html(data['patient_info']['allergies']);
							$('#famhistoryTd').html(data['patient_info']['family']);
							$('#maintenanceTd').html(data['patient_info']['maintenance_medication']);
							$('#patientInfoModalFooter').html('<a href="/doctor/addrecords/'+ patientId +'" class="btn btn-info" role="button" id="addnewrecordfromsearch">Add New Record</a><a href="/doctor/viewrecords/'+ patientId +'" class="btn btn-info" role="button" id=viewrecordsfromsearch>View Records</a>');
							if(data['patient_info']['picture'])
							{
								$('#searchPatientRecordInfoImg').attr('src', '/images/'+data['patient_info']['picture']);
							}
							else
							{
								$('#searchPatientRecordInfoImg').attr('src', '/images/blankprofpic.png');
							}
							$('#searchPatientRecordInfo').modal();

							$('#addnewrecordfromsearch').click(function() {
								$('#searchPatientRecordInfo').modal('hide');
							});
							$('#viewrecordsfromsearch').click(function() {
								$('#searchPatientRecordInfo').modal('hide');
							});
						});
  					});
  				}
  				else if(data['counter'] == 'blankstring')
  				{
  					$('#searchloading').hide();
					$('#searchTable').hide();
					$('#searchResults').html("");
					$('#searchlistofallpatients').show();
  				}
  				else
  				{
  					$('#searchloading').hide();
  					$('#searchlistofallpatients').hide();
  					$('#searchTable').show();
  					$('#searchResults').html("<tr><td>No results found.</td></tr>");
  				}
  			});
	
});
var checkboxMedicalServiceCounter = 0;
$('.checkboxMedicalService').click(function(){

	if($(this).is(':checked'))
	{
		checkboxMedicalServiceCounter++;
	}
	else
	{
		checkboxMedicalServiceCounter--;
	}
	if(checkboxMedicalServiceCounter>0)
	{
		$('#addNewMedicalRecordWConfirmRequests').show();
		$('#physicalexamaccordion input[type="text"]').removeAttr('disabled');
	}
	else
	{
		$('#addNewMedicalRecordWConfirmRequests').hide();
		$('#physicalexamaccordion input[type="text"]').val('');
		$('#physicalexamaccordion input[type="text"]').attr('disabled', 'disabled');
	}
});
$('.listofallpatients').click(function()
{
	var patientId = $(this).attr('id').split('_')[1];
	$.post('/displaypatientrecordsearch',
	{
		patient_id: patientId
	}, function(data) {
		output = '';
		// var age = Math.floor((new Date() - new Date(data['patient_info']['birthday'])) / (365.25 * 24 * 60 * 60 * 1000));
		// $('#ageTd').html(age);
		$('#ageTd').html(data['patient_info']['age']);
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
			$('#courseTd').html(data['patient_info']['degree_program_description']);
			$('#yearlevelTd').html(data['patient_info']['year_level']);
			$('#courseRow').show();
			$('#yearlevelRow').show();
		}
		else{
			$('#courseTd').html('');
			$('#yearlevelTd').html('');
			$('#courseRow').hide();
			$('#yearlevelRow').hide();
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
		$('#illnessesTd').html(data['patient_info']['illness']);
		$('#operationTd').html(data['patient_info']['operation']);
		$('#allergiesTd').html(data['patient_info']['allergies']);
		$('#famhistoryTd').html(data['patient_info']['family']);
		$('#maintenanceTd').html(data['patient_info']['maintenance_medication']);
		$('#patientInfoModalFooter').html('<a href="/doctor/addrecords/'+ patientId +'" class="btn btn-info" role="button" id="addnewrecordfromsearch">Add New Record</a><a href="/doctor/viewrecords/'+ patientId +'" class="btn btn-info" role="button" id=viewrecordsfromsearch>View Records</a>');
		
		if(data['patient_info']['picture'])
		{
			$('#searchPatientRecordInfoImg').attr('src', '/images/'+data['patient_info']['picture']);
		}
		else
		{
			$('#searchPatientRecordInfoImg').attr('src', '/images/blankprofpic.png');
		}
		$('#searchPatientRecordInfo').modal();

		$('#addnewrecordfromsearch').click(function() {
			$('#searchPatientRecordInfo').modal('hide');
		});
		$('#viewrecordsfromsearch').click(function() {
			$('#searchPatientRecordInfo').modal('hide');
		});
	});
});

$('#addnewrecordsubmit').click(function() {
	$('#proceedToAddNewMedicalRecord').modal('hide');
});
$('.medicalrecorddate').click(function() {
	var medicalAppointmentId = $(this).attr('id').split('_')[1];
	$.post('/viewindividualrecordfromsearch',
		{
			medical_appointment_id: medicalAppointmentId}, function(data, textStatus, xhr)
		{
			if(data['physical_examination'])
				{
					$('#heightTd').html(data['physical_examination']['height']);
					$('#weightTd').html(data['physical_examination']['weight']);
					$('#bpTd').html(data['physical_examination']['blood_pressure']);
					$('#prTd').html(data['physical_examination']['pulse_rate']);
					$('#righteyeTd').html(data['physical_examination']['right_eye']);
					$('#lefteyeTd').html(data['physical_examination']['left_eye']);
					$('#headTd').html(data['physical_examination']['head']);
					$('#eentTd').html(data['physical_examination']['eent']);
					$('#neckTd').html(data['physical_examination']['neck']);
					$('#chestTd').html(data['physical_examination']['chest']);
					$('#heartTd').html(data['physical_examination']['heart']);
					$('#lungsTd').html(data['physical_examination']['lungs']);
					$('#abdomenTd').html(data['physical_examination']['abdomen']);
					$('#backTd').html(data['physical_examination']['back']);
					$('#skinTd').html(data['physical_examination']['skin']);
					$('#extremitiesTd').html(data['physical_examination']['extremities']);
				}
				else
				{
					$('#heightTd').html('');
					$('#weightTd').html('');
					$('#bpTd').html('');
					$('#prTd').html('');
					$('#righteyeTd').html('');
					$('#lefteyeTd').html('');
					$('#headTd').html('');
					$('#eentTd').html('');
					$('#neckTd').html('');
					$('#chestTd').html('');
					$('#heartTd').html('');
					$('#lungsTd').html('');
					$('#abdomenTd').html('');
					$('#backTd').html('');
					$('#skinTd').html('');
					$('#extremitiesTd').html('');
				}
				if(data['cbc_result'])
				{
					$('#hemoglobinTd').html(data['cbc_result']['hemoglobin']);
					$('#hemasocritTd').html(data['cbc_result']['hemasocrit']);
					$('#wbcTd').html(data['cbc_result']['wbc']);
				}
				else
				{
					$('#cbc_results').hide();
					$('#hemoglobinTd').html('');
					$('#hemasocritTd').html('');
					$('#wbcTd').html('');
				}
				if(data['urinalysis_result'])
				{
					$('#puscellsTd').html(data['urinalysis_result']['pus_cells']);
					$('#rbcTd').html(data['urinalysis_result']['rbc']);
					$('#albuminTd').html(data['urinalysis_result']['albumin']);
					$('#sugarTd').html(data['urinalysis_result']['sugar']);
				}
				else
				{
					$('#urinalysis_results').hide();
					$('#puscellsTd').html('');
					$('#rbcTd').html('');
					$('#albuminTd').html('');
					$('#sugarTd').html('');
				}
				if(data['fecalysis_result'])
				{
					$('#macroscopicTd').html(data['fecalysis_result']['macroscopic']);
					$('#microscopicTd').html(data['fecalysis_result']['microscopic']);
				}
				else
				{
					$('#fecalysis_results').hide();
					$('#macroscopicTd').html('');
					$('#microscopicTd').html('');
				}
				if(data['drug_test_result'])
				{
					$('#drugtestTd').html(data['drug_test_result']['drug_test'])
				}
				else
				{
					$('#drug_test_results').hide();
					$('#drugtestTd').html('');
				}
				if(data['chest_xray_result'])
				{
					$('#chestxrayTd').html(data['chest_xray_result']['xray_result']);
				}
				else
				{
					$('#xray_results').hide();
					$('#cchestxrayTd').html('');
				}
				if(data['remark'])
				{
					$('#remarksTd').html(data['remark']['remark']);
				}
				else
				{
					$('#remarksTd').html('');
				}
				if(data['prescription'])
				{
					$('#prescriptionTd').html(data['prescription']['prescription']);
				}
				else
				{
					$('#prescriptionTd').html('');
				}

			$('#viewMedicalRecordBasedOnDateModal').modal();
	});
});

});