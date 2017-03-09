$(document).ready( function(){
// ------------------DASHBOARD---------------
  $('.addMedicalBilling').click(function(){
    var id = ($(this).attr('id').split('_'));
    var appointmentId = id[3];
    var amount = id[4];
    console.log(appointmentId);
    $.ajax({
        type: "POST",
        url: displayMedicalBilling,
        data: {appointment_id:  appointmentId, _token: token},
        success: function(data)
        {
          $('#display_amount_modal').val(amount);
          output = '';
          output += "<tr><th>Service Description</th><th>Service Rate</td><th>Type</th><th></th></tr>"
          for(var i=0; i < data['display_medical_billing'].length; i++)
          {
            output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].service_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
          }
          $('#displayMedicalBillingModal').html(output);
          $('#displayMedicalBillingTableModal').show();
          $('#confirm_medical_billing').modal();
          $('#addMedicalBillingButton').click(function(){
            $.ajax({
                  type: "POST",
                  url: confirmMedicalBilling,
                  data: {appointment_id:  appointmentId, _token: token},
                  success: function(data)
                  {
                    $('#confirm_medical_billing').modal('hide');
                    $('.addMedicalBilling').closest('tr').remove();
                  }
            });
          });   
        }
    });     
  });

//-----------PROFILE---------------
// ------------------SEARCH PATIENT---------------

});

   