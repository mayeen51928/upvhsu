$(document).ready( function(){
// ----------------------------- Dashboard -----------------------------
function highchartsdentalfunc(){
	$.post('/totalnumberofdentalpatients', {}, function(data, textStatus, xhr) {
    if(data)
    {
       Highcharts.chart('dentistcontainer', {
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
if($('#dentistdashboard').val() == 1)
{
	highchartsdentalfunc();
}
$('#staffnotesdentist').keyup(function() {
	// if($('#staffnotesdoctor').val())
	// {
	$('#savingstatus').html('Saving...');
		$.post('/dentist/updatestaffnotes',
			{note: $('#staffnotesdentist').val()}, function(data, textStatus, xhr) {
			$('#savingstatus').html('&nbsp;');
		});
	// }
});

$('.dental_chart').click(function(){
	var id = $(this).attr('id').split("_");
	teethId = id[1];
	$.ajax({
		  type: "POST",
		  url: updateDentalRecordModal,
		  data: {teeth_id:  teethId, _token: token},
		  success: function(data)
		  {
		  	console.log(data['condition_id']);
		  	console.log(data['operation_id']);
		  	if (data['condition_id'] != null) {
		  		$('.condition').val(data['condition_id']);
		  	}
		  	else{
		  		$('.condition').val(0);
		  	}
		  	if(data['operation_id'] != null){
		  		$('.operation').val(data['operation_id']);
		  	}
		  	else{
		  		$('.operation').val(0);
		  	}
				
		  }
	  });
		window.setTimeout(function(){
			$('#update-dental-record-modal').modal('show');
    }, 5000)
});


$('.updateDentalRecord').click(function(){
	if($('.condition').val() || $('.operation').val()){
		var id = $(this).attr('id').split("_");
		appointmentId = id[1];
		console.log(appointmentId);
		var conditionId = $('.condition').val();
		var operationId = $('.operation').val();
		if (operationId == null) { operationId = 0; };
		if (conditionId == null) { conditionId = 0; };
		// console.log(teethId);
		// console.log(conditionId);
		// console.log(operationId);
		// console.log(appointmentId);
		$.ajax({
			  type: "POST",
			  url: insertDentalRecordModal,
			  data: {teeth_id:  teethId, condition_id:  conditionId, operation_id:  operationId, appointment_id:  appointmentId,  _token: token},
			  success: function(data)
			  {
			  	console.log("condition id "+conditionId);
			  	console.log("operation id "+operationId);
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

// $('.dental_chart').mouseover(function(){
//     var id = $(this).attr('id').split("_");
//     var teethId = id[1];
//     var type = id[0];
//     $.ajax({
//     	type: "POST",
//     	url: hoverDentalChart,
//     	data: {teeth_id:  teethId, type:  type, _token: token},
//     	success: function(data)
//     	{
//     		$('#'+data['type']+'_'+data['id']).effect( "pulsate", {times:1}, 1000 );
//     	}
//     });
// });



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


// ------------------BILLING---------------
$('.addBillingToDental').click(function(){
	var id = $(this).attr('id').split("_");
	appointmentId = id[1];
	output = '';
	$('.displayServices').html(output);
	$.ajax({
		  type: "POST",
		  url: addBillingDental,
		  data: {appointment_id:  appointmentId, _token: token},
		  success: function(data)
		  {
		  		console.log(data['checker']);
		  		var dob = new Date(data['patient_info']['birthday']);
			  	var today = new Date();
			    var dayDiff = Math.ceil(today - dob) / (1000 * 60 * 60 * 24 * 365);
			    var age = parseInt(dayDiff);
			  	if(data['patient_type_id'] == 5 && age>59){
			  		$('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
			  		$('.dental_senior_checker_medical').show();
			  		$('input[type=radio][name=dental_radio_button_medical]').change(function() {
			  			output="";
			  			$('.displayServices').html(output);
			  			if (this.value == '5') {
			  				output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
			  				for (var i = 0; i < data['display_dental_services'].length; i++){
			  					output += "<tr><td><input type='checkbox' class='checkboxDentalService' id="+data['display_dental_services'][i].service_rate+" value="+data['display_dental_services'][i].id+"></td><td class='dentalService'>"+data['display_dental_services'][i].service_description+"</td><td class='dentalServiceRate'>"+data['display_dental_services'][i].service_rate+"</td></tr>";
								}
			        }
			        else if (this.value == '6') {
		            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
								for (var i = 0; i < data['display_dental_services_senior'].length; i++){
									output += "<tr><td><input type='checkbox' class='checkboxDentalService' id="+data['display_dental_services_senior'][i].service_rate+" value="+data['display_dental_services_senior'][i].id+"></td><td class='dentalService'>"+data['display_dental_services_senior'][i].service_description+"</td><td class='dentalServiceRate'>"+data['display_dental_services_senior'][i].service_rate+"</td></tr>";
								}
							}
							$('.displayServices').html(output);
							if(data['checker'] == '0'){
								$(".displayServices :input").attr("disabled", true);
								$('.dental-bill-input').html("").append("<input type='text' class='form-control' id='dental-bill' disabled>");
								$('.dental-bill-confirm').html("").append("<button type='button' class='btn btn-primary dental-bill-confirm-button' id='dentalBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
							}
							else{
								$('.dental-bill-input').html("").append("<input type='text' class='form-control' id='dental-bill' disabled>");
								$('.dental-bill-confirm').html("").append("<button type='button' class='btn btn-primary dental-bill-confirm-button' id='dentalBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
							}
							var fin = 0;
							$('.checkboxDentalService').click(function(){
				        if ($(this).is(':checked')){
				          var dentalBillRate = parseFloat($(this).attr('id'));
				          fin = parseFloat(fin+dentalBillRate);
				          $("#dental-bill").val(fin);
				        }
				        else{
				          var dentalBillRate = parseFloat($(this).attr('id'));
				          fin = parseFloat(fin-dentalBillRate);
				          $("#dental-bill").val(fin);
				        }
				      });
				    });
			  	}
			  	else{
			  		$('.dental_senior_checker_medical').hide();
			  		$('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
						output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
						for (var i = 0; i < data['display_dental_services'].length; i++){
							output += "<tr><td><input type='checkbox' class='checkboxDentalService' id="+data['display_dental_services'][i].service_rate+" value="+data['display_dental_services'][i].id+"></td><td class='dentalService'>"+data['display_dental_services'][i].service_description+"</td><td class='dentalServiceRate'>"+data['display_dental_services'][i].service_rate+"</td></tr>";
						}
						$('.displayServices').html(output);
						if(data['checker'] == '0'){
							$(".displayServices :input").attr("disabled", true);
							$('.dental-bill-input').html("").append("<input type='text' class='form-control' id='dental-bill' disabled>");
							$('.dental-bill-confirm').html("").append("<button type='button' class='btn btn-primary dental-bill-confirm-button' id='xrayBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
						}
						else{
							$('.dental-bill-input').html("").append("<input type='text' class='form-control' id='dental-bill' disabled>");
							$('.dental-bill-confirm').html("").append("<button type='button' class='btn btn-primary dental-bill-confirm-button' id='xrayBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
						}
						var fin = 0;
						$('.checkboxDentalService').click(function(){
			        if ($(this).is(':checked')){
			          var dentalBillRate = parseFloat($(this).attr('id'));
			          fin = parseFloat(fin+dentalBillRate);
			          $("#dental-bill").val(fin);
			        }
			        else{
			          var dentalBillRate = parseFloat($(this).attr('id'));
			          fin = parseFloat(fin-dentalBillRate);
			          $("#dental-bill").val(fin);
			        }
			      });
					}
					$('#dentalBillingModal').modal();
		  }
	  });
});


$(document).on('click', '.dental-bill-confirm-button', function(){
	var appointmentId = $(this).attr('id').split('_')[1];
	checked_services_array_id=[];
	checked_services_array_rate=[];
	$("input:checkbox.checkboxDentalService").each(function(){
	    var dentalServiceCheckbox = $(this);
	    if(dentalServiceCheckbox.is(":checked")){
        checked_services_array_id.push(dentalServiceCheckbox.attr("value"));
        checked_services_array_rate.push(dentalServiceCheckbox.attr("id"));
	    }
	});
	$.ajax({
		  type: "POST",
		  url: confirmBillingDental,
		  data: {appointment_id:  appointmentId, checked_services_array_id:  checked_services_array_id, checked_services_array_rate:  checked_services_array_rate, _token: token},
		  success: function(data)
		  {
		  	highchartsdentalfunc();
		  	$('#dentalBillingModal').modal("hide");
		  	$('#addBillingToDental_'+appointmentId).closest("tr").remove();
		  }
  	});
	return false;
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
		$('#viewrecordsfromsearchdental').click(function() {
			$('#searchPatientRecordInfoDental').modal('hide');
		});
	});
});
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
$('#searchbydatebuttondental').click(function() {
	console.log($('#search_month').find(':selected')[0].value);
	console.log($('#search_date').find(':selected')[0].value);
	console.log($('#search_year').find(':selected')[0].value);
	$('#searchlistofallpatients').hide();
		$('#searchTable').hide();
		// $('#searchResults').html("");
		$('#searchloading').show();
	$.post('/searchpatientbydaterecorddental',
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
	  					output += "<tr><td>" + data['searchpatientscheduledayarray'][i] + "</td><td>" + data['searchpatientscheduletimearray'][i]+"</td><td><a class='searchQueryResults' href='/dentist/viewdentalrecord/" + data['searchpatientappointmentidyarray'][i]+ "/' dentalrecorddate' id='dentalrecorddate_"+data['searchpatientappointmentidyarray'][i]+"'>"+data['searchpatientnamearray'][i]+"</a></td></tr>";
	  				}
	  				$('#searchlistofallpatients').hide();
	  				$('#searchloading').hide();
	  				$('#searchResults').html(output);
  					$('#searchTable').show();
	  				$('.dentalrecorddate').click(function() {
						var dentalAppointmentId = $(this).attr('id').split('_')[1];
						$.post('/viewindividualrecordfromsearchdental',
							{
								dental_appointment_id: dentalAppointmentId}, function(data, textStatus, xhr)
							{
								$('#viewDentalRecordBasedOnDateModal').modal();
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
// ------------------------------ End of Search Patient ---------------------
});