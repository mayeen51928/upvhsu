$(document).ready(function(){
	$.ajaxSetup({
  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});

// ------------------DASHBOARD---------------

$('.addXrayResult').click(function(){
	var xray_id = $(this).attr('id').split("_")[1];
	$('#add-xray-result').modal();
	$('#addXrayResultButton').click(function(){
		if($('#chest-xray').val())
		{
			var chest_xray = $('#chest-xray').val();
			$.post('/addxrayresult',
			{
		      	xray_id: xray_id,
		      	chest_xray: chest_xray,
	      	} , function(data){
	      	$('#add-xray-result').modal('hide');
	      	$('#chest-xray').val('');
	      });
	   }
	});
});

	$('.addBillingToXray').click(function(){
		var id = $(this).attr('id').split("_");
		appointmentId = id[1];
		$.ajax({
		  type: "POST",
		  url: addBillingXray,
		  data: {appointment_id:  appointmentId, _token: token},
		  success: function(data)
		  {
		  	output = '';
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
					};
				});
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