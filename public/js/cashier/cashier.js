$(document).ready( function(){
// ------------------DASHBOARD---------------
	$('.addMedicalBilling').click(function(){
		buttonIdMedical = $(this).attr('id');
		var id = ($(this).attr('id').split('_'));
		appointmentIdMedical = id[3];
		amountMedical = id[4];
		$.ajax({
				type: "POST",
				url: displayMedicalBilling,
				data: {appointment_id:  appointmentIdMedical, _token: token},
				success: function(data)
				{
					$('#display_amount_modal_medical').val(amountMedical);
					output = '';
					output += "<tr><th>Service Description</th><th>Service Rate</td><th>Type</th><th></th></tr>"
					for(var i=0; i < data['display_medical_billing'].length; i++)
					{
						output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].service_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
					}
					$('#displayMedicalBillingModal').html(output);
					$('#displayMedicalBillingTableModal').show();
					$('#confirm_medical_billing').modal();
					
				}
		});     
	});
	$('#addMedicalBillingButton').click(function(){
		$.ajax({
					type: "POST",
					url: confirmMedicalBilling,
					data: {appointment_id:  appointmentIdMedical, _token: token},
					success: function(data)
					{
						$("#add_medical_billing_tr_"+appointmentIdMedical).remove();
						medicalVal = $('#receivable_medical').val() - amountMedical;
						$('#receivable_medical').val(medicalVal.toFixed(2));
						$('#confirm_medical_billing').modal('hide');	
					}
		});
	});   
	$('.addDentalBilling').click(function(){
		buttonIdDental = $(this).attr('id');
		var id = ($(this).attr('id').split('_'));
		appointmentIdDental = id[3];
		amountDental = id[4];
		$.ajax({
				type: "POST",
				url: displayDentalBilling,
				data: {appointment_id:  appointmentIdDental, _token: token},
				success: function(data)
				{
					$('#display_amount_modal_dental').val(amountDental);
					output = '';
					output += "<tr><th>Service Description</th><th>Service Rate</td><th></th></tr>"
					for(var i=0; i < data['display_dental_billing'].length; i++)
					{
						output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].service_rate+"</td></tr>";
					}
					$('#displayDentalBillingModal').html(output);
					$('#displayDentalBillingTableModal').show();
					$('#confirm_dental_billing').modal();
				}
		});     
	});

	$('#addDentalBillingButton').click(function(){
		$.ajax({
					type: "POST",
					url: confirmDentalBilling,
					data: {appointment_id:  appointmentIdDental, _token: token},
					success: function(data)
					{
						$("#add_dental_billing_tr_"+appointmentIdDental).remove();
						dentalVal = $('#receivable_dental').val() - amountDental;
						$('#receivable_dental').val(dentalVal.toFixed(2));
						$('#confirm_dental_billing').modal('hide');	
					}
		});
	});   
//-----------PROFILE---------------
// ------------------SEARCH PATIENT---------------

});

	 