$(document).ready( function(){
// ----------------------------- Dashboard -----------------------------
$('.dental_chart').click(function(){
	var id = $(this).attr('id').split("_");
	teethId = id[1];
	$.ajax({
		  type: "POST",
		  url: updateDentalRecordModal,
		  data: {teeth_id:  teethId, _token: token},
		  success: function(data)
		  {
			if (data['status'] == 1) {
				$('.condition').val(data['condition_id']);
				$('.operation').val(data['operation_id']);
			}
			else{
				$('.condition').val(0);
				$('.operation').val(0);
			}
		  }
	  });
	window.setTimeout(function(){
            $('#update-dental-record-modal').modal('show');
        }, 1000)
});


$('.updateDentalRecord').click(function(){
	if($('.condition').val() || $('.operation').val()){
		var id = $(this).attr('id').split("_");
		appointmentId = id[1];
		var conditionId = $('.condition').val();
		var operationId = $('.operation').val();
		if (operationId == null) { operationId = 0; };
		if (conditionId == null) { conditionId = 0; };
		$.ajax({
			  type: "POST",
			  url: insertDentalRecordModal,
			  data: {teeth_id:  teethId, condition_id:  conditionId, operation_id:  operationId, appointment_id:  appointmentId,  _token: token},
			  success: function(data)
			  {
			  	console.log('#condition_'+teethId);
			  	if (conditionId == 1) {
			  		$('#condition_'+teethId).css({ fill: "#ff4000" });
			  	}
			  	else if (conditionId == 2) {
			  		$('#condition_'+teethId).css({ fill: "#ffff00" });
			  	}
			  	else if (conditionId == 3) {
			  		$('#condition_'+teethId).css({ fill: "#00ff00" });
			  	}
			  	else if (conditionId == 4) {
			  		$('#condition_'+teethId).css({ fill: "#00ffff" });
			  	}
			  	else if (conditionId == 5) {
			  		$('#condition_'+teethId).css({ fill: "#0000ff" });
			  	}
			  	else {
			  		$('#condition_'+teethId).css({ fill: "white" });
			  	}
			  	
			  	if (operationId == 1) {
			  		$('#operation_'+teethId).css({ fill: "#bf00ff" });
			  	}
			  	else if (operationId == 2) {
			  		$('#operation_'+teethId).css({ fill: "#ff0080" });
			  	}
			  	else if (operationId == 3) {
			  		$('#operation_'+teethId).css({ fill: "#ff0000" });
			  	}
			  	else if (operationId == 4) {
			  		$('#operation_'+teethId).css({ fill: "#808080" });
			  	}
			  	else if (operationId == 5) {
			  		$('#operation_'+teethId).css({ fill: "#194d19" });
			  	}
			  	else {
			  		$('#operation_'+teethId).css({ fill: "white" });
			  	};
				$('#update-dental-record-modal').modal("hide");
			  }
		  });
	}
	
	
});

$('.dental_chart').mouseover(function(){
    var id = $(this).attr('id').split("_");
    var teethId = id[1];
    var type = id[0];
    $.ajax({
    	type: "POST",
    	url: hoverDentalChart,
    	data: {teeth_id:  teethId, type:  type, _token: token},
    	success: function(data)
    	{
    		$('#'+data['type']+'_'+data['id']).effect( "pulsate", {times:1}, 1000 );
    	}
    });
});

$('.dental_chart').mouseout(function(){
    $('#condition_1').css({	'background-color':'#ff4000',
    						'border-color':'#ff4000'
    					});
    $('#condition_2').css({	'background-color':'#ffff00',
    						'border-color':'#ffff00'
    					});
    $('#condition_3').css({	'background-color':'#00ff00',
    						'border-color':'#00ff00'
    					});
    $('#condition_4').css({	'background-color':'#00ffff',
    						'border-color':'#00ffff'
    					});
    $('#condition_5').css({	'background-color':'#0000ff',
    						'border-color':'#0000ff'
    					});
    $('#operation_1').css({	'background-color':'#bf00ff',
    						'border-color':'#bf00ff'
    					});
    $('#operation_2').css({	'background-color':'#ff0080',
    						'border-color':'#ff0080'
    					});
    $('#operation_3').css({	'background-color':'#ff0000',
    						'border-color':'#ff0000'
    					});
    $('#operation_4').css({	'background-color':'#808080',
    						'border-color':'#808080'
    					});
    $('#operation_5').css({	'background-color':'#194d19',
    						'border-color':'#194d19'
    					});
    
});


$('.updateDentalDiagnosis').click(function(){
	var id = $(this).attr('id').split("_");
	appointmentId = id[1];
	console.log(appointmentId);
		$.ajax({
		  type: "POST",
		  url: updateDentalDiagnosis,
		  data: {appointment_id:  appointmentId, _token: token},
		  success: function(data)
		  {
		  	console.log(data['success']);
		  	setTimeout(function() {
			  window.location.href = "http://localhost:8000/dentist";
			}, 5000);
		  }
	  });
});

$('.addedDentalRecord').click(function(){
	$('#confirm_additional_dental_record').modal('show');
});

$('.confirmAdditionalDentalRecord').click(function(){
	var id = $(this).attr('id').split("_");
	appointmentId = id[1];
  var dentalCaries = $("#selDentalCaries").find(':selected')[0].value;
  var gingivitis = $("#selGingivitis").find(':selected')[0].value;
  var peridontalPocket = $("#selPeridontalPocket").find(':selected')[0].value;
  var oralDebris = $("#selOralDebris").find(':selected')[0].value;
  var calculus = $("#selCalculus").find(':selected')[0].value;
  var neoplasm = $("#selNeoplasm").find(':selected')[0].value;
  var dentalFacioAnomaly = $("#selDentalFacioAnomaly").find(':selected')[0].value;
  var teethPresent = $("#teethPresent").val();
	$.ajax({
		  type: "POST",
		  url: additionalDentalRecord,
		  data: {	appointment_id:appointmentId,
		  				dental_caries:dentalCaries, 
		  				gingivitis:gingivitis, 
		  				peridontal_pocket:peridontalPocket, 
		  				oral_debris:oralDebris,
		  				calculus:calculus,
		  				neoplasm:neoplasm,
		  				dental_facio_anomaly:dentalFacioAnomaly,
		  				teeth_present:teethPresent,
		  				_token: token
		  			},
		  success: function(data)
		  {
		  	$('#confirm_additional_dental_record').modal('hide');
		  	$('#selDentalCaries').attr("disabled", "disabled");
		  	$('#selGingivitis').attr("disabled", "disabled");
		  	$('#selPeridontalPocket').attr("disabled", "disabled");
		  	$('#selOralDebris').attr("disabled", "disabled");
		  	$('#selCalculus').attr("disabled", "disabled");
		  	$('#selNeoplasm').attr("disabled", "disabled");
		  	$('#selDentalFacioAnomaly').attr("disabled", "disabled");
		  	$('#teethPresent').attr("disabled", "disabled");
		  	$('#additionalDentalRecordInput').attr("disabled", "disabled");
				$('.addedDentalRecord').attr("disabled", "disabled");
				$('#additionalDentalRecordPanelBody').css('background-color', '#d6e9c6');
		  }
	 });
});















// ----------------------------- End of Dashboard ----------------------






// ----------------------------- Profile -----------------------------





// ----------------------------- End of Profile ----------------------









// ----------------------------- Manage Schedule -----------------------------

$('.addmoredentalsched').click(function(){
	$(this).parents('.dental_manage').find('tbody').append('<tr class="schedule_tr"><td><input type="date" class="form-control"/></td><td><input type="time" class="form-control starthour"/></td><td><input type="time" class="form-control endhour"/></td><td><button class="btn btn-danger btn-sm removedentalsched">Remove</button></td></tr>');
	$('.removedentalsched').click(function(){
		// console.log($(this).closest('tr'));
		$(this).closest('tr').remove();

	});
});
$('.removedentalsched').click(function(){
	// console.log($(this).closest('tr'));
	$(this).closest('tr').remove();
});
$('#adddentalschedule').click(function(){
	var schedules = [];
	$('.schedule_tr').each(function(){
		if($(this).find('input[type="date"]').val() && $(this).find('.starthour').val() && $(this).find('.endhour').val()){
			schedules.push($(this).find('input[type="date"]').val() + ' ' + $(this).find('.starthour').val() + ':00;;;' + $(this).find('input[type="date"]').val() + ' ' + $(this).find('.endhour').val() + ':00');
			// console.log(schedules);
		}
	});
	if(schedules.length > 0){
		$.ajax({
			url: addDentalSchedule,
			type: 'POST',
			dataType: 'json',
			data: {schedules:  schedules, _token: token},
			success: function(data) {
				$('button').attr('disabled', 'disabled');
				$('input').attr('disabled', 'disabled');
				$('#manageschedulepanel').css('background-color', '#d6e9c6');
			},
			error: function(xhr, textStatus, errorThrown) {
			}
		});
	}
	
});

// ----------------------------- End of Manage Schedule ----------------------
// ------------------------------ Search Patient ----------------------------
$("#search_patientdental").keyup(function(){
	// if($('#search_patient').val()){
		$('#searchlistofallpatientsdental').hide();
		$('#searchTabledental').hide();
		// $('#searchResultsdental').html("");
		$('#searchloadingdental').show();
		var searchString = $('#search_patientdental').val();
		$.post('/searchpatientnamerecorddental',
			{
				search_string: searchString
			}, function(data) {
				// $('#searchlistofallpatientsdental').hide();
				$('#searchResultsdental').html("");
				// $('#searchTabledental').hide();
				if(data['counter']>0)
				{
			  		output = '';
	  				for(var i=0; i < data['searchpatientidarray'].length; i++)
	  				{
	  					output += "<tr><td><a class='searchQueryResultsDental' id='resultId_"+data['searchpatientidarray'][i]+"'>"+data['searchpatientlastnamearray'][i]+", "+data['searchpatientfirstnamearray'][i]+"</a></td></tr>";
	  				}
	  				$('#searchloadingdental').hide();
	  				$('#searchResultsdental').html(output);
  					$('#searchTabledental').show();
  					$('.searchQueryResultsDental').click(function()
  					{
  						var patientId = $(this).attr('id').split('_')[1];
  						$.post('/displaypatientrecordsearchdental',
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
							$('#patientInfoModalFooter').html('<a href="/dentist/viewrecords/'+ patientId +'" class="btn btn-info" role="button" id=viewrecordsfromsearchdental>View Records</a>');
							if(data['patient_info']['picture'])
							{
								$('#searchPatientRecordInfoImg').attr('src', '/images/'+data['patient_info']['picture']);
							}
							else
							{
								$('#searchPatientRecordInfoImg').attr('src', '/images/blankprofpic.png');
							}
							$('#searchPatientRecordInfoDental').modal();

							$('#addnewrecordfromsearch').click(function() {
								$('#searchPatientRecordInfoDental').modal('hide');
							});
							$('#viewrecordsfromsearch').click(function() {
								$('#searchPatientRecordInfoDental').modal('hide');
							});
						});
  					});
  				}
  				else if(data['counter'] == 'blankstring')
  				{
  					$('#searchloadingdental').hide();
					$('#searchTabledental').hide();
					$('#searchResultsdental').html("");
					$('#searchlistofallpatientsdental').show();
  				}
  				else
  				{
  					$('#searchloadingdental').hide();
  					$('#searchlistofallpatientsdental').hide();
  					$('#searchTabledental').show();
  					$('#searchResultsdental').html("<tr><td>No results found.</td></tr>");
  				}
  			});
});
$('.listofallpatientsdental').click(function()
{
	var patientId = $(this).attr('id').split('_')[1];
	$.post('/displaypatientrecordsearchdental',
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
		$('#patientInfoModalFooter').html('<a href="/dentist/viewrecords/'+ patientId +'" class="btn btn-info" role="button" id=viewrecordsfromsearchdental>View Records</a>');
		if(data['patient_info']['picture'])
		{
			$('#searchPatientRecordInfoImg').attr('src', '/images/'+data['patient_info']['picture']);
		}
		else
		{
			$('#searchPatientRecordInfoImg').attr('src', '/images/blankprofpic.png');
		}
		$('#searchPatientRecordInfoDental').modal();

		$('#addnewrecordfromsearch').click(function() {
			$('#searchPatientRecordInfoDental').modal('hide');
		});
		$('#viewrecordsfromsearch').click(function() {
			$('#searchPatientRecordInfoDental').modal('hide');
		});
	});
});
// ------------------------------ End of Search Patient ---------------------
});