$(document).ready(function(){
	$.ajaxSetup({
  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

// ------------------DASHBOARD---------------

$('.addXrayResult').click(function(){
	var medical_appointment_id = $(this).attr('id').split("_")[1];
	$('#add-xray-result-footer').html('');
	$.post('/viewxraydiagnosis', {medical_appointment_id: medical_appointment_id}, function(data, textStatus, xhr) {
    if(data['xray_result'])
    {
    	$('#chest-xray').val(data['xray_result']['xray_result']);
    	if(data['xray_result']['xray_result'])
    	{
    		$('#chest-xray').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#chest-xray').removeAttr('disabled');
    	}
    }
    $('#add-xray-result-footer').append('<button type="button" class="btn btn-success addXrayResultButton" id="addXrayResultButton_'+medical_appointment_id+'">Save</button><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>');
	$('#add-xray-result').modal();
	$('.addXrayResultButton').click(function(){
		if($('#chest-xray').val())
		{
			var medical_appointment_id = $(this).attr('id').split("_")[1];
			var chest_xray = $('#chest-xray').val();
			$.post('/addxrayresult',
			{
		      	medical_appointment_id: medical_appointment_id,
		      	chest_xray: chest_xray,
	      	} , function(data){
	      		$('#xraycountpanel').load(location.href + " #xraycount");
		      	$('#add-xray-result').modal('hide');
		      	$('#chest-xray').val('');
		      	// $("#addXrayResult_"+xray_id).prop( "disabled", true );
	      });
	   }
	});
    });
	
});

$('.addBillingToXray').click(function(){
	var id = $(this).attr('id').split("_");
	appointmentId = id[1];
	output="";
	$('.displayServices').html(output);
	$.ajax({
	  type: "POST",
	  url: addBillingXray,
	  data: {appointment_id:  appointmentId, _token: token},
	  success: function(data)
	  {
	  	var dob = new Date(data['patient_info']['birthday']);
	  	var today = new Date();
	    var dayDiff = Math.ceil(today - dob) / (1000 * 60 * 60 * 24 * 365);
	    var age = parseInt(dayDiff);
	  	if(data['patient_type_id'] == 5 && age>59){
	  		console.log(data['display_xray_services_senior']);
	  		console.log("Patient is an OPD");
	  		$('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
	  		$('.medical_senior_checker_xray').show();
	  		$('input[type=radio][name=xray_radio_button_medical]').change(function() {
	  			output="";
	  			$('.displayServices').html(output);
	  			if (this.value == '5') {
	  				output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
	  				for (var i = 0; i < data['display_xray_services'].length; i++){
	  					output += "<tr><td><input type='checkbox' class='checkboxXrayService' id="+data['display_xray_services'][i].service_rate+" value="+data['display_xray_services'][i].id+"></td><td class='xrayService'>"+data['display_xray_services'][i].service_description+"</td><td class='xrayServiceRate'>"+data['display_xray_services'][i].service_rate+"</td></tr>";
						}
	        }
	        else if (this.value == '6') {
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
						for (var i = 0; i < data['display_xray_services_senior'].length; i++){
							output += "<tr><td><input type='checkbox' class='checkboxXrayService' id="+data['display_xray_services_senior'][i].service_rate+" value="+data['display_xray_services_senior'][i].id+"></td><td class='xrayService'>"+data['display_xray_services_senior'][i].service_description+"</td><td class='xrayServiceRate'>"+data['display_xray_services_senior'][i].service_rate+"</td></tr>";
						}
					}
					$('.displayServices').html(output);
					if(data['checker'] == '0'){
						$(".displayServices :input").attr("disabled", true);
						$('.xray-bill-input').html("").append("<input type='text' class='form-control' id='xray-bill' disabled>");
						$('.xray-bill-confirm').html("").append("<button type='button' class='btn btn-primary xray-bill-confirm-button' id='xrayBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
					}
					else{
						$('.xray-bill-input').html("").append("<input type='text' class='form-control' id='xray-bill' disabled>");
						$('.xray-bill-confirm').html("").append("<button type='button' class='btn btn-primary xray-bill-confirm-button' id='xrayBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
					}
					var fin = 0;
					$('.checkboxXrayService').click(function(){
						if ($(this).is(':checked')){
							var xrayBillRate = parseFloat($(this).attr('id'));
							fin = parseFloat(fin+xrayBillRate);
							$("#xray-bill").val(fin);
							console.log(fin);
						};
					});
		    });
	  	}

	  	else{
	  		console.log("Patient is a student");
	  		$('.medical_senior_checker_xray').hide();
	  		$('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
				output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
				for (var i = 0; i < data['display_xray_services'].length; i++){
					output += "<tr><td><input type='checkbox' class='checkboxXrayService' id="+data['display_xray_services'][i].service_rate+" value="+data['display_xray_services'][i].id+"></td><td class='xrayService'>"+data['display_xray_services'][i].service_description+"</td><td class='xrayServiceRate'>"+data['display_xray_services'][i].service_rate+"</td></tr>";
				}
				$('.displayServices').html(output);
				if(data['checker'] == '0'){
					$(".displayServices :input").attr("disabled", true);
					$('.xray-bill-input').html("").append("<input type='text' class='form-control' id='xray-bill' disabled>");
					$('.xray-bill-confirm').html("").append("<button type='button' class='btn btn-primary xray-bill-confirm-button' id='xrayBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
				}
				else{
					$('.xray-bill-input').html("").append("<input type='text' class='form-control' id='xray-bill' disabled>");
					$('.xray-bill-confirm').html("").append("<button type='button' class='btn btn-primary xray-bill-confirm-button' id='xrayBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
				}
				var fin = 0;
				$('.checkboxXrayService').click(function(){
					if ($(this).is(':checked')){
						var xrayBillRate = parseFloat($(this).attr('id'));
						fin = parseFloat(fin+xrayBillRate);
						$("#xray-bill").val(fin);
						console.log(fin);
					};
				});
			}
			$('#xrayBillingModal').modal();
	  }
  });
});

$(document).on('click', '.xray-bill-confirm-button', function(){
	var appointmentId = $(this).attr('id').split('_')[1];
	checked_services_array_id=[];
	checked_services_array_rate=[];
	$("input:checkbox").each(function(){
	    var $this = $(this);
	    if($this.is(":checked")){
	        checked_services_array_id.push($this.attr("value"));
	        checked_services_array_rate.push($this.attr("id"));
	    }
	});
	$.ajax({
		  type: "POST",
		  url: confirmBillingXray,
		  data: {appointment_id:  appointmentId, checked_services_array_id:  checked_services_array_id, checked_services_array_rate:  checked_services_array_rate, _token: token},
		  success: function(data)
		  {
		  	$('#addBillingToXray_'+appointmentId).closest("tr").remove();
		  	$('#xrayBillingModal').modal("hide");
		  }
  	});
	return false;
});

// ------------------PROFILE---------------
// ------------------SEARCH PATIENT---------------
	
});