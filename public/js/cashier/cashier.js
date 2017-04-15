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
					var total = 0;
					$('#display_amount_modal_medical').val(amountMedical);
					output = '';
					output += "<tr><th>Service Description</th><th>Service Rate</td><th>Type</th></tr>"
					if(data['patient_type_checker'] == 1 || data['patient_type_checker'] == 2 || data['patient_type_checker'] == 3 || data['patient_type_checker'] == 4 || data['patient_type_checker'] == 5){
						for(var i=0; i < data['display_medical_billing'].length; i++)
						{
							if(data['patient_type_checker'] == 1){
								console.log("student");
								output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].student_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
								total += parseFloat(data['display_medical_billing'][i].student_rate);	
							}
							else if(data['patient_type_checker'] == 5){
								console.log("opd");
								output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].opd_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
								total += parseFloat(data['display_medical_billing'][i].opd_rate);
							}
							else{
								console.log("faculty");
								output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].faculty_staff_dependent_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
								total += parseFloat(data['display_medical_billing'][i].faculty_staff_dependent_rate);
							}
						}
					}
					else{
						for(var i=0; i < data['display_medical_billing'].length; i++)
						{
							output += "<tr><td>"+data['display_medical_billing'][i].service_description+"</td><td>"+data['display_medical_billing'][i].senior_rate+"</td><td>"+data['display_medical_billing'][i].service_type+"</td></tr>";
							total += parseFloat(data['display_medical_billing'][i].senior_rate);
						}
					}
					$('#displayMedicalBillingModal').html(output);
					$('#displayMedicalBillingTableModal').show();
					$('#confirm_medical_billing').modal();
					$('#printMedicalReceiptButton').click(function(){
						var x = window.open();
						x.document.open;
						x.document.write('');
				    x.document.write('<html><head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">></script><script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script></head>');
				   	x.document.write('<center><img src="/images/upvweb_logo.png"  alt="Infirmary Logo"/>');
				  	x.document.write('<b><h4>University of the Phillipines Visayas</h4></b><h5>Miagao, Iloilo 5023</h5><h5>Telephone Number : 236-789</h5><br><h1>PATIENT BILL</h1><br></center>');
				    x.document.write('<h4>Patient: <b>'+data['medical_receipt']['patient_first_name']+'&nbsp;'+data['medical_receipt']['patient_last_name']+'</b></h4>');
				    x.document.write('<h4>Doctor: <b>'+data['medical_receipt']['staff_first_name']+'&nbsp;'+data['medical_receipt']['staff_last_name']+'</b></h4>');
				    x.document.write('<h5>Date of Consultation <b>'+data['medical_receipt']['schedule_day']+'</b></h5>')
				    x.document.write('<div class="container"><table class="table table-bordered"><tbody>'+output+'</tbody></table></div><br><br>');
				  	x.document.write('<h4 style="text-align:right;">Total Amount: <b>Php '+total+'</b></h4>');
				    x.document.write('<script>setTimeout(function(){window.print();},500);</script></body></html>');
					});
					
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
							$('#medical_billing_past').hide();
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
					var total = 0;
					console.log(data['patient_type_checker']);
					$('#display_amount_modal_dental').val(amountDental);
					output = '';
					output += "<tr><th>Service Description</th><th>Service Rate</td></tr>"
					if(data['patient_type_checker'] == 1 || data['patient_type_checker'] == 2 || data['patient_type_checker'] == 3 || data['patient_type_checker'] == 4 || data['patient_type_checker'] == 5){
						for(var i=0; i < data['display_dental_billing'].length; i++)
						{
							if(data['patient_type_checker'] == 1){
								output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].student_rate+"</td></tr>";
								total += parseFloat(data['display_dental_billing'][i].student_rate);
							}
							else if(data['patient_type_checker'] == 5){
								output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].opd_rate+"</td></tr>";
								total += parseFloat(data['display_dental_billing'][i].opd_rate);
							}
							else{
								output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].faculty_staff_dependent_rate+"</td></tr>";
								total += parseFloat(data['display_dental_billing'][i].faculty_staff_dependent_rate);
							}
						}
					}
					else{
						for(var i=0; i < data['display_dental_billing'].length; i++)
						{
							output += "<tr><td>"+data['display_dental_billing'][i].service_description+"</td><td>"+data['display_dental_billing'][i].senior_rate+"</td></tr>";
							total += parseFloat(data['display_dental_billing'][i].senior_rate);
						}
					}
					$('#displayDentalBillingModal').html(output);
					$('#displayDentalBillingTableModal').show();
					$('#confirm_dental_billing').modal();

					$('#printDentalReceiptButton').click(function(){
						var x = window.open();
						x.document.open;
						x.document.write('');
				    x.document.write('<html><head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">></script><script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script></head>');
				   	x.document.write('<center><img src="/images/upvweb_logo.png"  alt="Infirmary Logo"/>');
				  	x.document.write('<b><h4>University of the Phillipines Visayas</h4></b><h5>Miagao, Iloilo 5023</h5><h5>Telephone Number : 236-789</h5><br><h1>PATIENT BILL</h1><br></center>');
				    x.document.write('<h4>Patient: <b>'+data['dental_receipt']['patient_first_name']+'&nbsp;'+data['dental_receipt']['patient_last_name']+'</b></h4>');
				    x.document.write('<h4>Doctor: <b>'+data['dental_receipt']['staff_first_name']+'&nbsp;'+data['dental_receipt']['staff_last_name']+'</b></h4>');
				    x.document.write('<h5>Date of Consultation <b>'+data['dental_receipt']['schedule_start']+' - '+data['dental_receipt']['schedule_end']+'</b></h5><br>')
				    x.document.write('<div class="container"><table class="table table-bordered"><tbody>'+output+'</tbody></table></div><br><br>');
				  	x.document.write('<h4 style="text-align:right;">Total Amount: <b>Php '+total+'</b></h4>');
				    x.document.write('<script>setTimeout(function(){window.print();},500);</script></body></html>');
					});
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
						if(dentalVal == 0){
							$('#receivable_dental').html('');
							$('#dental_billing_past').hide();
						}
						else{
							$('#receivable_dental').html(dentalVal.toFixed(2));
						}
						$('#confirm_dental_billing').modal('hide');	
					}
		});
	});   
//-----------PROFILE---------------
// ------------------SEARCH PATIENT---------------

});

	 