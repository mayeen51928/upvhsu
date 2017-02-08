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
	      	$('#addXrayResult_'+xray_id).closest("tr").remove();
	      	$('#add-xray-result').modal('hide');
	      	$('#chest-xray').val('');
	      });
	   }
	});
});
// ------------------PROFILE---------------
// ------------------SEARCH PATIENT---------------
	
});