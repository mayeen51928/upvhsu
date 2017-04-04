$(document).ready( function(){
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});


	// -----------------SCEDULE APPOINTMENT (NOT LOGGED IN)---------------------
	numOfClicksMedical = 0;
	numOfClicksDental = 0;
	percentageDental = 0;
	percentageMedical = 0
  
	if($('#typeDental').is(':checked'))
	{
		$('#dentalAppointment0').fadeIn();
  	}
  	if($('#typeMedical').is(':checked'))
  	{
  		$('#medicalAppointment0').fadeIn();
  	}
  	$('#typeDental').click(function(){
  		if($(this).is(':checked'))
  		{
  			$('#dentalAppointment0').fadeIn();
  		}
  		else
  		{
  			$('#dentalAppointment0').fadeOut();
  		}
  	});

  	$('#typeMedical').click(function(){
  		if($(this).is(':checked'))
  		{
  			$('#medicalAppointment0').fadeIn();
  		}else
  		{
  			$('#medicalAppointment0').fadeOut();
  		}
  	});
  	// $('#typeDental').click(function(){
  	// 	if($(this).is(':checked') && !($('#typeMedical').is(':checked')))
  	// 	{
  	// 		$('#dentalAppointment0').fadeIn();
  	// 	}
  	// 	else if($(this).is(':checked') && ($('#typeMedical').is(':checked')))
  	// 	{
  	// 		$('#medicalAppointment0').animate({
  	// 			marginLeft: '+=25%'},
  	// 			function(){
  	// 				$('#medicalAppointment0').removeAttr('style').css({display: 'block'});
  	// 				$('#medicalAppointment0').removeClass('col-md-offset-6');
  	// 				$('#dentalAppointment0').fadeIn();
  	// 			});
  	// 	}
  	// 	else if(!($(this).is(':checked')) && ($('#typeMedical').is(':checked')))
  	// 	{
  	// 		$('#dentalAppointment0').fadeOut(function(){
  	// 			$('#medicalAppointment0').addClass('col-md-offset-6');
  	// 			$('#medicalAppointment0').animate({marginLeft: '-=25%'});
  	// 		});
  	// 	}
  	// 	else if(!($(this).is(':checked')) && !($('#typeMedical').is(':checked')))
  	// 	{
  	// 		$('#dentalAppointment').fadeOut();
  	// 	}
  	// 	else
  	// 	{

  	// 	}
  	// });

  	// $('#typeMedical').click(function(){
  	// 	if($(this).is(':checked') && !($('#typeDental').is(':checked')))
  	// 	{
  	// 		$('#medicalAppointment0').fadeIn();
  	// 	}
  	// 	else if($(this).is(':checked') && $('#typeDental').is(':checked'))
  	// 	{
  	// 		$('#dentalAppointment0').animate({
  	// 			marginLeft: '0%'},
  	// 			function(){
  	// 				$('#medicalAppointment0').removeClass('col-md-offset-3');
  	// 				$('#medicalAppointment0').fadeIn();
  	// 			});
  	// 	}
  	// 	else
  	// 	{
  	// 		$('#medicalAppointment0').fadeOut(function(){
  	// 			$('#dentalAppointment0').animate({marginLeft: '25%'});
  	// 		});
  	// 	}
  	// });

  	$("#selectdentaldate").change(function(){
  		var dentalDate = $(this).find(':selected')[0].value;
  		$.ajax({
  			type: "POST",
  			url: displayDentalSchedule,
  			data: {dental_date:  dentalDate, _token: token},
  			success: function(data)
  			{
  				$('#selectdentaltime').removeAttr('disabled');
  				console.log(data["start"]);
  				console.log(data["end"]);
  				console.log(data["staff"]);
  				$('#selectdentaltime').html("").append("<option disabled selected>Select doctor and time</option>");
  				for(var i=0; i < data['start'].length; i++)
  				{
  					$('#selectdentaltime').append("<option id="+data['id'][i]+">"+data['staff'][i]+" "+data['start'][i]+" - "+data['end'][i]+"</option>");
  				}
  			}
  		});
  	});

  	$("#selectmedicaldate").change(function(){
  		var medicalDate = $(this).find(':selected')[0].value;
  		$.ajax({
  			type: "POST",
  			url: displayMedicalSchedule,
  			data: {medical_date:  medicalDate, _token: token},
  			success: function(data)
  			{
  				$('#selectmedicaldoctor').removeAttr('disabled');
  				console.log(data["staff"]);
  				$('#selectmedicaldoctor').html("").append("<option disabled selected>Select doctor</option>");
  				for(var i=0; i < data['staff'].length; i++)
  				{
  					$('#selectmedicaldoctor').append("<option id="+data['id'][i]+">"+data['staff'][i]+"</option>");
  				}
  			}
  		});
  	});

  	$("#submitdentalappointment").click(function(){
  		var scheduleID = $('#selectdentaltime').find(':selected')[0].id;
  		console.log("Schedule ID is " + scheduleID);
  		if(!($('#dentalNotes').val()) && scheduleID)
  		{
  			$('#dentalNotesErrorMsg').css('color', 'red');
  			$('#dentalNotesErrorMsg').html('Reasons (e.g. molar toothace): REQUIRED');
  			$('#selectdentaldateErrorMsg').css('color', 'black');
  			$('#selectdentaldateErrorMsg').html('Date:');
  			$('#selectdentaltimeErrorMsg').css('color', 'black');
  			$('#selectdentaltimeErrorMsg').html('Doctor and Time:');
  		}
  		if($('#dentalNotes').val() && !scheduleID)
  		{
  			$('#dentalNotesErrorMsg').css('color', 'black');
  			$('#dentalNotesErrorMsg').html('Reasons (e.g. molar toothace):');
  			$('#selectdentaldateErrorMsg').css('color', 'red');
  			$('#selectdentaldateErrorMsg').html('Date: REQUIRED');
  			$('#selectdentaltimeErrorMsg').css('color', 'red');
  			$('#selectdentaltimeErrorMsg').html('Doctor and Time: REQUIRED');
  		}
  		if($('#dentalNotes').val() && scheduleID)
  		{
  			$('#dentalNotesErrorMsg').css('color', 'black');
  			$('#dentalNotesErrorMsg').html('Reasons (e.g. molar toothace):');
  			$('#selectdentaldateErrorMsg').css('color', 'black');
  			$('#selectdentaldateErrorMsg').html('Date:');
  			$('#selectdentaltimeErrorMsg').css('color', 'black');
  			$('#selectdentaltimeErrorMsg').html('Doctor and Time:');
  		}
  		if(!$('#dentalNotes').val() && !scheduleID)
  		{
  			$('#dentalNotesErrorMsg').css('color', 'red');
  			$('#dentalNotesErrorMsg').html('Reasons (e.g. molar toothace): REQUIRED');
  			$('#selectdentaldateErrorMsg').css('color', 'red');
  			$('#selectdentaldateErrorMsg').html('Date: REQUIRED');
  			$('#selectdentaltimeErrorMsg').css('color', 'red');
  			$('#selectdentaltimeErrorMsg').html('Doctor and Time: REQUIRED');
  		}
  		// event.preventDefault();
  		if($('#dentalNotes').val() && scheduleID)
  		{
  			$.post('/createappointment_dental',{reasons:$('#dentalNotes').val(), dental_schedule_id: scheduleID} , function(data){
  				if(data['success']=='yes')
  				{
  					$('#dentalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
  					$('#dentalNotes').attr("disabled", "disabled");
  					// $('#selDentalDate').attr("disabled", "disabled");
  					$('#selectdentaltime').attr("disabled", "disabled");
  					$('#submitDentalAppointment').addClass("disabled");
            $('#selectdentaldate').attr('disabled', 'disabled');
            // $('#selectdentaldoctor').attr('disabled', 'disabled');
  					$('#dentalAppointmentPanelBody').css('background-color', '#d6e9c6');
  					$('#submitdentalappointment').attr("disabled", "disabled");
  				}
          else if (data['success']=='alreadyexists')
          {
            alert('Appointment already exists!');
          }
  				else
  				{
            $('#login_dental_error').html('');
            $('#loginmodaldental #user_name_modal_dental').val('');
            $('#loginmodadental #password_modal_dental').val('');
            $('#loginmodaldental').modal();
  					$('#loginmodaldental').modal();
  				}
  			});
  		}
  	});

  	$("#submitmedicalappointment").click(function(){
  		var scheduleID = $('#selectmedicaldoctor').find(':selected')[0].id;
  		console.log("Schedule ID is " + scheduleID);
  		if(!($('#medicalNotes').val()) && scheduleID)
  		{
  			$('#medicalNotesErrorMsg').css('color', 'red');
  			$('#medicalNotesErrorMsg').html('Reasons (e.g. physical pain felt): REQUIRED');
  			$('#selectmedicaldateErrorMsg').css('color', 'black');
  			$('#selectmedicaldateErrorMsg').html('Date:');
  			$('#selectmedicaldoctorErrorMsg').css('color', 'black');
  			$('#selectmedicaldoctorErrorMsg').html('Doctor:');
  		}
  		if($('#medicalNotes').val() && !scheduleID)
  		{
  			$('#medicalNotesErrorMsg').css('color', 'black');
  			$('#medicalNotesErrorMsg').html('Reasons (e.g. physical pain felt):');
  			$('#selectmedicaldateErrorMsg').css('color', 'red');
  			$('#selectmedicaldateErrorMsg').html('Date: REQUIRED');
  			$('#selectmedicaldoctorErrorMsg').css('color', 'red');
  			$('#selectmedicaldoctorErrorMsg').html('Doctor: REQUIRED');
  		}
  		if($('#medicalNotes').val() && scheduleID)
  		{
  			$('#medicalNotesErrorMsg').css('color', 'black');
  			$('#medicalNotesErrorMsg').html('Reasons (e.g. physical pain felt):');
  			$('#selectmedicaldateErrorMsg').css('color', 'black');
  			$('#selectmedicaldateErrorMsg').html('Date:');
  			$('#selectmedicaldoctorErrorMsg').css('color', 'black');
  			$('#selectmedicaldoctorErrorMsg').html('Doctor:');
  		}
  		if(!$('#medicalNotes').val() && !scheduleID)
  		{
  			$('#medicalNotesErrorMsg').css('color', 'red');
  			$('#medicalNotesErrorMsg').html('Reasons (e.g. physical pain felt): REQUIRED');
  			$('#selectmedicaldateErrorMsg').css('color', 'red');
  			$('#selectmedicaldateErrorMsg').html('Date: REQUIRED');
  			$('#selectmedicaldoctorErrorMsg').css('color', 'red');
  			$('#selectmedicaldoctorErrorMsg').html('Doctor: REQUIRED');
  		}
  		if($('#medicalNotes').val() && scheduleID)
  		{
  			$.post('/createappointment_medical',{reasons:$('#medicalNotes').val(), medical_schedule_id: scheduleID} , function(data){
  				if(data['success']=='yes')
  				{
	  				$('#medicalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
	  				$('#medicalNotes').attr("disabled", "disabled");
	  				$('#selMedicalDate').attr("disabled", "disabled");
	  				$('#selMedicalDoctor').attr("disabled", "disabled");
	  				$('#submitMedicalAppointment').addClass("disabled");
            $('#selectmedicaldate').attr('disabled', 'disabled');
            $('#selectmedicaldoctor').attr('disabled', 'disabled');
	  				$('#medicalAppointmentPanelBody').css('background-color', '#d6e9c6');
	  				$("#submitmedicalappointment").attr('disabled','disabled');
  				}
          else if (data['success']=='alreadyexists')
          {
            alert('Appointment already exists!');
          }
  				else
  				{
            $('#login_medical_error').html('');
            $('#loginmodalmedical #user_name_modal_medical').val('');
            $('#loginmodalmedical #password_modal_medical').val('');
  					$('#loginmodalmedical').modal();
  				}
  			});
  		}
  	});

    $('#signupDental_modal').click(function(){
    	$('#login_dental_error').html('');
    	numOfClicksDental = 0;
    	$('.signup1_dental').show();
    	$('.signup2_dental').hide();
    	$('.signup_progressbar_dental').show();
    	$(this).hide();
    	$('#signupbackDental_modal').show();
    	$('#signupnextDental_modal').show();
    	percentageDental += 25;
    	$('#changeProgressDental').attr('aria-valuenow', percentageDental).css('width', percentageDental+'%').html('1 of 4');
    	$('#login_modal_dental').hide();
    });
    $('#signupMedical_modal').click(function(){
    	$('#login_medical_error').html('');
    	numOfClicksMedical = 0;
    	$('.signup1_medical').show();
    	$('.signup2_medical').hide();
    	$('.signup_progressbar').show();
    	$(this).hide();
    	$('#signupbackMedical_modal').show();
    	$('#signupnextMedical_modal').show();
    	percentageMedical += 25;
    	$('#changeProgress').attr('aria-valuenow', percentageMedical).css('width', percentageMedical+'%').html('1 of 4');
    	$('#login_modal_medical').hide();
    });

    $('#login_modal_dental').click(function(){
    	$('#login_dental_error').html('');
    	var scheduleID = $('#selectdentaltime').find(':selected')[0].id;
    	$.post('/loginfromdentalappointment',
    	{
    		user_name_modal_dental:$('#user_name_modal_dental').val(),
            password_modal_dental:$('#password_modal_dental').val(),
            reasons:$('#dentalNotes').val(),
            dental_schedule_id: scheduleID
        } , function(data){
        	if(data['passwordmatch']=='yes')
        	{
        		$('#login_dental_error').html('');
        		$('#dentalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
        		$('#dentalNotes').attr("disabled", "disabled");
        		$('#selDentalDate').attr("disabled", "disabled");
        		$('#selDentalTime').attr("disabled", "disabled");
        		$('#submitDentalAppointment').addClass("disabled");
            $('#selectdentaldate').attr('disabled', 'disabled');
            $('#selectdentaltime').attr('disabled', 'disabled');
        		$('#dentalAppointmentPanelBody').css('background-color', '#d6e9c6');
            $('#submitdentalappointment').attr("disabled", "disabled");
        		$('#navigationBar').load(location.href + " #navigationBar");
        		$('#loginmodaldental').modal("hide");
        	}
        	else
        	{
        		$('#login_dental_error').css('color', 'red').delay(2000).html('Your login credentials are incorrect.');
        	}
        });
    });

    $('#login_modal_medical').click(function(){
    	$('#login_medical_error').html('');
    	var scheduleID = $('#selectmedicaldoctor').find(':selected')[0].id;
    	$.post('/loginfrommedicalappointment',
    	{
    		user_name_modal_medical:$('#user_name_modal_medical').val(),
            password_modal_medical:$('#password_modal_medical').val(),
            reasons:$('#medicalNotes').val(),
            medical_schedule_id: scheduleID
        } , function(data){
        	if(data['passwordmatch']=='yes')
        	{
        		$('#login_medical_error').html('');
        		$('#medicalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
                    $('#medicalNotes').attr("disabled", "disabled");
                    $('#selMedicalDate').attr("disabled", "disabled");
                    $('#submitMedicalAppointment').addClass("disabled");
                    $('#selectmedicaldate').attr('disabled', 'disabled');
                    $('#selectmedicaldoctor').attr('disabled', 'disabled');
                    $('#medicalAppointmentPanelBody').css('background-color', '#d6e9c6');
                    $('#navigationBar').load(location.href + " #navigationBar");
                    $("#submitmedicalappointment").attr('disabled','disabled');
                    $('#loginmodalmedical').modal("hide");
        	}
          else if(data['passwordmatch'] == 'alreadyexists')
          {
            $('#login_medical_error').css('color', 'red').delay(2000).html('Error! You have existing appointment with this schedule.');
          }
        	else
        	{
        		$('#login_medical_error').css('color', 'red').delay(2000).html('Your login credentials are incorrect.');
        	}
        });
    });

    
    $('#birthdate_dental').keyup(function() {
      console.log($('#birthdate_dental').val());
      if($("input[name=patient_type_dental]:checked").val() == 5
        && (Math.floor((new Date() - new Date($('#birthdate_dental').val())) / (365.25 * 24 * 60 * 60 * 1000)) >= 60))
      {
        $('#senior_citizen_id_dental').removeAttr('disabled');
      }
      else
      {
        $('#senior_citizen_id_dental').attr('disabled', 'disabled');
      }
    });
    $('#birthdate_medical').keyup(function() {
      console.log($('#birthdate_medical').val());
      if($("input[name=patient_type_medical]:checked").val() == 5
        && (Math.floor((new Date() - new Date($('#birthdate_medical').val())) / (365.25 * 24 * 60 * 60 * 1000)) >= 60))
      {
        $('#senior_citizen_id_medical').removeAttr('disabled');
      }
      else
      {
        $('#senior_citizen_id_medical').attr('disabled', 'disabled');
      }
    });
    $('#selMedicalDoctor').closest('div').css({marginBottom: '0px'});

    $("input[name=patient_type_dental]").click(function(){
    	if($("input[name=patient_type_dental]:checked").val() == 1)
    	{
	    	$("#degree_program_dental").removeAttr('disabled');
	    	$('#yearlevel_dental').removeAttr('disabled');
        $('#senior_citizen_id_dental').attr('disabled', 'disabled');
	    }
      else if($("input[name=patient_type_dental]:checked").val() == 5
        && (Math.floor((new Date() - new Date($('#birthdate_dental').val())) / (365.25 * 24 * 60 * 60 * 1000)) >= 60))
      {
        $('#senior_citizen_id_dental').removeAttr('disabled');
      }
	    else
	    {
        $('#senior_citizen_id_dental').attr('disabled', 'disabled');
        $("#degree_program_dental option[value=default]").prop('selected', true);
        $('#yearlevel_dental').val('');
	    	$("#degree_program_dental").attr('disabled', 'disabled');
	    	$('#yearlevel_dental').attr('disabled', 'disabled');
	    }
    });

    $("input[name=patient_type_medical]").click(function(){
    	if($("input[name=patient_type_medical]:checked").val() == 1)
    	{
	    	$("#degree_program_medical").removeAttr('disabled').attr('required', 'required');
	    	$('#yearlevel_medical').removeAttr('disabled').attr('required', 'required');
        $('#senior_citizen_id_medical').attr('disabled', 'disabled');
	    }
      else if($("input[name=patient_type_medical]:checked").val() == 5
        && (Math.floor((new Date() - new Date($('#birthdate_medical').val())) / (365.25 * 24 * 60 * 60 * 1000)) >= 60))
      {
        
        $('#senior_citizen_id_medical').removeAttr('disabled');
      }
	    else
	    {
        $('#senior_citizen_id_medical').attr('disabled', 'disabled');
        $("#degree_program_medical option[value=default]").prop('selected', true);
        $('#yearlevel_medical').val('');
	    	$("#degree_program_medical").attr('disabled', 'disabled');
	    	$('#yearlevel_medical').attr('disabled', 'disabled');
	    }
    });
    
    $('#signupconfirmDental_modal').click(function(){
      $('#login_dental_error').html('');
    	var scheduleID = $('#selectdentaltime').find(':selected')[0].id;
        if(
        	$('#user_name_modal_dental').val() &&
        	$('#password_modal_dental').val() &&
        	$('#dentalNotes').val() &&
        	scheduleID &&
        	$('#dentalNotes').val() &&
        	$('#first_name_dental').val() &&
        	$('#middle_name_dental').val() &&
        	$('#last_name_dental').val() &&
        	$("input[name='patient_type_dental']:checked").val() &&
        	$("input[name='sex_dental']:checked").val() &&
        	$('#birthdate_dental').val() &&
        	$('#civil_status_dental').val() &&
        	$('#religion_dental').val() &&
        	$('#nationality_dental').val() &&
        	$('#father_first_dental').val() &&
        	$('#father_middle_dental').val() &&
        	$('#father_last_dental').val() &&
        	$('#mother_first_dental').val() &&
        	$('#mother_middle_dental').val() &&
        	$('#mother_last_dental').val() &&
        	$('#street_dental').val() &&
        	$('#town_dental').val() &&
        	$('#province_dental').val() &&
        	$('#residencetelephone_dental').val() &&
        	$('#personalcontactnumber_dental').val() &&
        	$('#residencecellphone_dental').val() &&
        	$('#guardian_first_dental').val() &&
        	$('#guardian_middle_dental').val() &&
        	$('#guardian_last_dental').val() &&
        	$('#guardian_relationship_dental').val() &&
        	$('#guardian_street_dental').val() &&
        	$('#guardian_town_dental').val() &&
        	$('#guardian_province_dental').val() &&
        	$('#guardianresidencetelephone_dental').val() &&
        	$('#guardianresidencecellphone_dental').val() &&
        	$('#illness_history_dental').val() &&
        	$('#operation_history_dental').val() &&
        	$('#allergies_history_dental').val() &&
        	$('#family_history_dental').val() &&
            $('#maintenance_medication_history_dental').val()
            )
        {
          $('#loginmodaldental input, #loginmodaldental select').attr('disabled', 'disabled');
        	$.post('/signupfromdentalappointment',{
	    		user_name:$('#user_name_modal_dental').val(),
	            password:$('#password_modal_dental').val(),
	            reasons:$('#dentalNotes').val(),
	            schedule_id: scheduleID,
	            reasons:$('#dentalNotes').val(),
	            first_name:$('#first_name_dental').val(),
              middle_name:$('#middle_name_dental').val(),
              last_name: $('#last_name_dental').val(),
              patient_type_id: $("input[name='patient_type_dental']:checked").val(),
              sex:$("input[name='sex_dental']:checked").val(),
              year_level: $('#yearlevel_dental').val(),
              degree_program_id: $("#degree_program_dental").val(),
              birthdate: $('#birthdate_dental').val(),
              senior_citizen_id: $('#senior_citizen_id_dental').val(),
              civil_status: $('#civil_status_dental').val(),
              religion: $('#religion_dental').val(),
              nationality: $('#nationality_dental').val(),
              father_first_name:$('#father_first_dental').val(),
              father_middle_name:$('#father_middle_dental').val(),
              father_last_name:$('#father_last_dental').val(),
              mother_first_name:$('#mother_first_dental').val(),
              mother_middle_name:$('#mother_middle_dental').val(),
              mother_last_name:$('#mother_last_dental').val(),
              street:$('#street_dental').val(),
              town:$('#town_dental').val(),
              province:$('#province_dental').val(),
              residencetelephone:$('#residencetelephone_dental').val(),
              personalcontactnumber:$('#personalcontactnumber_dental').val(),
              residencecellphone:$('#residencecellphone_dental').val(),
              guardian_first_name: $('#guardian_first_dental').val(),
              guardian_middle_name: $('#guardian_middle_dental').val(),
              guardian_last_name: $('#guardian_last_dental').val(),
              guardian_relationship:$('#guardian_relationship_dental').val(),
              guardian_street:$('#guardian_street_dental').val(),
              guardian_town:$('#guardian_town_dental').val(),
              guardian_province:$('#guardian_province_dental').val(),
              guardianresidencetelephone:$('#guardianresidencetelephone_dental').val(),
              guardianresidencecellphone:$('#guardianresidencecellphone_dental').val(),
              illness_history:$('#illness_history_dental').val(),
              operation_history:$('#operation_history_dental').val(),
              allergies_history:$('#allergies_history_dental').val(),
              family_history:$('#family_history_dental').val(),
              maintenance_medication_history:$('#maintenance_medication_history_dental').val(),
	        } ,
	        function(data){
            if(data['message'] == 'Success')
            {
              $('#login_dental_error').html('');
              $('#dentalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
              $('#dentalNotes').attr("disabled", "disabled");
              $('#selectdentaldate').attr('disabled', 'disabled');
              $('#selectdentaltime').attr('disabled', 'disabled');
              $('#submitDentalAppointment').addClass("disabled");
              $('#dentalAppointmentPanelBody').css('background-color', '#d6e9c6');
              $('#navigationBar').load(location.href + " #navigationBar");
              $( "#loginmodaldental" ).find( "input" ).attr({disabled: 'disabled'});
              $('#submitdentalappointment').attr("disabled", "disabled");
              setTimeout(function() { $('#loginmodaldental').modal("hide"); }, 500);
            }
	        	else
            {
              $('#login_dental_error').css('color', 'red').delay(2000).html(data['message']);
            }
	        });
        }
        else
        {
          $('#login_dental_error').css('color', 'red').delay(2000).html('Please fill out all fields!');
        }
    });
    
    $('#signupnextDental_modal').click(function() {
        numOfClicksDental ++;
        if(numOfClicksDental == 1){
            $('.signup0_dental').hide();
            $('.signup1_dental').hide();
            $('.signup2_dental').show();
            percentageDental += 25;
            $('#changeProgressDental').attr('aria-valuenow', percentageDental).css('width', percentageDental+'%').html('2 of 4');

        }
        if(numOfClicksDental == 2){
            $('.signup2_dental').hide();
            $('.signup3_dental').show();
            percentageDental += 25;
            $('#changeProgressDental').attr('aria-valuenow', percentageDental).css('width', percentageDental+'%').html('3 of 4');
        }
        if(numOfClicksDental == 3){
            $('.signup3_dental').hide();
            $('.signup4_dental').show();
            $('#signupnextDental_modal').hide();
            $('#signupconfirmDental_modal').show();
            percentageDental += 25;
            $('#changeProgressDental').attr('aria-valuenow', percentageDental).css('width', percentageDental+'%').html('4 of 4');
        }
        
    });
    $('#signupbackDental_modal').click(function() {
        numOfClicksDental --;
        if(numOfClicksDental == 2){
            $('.signup3_dental').show();
            $('.signup4_dental').hide();
            $('#signupnextDental_modal').show();
            $('#signupconfirmDental_modal').hide();
            percentageDental -= 25;
            $('#changeProgressDental').attr('aria-valuenow', percentageDental).css('width', percentageDental+'%').html('3 of 4');
        }
        if(numOfClicksDental == 1){
            $('.signup2_dental').show();
            $('.signup3_dental').hide();
            percentageDental -= 25;
            $('#changeProgressDental').attr('aria-valuenow', percentageDental).css('width', percentageDental+'%').html('2 of 4');
        }
        if(numOfClicksDental == 0){
            $('.signup0_dental').show();
            $('.signup1_dental').show();
            $('.signup2_dental').hide();
            percentageDental -= 25;
            $('#changeProgressDental').attr('aria-valuenow', percentageDental).css('width', percentageDental+'%').html('1 of 4');
        }
        if(numOfClicksDental < 0){
            $('.signup0_dental').show();
            $('.signup1_dental').hide();
            numOfClicksDental = 0;
            percentageDental -= 25;
            $('#signupDental_modal').show();
            $('#login_modal_dental').show();
            $('.signup_progressbar_dental').hide();
            $('#signupnextDental_modal').hide();
            $('#signupbackDental_modal').hide();
        }
    });
    $('#signupnextMedical_modal').click(function() {
        numOfClicksMedical ++;
        if(numOfClicksMedical == 1){
            $('.signup0_medical').hide();
            $('.signup1_medical').hide();
            $('.signup2_medical').show();
            percentageMedical += 25;
            $('#changeProgress').attr('aria-valuenow', percentageMedical).css('width', percentageMedical+'%').html('2 of 4');
        }
        if(numOfClicksMedical == 2){
            $('.signup2_medical').hide();
            $('.signup3_medical').show();
            percentageMedical += 25;
            $('#changeProgress').attr('aria-valuenow', percentageMedical).css('width', percentageMedical+'%').html('3 of 4');
        }
        if(numOfClicksMedical == 3){
            $('.signup3_medical').hide();
            $('.signup4_medical').show();
            $('#signupnextMedical_modal').hide();
            $('#signupconfirmMedical_modal').show();
            percentageMedical += 25;
            $('#changeProgress').attr('aria-valuenow', percentageMedical).css('width', percentageMedical+'%').html('4 of 4');
        }
        
    });
    $('#signupbackMedical_modal').click(function() {
        numOfClicksMedical --;
        if(numOfClicksMedical == 2){
            $('.signup3_medical').show();
            $('.signup4_medical').hide();
            $('#signupnextMedical_modal').show();
            $('#signupconfirmMedical_modal').hide();
            percentageMedical -= 25;
            $('#changeProgress').attr('aria-valuenow', percentageMedical).css('width', percentageMedical+'%').html('3 of 4');
        }
        if(numOfClicksMedical == 1){
            $('.signup2_medical').show();
            $('.signup3_medical').hide();
            percentageMedical -= 25;
            $('#changeProgress').attr('aria-valuenow', percentageMedical).css('width', percentageMedical+'%').html('2 of 4');
        }
        if(numOfClicksMedical == 0){
            $('.signup0_medical').show();
            $('.signup1_medical').show();
            $('.signup2_medical').hide();
            percentageMedical -= 25;
            $('#changeProgress').attr('aria-valuenow', percentageMedical).css('width', percentageMedical+'%').html('1 of 4');
        }
        if(numOfClicksMedical < 0){
            $('.signup0_medical').show();
            $('.signup1_medical').hide();
            numOfClicksMedical = 0;
            percentageMedical -= 25;
            $('.signup_progressbar').hide();
            $('#changeProgress').attr('aria-valuenow', percentageMedical).css('width', percentageMedical+'%').html('&nbsp;');
            $('#signupMedical_modal').show();
            $('#login_modal_medical').show();
            $('#signupnextMedical_modal').hide();
            $('#signupbackMedical_modal').hide();
        }
    });

    $('#signupconfirmMedical_modal').click(function(){
      $('#login_medical_error').html('');
    	var scheduleID = $('#selectmedicaldoctor').find(':selected')[0].id;
      $('#loginmodalmedical input, #loginmodalmedical select').attr('disabled', 'disabled');
    	if(
        	$('#user_name_modal_medical').val() &&
        	$('#password_modal_medical').val() &&
        	$('#medicalNotes').val() &&
        	scheduleID &&
        	$('#medicalNotes').val() &&
        	$('#first_name_medical').val() &&
        	$('#middle_name_medical').val() &&
        	$('#last_name_medical').val() &&
        	$("input[name='patient_type_medical']:checked").val() &&
        	$("input[name='sex_medical']:checked").val() &&
        	$('#birthdate_medical').val() &&
        	$('#civil_status_medical').val() &&
        	$('#religion_medical').val() &&
        	$('#nationality_medical').val() &&
        	$('#father_first_medical').val() &&
        	$('#father_middle_medical').val() &&
        	$('#father_last_medical').val() &&
        	$('#mother_first_medical').val() &&
        	$('#mother_middle_medical').val() &&
        	$('#mother_last_medical').val() &&
        	$('#street_medical').val() &&
        	$('#town_medical').val() &&
        	$('#province_medical').val() &&
        	$('#residencetelephone_medical').val() &&
        	$('#personalcontactnumber_medical').val() &&
        	$('#residencecellphone_medical').val() &&
        	$('#guardian_first_medical').val() &&
        	$('#guardian_middle_medical').val() &&
        	$('#guardian_last_medical').val() &&
        	$('#guardian_relationship_medical').val() &&
        	$('#guardian_street_medical').val() &&
        	$('#guardian_town_medical').val() &&
        	$('#guardian_province_medical').val() &&
        	$('#guardianresidencetelephone_medical').val() &&
        	$('#guardianresidencecellphone_medical').val() &&
        	$('#illness_history_medical').val() &&
        	$('#operation_history_medical').val() &&
        	$('#allergies_history_medical').val() &&
        	$('#family_history_medical').val() &&
            $('#maintenance_medication_history_medical').val()
            )
        {
          // $('#loginmodalmedical input, #loginmodalmedical select').attr('disabled', 'disabled');
        	$.post('/signupfrommedicalappointment',{
	    		user_name:$('#user_name_modal_medical').val(),
	            password:$('#password_modal_medical').val(),
	            reasons:$('#medicalNotes').val(),
	            schedule_id: scheduleID,
	            reasons:$('#medicalNotes').val(),
	            first_name:$('#first_name_medical').val(),
                middle_name:$('#middle_name_medical').val(),
                last_name: $('#last_name_medical').val(),
                patient_type_id: $("input[name='patient_type_medical']:checked").val(),
                sex:$("input[name='sex_medical']:checked").val(),
                year_level: $('#yearlevel_medical').val(),
                degree_program_id: $("#degree_program_medical").val(),
                birthdate: $('#birthdate_medical').val(),
                senior_citizen_id: $('#senior_citizen_id_medical').val(),
                civil_status: $('#civil_status_medical').val(),
                religion: $('#religion_medical').val(),
                nationality: $('#nationality_medical').val(),
                father_first_name:$('#father_first_medical').val(),
                father_middle_name:$('#father_middle_medical').val(),
                father_last_name:$('#father_last_medical').val(),
                mother_first_name:$('#mother_first_medical').val(),
                mother_middle_name:$('#mother_middle_medical').val(),
                mother_last_name:$('#mother_last_medical').val(),
                street:$('#street_medical').val(),
                town:$('#town_medical').val(),
                province:$('#province_medical').val(),
                residencetelephone:$('#residencetelephone_medical').val(),
                personalcontactnumber:$('#personalcontactnumber_medical').val(),
                residencecellphone:$('#residencecellphone_medical').val(),
                guardian_first_name: $('#guardian_first_medical').val(),
                guardian_middle_name: $('#guardian_middle_medical').val(),
                guardian_last_name: $('#guardian_last_medical').val(),
                guardian_relationship:$('#guardian_relationship_medical').val(),
                guardian_street:$('#guardian_street_medical').val(),
                guardian_town:$('#guardian_town_medical').val(),
                guardian_province:$('#guardian_province_medical').val(),
                guardianresidencetelephone:$('#guardianresidencetelephone_medical').val(),
                guardianresidencecellphone:$('#guardianresidencecellphone_medical').val(),
                illness_history:$('#illness_history_medical').val(),
                operation_history:$('#operation_history_medical').val(),
                allergies_history:$('#allergies_history_medical').val(),
                family_history:$('#family_history_medical').val(),
                maintenance_medication_history:$('#maintenance_medication_history_medical').val(),
	        } ,
	        function(data){
            if(data['message'] == 'Success')
            {
              $('#login_medical_error').html('');
              $('#medicalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
              $('#medicalNotes').attr("disabled", "disabled");
              $('#selectmedicaldate').attr('disabled', 'disabled');
              $('#selectmedicaldoctor').attr('disabled', 'disabled');
              $('#submitMedicalAppointment').addClass("disabled");
              $('#medicalAppointmentPanelBody').css('background-color', '#d6e9c6');
              $('#navigationBar').load(location.href + " #navigationBar");
              $( "#loginmodalmedical" ).find( "input" ).attr({disabled: 'disabled'});
              $("#submitmedicalappointment").attr('disabled','disabled');
              setTimeout(function() { $('#loginmodalmedical').modal("hide"); }, 500);
            }
            else
            {
              $('#loginmodalmedical input, #loginmodalmedical select').removeAttr('disabled');
              $('#login_medical_error').css('color', 'red').delay(2000).html(data['message']);
            }
	        	
	        });
        }
        else
        {
          $('#loginmodalmedical input, #loginmodalmedical select').removeAttr('disabled');
          $('#login_medical_error').css('color', 'red').delay(2000).html('Please fill out all fields!');
        }
    });
});