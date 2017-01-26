$(document).ready( function(){
// ----------------------------- Dashboard -----------------------------
$('.dental_chart').click(function(){
	var id = $(this).attr('id').split("_");
	teethId = id[1];
	$.ajax({
		  type: "POST",
		  url: updateDentalRecordModal,
		  data: {teeth_id:  teethId, _token: token},
		  success: function(data)
		  {
			if (data['status'] == 1) {
				$('.condition').val(data['condition_id']);
				$('.operation').val(data['operation_id']);
			}
			else{
				$('.condition').val(0);
				$('.operation').val(0);
			}
		  }
	  });
	window.setTimeout(function(){
            $('#update-dental-record-modal').modal('show');
        }, 1000)
});


$('.updateDentalRecord').click(function(){
	if($('.condition').val() && $('.operation').val()){
		var appointmentId = $('.appointment').val();
		var conditionId = $('.condition').val();
		var operationId = $('.operation').val();
		if (operationId == null) { operationId = 0; };
		if (conditionId == null) { conditionId = 0; };
		$.ajax({
			  type: "POST",
			  url: insertDentalRecordModal,
			  data: {teeth_id:  teethId, condition_id:  conditionId, operation_id:  operationId, appointment_id:  appointmentId,  _token: token},
			  success: function(data)
			  {
			  	console.log('#condition_'+teethId);
			  	if (conditionId == 0) {
			  		$('#condition_'+teethId).css({ fill: "white" });
			  	}
			  	else if (conditionId == 1) {
			  		$('#condition_'+teethId).css({ fill: "blue" });
			  	}
			  	else if (conditionId == 2) {
			  		$('#condition_'+teethId).css({ fill: "red" });
			  	}
			  	else if (conditionId == 3) {
			  		$('#condition_'+teethId).css({ fill: "yellow" });
			  	}
			  	else if (conditionId == 4) {
			  		$('#condition_'+teethId).css({ fill: "cyan" });
			  	}
			  	else {
			  		$('#condition_'+teethId).css({ fill: "pink" });
			  	};
			  	if (operationId == 0) {
			  		$('#operation_'+teethId).css({ fill: "white" });
			  	}
			  	else if (operationId == 1) {
			  		$('#operation_'+teethId).css({ fill: "blue" });
			  	}
			  	else if (operationId == 2) {
			  		$('#operation_'+teethId).css({ fill: "red" });
			  	}
			  	else if (operationId == 3) {
			  		$('#operation_'+teethId).css({ fill: "yellow" });
			  	}
			  	else if (operationId == 4) {
			  		$('#operation_'+teethId).css({ fill: "cyan" });
			  	}
			  	else {
			  		$('#operation_'+teethId).css({ fill: "pink" });
			  	};
				$('#update-dental-record-modal').modal("hide");
			  }
		  });
	}
	
	
});

$('.updateDentalDiagnosis').click(function(){
	var id = $(this).attr('id').split("_");
	appointmentId = id[1];
	console.log(appointmentId);
		$.ajax({
		  type: "POST",
		  url: updateDentalDiagnosis,
		  data: {appointment_id:  appointmentId, _token: token},
		  success: function(data)
		  {
		  	console.log(data['success']);
		  	setTimeout(function() {
			  window.location.href = "http://localhost:8000/dentist";
			}, 5000);
		  }
	  });
});
















// ----------------------------- End of Dashboard ----------------------






// ----------------------------- Profile -----------------------------





// ----------------------------- End of Profile ----------------------









// ----------------------------- Manage Schedule -----------------------------

$('.addmoredentalsched').click(function(){
	$(this).parents('.dental_manage').find('tbody').append('<tr class="schedule_tr"><td><input type="date" class="form-control"/></td><td><input type="time" class="form-control starthour"/></td><td><input type="time" class="form-control endhour"/></td><td><button class="btn btn-danger btn-sm removedentalsched">Remove</button></td></tr>');
	$('.removedentalsched').click(function(){
		// console.log($(this).closest('tr'));
		$(this).closest('tr').remove();

	});
});
$('.removedentalsched').click(function(){
	// console.log($(this).closest('tr'));
	$(this).closest('tr').remove();
});
$('#adddentalschedule').click(function(){
	var schedules = [];
	$('.schedule_tr').each(function(){
		if($(this).find('input[type="date"]').val() && $(this).find('.starthour').val() && $(this).find('.endhour').val()){
			schedules.push($(this).find('input[type="date"]').val() + ' ' + $(this).find('.starthour').val() + ':00;;;' + $(this).find('input[type="date"]').val() + ' ' + $(this).find('.endhour').val() + ':00');
			// console.log(schedules);
		}
	});
	if(schedules.length > 0){
		$.ajax({
			url: addDentalSchedule,
			type: 'POST',
			dataType: 'json',
			data: {schedules:  schedules, _token: token},
			success: function(data) {
				$('button').attr('disabled', 'disabled');
				$('input').attr('disabled', 'disabled');
				$('#manageschedulepanel').css('background-color', '#d6e9c6');
			},
			error: function(xhr, textStatus, errorThrown) {
			}
		});
	}
	
});

// ----------------------------- End of Manage Schedule ----------------------
});