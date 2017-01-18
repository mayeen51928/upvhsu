$(document).ready( function(){
// ----------------------------- Dashboard -----------------------------
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
    // console.log(numOfClicksMedical_Diagnosis);
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

$('.addDentalRecordButton').click(function() {
  // e.preventDefault();
  // e.stopImmediatePropagation();
  appointmentId = $(this).attr('id');
  $.ajax({
          type: "POST",
          url: addDentalRecord,
          data: {appointment_id:  appointmentId, _token: token},
          success: function(data)
          {
            $('.personal-information-name').html("").append("<p>"+data['dental_appointment_info']['patient_first_name']+" "+data['dental_appointment_info']['patient_last_name']+"</p>");
            $('.personal-information-time').html("").append("<p>"+data['dental_appointment_info']['schedule_start']+"-"+data['dental_appointment_info']['schedule_end']+"</p>");
            $('.personal-information-reasons').html("").append("<p>"+data['dental_appointment_info']['reasons']+"</p>");
            $('#create-dental-record-modal').modal();
            console.log("Clicked add dental diagnosis button!");
          }
  });
  return false;
});

$('.dental-chart').click(function() {
  // e.preventDefault();
  // e.stopImmediatePropagation();
  var teethId = $(this).attr('id');
  $.ajax({
          type: "POST",
          url: addDentalRecordPerTeeth,
          data: {teeth_id:  teethId, appointment_id: appointmentId, _token: token},
          success: function(data)
          {
            $('#create-dental-record-per-tooth-modal').modal();
            console.log("Clicked dental chart button!");
            $('#updateDentalRecord').click(function(e) {
              e.preventDefault();
              e.stopImmediatePropagation();
              var condition_id = $('.condition').val();
              var operation_id = $('.operation').val();
              $.ajax({
                      type: "POST",
                      url: updateDentalRecord,
                      data: {appointment_id:  appointmentId, teeth_id:  teethId, condition_id: condition_id, operation_id: operation_id, _token: token},
                      success: function(data)
                      {
                         $('#create-dental-record-per-tooth-modal').hide();
                         console.log("Clicked update dental record button!");
                      }
              });
              return false;
            });
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
});