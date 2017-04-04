$(document).ready( function(){
// ------------------DASHBOARD---------------
function cashierhighcharts(){
// 	Highcharts.setOptions({
//     colors: ['#058DC7', '#50B432', '#800000']
// });
	$.post('/appointmentstatus', {}, function(data, textStatus, xhr) {
		Highcharts.chart('cashierdashboard', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },

    title: {
        text: 'Status of Today\'s Appointments'
    },
    // subtitle: {
    //     text: '3D donut in Highcharts'
    // },
    plotOptions: {
        pie: {
            innerSize: 80,
            depth: 45
        }
    },
    series: [{
        name: 'Number of Appointments',
        data: [
            ['Billed/Unpaid', data['unpaid']],
            ['Unbilled', data['unbilled']],
            ['Paid', data['paid']]
        ]
    }]
});
	});
	

}
if($('#cashiergraphtrigger').val()==1)
{
	cashierhighcharts();
}
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
					if(data['patient_senior_checker'] == 1 || data['patient_senior_checker'] == 2 || data['patient_senior_checker'] == 3 || data['patient_senior_checker'] == 4 || data['patient_senior_checker'] == 5){
						for(var i=0; i < data['display_medical_billing'].length; i++)
						{
							if(data['patient_type_checker'] == 1){
								output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].student_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
							}
							if(data['patient_type_checker'] == 5){
								output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].opd_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
							}
							else{
								output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].faculty_staff_dependent_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
							}
						}
					}
					else{
						for(var i=0; i < data['display_medical_billing'].length; i++)
						{
							output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].senior_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
						}
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
						medicalVal = $('#receivable_medical').html() - amountMedical;
						if(medicalVal == 0){
							$('#receivable_medical').html('');
						}
						else{
							$('#receivable_medical').html(medicalVal.toFixed(2));
						}
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
					if(data['patient_type_checker'] == 1 || data['patient_type_checker'] == 2 || data['patient_type_checker'] == 3 || data['patient_type_checker'] == 4 || data['patient_type_checker'] == 5){
						for(var i=0; i < data['display_dental_billing'].length; i++)
						{
							if(data['patient_type_checker'] == 1){
								output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].student_rate+"</td></tr>";
							}
							if(data['patient_type_checker'] == 5){
								output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].opd_rate+"</td></tr>";
							}
							else{
								output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].faculty_staff_dependent_rate+"</td></tr>";
							}
						}
					}
					else{
						for(var i=0; i < data['display_dental_billing'].length; i++)
						{
							output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].senior_rate+"</td></tr>";
						}
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
						dentalVal = $('#receivable_dental').html() - amountDental;
						$('#receivable_dental').html(dentalVal.toFixed(2));
						$('#confirm_dental_billing').modal('hide');	
					}
		});
	});   
//-----------PROFILE---------------
// ------------------SEARCH PATIENT---------------

});

	 