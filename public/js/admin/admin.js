$(document).ready( function(){
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});

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

	$("#about_medical").click(function(){
		$('#medicalServicesModal').modal();
	});

	$("#about_dental").click(function(){
		$('#dentalServicesModal').modal();
	});

	$("#about_lab").click(function(){
		$('#labServicesModal').modal();
	});

	$("#about_xray").click(function(){
		$('#xrayServicesModal').modal();
	});

	$(function() {
			$('#about_medical').hover(function() {
					$(this).addClass('hover_medical');
			}, function() {
					$(this).removeClass('hover_medical');
			});
	});

	$(function() {
			$('#about_dental').hover(function() {
					$(this).addClass('hover_dental');
			}, function() {
					$(this).removeClass('hover_dental');
			});
	});

	$(function() {
			$('#about_lab').hover(function() {
					$(this).addClass('hover_lab');
			}, function() {
					$(this).removeClass('hover_lab');
			});
	});

	$(function() {
			$('#about_xray').hover(function() {
					$(this).addClass('hover_xray');
			}, function() {
					$(this).removeClass('hover_xray');
			});
	});
 
})

