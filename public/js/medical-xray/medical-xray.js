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
		if(data['patient_type_id'] == 5){
			$('#patient_type_radio_xray').css("display","block");
		}
		else{
			$('#patient_type_radio_xray').css("display","none");
		}
    $('#add-xray-result-footer').append('<button type="button" class="btn btn-success addXrayResultButton" id="addXrayResultButton_'+medical_appointment_id+'">Save</button><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>');
		$('#add-xray-result').modal();
		$('.addXrayResultButton').click(function(){
			var medical_appointment_id = $(this).attr('id').split("_")[1];
			var chest_xray = $('#chest-xray').val();
			xray_services_id=[];
			$("input:checkbox.checkboxXrayService").each(function(){
					if($(this).is(":checked")){
							xray_services_id.push($(this).attr("id"));
					}
			});
			if($('#chest-xray').val())
			{
				var medical_appointment_id = $(this).attr('id').split("_")[1];
				var chest_xray = $('#chest-xray').val();
				$.post('/addxrayresult',
				{
	      	medical_appointment_id: medical_appointment_id,
	      	chest_xray: chest_xray,
	      	xray_services_id: xray_services_id,
      	} , function(data){
	      		$('#xraycountpanel').load(location.href + " #xraycount");
		      	$('#add-xray-result').modal('hide');
		      	$('#chest-xray').val('');
		      	$('#addXrayResult_'+medical_appointment_id).closest("tr").remove();
	      });
		  }
		});
  });
});


// ------------------PROFILE---------------
// ------------------SEARCH PATIENT---------------
	
});