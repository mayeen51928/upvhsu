$(document).ready( function(){

  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  // -----------------SCEDULE APPOINTMENT (NOT LOGGED IN)---------------------

  numOfClicksMedical = 0;
  numOfClicksDental = 0;
  percentageDental = 0;
  percentageMedical = 0

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

  $("#selectdentaldate").change(function() {
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
              $('#selectdentaltime').html("").append("<option disabled selected> -- select date of appointment -- </option>");
              for(var i=0; i < data['start'].length; i++) {
                $('#selectdentaltime').append("<option id="+data['id'][i]+">"+data['staff'][i]+" "+data['start'][i]+" - "+data['end'][i]+"</option>");
              }
          }
      });
  });

  $("#selectmedicaldate").change(function() {
      var medicalDate = $(this).find(':selected')[0].value;
      $.ajax({
          type: "POST",
          url: displayMedicalSchedule,
          data: {medical_date:  medicalDate, _token: token},
          success: function(data)
          {
              $('#selectmedicaldoctor').removeAttr('disabled');
              console.log(data["staff"]);
              $('#selectmedicaldoctor').html("").append("<option disabled selected> -- select date of appointment -- </option>");
              for(var i=0; i < data['staff'].length; i++) {
                $('#selectmedicaldoctor').append("<option id="+data['id'][i]+">"+data['staff'][i]+"</option>");
              }
          }
      });
  });

  $("#submitdentalappointment").click(function() {
    var scheduleID = $('#selectdentaltime').find(':selected')[0].id;
    console.log("Schedule ID is " + scheduleID);
<<<<<<< HEAD
=======
    $.post('/createappointment_dental',{reasons:$('#dentalNotes').val(), dental_schedule_id: scheduleID} , function(data){
      $('#dentalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
      $('#dentalNotes').attr("disabled", "disabled");
      $('#selDentalDate').attr("disabled", "disabled");
      $('#selDentalTime').attr("disabled", "disabled");
      $('#submitDentalAppointment').addClass("disabled");
      $('#dentalAppointmentPanelBody').css('background-color', '#d6e9c6');
      $('#submitdentalappointment').attr("disabled", "disabled");
    });
    // $.ajax({
    //     type: "POST",
    //     url: "schedule-dental-appointment.php",
    //     async: true,
    //     data: {'reasons':$('#dentalNotes').val(), 'day':inputDate, 'time': inputTime, 'staff_id':staffId},
    //     success: function(response)
    //     {
    //         message = JSON.parse(response);
    //     console.log(message);
    //         if(message==1){
    //             console.log("Success!");
    //             $('#dentalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
    //             $('#dentalNotes').attr("disabled", "disabled");
    //             $('#selDentalDate').attr("disabled", "disabled");
    //             $('#selDentalTime').attr("disabled", "disabled");
    //             $('#submitDentalAppointment').addClass("disabled");
    //             $('#dentalAppointmentPanelBody').css('background-color', '#d6e9c6');
    //         }
    //         else{
    //             $('#loginModalDental').modal();
    //         }            
    //     }
    // });
>>>>>>> 0f2f8a95bb388be73e732df8f4b0dcc3ff26f14d
  });

  $("#submitmedicalappointment").click(function() {
    var scheduleID = $('#selectmedicaldoctor').find(':selected')[0].id;
    console.log("Schedule ID is " + scheduleID);
    $.post('/createappointment_medical',{reasons:$('#medicalNotes').val(), medical_schedule_id: scheduleID} , function(data){
      $('#medicalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
      $('#medicalNotes').attr("disabled", "disabled");
      $('#selMedicalDate').attr("disabled", "disabled");
      $('#selMedicalDoctor').attr("disabled", "disabled");
      $('#submitMedicalAppointment').addClass("disabled");
      $('#medicalAppointmentPanelBody').css('background-color', '#d6e9c6');
      $("#submitmedicalappointment").attr('disabled','disabled');
    });
    // $.ajax({
    //     type: "POST",
    //     url: "schedule-medical-appointment.php",
    //     async: true,
    //     data: {'reasons':$('#medicalNotes').val(), 'day':inputDate, 'staff_id':staffId},
    //     success: function(response)
    //     {
    //         message = JSON.parse(response);
    //         console.log(message);
    //         if(message==1){
    //             console.log("Success!");
                // $('#medicalAppointment').removeClass("panel panel-default").addClass("panel panel-success");
                // $('#medicalNotes').attr("disabled", "disabled");
                // $('#selMedicalDate').attr("disabled", "disabled");
                // $('#selMedicalDoctor').attr("disabled", "disabled");
                // $('#submitMedicalAppointment').addClass("disabled");
                // $('#medicalAppointmentPanelBody').css('background-color', '#d6e9c6');
    //         }
    //         else{
    //             $('#loginMedicalModal').modal();
    //         }
            
            
    //     }
    // });
    
  });

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
              }
        });
  });    


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
})