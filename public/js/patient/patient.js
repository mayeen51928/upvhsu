$(document).ready( function(){
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

// ------------------DASHBOARD---------------
$('.dental_appointments_prescription').click(function(){
    var patientId = $(this).attr('id');
    console.log(patientId);
    $.ajax({
        type: "POST",
        url: viewDentalRecord,
        data: {patient_id:  patientId, _token: token},
        success: function(data)
        {
        //   console.log('#condition_'+teethId);
        //   if (conditionId == 1) {
        //     $('#condition_'+teethId).css({ fill: "#ff4000" });
        //   }
        //   else if (conditionId == 2) {
        //     $('#condition_'+teethId).css({ fill: "#ffff00" });
        //   }
        //   else if (conditionId == 3) {
        //     $('#condition_'+teethId).css({ fill: "#00ff00" });
        //   }
        //   else if (conditionId == 4) {
        //     $('#condition_'+teethId).css({ fill: "#00ffff" });
        //   }
        //   else if (conditionId == 5) {
        //     $('#condition_'+teethId).css({ fill: "#0000ff" });
        //   }
        //   else {
        //     $('#condition_'+teethId).css({ fill: "white" });
        //   }
          
        //   if (operationId == 1) {
        //     $('#operation_'+teethId).css({ fill: "#bf00ff" });
        //   }
        //   else if (operationId == 2) {
        //     $('#operation_'+teethId).css({ fill: "#ff0080" });
        //   }
        //   else if (operationId == 3) {
        //     $('#operation_'+teethId).css({ fill: "#ff0000" });
        //   }
        //   else if (operationId == 4) {
        //     $('#operation_'+teethId).css({ fill: "#808080" });
        //   }
        //   else if (operationId == 5) {
        //     $('#operation_'+teethId).css({ fill: "#194d19" });
        //   }
        //   else {
        //     $('#operation_'+teethId).css({ fill: "white" });
        //   };
        // $('#update-dental-record-modal').modal("hide");
        }
      });
});
$('.medical_appointments_prescription').click(function(){
    $('#remarkModal').html('');
    $('#remarkModalFooter').html('');
    var medical_appointment_id = $(this).attr('id').split("_")[1];
    $.post('/getremarkspatientdashboard', {medical_appointment_id: medical_appointment_id}, function(data, textStatus, xhr) {
        if(data['success']==1)
        {
            $('#remarkModal').html(data['prescription']);
            $('#remarkModalFooter').html('Added on: ' + data['date']);
        }
        $('#prescriptionModal').modal();
    });
    

});
// ------------------PROFILE---------------
// ------------------VISITS HISTORY---------------
// ------------------BILLING RECORDS---------------

});