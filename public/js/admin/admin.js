$(document).ready( function(){
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});
	//--------------------------DASHBOARD----------------------------
	//
	if($('#admingraphtrigger').val()==1)
	{
		var newDate = Date.now() + -3*24*3600*1000; // date 3 days ago in milliseconds UTC
		startpoint = new Date(newDate); // or .toISOString(), BUT NOT toString
		$.post('/admingraphdata', {
			year: startpoint.getFullYear(),
			month: startpoint.getMonth()+1,
			date: startpoint.getDate()
		},
		function(data, textStatus, xhr) {
			Highcharts.chart('admingraph', {
				title: {
					text: 'Overview of Requests/Appointments'
				},
				subtitle: {
					text: 'Based on dental and medical appointments, laboratory and x-ray requests'
				},
				xAxis: {
					type: 'datetime'
				},
				yAxis: {
					title: {
						text: 'Number of Requests/Appointments'
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},
				plotOptions: {
					series: {
						pointStart: Date.UTC(startpoint.getFullYear(), startpoint.getMonth(), startpoint.getDate()),
						pointInterval: 24 * 3600 * 1000 // one day
					}
				},
				series: [{
					name: 'Dental Appointments',
					data: [data['dental_appointment_count'][0], data['dental_appointment_count'][1], data['dental_appointment_count'][2], data['dental_appointment_count'][3], data['dental_appointment_count'][4], data['dental_appointment_count'][5], data['dental_appointment_count'][6]]
				},{
					name: 'Medical Appointments',
					data: [data['medical_appointment_count'][0], data['medical_appointment_count'][1], data['medical_appointment_count'][2], data['medical_appointment_count'][3], data['medical_appointment_count'][4], data['medical_appointment_count'][5], data['medical_appointment_count'][6]]
				}, {
					name: 'CBC',
					data: [data['cbc_request_count'][0], data['cbc_request_count'][1], data['cbc_request_count'][2], data['cbc_request_count'][3], data['cbc_request_count'][4], data['cbc_request_count'][5], data['cbc_request_count'][6]]
				}, {
					name: 'Fecalysis',
					data: [data['fecalysis_request_count'][0], data['fecalysis_request_count'][1], data['fecalysis_request_count'][2], data['fecalysis_request_count'][3], data['fecalysis_request_count'][4], data['fecalysis_request_count'][5], data['fecalysis_request_count'][6]]
				}, {
					name: 'Drug Test',
					data: [data['drug_test_request_count'][0], data['drug_test_request_count'][1], data['drug_test_request_count'][2], data['drug_test_request_count'][3], data['drug_test_request_count'][4], data['drug_test_request_count'][5], data['drug_test_request_count'][6]]
				}, {
					name: 'Urinalysis',
					data: [data['urinalysis_request_count'][0], data['urinalysis_request_count'][1], data['urinalysis_request_count'][2], data['urinalysis_request_count'][3], data['urinalysis_request_count'][4], data['urinalysis_request_count'][5], data['urinalysis_request_count'][6]]
				}, {
					name: 'Chest X-Ray',
					data: [data['chest_xray_request_count'][0], data['chest_xray_request_count'][1], data['chest_xray_request_count'][2], data['chest_xray_request_count'][3], data['chest_xray_request_count'][4], data['chest_xray_request_count'][5], data['chest_xray_request_count'][6]]
				}]
			});
		});
		$('.highcharts-container').css('height', '405px');
	}
	$("#typeOfPatientMedical").change(function(){
		var patientTypeId = $(this).find(':selected')[0].value;
		$.ajax({
			type: "POST",
			url: displayMedicalServices,
			data: {patient_type_id:  patientTypeId, _token: token},
			success: function(data)
			{
				output = ' ';
				if (data['counter']==0) {
					output += "<tr><td><b>No results found.</b></td><td></td><td></td></tr>"
					output += '<tr><td></td><td></td><td><span style="float: right"><button id="editMedicalServicesButton_'+patientTypeId+'" type="button" class="btn btn-success editMedicalServicesButton" data-toggle="modal">Add Record</button></span></td></tr>';
				}
				else{
					output += '<tr><th>Service Description</th><th>Service Rate</td><th>Type</th></tr>'
					for(var i=0; i < data['display_medical_services'].length; i++)
					{
						output += "<tr><td>"+data['display_medical_services'][i].service_description+"</td><td>"+data['display_medical_services'][i].service_rate+"</td><td>"+data['display_medical_services'][i].service_type+"</td></tr>";
					}
					output += '<tr><td></td><td></td><td><span style="float: right"><button id="editMedicalServicesButton_'+patientTypeId+'" type="button" class="btn btn-success editMedicalServicesButton" data-toggle="modal">Add/Edit Record</button></span></td></tr>';
				}
				$('#displayMedicalServices').html(output);
				$('#displayMedicalServicesTable').show();

				$(".editMedicalServicesButton").click(function(){
					var id = $(this).attr('id').split("_");
					var patientTypeId = id[1];
					$.ajax({
							type: "POST",
							url: editMedicalServices,
							data: {patient_type_id:  patientTypeId, _token: token},
							success: function(data)
							{
								output = ' ';
								footer = ' ';
								output += "<tr><th>Service Description</th><th>Service Rate</td><th>Type</th><th></th></tr>"
								for(var i=0; i < data['display_medical_services'].length; i++)
								{
									if(data['display_medical_services'][i].service_type == 'medical'){selectType = "<select class='form-control medical_services_type'><option value='medical' selected>medical</option><option value='xray'>xray</option><option value='cbc'>cbc</option><option value='drugtest'>drug test</option><option value='fecalysis'>fecalysis</option><option value='urinalysis'>urinalysis</option></select>";};
									if(data['display_medical_services'][i].service_type == 'xray'){selectType = "<select class='form-control medical_services_type'><option value='medical' >medical</option><option value='xray' selected>xray</option><option value='cbc'>cbc</option><option value='drugtest'>drug test</option><option value='fecalysis'>fecalysis</option><option value='urinalysis'>urinalysis</option></select>";};
									if(data['display_medical_services'][i].service_type == 'cbc'){selectType = "<select class='form-control medical_services_type'><option value='medical' >medical</option><option value='xray'>xray</option><option value='cbc' selected>cbc</option><option value='drugtest'>drug test</option><option value='fecalysis'>fecalysis</option><option value='urinalysis'>urinalysis</option></select>";};
									if(data['display_medical_services'][i].service_type == 'drugtest'){selectType = "<select class='form-control medical_services_type'><option value='medical' >medical</option><option value='xray'>xray</option><option value='cbc'>cbc</option><option value='drugtest' selected>drug test</option><option value='fecalysis'>fecalysis</option><option value='urinalysis'>urinalysis</option></select>";};
									if(data['display_medical_services'][i].service_type == 'fecalysis'){selectType = "<select class='form-control medical_services_type'><option value='medical' >medical</option><option value='xray'>xray</option><option value='cbc'>cbc</option><option value='drugtest'>drug test</option><option value='fecalysis' selected>fecalysis</option><option value='urinalysis'>urinalysis</option></select>";};
									if(data['display_medical_services'][i].service_type == 'urinalysis'){selectType = "<select class='form-control medical_services_type'><option value='medical' >medical</option><option value='xray'>xray</option><option value='cbc'>cbc</option><option value='drugtest'>drug test</option><option value='fecalysis'>fecalysis</option><option value='urinalysis' selected>urinalysis</option></select>";};
									output += "<tr class='medical_services_tr'><td><input type='text' class='form-control medical_services_description' value='"+data['display_medical_services'][i].service_description+"'></td><td><input type='text' class='form-control medical_services_rate' value='"+data['display_medical_services'][i].service_rate+"'></td><td>"+selectType+"</td><td><button class='btn btn-danger btn-sm removemedicalservice'>x</button></td></tr>";
								}
								footer += '<button type="button" class="btn btn-danger" data-dismiss="modal">Back</button><button type="button" class="btn btn-success" id="editMedicalServicesModal">Save Changes</button>';
								$('#savechangesbuttonmedical').html(footer);
								$('#displayMedicalServicesModal').html(output);
								$('#displayMedicalServicesTableModal').show();
								setTimeout(function(){
									$('#editMedicalServices').modal();
								},3000)

								$(".removemedicalservice").click(function(){
									$(this).closest('tr').remove();
								}); 

								$("#editMedicalServicesModal").click(function(){
									var medicalservices = [];
									console.log("Patient type "+patientTypeId);
									$('.medical_services_tr').each(function(){
										if($(this).find('.medical_services_description').val() && $(this).find('.medical_services_rate').val() && $(this).find('.medical_services_type').val()){
											medicalservices.push($(this).find('.medical_services_description').val() + '(:::)' + $(this).find('.medical_services_rate').val() + '(:::)' + $(this).find('.medical_services_type').val());
										}
									});
									if(medicalservices.length > 0){
										$.ajax({
											url: updateMedicalServices,
											type: 'POST',
											dataType: 'json',
											data: {medical_services:medicalservices, patient_type_id:patientTypeId,  _token: token},
											success: function(data) {
												$("#typeOfPatientMedical").val($("#typeOfPatientMedical option:first").val());
												$('#displayMedicalServices').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Successful!</div>');
												$('#editMedicalServices').modal('hide');
											},
											error: function(xhr, textStatus, errorThrown) {
											}
										});
									}
								});
							}
					});
				});
			}
		})
	});

	$('.addmoremedicalservices').click(function(){
		$(this).parents('.dental_manage').find('tbody').append("<tr class='medical_services_tr'><td><input type='text' class='form-control medical_services_description'></td><td><input type='text' class='form-control medical_services_rate'></td><td><select class='form-control medical_services_type'><option selected disabled>-- type --</option><option value='medical'>medical</option><option value='xray'>xray</option><option value='cbc'>cbc</option><option value='drugtest'>drug test</option><option value='fecalysis'>fecalysis</option><option value='urinalysis'>urinalysis</option></select></td><td><button class='btn btn-danger btn-sm removemedicalservice'>x</button></td></tr>");
		$('.removemedicalservice').click(function(){
			$(this).closest('tr').remove();
		});
	});

	

	

	$("#typeOfPatientDental").change(function(){
		var patientTypeId = $(this).find(':selected')[0].value;
		console.log(patientTypeId);
		$.ajax({
			type: "POST",
			url: displayDentalServices,
			data: {patient_type_id:  patientTypeId, _token: token},
			success: function(data)
			{
			}
		});
	});
})

