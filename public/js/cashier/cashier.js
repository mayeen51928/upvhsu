$(document).ready( function(){
// ------------------DASHBOARD---------------
  $('.addMedicalBilling').click(function(){
    var id = ($(this).attr('id').split('_'));
    var appointmentId = id[3];
    console.log(appointmentId);
    $('#confirm_medical_billing').modal();
    $('#addMedicalBillingButton').click(function(){
        $.ajax({
            type: "POST",
            url: confirmMedicalBilling,
            data: {appointment_id:  appointmentId, _token: token},
            success: function(data)
            {
              $('#confirm_medical_billing').modal('hide');
            }
      });
    });        
  });

//-----------PROFILE---------------
// ------------------SEARCH PATIENT---------------

});

   