$(document).ready( function(){

	numOfClicksMedical = 0;
	numOfClicksDental = 0;
    percentageDental = 0;
    percentageMedical = 0

	$('.h3Title').mouseover(
		function(){
			$(this).find('.h3Icon').css("animation", "spin 2s");
	});
	$(window).scroll( function(){
    
        /* Check the location of each desired element */
        $('.fadeShow').each( function(i){
            
            var bottom_of_object = $(this).offset().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            
            /* If the object is completely visible in the window, fade it it */
            if( bottom_of_window > bottom_of_object ){
                
                $(this).animate({'opacity':'1'},500);
                    
            }
            
        }); 
    
    });
    //Home Login
    $('#login').click(function(){
        if(!($('#user_name').val()) && !($('#password').val())){
            $('#loginErrorMessage').html('Enter username and password');
            return false;
        }
        else if(!($('#user_name').val()) && ($('#password').val())){
            $('#loginErrorMessage').html('Enter username');
            return false;
        }
        else if(($('#user_name').val()) && !($('#password').val())){
            $('#loginErrorMessage').html('Enter password');
            return false;
        }
        else{

        }
        
    });

    $('.homeForm:first').delay("200").fadeIn();
    $('.homeForm:last').delay("500").fadeIn();
    
    if($('#typeDental').is(':checked')){
          $('#dentalAppointment0').fadeIn();
    }
    if($('#typeMedical').is(':checked')){
          $('#medicalAppointment0').fadeIn();
    }
    $('#typeDental').click(function() {
        if($(this).is(':checked') && !($('#typeMedical').is(':checked'))){
            $('#dentalAppointment0').fadeIn();   
        }
        else if($(this).is(':checked') && ($('#typeMedical').is(':checked'))){
            $('#medicalAppointment0').animate({
                marginLeft: '+=25%'},
                function() {
                    $('#medicalAppointment0').removeAttr('style').css({display: 'block'});
                    $('#medicalAppointment0').removeClass('col-md-offset-6');
                    $('#dentalAppointment0').fadeIn();
                });
        }
        else if(!($(this).is(':checked')) && ($('#typeMedical').is(':checked'))){
            $('#dentalAppointment0').fadeOut(function(){
                $('#medicalAppointment0').addClass('col-md-offset-6');
                $('#medicalAppointment0').animate({
                    marginLeft: '-=25%'});
            });
        }
        else if(!($(this).is(':checked')) && !($('#typeMedical').is(':checked'))){
            $('#dentalAppointment').fadeOut();
        }
        else{
            
        }
    });
    $('#typeMedical').click(function() {
        if($(this).is(':checked') && !($('#typeDental').is(':checked'))){
            $('#medicalAppointment0').fadeIn();
        }
        else if($(this).is(':checked') && $('#typeDental').is(':checked')){
           $('#dentalAppointment0').animate({
               marginLeft: '0%'},
               function() {
                $('#medicalAppointment0').removeClass('col-md-offset-3');
              $('#medicalAppointment0').fadeIn();
           });    
        }
        else{
            $('#medicalAppointment0').fadeOut(function(){
                $('#dentalAppointment0').animate({
                    marginLeft: '25%'});
            });
        } 
    });
    // 
    // 
    // if($('#typeDental').is(':checked')){
    //       $('#dentalAppointment0').fadeIn();
    // }
    // if($('#typeMedical').is(':checked')){
    //       $('#medicalAppointment0').fadeIn();
    // }
    // $('#typeDental').click(function() {
    //     $('#dentalAppointment0').fadeToggle();
    // });
    // $('#typeMedical').click(function() {
    //     $('#medicalAppointment0').fadeToggle();
    // });
    $('#signupDental_modal').click(function(){
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
    
    $("#selDentalDate").change(function() {
        var dentalDate = $(this).find(':selected')[0].value;
        $.ajax({
            type: "POST",
            url: displayDentalSchedule,
            data: {dental_date:  dentalDate, _token: token},
            success: function(data)
            {
                $('#selDentalTime').removeAttr('disabled');
                console.log(data["start"]);
                console.log(data["end"]);
                console.log(data["staff"]);
                $('#selDentalTime').html("").append("<option disabled selected> -- select date of appointment -- </option>");
                for(var i=0; i < data['start'].length; i++) {
                  $('#selDentalTime').append("<option>"+data['staff'][i]+" "+data['start'][i]+" - "+data['end'][i]+"</option>");
                }
            }
        });
    });

    $("#selMedicalDate").change(function() {
        var medicalDate = $(this).find(':selected')[0].value;
        $.ajax({
            type: "POST",
            url: displayMedicalSchedule,
            data: {medical_date:  medicalDate, _token: token},
            success: function(data)
            {
                $('#selMedicalDoctor').removeAttr('disabled');
                console.log(data["staff"]);
                $('#selMedicalDoctor').html("").append("<option disabled selected> -- select date of appointment -- </option>");
                for(var i=0; i < data['staff'].length; i++) {
                  $('#selMedicalDoctor').append("<option>"+data['staff'][i]+"</option>");
                }
            }
        });
    });


    $("#submitDentalAppointment").click(function() {
        if($('#dentalNotes').val() && $('#selDentalDate').find(':selected')[0].value && $('#selDentalTime').find(':selected')[0].value){
            var inputDate = $('#selDentalDate').find(':selected')[0].value;
            var arrayInputTime = $('#selDentalTime').find(':selected')[0].value;
            var inputTimeSplit = arrayInputTime.split(" - ");
            var inputTime = inputTimeSplit[1];
            var staffIdSplit = $('#selDentalTime').children(":selected").attr("id").split("_");
            console.log("staffIdSplit: " + staffIdSplit);
            var staffId = staffIdSplit[1];

            console.log("Array input time " + arrayInputTime);

            console.log("Input time: " + inputTime);
            console.log("staff ID: " + staffId);

            console.log(inputDate);
                    console.log(inputTime);
            $.ajax({
                type: "POST",
                url: "schedule-dental-appointment.php",
                async: true,
                data: {'reasons':$('#dentalNotes').val(), 'day':inputDate, 'time': inputTime, 'staff_id':staffId},
                success: function(response)
                {
                    message = JSON.parse(response);
                console.log(message);
                    if(message==1){
                        console.log("Success!");
                        $('#dentalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
                        $('#dentalNotes').attr("disabled", "disabled");
                        $('#selDentalDate').attr("disabled", "disabled");
                        $('#selDentalTime').attr("disabled", "disabled");
                        $('#submitDentalAppointment').addClass("disabled");
                        $('#dentalAppointmentPanelBody').css('background-color', '#d6e9c6');
                    }
                    else{
                        $('#loginModalDental').modal();
                    }
                    
                    
                }
            });
        }
        return false;
    });



// -----------------------------------------MEDICAL APPOINTMENT-------------------------------------------------

    $("#submitMedicalAppointment").click(function() {
        if($('#medicalNotes').val() && $('#selMedicalDate').find(':selected')[0].value && $('#selMedicalDoctor').find(':selected')[0].value){
            var inputDate = $('#selMedicalDate').find(':selected')[0].value;
            // var arrayInputTime = $('#selMedicalDoctor').find(':selected')[0].value;
            // var inputTimeSplit = arrayInputTime.split(" - ");
            // var inputTime = inputTimeSplit[1];
            var staffIdSplit = $('#selMedicalDoctor').children(":selected").attr("id").split("_");
            console.log("staffIdSplit: " + staffIdSplit);
            var staffId = staffIdSplit[1];

            $.ajax({
                type: "POST",
                url: "schedule-medical-appointment.php",
                async: true,
                data: {'reasons':$('#medicalNotes').val(), 'day':inputDate, 'staff_id':staffId},
                success: function(response)
                {
                    message = JSON.parse(response);
                    console.log(message);
                    if(message==1){
                        console.log("Success!");
                        $('#medicalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
                        $('#medicalNotes').attr("disabled", "disabled");
                        $('#selMedicalDate').attr("disabled", "disabled");
                        $('#selMedicalDoctor').attr("disabled", "disabled");
                        $('#submitMedicalAppointment').addClass("disabled");
                        $('#medicalAppointmentPanelBody').css('background-color', '#d6e9c6');
                    }
                    else{
                        $('#loginMedicalModal').modal();
                    }
                    
                    
                }
            });
        }
        return false;
    });

    $('#login_modal_medical').click(function(){
        console.log($('#user_name_modal_medical').val());
        console.log($('#password_modal_medical').val());
        var inputDate = $('#selMedicalDate').find(':selected')[0].value;
        var staffIdSplit = $('#selMedicalDoctor').children(":selected").attr("id").split("_");
        var staffId = staffIdSplit[1];
        $.ajax({
                type: "POST",
                url: "login-from-schedule-appointment-medical.php",
                async: true,
                data: {'user_name_modal':$('#user_name_modal_medical').val(), 'password_modal':$('#password_modal_medical').val(), 'reasons':$('#medicalNotes').val(), 'day':inputDate, 'staff_id':staffId},
                success: function(response)
                {
                    message = JSON.parse(response);
                    console.log("Message is..."+message);
                    if(message==1){
                        console.log("Success!");
                        $('#medicalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
                        $('#medicalNotes').attr("disabled", "disabled");
                        $('#selMedicalDate').attr("disabled", "disabled");
                        $('#submitMedicalAppointment').addClass("disabled");
                        $('#medicalAppointmentPanelBody').css('background-color', '#d6e9c6');
                        $('.navigationBar').load(location.href + " .navigationBar");
                        $('#loginMedicalModal').modal("hide");
                        return false;
                    }
                    else{
                        console.log("Invalid bes");
                        $('#loginErrorMessageMedical').html("Wrong username/password combination");
                    }
                    
                    // alert("Hello");
                    
                }
            });
         
    });


//----------------------------------------------------------------------------------------------------------    


    $('#login_modal_dental').click(function(){
        console.log($('#user_name_modal').val());
        console.log($('#password_modal').val());
        var inputDate = $('#selDentalDate').find(':selected')[0].value;
        var arrayInputTime = $('#selDentalTime').find(':selected')[0].value;
        var inputTimeSplit = arrayInputTime.split(" - ");
        var inputTime = inputTimeSplit[1];
        var staffIdSplit = $('#selDentalTime').children(":selected").attr("id").split("_");
        var staffId = staffIdSplit[1];
        console.log("staffId: " + staffId);
        $.ajax({
                type: "POST",
                url: "login-from-schedule-appointment.php",
                async: true,
                data: {'user_name_modal_dental':$('#user_name_modal_dental').val(), 'password_modal_dental':$('#password_modal_dental').val(), 'staff_id':staffId, 'reasons':$('#dentalNotes').val(), 'day':inputDate, 'time': inputTime},
                success: function(response)
                {
                    message = JSON.parse(response);
                    console.log(message);
                    if(message==1){
                        console.log("Success!");
                        $('#dentalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
                        $('#dentalNotes').attr("disabled", "disabled");
                        $('#selDentalDate').attr("disabled", "disabled");
                        $('#selDentalTime').attr("disabled", "disabled");
                        $('#submitDentalAppointment').addClass("disabled");
                        $('#dentalAppointmentPanelBody').css('background-color', '#d6e9c6');
                        $('.navigationBar').load(location.href + " .navigationBar");
                         $('#loginModalDental').modal("hide");
                         return false;

                    }
                    else{
                        $('#loginErrorMessage').html("Wrong username/password combination");
                    }
                    
                    // alert("Hello");
                    
                }
            });
         
    });
    $('#selMedicalDoctor').closest('div').css({marginBottom: '0px'})
    $('#signupconfirmDental_modal').click(function(){
    	console.log('radio:'+$("input[name=patient_type_dental]:checked").val());
        console.log('course:'+$("#degree_program_dental").val());
        console.log($('#birthdate_dental').val());
        console.log( $("input[name='sex_dental']:checked").val());
        console.log($('#yearlevel_dental').val());
        console.log($("#degree_program_dental").val());
        console.log($('#birthdate_dental').val());
        console.log($('#religion_dental').val());
        console.log($('#nationality_dental').val());
        console.log($('#father_dental').val());
        console.log($('#mother_dental').val());
        console.log($('#street_dental').val());
        console.log($('#town_dental').val());
        console.log($('#province_dental').val());
        console.log($('#residencetelephone_dental').val());
        console.log($('#residencecellphone_dental').val());
        console.log($('#personalcontactnumber_dental').val());
        console.log($('#guardian_name_dental').val());
        console.log($('#guardian_relationship_dental').val());
        console.log($('#guardian_address_dental').val());
        console.log($('#guardianresidencetelephone_dental').val());
        console.log($('#guardianresidencecellphone_dental').val());
        console.log($('#illness_history_dental').val());
        console.log($('#operation_history_dental').val());
        console.log($('#allergies_history_dental').val());
        console.log($('#family_history_dental').val());
        console.log($('#maintenance_medication_history_dental').val());
        if(
        	$('#user_name_modal_dental').val() &&
        	$('#password_modal_dental').val() &&
        	$('#first_name_dental').val() &&
        	$('#middle_name_dental').val() &&
        	$('#last_name_dental').val() &&
        	$("input[name='patient_type_dental']:checked").val() &&
            $('#age_dental').val() &&
            $("input[name='sex_dental']:checked").val() &&
            $('#yearlevel_dental').val() &&
            $("#degree_program_dental").val() &&
            $('#birthdate_dental').val() &&
            $('#religion_dental').val() &&
            $('#nationality_dental').val() &&
            $('#father_dental').val() &&
            $('#mother_dental').val() &&
            $('#street_dental').val() &&
            $('#town_dental').val() &&
            $('#province_dental').val() &&
            $('#residencetelephone_dental').val() &&
            $('#residencecellphone_dental').val() &&
            $('#personalcontactnumber_dental').val() &&
            $('#guardian_name_dental').val() &&
            $('#guardian_relationship_dental').val() &&
            $('#guardian_address_dental').val() &&
            $('#guardianresidencetelephone_dental').val() &&
            $('#guardianresidencecellphone_dental').val() &&
            $('#illness_history_dental').val() &&
            $('#operation_history_dental').val() &&
            $('#allergies_history_dental').val() &&
            $('#family_history_dental').val() &&
            $('#maintenance_medication_history_dental').val()
        	){
        console.log($('#user_name_modal').val());
        console.log($('#password_modal').val());
        console.log($('#first_name').val());
        console.log($('#middle_name').val());
        var inputDate = $('#selDentalDate').find(':selected')[0].value;
        var arrayInputTime = $('#selDentalTime').find(':selected')[0].value;
        var inputTimeSplit = arrayInputTime.split(" - ");
        var inputTime = inputTimeSplit[1];
        var staffIdSplit = $('#selDentalTime').children(":selected").attr("id").split("_");
        var staffId = staffIdSplit[1];
        console.log("staffId: " + staffId);
        $.ajax({
                type: "POST",
                url: "signup-from-schedule-appointment.php",
                async: true,
                data: {
                	'user_name_modal_dental':$('#user_name_modal_dental').val(),
                	'password_modal_dental':$('#password_modal_dental').val(),
                	'staff_id':staffId,
                	'reasons':$('#dentalNotes').val(),
                	'day':inputDate,
                	'time': inputTime,
                	'first_name_dental':$('#first_name_dental').val(),
                'middle_name_dental':$('#middle_name_dental').val(),
                'last_name_dental': $('#last_name_dental').val(),
                'patient_type_dental': $("input[name='patient_type_dental']:checked").val(),
                'age_dental':$('#age_dental').val(),
                'sex_dental':$("input[name='sex_dental']:checked").val(),
                'yearlevel_dental': $('#yearlevel_dental').val(),
                'degree_program_dental': $("#degree_program_dental").val(),
                'birthdate_dental': $('#birthdate_dental').val(),
                'religion_dental': $('#religion_dental').val(),
                'nationality_dental': $('#nationality_dental').val(),
                'father_dental':$('#father_dental').val(),
                'mother_dental':$('#mother_dental').val(),
                'street_dental':$('#street_dental').val(),
                'town_dental':$('#town_dental').val(),
                'province_dental':$('#province_dental').val(),
                'residencetelephone_dental':$('#residencetelephone_dental').val(),
                'personalcontactnumber_dental':$('#personalcontactnumber_dental').val(),
                'residencecellphone_dental':$('#residencecellphone_dental').val(),
                'guardian_name_dental': $('#guardian_name_dental').val(),
                'guardian_relationship_dental':$('#guardian_relationship_dental').val(),
                'guardian_address_dental':$('#guardian_address_dental').val(),
                'guardianresidencetelephone_dental':$('#guardianresidencetelephone_dental').val(),
                'guardianresidencecellphone_dental':$('#guardianresidencecellphone_dental').val(),
                'illness_history_dental':$('#illness_history_dental').val(),
                'operation_history_dental':$('#operation_history_dental').val(),
                'allergies_history_dental':$('#allergies_history_dental').val(),
                'family_history_dental':$('#family_history_dental').val(),
                'maintenance_medication_history_dental':$('#maintenance_medication_history_dental').val()
                },
                success: function()
                {
                        console.log("Success!");
                        $('#dentalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
                        $('#dentalNotes').attr("disabled", "disabled");
                        $('#selDentalDate').attr("disabled", "disabled");
                        $('#selDentalTime').attr("disabled", "disabled");
                        $('#submitDentalAppointment').addClass("disabled");
                        $('#dentalAppointmentPanelBody').css('background-color', '#d6e9c6');
                        $('.navigationBar').load(location.href + " .navigationBar");
                        $( "#loginModalDental" ).find( "input" ).attr({
                            disabled: 'disabled'
                        });
                        setTimeout(function() { $('#loginModalDental').modal("hide"); }, 500);
                        
                        return false;
                }
            });
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
        console.log('radio:'+$("input[name=patient_type_medical]:checked").val());
        console.log('course:'+$("#degree_program_medical").val());
        console.log($('#birthdate_medical').val());
        console.log( $("input[name='sex_medical']:checked").val());
        console.log($('#yearlevel_medical').val());
        console.log($("#degree_program_medical").val());
        console.log($('#birthdate_medical').val());
        console.log($('#religion_medical').val());
        console.log($('#nationality_medical').val());
        console.log($('#father_medical').val());
        console.log($('#mother_medical').val());
        console.log($('#street_medical').val());
        console.log($('#town_medical').val());
        console.log($('#province_medical').val());
        console.log($('#residencetelephone_medical').val());
        console.log($('#residencecellphone_medical').val());
        console.log($('#personalcontactnumber_medical').val());
        console.log($('#guardian_name_medical').val());
        console.log($('#guardian_relationship_medical').val());
        console.log($('#guardian_address_medical').val());
        console.log($('#guardianresidencetelephone_medical').val());
        console.log($('#guardianresidencecellphone_medical').val());
        console.log($('#illness_history_medical').val());
        console.log($('#operation_history_medical').val());
        console.log($('#allergies_history_medical').val());
        console.log($('#family_history_medical').val());
        console.log($('#maintenance_medication_history_medical').val());
        // console.log();
        // console.log();
        // console.log();
        // console.log();
        if($('#user_name_modal_medical').val() &&
            $('#password_modal_medical').val() &&
            $('#first_name_medical').val() &&
            $('#middle_name_medical').val() &&
            $('#last_name_medical').val() &&
            $("input[name='patient_type_medical']:checked").val() &&
            $('#age_medical').val() &&
            $("input[name='sex_medical']:checked").val() &&
            $('#yearlevel_medical').val() &&
            $("#degree_program_medical").val() &&
            $('#birthdate_medical').val() &&
            $('#religion_medical').val() &&
            $('#nationality_medical').val() &&
            $('#father_medical').val() &&
            $('#mother_medical').val() &&
            $('#street_medical').val() &&
            $('#town_medical').val() &&
            $('#province_medical').val() &&
            $('#residencetelephone_medical').val() &&
            $('#residencecellphone_medical').val() &&
            $('#personalcontactnumber_medical').val() &&
            $('#guardian_name_medical').val() &&
            $('#guardian_relationship_medical').val() &&
            $('#guardian_address_medical').val() &&
            $('#guardianresidencetelephone_medical').val() &&
            $('#guardianresidencecellphone_medical').val() &&
            $('#illness_history_medical').val() &&
            $('#operation_history_medical').val() &&
            $('#allergies_history_medical').val() &&
            $('#family_history_medical').val() &&
            $('#maintenance_medication_history_medical').val()
            )
        {
            
        var inputDate = $('#selMedicalDate').find(':selected')[0].value;
        var staffIdSplit = $('#selMedicalDoctor').children(":selected").attr("id").split("_");
        var staffId = staffIdSplit[1];
        console.log($('#user_name_modal_medical').val());
        console.log($('#password_modal_medical').val());
        console.log($('#first_name_medical').val());
        console.log($('#middle_name_medical').val());
        console.log($('#last_name_medical').val());
        console.log(inputDate);
        console.log(staffId);
        $.ajax({
                type: "POST",
                url: "signup-from-schedule-appointment-medical.php",
                async: true,
                data: {
                'user_name_modal_medical':$('#user_name_modal_medical').val(),
                'password_modal_medical':$('#password_modal_medical').val(),
                'staff_id':staffId,
                'reasons':$('#medicalNotes').val(),
                'day':inputDate,
                'first_name_medical':$('#first_name_medical').val(),
                'middle_name_medical':$('#middle_name_medical').val(),
                'last_name_medical': $('#last_name_medical').val(),
                'patient_type_medical': $("input[name='patient_type_medical']:checked").val(),
                'age_medical':$('#age_medical').val(),
                'sex_medical':$("input[name='sex_medical']:checked").val(),
                'yearlevel_medical': $('#yearlevel_medical').val(),
                'degree_program_medical': $("#degree_program_medical").val(),
                'birthdate_medical': $('#birthdate_medical').val(),
                'religion_medical': $('#religion_medical').val(),
                'nationality_medical': $('#nationality_medical').val(),
                'father_medical':$('#father_medical').val(),
                'mother_medical':$('#mother_medical').val(),
                'street_medical':$('#street_medical').val(),
                'town_medical':$('#town_medical').val(),
                'province_medical':$('#province_medical').val(),
                'residencetelephone_medical':$('#residencetelephone_medical').val(),
                'personalcontactnumber_medical':$('#personalcontactnumber_medical').val(),
                'residencecellphone_medical':$('#residencecellphone_medical').val(),
                'guardian_name_medical': $('#guardian_name_medical').val(),
                'guardian_relationship_medical':$('#guardian_relationship_medical').val(),
                'guardian_address_medical':$('#guardian_address_medical').val(),
                'guardianresidencetelephone_medical':$('#guardianresidencetelephone_medical').val(),
                'guardianresidencecellphone_medical':$('#guardianresidencecellphone_medical').val(),
                'illness_history_medical':$('#illness_history_medical').val(),
                'operation_history_medical':$('#operation_history_medical').val(),
                'allergies_history_medical':$('#allergies_history_medical').val(),
                'family_history_medical':$('#family_history_medical').val(),
                'maintenance_medication_history_medical':$('#maintenance_medication_history_medical').val()
                },
                success: function()
                {
                        console.log("Success!");
                        $('#medicalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
                        $('#medicalNotes').attr("disabled", "disabled");
                        $('#selMedicalDoctor').attr("disabled", "disabled");
                        $('#selMedicalDate').attr("disabled", "disabled");
                        $('#submitMedicalAppointment').addClass("disabled");
                        $('#medicalAppointmentPanelBody').css('background-color', '#d6e9c6');
                        $('.navigationBar').load(location.href + " .navigationBar");
                        $( "#loginMedicalModal" ).find( "input" ).attr({
                            disabled: 'disabled'
                        });

                        setTimeout(function() { $('#loginMedicalModal').modal("hide"); }, 500);
                        percentage = 0;
                        return false;
                }
            });
        }
    });

	// MODAL FOR CREATING NEW RECORD FOR MEDICAL
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

	$('.addLaboratoryResult').click(function(){
		console.log($(this).attr('id'));
        var rowToRemove = $(this).attr('id');
		var buttonId = ($(this).attr('id').split('_'));
		var patient_id = buttonId[1];
		var appointment_id = buttonId[2];
		var staff_id = buttonId[3];
		$('#add-laboratory-result').modal();
		$('#addLabResultButton').click(function(){
			if($('#hemoglobin-lab').val()
				&& $('#hemasocrit-lab').val()
				&& $('#wbc-lab').val()
				&& $('#pus-cells-lab').val()
				&& $('#rbc-lab').val()
				&& $('#albumin-lab').val()
				&& $('#sugar-lab').val()
				&& $('#macroscopic-lab').val()
				&& $('#microscopic-lab').val()
				&& $('#drug-test-lab').val()
			){
				var hemoglobin = $('#hemoglobin-lab').val();
				var hemasocrit = $('#hemasocrit-lab').val();
				var wbc = $('#wbc-lab').val();
				var pusCells = $('#pus-cells-lab').val();
				var rbc = $('#rbc-lab').val();
				var albumin = $('#albumin-lab').val();
				var sugar = $('#sugar-lab').val();
				var macroscopic = $('#macroscopic-lab').val();
				var microscopic = $('#microscopic-lab').val();
				var drugTest = $('#drug-test-lab').val();
				$.ajax({
	                type: "POST",
	                url: "add-lab-results.php",
	                async: true,
	                data: 
	                {   'patient_id':patient_id,
	                    'appointment_id':appointment_id,
	                    'staff_id': staff_id,
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
	                },
	                success: function(response)
	                {
	                	message = JSON.parse(response);
	                	console.log(message);
	                	if(message==1){
	                		console.log("Success!");
                            $('#'+rowToRemove).parents('tr').remove();
	                		$('#add-laboratory-result').modal('hide');
	                	}
	                }
	            });
	           }
		});
		

		
	});
	$('.addXrayResult').click(function(){
		console.log($(this).attr('id'));
        var rowToRemove = $(this).attr('id');
		var buttonId = ($(this).attr('id').split('_'));
		var patient_id = buttonId[1];
		var appointment_id = buttonId[2];
		var staff_id = buttonId[3];
		$('#add-xray-result').modal();
		$('#addXrayResultButton').click(function(){
			if($('#chest-xray-xray').val()
			){
				var chestXray = $('#chest-xray-xray').val();
				$.ajax({
	                type: "POST",
	                url: "add-xray-results.php",
	                async: true,
	                data: 
	                {   'patient_id':patient_id,
	                    'appointment_id':appointment_id,
	                    'staff_id': staff_id,
	                    'chest_xray_result': chestXray
	                },
	                success: function(response)
	                {
	                	message = JSON.parse(response);
	                	console.log(message);
	                	if(message==1){
	                		console.log("Success!");
	                		$('#add-xray-result').modal('hide');
                            $('#'+rowToRemove).parents('tr').remove();
	                	}
	                }
	            });
	           }
		});
		

		
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
            // var hemoglobin = $('#hemoglobin').val();
            // var hemasocrit = $('#hemasocrit').val();
            // var wbc = $('#wbc').val();
            // var pusCells = $('#pus-cells').val();
            // var rbc = $('#rbc').val();
            // var albumin = $('#albumin').val();
            // var sugar = $('#sugar').val();
            // var macroscopic = $('#macroscopic').val();
            // var microscopic = $('#microscopic').val();
            // var drugTest = $('#drug-test').val();
            // var chestXray = $('#chest-xray').val();
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
                    // 'hemoglobin':hemoglobin,
                    // 'hemasocrit':hemasocrit,
                    // 'wbc':wbc,
                    // 'pus-cells':pusCells,
                    // 'rbc':rbc,
                    // 'albumin':albumin,
                    // 'sugar':sugar,
                    // 'macroscopic':macroscopic,
                    // 'microscopic':microscopic,
                    // 'drug-test':drugTest,
                    // 'chest-xray':chestXray,
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

	$('.medical_appointments_prescription').click(function(){
		var id = $(this).attr('id').split("_");

		console.log(id[1]);
		$.ajax({
			type: "POST",
			url: "appointments-detailed-info-for-patient-medical.php",
			async: true,
            data:{
            	'appointment_id': id[1]
            },
            success: function(response){
            	message = JSON.parse(response).split(";");
            	console.log(message);
            	var remark = message[0];
            	var date = message[1];
            	$('#remarkModal').html(remark);
            	$('#remarkModalFooter').html('Last modified: ' + date);
            }
		});
		$('#prescriptionModal').modal();
	});
	// MODAL FOR CREATING NEW RECORD FOR DENTAL
	$('.view_medical_history').click(function(){
        var id = $(this).attr('id').split("_");
        console.log(id[3]);
        $.ajax({
            type: "POST",
            url: "appointments-detailed-info-for-patient-medical.php",
            async: true,
            data:{
                'appointment_id': id[3]
            },
            success: function(response){
                message = JSON.parse(response).split(";");
                console.log(message);
                var remark = message[0];
                var date = message[1];
                $('#remarkModal').html(remark);
                $('#remarkModalFooter').html('Last modified: ' + date);
            }
        });
        $('#prescriptionModal').modal();
    });
	 // MODAL FOR CREATING NEW RECORD FOR DENTAL
    $('.view_dental_history').click(function() {
        if($(this).attr('id')){
           var patient_id = $(this).attr('id');
            console.log(patient_id);
            var patientIdSplit = patient_id.split("_");
            create_record_patient_id = patientIdSplit[3];
            console.log("Patient id is..." + create_record_patient_id);
            appointment_id = patientIdSplit[4];
            console.log("Appointment is..." + appointment_id);
            console.log('Hi '+$("select.condition_55").children());

            $.ajax({
                type: "POST",
                url: "display-dental-history-modal.php",
                async: true,
                data: {'create_record_patient_id':create_record_patient_id, 'appointment_id':appointment_id},
                success: function(response)
                {
                    message = JSON.parse(response);
                    console.log(message);
                    $('.condition_55').val('condition_55');
                    $('.condition_54').val('condition_54');
                    $('.condition_53').val('condition_53');
                    $('.condition_52').val('condition_52');
                    $('.condition_51').val('condition_51');
                    $('.condition_61').val('condition_61');
                    $('.condition_62').val('condition_62');
                    $('.condition_63').val('condition_63');
                    $('.condition_64').val('condition_64');
                    $('.condition_65').val('condition_65');
                    $('.operation_55').val('operation_55');
                    $('.operation_54').val('operation_54');
                    $('.operation_53').val('operation_53');
                    $('.operation_52').val('operation_52');
                    $('.operation_51').val('operation_51');
                    $('.operation_61').val('operation_61');
                    $('.operation_62').val('operation_62');
                    $('.operation_63').val('operation_63');
                    $('.operation_64').val('operation_64');
                    $('.operation_65').val('operation_65');
                     

                    if(typeof message=="object")
                    {
                        for(i=0; i<message.length; i++) 
                        {
                            var splitMessage = message[i].split("(;;)");
                            $('.personal-information-name').html("").append("<p>"+splitMessage[1]+" "+splitMessage[2]+"</p>");
                            $('.personal-information-time').html("").append("<p>"+splitMessage[3]+"</p>");
                            $('.personal-information-reasons').html("").append("<p>"+splitMessage[4]+"</p>");
                            $('.dental-button-container').html("").append("<button type='button' class='btn btn-primary update-dental-record-button' id='update-dental-record-button'>Update</button>");
                        
                            if(splitMessage[7]==1){
                                $('.condition_'+splitMessage[6]).val('1');
                            }
                            if(splitMessage[7]==2){
                                $('.condition_'+splitMessage[6]).val('2');
                            }
                            if(splitMessage[7]==3){
                                $('.condition_'+splitMessage[6]).val('3');
                            }
                            if(splitMessage[7]==4){
                                $('.condition_'+splitMessage[6]).val('4');
                            }
                            if(splitMessage[7]==5){
                                $('.condition_'+splitMessage[6]).val('5');
                            }
                            if(splitMessage[8]==1){
                                $('.operation_'+splitMessage[6]).val('1');
                            }
                            if(splitMessage[8]==2){
                                $('.operation_'+splitMessage[6]).val('2');
                            }
                            if(splitMessage[8]==3){
                                $('.operation_'+splitMessage[6]).val('3');
                            }
                            if(splitMessage[8]==4){
                                $('.operation_'+splitMessage[6]).val('4');
                            }
                            if(splitMessage[8]==5){
                                $('.operation_'+splitMessage[6]).val('5');
                            }
                            
                         
                        }
                    }
                    else
                    {
                        var splitMessage = message.split("(;;)");
                        if (splitMessage[6]=="null")
                        {
                            $('.personal-information-name').html("").append("<p>"+splitMessage[1]+" "+splitMessage[2]+"</p>");
                            $('.personal-information-time').html("").append("<p>"+splitMessage[3]+"</p>");
                            $('.personal-information-reasons').html("").append("<p>"+splitMessage[4]+"</p>");
                            $(".condition_55 option:first-child").attr("selected", "selected");
                            $(".condition_54 option:first-child").attr("selected", "selected");
                            $(".condition_53 option:first-child").attr("selected", "selected");
                            $(".condition_52 option:first-child").attr("selected", "selected");
                            $(".condition_51 option:first-child").attr("selected", "selected");
                            $(".condition_61 option:first-child").attr("selected", "selected");
                            $(".condition_62 option:first-child").attr("selected", "selected");
                            $(".condition_63 option:first-child").attr("selected", "selected");
                            $(".condition_64 option:first-child").attr("selected", "selected");
                            $(".condition_65 option:first-child").attr("selected", "selected");
                            $(".operation_55 option:first-child").attr("selected", "selected");
                            $(".operation_54 option:first-child").attr("selected", "selected");
                            $(".operation_53 option:first-child").attr("selected", "selected");
                            $(".operation_52 option:first-child").attr("selected", "selected");
                            $(".operation_51 option:first-child").attr("selected", "selected");
                            $(".operation_61 option:first-child").attr("selected", "selected");
                            $(".operation_62 option:first-child").attr("selected", "selected");
                            $(".operation_63 option:first-child").attr("selected", "selected");
                            $(".operation_64 option:first-child").attr("selected", "selected");
                            $(".operation_65 option:first-child").attr("selected", "selected");
                            $('.dental-button-container').html("").append("<button type='button' class='btn btn-primary add-dental-record-button' id='add-dental-record-button'>Submit</button>");
                        }
                    }
                    $('#view-dental-record-modal').modal();
                    return false;
                }
            });
        }
    }); 

    
    $('.dental_appointments_prescription').click(function() {
        if($(this).attr('id')){
           var patient_id = $(this).attr('id');
            console.log(patient_id);
            var patientIdSplit = patient_id.split("_");
            create_record_patient_id = patientIdSplit[2];
            console.log("Patient id is..." + create_record_patient_id);
            appointment_id = patientIdSplit[1];
            console.log("Appointment is..." + appointment_id);

            $.ajax({
                type: "POST",
                url: "display-dental-history-modal.php",
                async: true,
                data: {'create_record_patient_id':create_record_patient_id, 'appointment_id':appointment_id},
                success: function(response)
                {
                    message = JSON.parse(response);
                    console.log(message);
                    $('.condition_55').val('condition_55');
                    $('.condition_54').val('condition_54');
                    $('.condition_53').val('condition_53');
                    $('.condition_52').val('condition_52');
                    $('.condition_51').val('condition_51');
                    $('.condition_61').val('condition_61');
                    $('.condition_62').val('condition_62');
                    $('.condition_63').val('condition_63');
                    $('.condition_64').val('condition_64');
                    $('.condition_65').val('condition_65');
                    $('.operation_55').val('operation_55');
                    $('.operation_54').val('operation_54');
                    $('.operation_53').val('operation_53');
                    $('.operation_52').val('operation_52');
                    $('.operation_51').val('operation_51');
                    $('.operation_61').val('operation_61');
                    $('.operation_62').val('operation_62');
                    $('.operation_63').val('operation_63');
                    $('.operation_64').val('operation_64');
                    $('.operation_65').val('operation_65');
                     

                    if(typeof message=="object")
                    {
                        for(i=0; i<message.length; i++) 
                        {
                            var splitMessage = message[i].split("(;;)");
                            $('.personal-information-name').html("").append("<p>"+splitMessage[1]+" "+splitMessage[2]+"</p>");
                            $('.personal-information-time').html("").append("<p>"+splitMessage[3]+"</p>");
                            $('.personal-information-reasons').html("").append("<p>"+splitMessage[4]+"</p>");
                            $('.dental-button-container').html("").append("<button type='button' class='btn btn-primary update-dental-record-button' id='update-dental-record-button'>Update</button>");
                        
                            if(splitMessage[7]==1){
                                $('.condition_'+splitMessage[6]).val('1');
                            }
                            if(splitMessage[7]==2){
                                $('.condition_'+splitMessage[6]).val('2');
                            }
                            if(splitMessage[7]==3){
                                $('.condition_'+splitMessage[6]).val('3');
                            }
                            if(splitMessage[7]==4){
                                $('.condition_'+splitMessage[6]).val('4');
                            }
                            if(splitMessage[7]==5){
                                $('.condition_'+splitMessage[6]).val('5');
                            }
                            if(splitMessage[8]==1){
                                $('.operation_'+splitMessage[6]).val('1');
                            }
                            if(splitMessage[8]==2){
                                $('.operation_'+splitMessage[6]).val('2');
                            }
                            if(splitMessage[8]==3){
                                $('.operation_'+splitMessage[6]).val('3');
                            }
                            if(splitMessage[8]==4){
                                $('.operation_'+splitMessage[6]).val('4');
                            }
                            if(splitMessage[8]==5){
                                $('.operation_'+splitMessage[6]).val('5');
                            }
                            
                         
                        }
                    }
                    else
                    {
                        var splitMessage = message.split("(;;)");
                        if (splitMessage[6]=="null")
                        {
                            $('.personal-information-name').html("").append("<p>"+splitMessage[1]+" "+splitMessage[2]+"</p>");
                            $('.personal-information-time').html("").append("<p>"+splitMessage[3]+"</p>");
                            $('.personal-information-reasons').html("").append("<p>"+splitMessage[4]+"</p>");
                            $(".condition_55 option:first-child").attr("selected", "selected");
                            $(".condition_54 option:first-child").attr("selected", "selected");
                            $(".condition_53 option:first-child").attr("selected", "selected");
                            $(".condition_52 option:first-child").attr("selected", "selected");
                            $(".condition_51 option:first-child").attr("selected", "selected");
                            $(".condition_61 option:first-child").attr("selected", "selected");
                            $(".condition_62 option:first-child").attr("selected", "selected");
                            $(".condition_63 option:first-child").attr("selected", "selected");
                            $(".condition_64 option:first-child").attr("selected", "selected");
                            $(".condition_65 option:first-child").attr("selected", "selected");
                            $(".operation_55 option:first-child").attr("selected", "selected");
                            $(".operation_54 option:first-child").attr("selected", "selected");
                            $(".operation_53 option:first-child").attr("selected", "selected");
                            $(".operation_52 option:first-child").attr("selected", "selected");
                            $(".operation_51 option:first-child").attr("selected", "selected");
                            $(".operation_61 option:first-child").attr("selected", "selected");
                            $(".operation_62 option:first-child").attr("selected", "selected");
                            $(".operation_63 option:first-child").attr("selected", "selected");
                            $(".operation_64 option:first-child").attr("selected", "selected");
                            $(".operation_65 option:first-child").attr("selected", "selected");
                            $('.dental-button-container').html("").append("<button type='button' class='btn btn-primary add-dental-record-button' id='add-dental-record-button'>Submit</button>");
                        }
                    }
                    $('#view-dental-record-modal').modal();
                    return false;
                }
            });
        }
    });
	$('.addDentalRecordButton').click(function() {
        if($(this).attr('id')){
            var patient_id = $(this).attr('id');
            removeDentalRow = $(this).attr('id');
            console.log(patient_id);
            var patientIdSplit = patient_id.split("_");
            create_record_patient_id = patientIdSplit[1];
            console.log("Patient id is..." + create_record_patient_id);
            appointment_id = patientIdSplit[2];
            console.log("Appointment is..." + appointment_id);
            $.ajax({
                type: "POST",
                url: "display-dental-info-modal.php",
                async: true,
                data: {'create_record_patient_id':create_record_patient_id, 'appointment_id':appointment_id},
                success: function(response)
                {
                    message = JSON.parse(response);
                    console.log(message);
                    $('.condition_55').val('condition_55');
                    $('.condition_54').val('condition_54');
                    $('.condition_53').val('condition_53');
                    $('.condition_52').val('condition_52');
                    $('.condition_51').val('condition_51');
                    $('.condition_61').val('condition_61');
                    $('.condition_62').val('condition_62');
                    $('.condition_63').val('condition_63');
                    $('.condition_64').val('condition_64');
                    $('.condition_65').val('condition_65');
                    $('.operation_55').val('operation_55');
                    $('.operation_54').val('operation_54');
                    $('.operation_53').val('operation_53');
                    $('.operation_52').val('operation_52');
                    $('.operation_51').val('operation_51');
                    $('.operation_61').val('operation_61');
                    $('.operation_62').val('operation_62');
                    $('.operation_63').val('operation_63');
                    $('.operation_64').val('operation_64');
                    $('.operation_65').val('operation_65');
                     

                    if(typeof message=="object")
                    {
                        for(i=0; i<message.length; i++) 
                        {
                            var splitMessage = message[i].split("(;;)");
                            $('.personal-information-name').html("").append("<p>"+splitMessage[1]+" "+splitMessage[2]+"</p>");
                            $('.personal-information-time').html("").append("<p>"+splitMessage[3]+"</p>");
                            $('.personal-information-reasons').html("").append("<p>"+splitMessage[4]+"</p>");
                            $('.dental-button-container').html("").append("<button type='button' class='btn btn-primary update-dental-record-button' id='update-dental-record-button'>Update</button>");
                        
                            if(splitMessage[7]==1){
                                $('.condition_'+splitMessage[6]).val('1');
                            }
                            if(splitMessage[7]==2){
                                $('.condition_'+splitMessage[6]).val('2');
                            }
                            if(splitMessage[7]==3){
                                $('.condition_'+splitMessage[6]).val('3');
                            }
                            if(splitMessage[7]==4){
                                $('.condition_'+splitMessage[6]).val('4');
                            }
                            if(splitMessage[7]==5){
                                $('.condition_'+splitMessage[6]).val('5');
                            }
                            if(splitMessage[8]==1){
                                $('.operation_'+splitMessage[6]).val('1');
                            }
                            if(splitMessage[8]==2){
                                $('.operation_'+splitMessage[6]).val('2');
                            }
                            if(splitMessage[8]==3){
                                $('.operation_'+splitMessage[6]).val('3');
                            }
                            if(splitMessage[8]==4){
                                $('.operation_'+splitMessage[6]).val('4');
                            }
                            if(splitMessage[8]==5){
                                $('.operation_'+splitMessage[6]).val('5');
                            }
                            
                         
                        }
                    }
                    else
                    {
                        var splitMessage = message.split("(;;)");
                        if (splitMessage[6]=="null")
                        {
                            $('.personal-information-name').html("").append("<p>"+splitMessage[1]+" "+splitMessage[2]+"</p>");
                            $('.personal-information-time').html("").append("<p>"+splitMessage[3]+"</p>");
                            $('.personal-information-reasons').html("").append("<p>"+splitMessage[4]+"</p>");
                            $(".condition_55 option:first-child").attr("selected", "selected");
                            $(".condition_54 option:first-child").attr("selected", "selected");
                            $(".condition_53 option:first-child").attr("selected", "selected");
                            $(".condition_52 option:first-child").attr("selected", "selected");
                            $(".condition_51 option:first-child").attr("selected", "selected");
                            $(".condition_61 option:first-child").attr("selected", "selected");
                            $(".condition_62 option:first-child").attr("selected", "selected");
                            $(".condition_63 option:first-child").attr("selected", "selected");
                            $(".condition_64 option:first-child").attr("selected", "selected");
                            $(".condition_65 option:first-child").attr("selected", "selected");
                            $(".operation_55 option:first-child").attr("selected", "selected");
                            $(".operation_54 option:first-child").attr("selected", "selected");
                            $(".operation_53 option:first-child").attr("selected", "selected");
                            $(".operation_52 option:first-child").attr("selected", "selected");
                            $(".operation_51 option:first-child").attr("selected", "selected");
                            $(".operation_61 option:first-child").attr("selected", "selected");
                            $(".operation_62 option:first-child").attr("selected", "selected");
                            $(".operation_63 option:first-child").attr("selected", "selected");
                            $(".operation_64 option:first-child").attr("selected", "selected");
                            $(".operation_65 option:first-child").attr("selected", "selected");
                            $('.dental-button-container').html("").append("<button type='button' class='btn btn-primary add-dental-record-button' id='add-dental-record-button'>Submit</button>");
                        }
                    }
                    $('#create-dental-record-modal').modal();
                    return false;
                }
            });
        }
    }); 
        
    $(document).on('click', '.dental-button-container #add-dental-record-button', function(){ 
        if ($( '.condition_55' ).val() 
            || $('.condition_54').val() 
            || $('.condition_53').val() 
            || $('.condition_52').val() 
            || $('.condition_51').val() 
            || $('.condition_61').val() 
            || $('.condition_62').val() 
            || $('.condition_63').val() 
            || $('.condition_64').val() 
            || $('.condition_65').val() 
            || $('.operation_55').val() 
            || $('.operation_54').val() 
            || $('.operation_53').val() 
            || $('.operation_52').val() 
            || $('.operation_51').val() 
            || $('.operation_61').val() 
            || $('.operation_62').val() 
            || $('.operation_63').val() 
            || $('.operation_64').val() 
            || $('.operation_65').val()){
            var patient_id = create_record_patient_id;
            var appointment_id_fin = appointment_id;
            var condition_55 = $('.condition_55').val(); 
            var condition_54 = $('.condition_54').val(); 
            var condition_53 = $('.condition_53').val();
            var condition_52 = $('.condition_52').val();
            var condition_51 = $('.condition_51').val(); 
            var condition_61 = $('.condition_61').val(); 
            var condition_62 = $('.condition_62').val();
            var condition_63 = $('.condition_63').val(); 
            var condition_64 = $('.condition_64').val();
            var condition_65 = $('.condition_65').val(); 
            var operation_55 = $('.operation_55').val(); 
            var operation_54 = $('.operation_54').val(); 
            var operation_53 = $('.operation_53').val(); 
            var operation_52 = $('.operation_52').val(); 
            var operation_51 = $('.operation_51').val(); 
            var operation_61 = $('.operation_61').val();
            var operation_62 = $('.operation_62').val(); 
            var operation_63 = $('.operation_63').val(); 
            var operation_64 = $('.operation_64').val(); 
            var operation_65 = $('.operation_65').val();
            $.ajax({
                type: "POST",
                url: "add-dental-record-modal.php",
                async: true,
                data: 
                {   'create_record_patient_id':patient_id,
                    'appointment_id':appointment_id_fin,
                    'condition_55':condition_55,
                    'condition_54':condition_54,
                    'condition_53':condition_53,
                    'condition_52':condition_52,
                    'condition_51':condition_51,
                    'condition_61':condition_61,
                    'condition_62':condition_62,
                    'condition_63':condition_63,
                    'condition_64':condition_64,
                    'condition_65':condition_65,
                    'operation_55':operation_55,
                    'operation_54':operation_54,
                    'operation_53':operation_53,
                    'operation_52':operation_52,
                    'operation_51':operation_51,
                    'operation_61':operation_61,
                    'operation_62':operation_62,
                    'operation_63':operation_63,
                    'operation_64':operation_64,
                    'operation_65':operation_65,
                },
                success: function(response)
                {
                    message = JSON.parse(response);
                    console.log(message);
                    if(message==1){
                        console.log("Success!");
                        $('#'+removeDentalRow).parents('tr').remove();
                        $('#create-dental-record-modal').modal("hide");

                    }  
                }
            });
        }
        return false;
    });

    $(document).on('click', '.dental-button-container #update-dental-record-button', function(){ 
        if ($( '.condition_55' ).val() 
            || $('.condition_54').val() 
            || $('.condition_53').val() 
            || $('.condition_52').val() 
            || $('.condition_51').val() 
            || $('.condition_61').val() 
            || $('.condition_62').val() 
            || $('.condition_63').val() 
            || $('.condition_64').val() 
            || $('.condition_65').val() 
            || $('.operation_55').val() 
            || $('.operation_54').val() 
            || $('.operation_53').val() 
            || $('.operation_52').val() 
            || $('.operation_51').val() 
            || $('.operation_61').val() 
            || $('.operation_62').val() 
            || $('.operation_63').val() 
            || $('.operation_64').val() 
            || $('.operation_65').val()){
            var patient_id = create_record_patient_id;
            var appointment_id_fin = appointment_id;
            var condition_55 = $('.condition_55').val(); 
            var condition_54 = $('.condition_54').val(); 
            var condition_53 = $('.condition_53').val();
            var condition_52 = $('.condition_52').val();
            var condition_51 = $('.condition_51').val(); 
            var condition_61 = $('.condition_61').val(); 
            var condition_62 = $('.condition_62').val();
            var condition_63 = $('.condition_63').val(); 
            var condition_64 = $('.condition_64').val();
            var condition_65 = $('.condition_65').val(); 
            var operation_55 = $('.operation_55').val(); 
            var operation_54 = $('.operation_54').val(); 
            var operation_53 = $('.operation_53').val(); 
            var operation_52 = $('.operation_52').val(); 
            var operation_51 = $('.operation_51').val(); 
            var operation_61 = $('.operation_61').val();
            var operation_62 = $('.operation_62').val(); 
            var operation_63 = $('.operation_63').val(); 
            var operation_64 = $('.operation_64').val(); 
            var operation_65 = $('.operation_65').val();
            $.ajax({
                type: "POST",
                url: "update-dental-record-modal.php",
                async: true,
                data: 
                {   'create_record_patient_id':patient_id,
                    'appointment_id':appointment_id_fin,
                    'condition_55':condition_55,
                    'condition_54':condition_54,
                    'condition_53':condition_53,
                    'condition_52':condition_52,
                    'condition_51':condition_51,
                    'condition_61':condition_61,
                    'condition_62':condition_62,
                    'condition_63':condition_63,
                    'condition_64':condition_64,
                    'condition_65':condition_65,
                    'operation_55':operation_55,
                    'operation_54':operation_54,
                    'operation_53':operation_53,
                    'operation_52':operation_52,
                    'operation_51':operation_51,
                    'operation_61':operation_61,
                    'operation_62':operation_62,
                    'operation_63':operation_63,
                    'operation_64':operation_64,
                    'operation_65':operation_65,
                },
                success: function(response)
                {
                    message = JSON.parse(response);
                    console.log(message);
                    if(message==1){
                        console.log("Success!");
                        $('#'+removeDentalRow).parents('tr').remove();
                         $('#create-dental-record-modal').modal("hide");

                    }  
                }
            });
        }
        return false;
    });

	$('.appointments_prescription').click(function(){
		var id = $(this).attr('id').split("_");
		console.log(id[1]);
		$.ajax({
			type: "POST",
			url: "appointments-detailed-info-for-patient-medical.php",
			async: true,
            data:{
            	'appointment_id': id[1]
            },
            success: function(response){
            	message = JSON.parse(response).split(";");
            	console.log(message);
            	var remark = message[0];
            	var date = message[1];
            	$('#remarkModal').html(remark);
            	$('#remarkModalFooter').html('Last modified: ' + date);
            }
		});
		$('#prescriptionModal').modal();
	});
	// $('#dashboardNav').click(function(){
 //        $('#patientDashboard').show();
 //        $('#patientHistory').hide();
 //        $('#patientProfile').hide();
 //        $(this).attr('class', 'active');
 //        $('#profileNav').removeAttr('class');
 //        $('#visitHistory').removeAttr('class');
 //    });
	// $('#profileNav').click(function(){
	// 	$('#patientHistory').hide();
 //        $('#patientDashboard').hide();
 //        $('#patientProfile').show();
	// 	$(this).attr('class', 'active');
	// 	$('#dashboardNav').removeAttr('class');
 //        $('#visitHistory').removeAttr('class');
	// });
 //    $('#visitHistory').click(function(){
 //        $('#patientHistory').show();
 //        $('#patientDashboard').hide();
 //        $('#patientProfile').hide();
 //        $(this).attr('class', 'active');
 //        $('#dashboardNav').removeAttr('class');
 //        $('#profileNav').removeAttr('class');
 //    });

	//SEARCH PATIENT STAFF ACCOUNT //
	$('#searchPatient').keyup(function() {
		// $('#searchResults').load(location.href + " #searchResults");
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
					// patientId=[];
					if(message=='null'){
						$('#searchResults').html("");
						$('#searchTable').hide();
					}
					else{
						for(i=0; i<message.length; i++) {
		                	messageSplit = message[i].split("(;;)");
		                	output += "<tr><td><a class='searchQueryResults' id='resultId_"+messageSplit[0]+"'>"+messageSplit[1]+"</a></td></tr>";
		                	// patientId.push(messageSplit[0]);

		                }
		                $('#searchResults').html(output);
		                $('#searchTable').show();
		                // console.log(patientId);
		                $('.searchQueryResults').click(function() {
		                	// console.log($(this).attr('id'));
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
									// message=obj.toArray();
									// console.log(message.first_name);
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
	$('#addNewMedicalRecordNoAppointment').click(function(){
		console.log($('#addNewMedicalRecordNoAppointmentForm').find("textarea"));
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
		$.ajax({
                type: "POST",
                url: "add-medical-record-modal.php",
                async: true,
                data: 
                {   'create_record_patient_id':$('#patient_id').val(),
                    'appointment_id':'none',
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
                },
                success: function(response)
                {
                	$('#physicalexamination').find("input").attr('disabled', 'disabled');
					$('#laboratoryresult1').find("input").attr('disabled', 'disabled');
					$('#remarksDiv1').find("textarea").attr('disabled', 'disabled');
					$('#prescriptionDiv1').find("textarea").attr('disabled', 'disabled');
					$(this).attr('disabled', 'disabled');
					// $('#addNewRecordSucessMessage').modal();
                }
            });
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
	
    

        // MEDICAL STAFF PAGE ----------------------
        // $('.medicalStaffImg').click(function(){
        //     $(this).parents('.staffInfoDiv').append('<div class="row"><p class="col-md-12">Hello</p></div>');
        // });
});