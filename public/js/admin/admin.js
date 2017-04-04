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
	$("#typeOfMedicalService").change(function(){
		var service_type = $(this).find(':selected')[0].value;
		$.ajax({
			type: "POST",
			url: displayMedicalServices,
			data: {service_type:  service_type, _token: token},
			success: function(data)
			{
				output = ' ';
				if(data['display_medical_services']){
					for(var i=0; i < data['display_medical_services'].length; i++)
					{
						output += "<tr><td>"+data['display_medical_services'][i].service_description+"</td></tr>";
					}
					output += '<tr><td></td><td></td><td><span style="float: right"><button id="editMedicalServicesButton_'+service_type+'" type="button" class="btn btn-success editMedicalServicesButton" data-toggle="modal">Add/Edit Record</button></span></td></tr>';
				}
				$('#displayMedicalServices').html(output);
				$('#displayMedicalServicesTable').show();

				$(".editMedicalServicesButton").click(function(){
					var type = $(this).attr('id').split("_");
					var service_type = type[1];
					if(service_type == 'medical' || service_type == 'cbc' || service_type == 'xray'){
						$('.addmoremedicalservices').css('display','block');
					}
					else{
						$('.addmoremedicalservices').css('display','none');
					}
					$.ajax({
							type: "POST",
							url: editMedicalServices,
							data: {service_type:  service_type, _token: token},
							success: function(data)
							{
								output = ' ';
								footer = ' ';
								output += "<tr><th>Service Description</th><th>Student Rate</td><th>Faculty/Staff/Dependent Rate</th><th>OPD Rate</th><th>Senior Rate</th></tr>"
								for(var i=0; i < data['display_medical_services'].length; i++)
								{
									if(data['display_medical_services'][i].service_type == 'drugtest' || data['display_medical_services'][i].service_type == 'fecalysis' || data['display_medical_services'][i].service_type == 'urinalysis'){
										output += "<tr class='medical_services_tr'><td><input type='text' class='form-control medical_services_description' value='"+data['display_medical_services'][i].service_description+"'></td><td><input type='text' class='form-control student_rate' value='"+data['display_medical_services'][i].student_rate+"'></td><td><input type='text' class='form-control faculty_staff_dependent_rate' value='"+data['display_medical_services'][i].faculty_staff_dependent_rate+"'></td><td><input type='text' class='form-control opd_rate' value='"+data['display_medical_services'][i].opd_rate+"'></td><td><input type='text' class='form-control senior_rate' value='"+data['display_medical_services'][i].senior_rate+"'></td></tr>";
									}
									else{
										output += "<tr class='medical_services_tr'><td><input type='text' class='form-control medical_services_description' value='"+data['display_medical_services'][i].service_description+"'></td><td><input type='text' class='form-control student_rate' value='"+data['display_medical_services'][i].student_rate+"'></td><td><input type='text' class='form-control faculty_staff_dependent_rate' value='"+data['display_medical_services'][i].faculty_staff_dependent_rate+"'></td><td><input type='text' class='form-control opd_rate' value='"+data['display_medical_services'][i].opd_rate+"'></td><td><input type='text' class='form-control senior_rate' value='"+data['display_medical_services'][i].senior_rate+"'></td><td><button class='btn btn-danger btn-sm removemedicalservice'>x</button></td></tr>";
									}
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
									$('.medical_services_tr').each(function(){
										if($(this).find('.medical_services_description').val() && $(this).find('.student_rate').val() && $(this).find('.faculty_staff_dependent_rate').val() && $(this).find('.opd_rate').val() && $(this).find('.senior_rate').val()){
											medicalservices.push($(this).find('.medical_services_description').val() + '(:::)' + $(this).find('.student_rate').val() + '(:::)' + $(this).find('.faculty_staff_dependent_rate').val() + '(:::)' + $(this).find('.opd_rate').val() + '(:::)' + $(this).find('.senior_rate').val());
										}
									});
									if(medicalservices.length > 0){
										$.ajax({
											url: updateMedicalServices,
											type: 'POST',
											dataType: 'json',
											data: {medical_services:medicalservices, service_type:service_type,  _token: token},
											success: function(data) {
												$("#typeOfMedicalService").val($("#typeOfMedicalService option:first").val());
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
		$(this).parents('.add-more-medical').find('tbody').append("<tr class='medical_services_tr'><td><input type='text' class='form-control medical_services_description'></td><td><input type='text' class='form-control student_rate'></td><td><input type='text' class='form-control faculty_staff_dependent_rate'></td><td><input type='text' class='form-control opd_rate'></td><td><input type='text' class='form-control senior_rate'></td><td><button class='btn btn-danger btn-sm removemedicalservice'>x</button></td></tr>");
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
	$('#addapatientaccountpanel #user_name').keyup(function(event) {
		$.post('/admin/checkifuserexists', {user_name: $('#addapatientaccountpanel #user_name').val()}, function(data, textStatus, xhr) {
			if(data['already_exists'] == 'yes')
			{
				$('#addapatientaccountpanel #user_name').attr('data-toggle', 'tooltip');
				$('#addapatientaccountpanel #user_name').attr('title', 'User already exists!');
				$('#addapatientaccountpanel #user_name').tooltip('show');
				$('#addapatientaccountsubmit').attr('disabled', 'disabled');
			}
			else
			{
				$('#addapatientaccountpanel #user_name').tooltip('destroy');
				$('#addapatientaccountsubmit').removeAttr('disabled');
			}
		});
	});
	$('#staff_id').keyup(function(event) {
		$.post('/admin/checkifuserexists', {user_name: $('#staff_id').val()}, function(data, textStatus, xhr) {
			if(data['already_exists'] == 'yes')
			{
				$('#staff_id').attr('data-toggle', 'tooltip');
				$('#staff_id').attr('title', 'User already exists!');
				$('#staff_id').tooltip('show');
				$('#addstaffaccountsubmit').attr('disabled', 'disabled');
			}
			else
			{
				$('#staff_id').tooltip('destroy');
				$('#addstaffaccountsubmit').removeAttr('disabled');
			}
		});
	});
});