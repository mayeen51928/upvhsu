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
		$.post('/display_medical_services',{
			service_type: service_type,
		}, function(data){
			output = ' ';
			if(data['display_medical_services']){
				for(var i=0; i < data['display_medical_services'].length; i++)
				{
					output += "<tr><td style='text-align:center;'>"+data['display_medical_services'][i].service_description+"</td></tr>";
				}
				output += '<tr><td><button id="editMedicalServicesButton_'+service_type+'" type="button" class="btn btn-success btn-block editMedicalServicesButton" data-toggle="modal">Add/Edit Record</button></td></tr>';
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
				$.post('/display_medical_services', {
					service_type: service_type,
				}, function(){
					output = ' ';
					footer = ' ';
					output += "<tr><th>Service Description</th><th>Student Rate</td><th>Faculty/Staff/Dependent Rate</th><th>OPD Rate</th><th>Senior Rate</th><th></th></tr>"
					for(var i=0; i < data['display_medical_services'].length; i++)
					{
						if(data['display_medical_services'][i].service_type == 'drugtest' || data['display_medical_services'][i].service_type == 'fecalysis' || data['display_medical_services'][i].service_type == 'urinalysis'){
							output += "<tr class='medical_services_tr'><td><input type='text' class='form-control medical_services_description' value='"+data['display_medical_services'][i].service_description+"'></td><td><input type='text' class='form-control student_rate' value='"+data['display_medical_services'][i].student_rate+"'></td><td><input type='text' class='form-control faculty_staff_dependent_rate' value='"+data['display_medical_services'][i].faculty_staff_dependent_rate+"'></td><td><input type='text' class='form-control opd_rate' value='"+data['display_medical_services'][i].opd_rate+"'></td><td><input type='text' class='form-control senior_rate' value='"+data['display_medical_services'][i].senior_rate+"'></td></tr>";
						}
						else{
							output += "<tr class='medical_services_tr'><td><input type='text' class='form-control medical_services_description' value='"+data['display_medical_services'][i].service_description+"'></td><td><input type='text' class='form-control student_rate' value='"+data['display_medical_services'][i].student_rate+"'></td><td><input type='text' class='form-control faculty_staff_dependent_rate' value='"+data['display_medical_services'][i].faculty_staff_dependent_rate+"'></td><td><input type='text' class='form-control opd_rate' value='"+data['display_medical_services'][i].opd_rate+"'></td><td><input type='text' class='form-control senior_rate' value='"+data['display_medical_services'][i].senior_rate+"'></td><td><button class='btn btn-danger btn-sm removemedicalservice'>x</button></td></tr>";
						}
					}
					footer += '<span style="float:left; color:red; display:none;" id="error_msg_medical"><b><i>Please fill all fields.</i></b></span><button type="button" class="btn btn-danger" data-dismiss="modal">Back</button><button type="button" class="btn btn-success" id="editMedicalServicesModal">Save Changes</button>';
					$('#savechangesbuttonmedical').html(footer);
					$('#displayMedicalServicesModal').html(output);
					$('#displayMedicalServicesTableModal').show();
					setTimeout(function(){
						$('#editMedicalServices').modal();
					},3000)

					$(".removemedicalservice").click(function(){
						$(this).closest('tr').remove();
					}); 

					$('.student_rate, .faculty_staff_dependent_rate, .opd_rate, .senior_rate').bind('keyup change', function() {
						if(!$.isNumeric($(this).val())){
							$(this).val('');
						}
						else{
							if($(this).val() < 0){
								$(this).val('');
							}
						}
					});

					$("#editMedicalServicesModal").click(function(){
						var medicalservices = [];
						var counter = 0;
						$('.medical_services_tr').each(function(){
							if($(this).find('.medical_services_description').val() && $(this).find('.student_rate').val() && $(this).find('.faculty_staff_dependent_rate').val() && $(this).find('.opd_rate').val() && $(this).find('.senior_rate').val()){
								medicalservices.push($(this).find('.medical_services_description').val() + '(:::)' + $(this).find('.student_rate').val() + '(:::)' + $(this).find('.faculty_staff_dependent_rate').val() + '(:::)' + $(this).find('.opd_rate').val() + '(:::)' + $(this).find('.senior_rate').val());
							}
							else{
								counter++;
							}
						})
						if(medicalservices.length > 0 && counter == 0){
							$.post('/update_medical_services', {
								medical_services: medicalservices,
								service_type: service_type,
							}, function(){
								$("#typeOfMedicalService").val($("#typeOfMedicalService option:first").val());
								$('#displayMedicalServices').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Successful!</div>');
								$('#editMedicalServices').modal('hide');
							});
						}
						else{
							$('#error_msg_medical').show();
						}
					});
				})
			});
		})
	});


	$(".editDentalServicesButton").click(function(){
		$.post('/edit_dental_services',
		{} , function(data){
				output = ' ';
				footer = ' ';
				output += "<tr><th>Service Description</th><th>Student Rate</td><th>Faculty/Staff/Dependent Rate</th><th>OPD Rate</th><th>Senior Rate</th><th></th></tr>"
				for(var i=0; i < data['display_dental_services'].length; i++)
				{
					output += "<tr class='dental_services_tr'><td><input type='text' class='form-control dental_services_description' value='"+data['display_dental_services'][i].service_description+"'></td><td><input type='text' class='form-control student_rate' value='"+data['display_dental_services'][i].student_rate+"'></td><td><input type='text' class='form-control faculty_staff_dependent_rate' value='"+data['display_dental_services'][i].faculty_staff_dependent_rate+"'></td><td><input type='text' class='form-control opd_rate' value='"+data['display_dental_services'][i].opd_rate+"'></td><td><input type='text' class='form-control senior_rate' value='"+data['display_dental_services'][i].senior_rate+"'></td><td><button class='btn btn-danger btn-sm removedentalservice'>x</button></td></tr>";
				}
				footer += '<span style="float:left; color:red; display:none;" id="error_msg_dental"><b><i>Please fill all fields.</i></b></span><button type="button" class="btn btn-danger" data-dismiss="modal">Back</button><button type="button" class="btn btn-success" id="editDentalServicesModal">Save Changes</button>';
				$('#savechangesbuttondental').html(footer);
				$('#displayDentalServicesModal').html(output);
				$('#displayDentalServicesTableModal').show();
				setTimeout(function(){
					$('#editDentalServices').modal();
				},3000)

				$(".removedentalservice").click(function(){
					$(this).closest('tr').remove();
				}); 

				$('.student_rate, .faculty_staff_dependent_rate, .opd_rate, .senior_rate').bind('keyup change', function() {
					if(!$.isNumeric($(this).val())){
						$(this).val('');
					}
					else{
						if($(this).val() < 0){
							$(this).val('');
						}
					}
				});

				$("#editDentalServicesModal").click(function(){
					var dentalservices = [];
					var counter = 0;
					$('.dental_services_tr').each(function(){
						if($(this).find('.dental_services_description').val() && $(this).find('.student_rate').val() && $(this).find('.faculty_staff_dependent_rate').val() && $(this).find('.opd_rate').val() && $(this).find('.senior_rate').val()){
							dentalservices.push($(this).find('.dental_services_description').val() + '(:::)' + $(this).find('.student_rate').val() + '(:::)' + $(this).find('.faculty_staff_dependent_rate').val() + '(:::)' + $(this).find('.opd_rate').val() + '(:::)' + $(this).find('.senior_rate').val());
						}
						else{
							counter++;
						}
					});
					if(dentalservices.length > 0 && counter == 0){
						$.post('/update_dental_services',
						{
							dental_services: dentalservices,
						} , function(data){
							$('#displayDentalServices').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Successful!</div>');
							$('#editDentalServices').modal('hide');
						});
					}
					else{
						$('#error_msg_dental').show();
					}
				});
			})
	});


	$('.addmoremedicalservices').click(function(){
		$(this).parents('.add-more-medical').find('tbody').append("<tr class='medical_services_tr'><td><input type='text' class='form-control medical_services_description'></td><td><input type='text' class='form-control student_rate'></td><td><input type='text' class='form-control faculty_staff_dependent_rate'></td><td><input type='text' class='form-control opd_rate'></td><td><input type='text' class='form-control senior_rate'></td><td><button class='btn btn-danger btn-sm removemedicalservice'>x</button></td></tr>");
		$('.removemedicalservice').click(function(){
			$(this).closest('tr').remove();
		});
	});

	$('.addmoredentalservices').click(function(){
		$(this).parents('.add-more-dental').find('tbody').append("<tr class='dental_services_tr'><td><input type='text' class='form-control dental_services_description'></td><td><input type='text' class='form-control student_rate'></td><td><input type='text' class='form-control faculty_staff_dependent_rate'></td><td><input type='text' class='form-control opd_rate'></td><td><input type='text' class='form-control senior_rate'></td><td><button class='btn btn-danger btn-sm removedentalservice'>x</button></td></tr>");
		$('.removedentalservice').click(function(){
			$(this).closest('tr').remove();
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
	$('.changepwbutton').click(function(event) {
		$('#changepwerrormessage').text('');
		var user_id = $(this).attr('id').split("_")[1];
		$('#changepwmodaluser').text(user_id);
		$('#changepwmodal input').val('');
		$('#changepwmodal').modal();
		$('#newpassword').bind('keyup change', function(){
			$('#changepwerrormessage').text('');
			if($(this).val() != $('#confirmnewpassword').val() && $('#confirmnewpassword').val()){
				$('#changepwerrormessage').text('Error! Passwords do not match.').css('color', 'red');
			}
			$('#confirmnewpassword').bind('keyup change', function(event) {
				$('#changepwerrormessage').text('');
				if($(this).val() != $('#newpassword').val()){
					$('#changepwerrormessage').text('Error! Passwords do not match.').css('color', 'red');
				}
				if($('#confirmnewpassword').val() && $('#newpassword').val() && $('#confirmnewpassword').val() == $('#newpassword').val()){
					$('#changepwerrormessage').text('Passwords match.').css('color', 'green');
				}
			});
		});
		$('#savepwbutton').click(function(event) {
		if($('#confirmnewpassword').val() && $('#newpassword').val() && $('#newpassword').val() == $('#confirmnewpassword').val()){
			$.post('/admin/changepassword', {user_id: user_id, password:$('#newpassword').val()}, function(data, textStatus, xhr) {
				if(data['success'] == 'yes'){
					$('#changepwmodal').modal('hide');
				}
			});
		}
		
		
	});
		
	});
	
});