$(document).ready( function(){
$.ajaxSetup({
  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
// ------------------DASHBOARD---------------
// 
$('.addLabResult').click(function(){
  var medical_appointment_id = $(this).attr('id').split("_")[1];
  $('#laboratoryresult-lab #cbc_div, #laboratoryresult-lab #drug_test_div, #laboratoryresult-lab #fecalysis_div, #laboratoryresult-lab #urinalysis_div').hide();
  $('#hemoglobin-lab, #hemasocrit-lab, #wbc-lab, #macroscopic-lab, #microscopic-lab, #rbc-lab, #pus-cells-lab').val('');
  $('#drug-test-lab option').prop('selected', function()
  {
    return this.defaultSelected;
  });
  $('#albumin-lab option, #sugar-lab option').prop('selected', function()
  {
    return this.defaultSelected;
  });
  $('#add-lab-result-footer').html('');
  $.post('/viewlabdiagnosis', {medical_appointment_id: medical_appointment_id}, function(data, textStatus, xhr) {
    if(data['cbc_result'])
    {
    	$('#hemoglobin-lab').val(data['cbc_result']['hemoglobin']);
    	if(data['cbc_result']['hemoglobin'])
    	{
    		$('#hemoglobin-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#hemoglobin-lab').removeAttr('disabled');
    	}

    	$('#hemasocrit-lab').val(data['cbc_result']['hemasocrit']);
    	if(data['cbc_result']['hemasocrit'])
    	{
    		$('#hemasocrit-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#hemasocrit-lab').removeAttr('disabled');
    	}

    	$('#wbc-lab').val(data['cbc_result']['wbc']);
    	if(data['cbc_result']['wbc'])
    	{
    		$('#wbc-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#wbc-lab').removeAttr('disabled');
    	}

      $('#laboratoryresult-lab #cbc_div').show();
    }
    if(data['drug_test_result'])
    {
    	$('#drug-test-lab').val(data['drug_test_result']['drug_test_result']);
    	if(data['drug_test_result']['drug_test_result'])
    	{
    		$('#drug-test-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#drug-test-lab').removeAttr('disabled');
    		$('#drug-test-lab option').prop('selected', function()
			  {
			    return this.defaultSelected;
			  });
    	}
      $('#laboratoryresult-lab #drug_test_div').show();
    }
    if(data['fecalysis_result'])
    {
    	$('#macroscopic-lab').val(data['fecalysis_result']['macroscopic']);
    	if(data['fecalysis_result']['macroscopic'])
    	{
    		$('#macroscopic-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#macroscopic-lab').removeAttr('disabled');
    	}
    	$('#microscopic-lab').val(data['fecalysis_result']['microscopic']);
    	if(data['fecalysis_result']['microscopic'])
    	{
    		$('#microscopic-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#microscopic-lab').removeAttr('disabled');
    	}
      $('#laboratoryresult-lab #fecalysis_div').show();
    }
    if(data['urinalysis_result'])
    {
    	$('#pus-cells-lab').val(data['urinalysis_result']['pus_cells']);
    	if(data['urinalysis_result']['pus_cells'])
    	{
    		$('#pus-cells-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#pus-cells-lab').removeAttr('disabled');
    	}
    	$('#rbc-lab').val(data['urinalysis_result']['rbc']);
    	if(data['urinalysis_result']['rbc'])
    	{
    		$('#rbc-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#rbc-lab').removeAttr('disabled');
    	}
    	$('#albumin-lab').val(data['urinalysis_result']['albumin']);
    	if(data['urinalysis_result']['albumin'])
    	{
    		$('#albumin-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#albumin-lab').removeAttr('disabled');
    		$('#albumin-lab option').prop('selected', function()
			  {
			    return this.defaultSelected;
			  });
    	}
    	$('#sugar-lab').val(data['urinalysis_result']['sugar']);
    	if(data['urinalysis_result']['sugar'])
    	{
    		$('#sugar-lab').attr('disabled', 'disabled');
    	}
    	else
    	{
    		$('#sugar-lab').removeAttr('disabled');
    		$('#sugar-lab option').prop('selected', function()
			  {
			    return this.defaultSelected;
			  });
    	}
      $('#laboratoryresult-lab #urinalysis_div').show();
    }
    $('#add-lab-result-footer').append('<button type="button" class="btn btn-success addLabResultButton" id="addLabResultButton_'+medical_appointment_id+'">Save</button><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>')
    $('.addLabResultButton').click(function(){
			var medical_appointment_id = $(this).attr('id').split("_")[1];
			$.post('/updatelabdiagnosis',
				{
					medical_appointment_id: medical_appointment_id,
					hemoglobin: $('#hemoglobin-lab').val(),
					hemasocrit: $('#hemasocrit-lab').val(),
					wbc: $('#wbc-lab').val(),

					drug_test: $('#drug-test-lab').val(),

					macroscopic: $('#macroscopic-lab').val(),
					microscopic: $('#microscopic-lab').val(),

					pus_cells: $('#pus-cells-lab').val(),
					rbc: $('#rbc-lab').val(),
					albumin: $('#albumin-lab').val(),
					sugar: $('#sugar-lab').val(),
			}, function(data, textStatus, xhr) {
        $('#cbccountpanel').load(location.href + " #cbccount");
        $('#drugtestcountpanel').load(location.href + " #drugtestcount");
        $('#fecalysiscountpanel').load(location.href + " #fecalysiscount");
        $('#urinalysiscountpanel').load(location.href + " #urinalysiscount");
				$('#add-lab-result').modal('hide');
			});
	});
    $('#add-lab-result').modal();
  });
});


// $('.addCbcResult').click(function(){
// 	var cbc_id = $(this).attr('id').split("_")[1];
//   $('#hemoglobin-lab, #hemasocrit-lab, #wbc-lab').val('');
// 	$('#add-cbc-result').modal();
// 	$('#addCbcResultButton').click(function(){
// 		if($('#hemoglobin-lab').val() && $('#hemasocrit-lab').val() && $('#wbc-lab').val())
// 		{
// 			var hemoglobin = $('#hemoglobin-lab').val();
// 	      var hemasocrit = $('#hemasocrit-lab').val();
// 	      var wbc = $('#wbc-lab').val();
// 	      $.post('/addcbcresult',
// 	      {
// 	      	cbc_id: cbc_id,
// 	      	hemoglobin: hemoglobin,
// 	      	hemasocrit: hemasocrit,
// 	      	wbc: wbc,
// 	      } , function(data){
// 	      	$('#add-cbc-result').modal('hide');
// 	      });
// 	   }
// 	});
// });
// $('.addDrugTestResult').click(function(){
//   var drug_test_id = $(this).attr('id').split("_")[1];
//   $('#drug-test-lab option').prop('selected', function()
//   {
//     return this.defaultSelected;
//   });
//   $('#add-drug-test-result').modal();
//   $('#addDrugTestResultButton').click(function(){
//     if($('#drug-test-lab').val())
//     {
//       var drug_test_result = $('#drug-test-lab').val();
//       $.post('/adddrugtestresult',
//       {
//         drug_test_id: drug_test_id,
//         drug_test_result: drug_test_result,
//       } , function(data){
//         $('#add-drug-test-result').modal('hide');
//       });
//     }
//   });
// });
// $('.addFecalysisResult').click(function(){
// 	var fecalysis_id = $(this).attr('id').split("_")[1];
//   $('#macroscopic-lab, #microscopic-lab').val('');
// 	$('#add-fecalysis-result').modal();
// 	$('#addFecalysisResultButton').click(function(){
// 		if($('#macroscopic-lab').val() && $('#microscopic-lab').val())
// 		{
// 			var macroscopic = $('#macroscopic-lab').val();
// 			var microscopic = $('#microscopic-lab').val();
// 			$.post('/addfecalysisresult',
// 			{
// 				fecalysis_id: fecalysis_id,
// 				macroscopic: macroscopic,
// 				microscopic: microscopic,
// 			} , function(data){
// 				$('#add-fecalysis-result').modal('hide');
// 			});
// 		}
// 	});
// });
// $('.addUrinalysisResult').click(function(){
// 	var urinalysis_id = $(this).attr('id').split("_")[1];
//   $('#rbc-lab, #pus-cells-lab').val('');
//   $('#albumin-lab option, #sugar-lab option').prop('selected', function()
//   {
//     return this.defaultSelected;
//   });
// 	$('#add-urinalysis-result').modal();
// 	$('#addUrinalysisResultButton').click(function(){
// 		if($('#pus-cells-lab').val() && $('#rbc-lab').val() && $('#albumin-lab').val() && $('#sugar-lab').val())
// 		{
// 			var pus_cells = $('#pus-cells-lab').val();
// 			var rbc = $('#rbc-lab').val();
// 			var albumin = $('#albumin-lab').val();
// 			var sugar = $('#sugar-lab').val();
// 			$.post('/addurinalysisresult',
// 			{
// 				urinalysis_id: urinalysis_id,
// 				pus_cells: pus_cells,
// 				rbc: rbc,
// 				albumin: albumin,
// 				sugar: sugar,
// 			} , function(data){
// 				$('#add-urinalysis-result').modal('hide');
// 			});
// 		}
// 	});
// });


$('.addBillingToCbc').click(function(){
  var id = $(this).attr('id').split("_");
  appointmentId = id[1];
  output="";
  $('.displayServices').html(output);
  $.ajax({
    type: "POST",
    url: addBillingCbc,
    data: {appointment_id:  appointmentId, _token: token},
    success: function(data)
    {
      console.log(data['patient_type_id']);
      var dob = new Date(data['patient_info']['birthday']);
      var today = new Date();
      var dayDiff = Math.ceil(today - dob) / (1000 * 60 * 60 * 24 * 365);
      var age = parseInt(dayDiff);
      if(data['patient_type_id'] == 5 && age>59){
        console.log("Patient is Senior");
        $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
        $('.medical_senior_checker_cbc').show();
        $('input[type=radio][name=cbc_radio_button_medical]').change(function() {
          output="";
          $('.displayServices').html(output);
          if (this.value == '5') {
            console.log("Mambo number 5");
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
            for (var i = 0; i < data['display_cbc_services'].length; i++){
              output += "<tr><td><input type='checkbox' class='checkboxCbcService' id="+data['display_cbc_services'][i].service_rate+" value="+data['display_cbc_services'][i].id+"></td><td class='cbcService'>"+data['display_cbc_services'][i].service_description+"</td><td class='xrayServiceRate'>"+data['display_cbc_services'][i].service_rate+"</td></tr>";
            }
          }
          else if (this.value == '6') {
            console.log("Mambo number 6");
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
            for (var i = 0; i < data['display_cbc_services_senior'].length; i++){
              output += "<tr><td><input type='checkbox' class='checkboxCbcService' id="+data['display_cbc_services_senior'][i].service_rate+" value="+data['display_cbc_services_senior'][i].id+"></td><td class='cbcService'>"+data['display_cbc_services_senior'][i].service_description+"</td><td class='cbcServiceRate'>"+data['display_cbc_services_senior'][i].service_rate+"</td></tr>";
            }
          }
          $('.displayServices').html(output);
          if(data['checker'] == '0'){
            $(".displayServices :input").attr("disabled", true);
            $('.cbc-bill-input').html("").append("<input type='text' class='form-control' id='cbc-bill' disabled>");
            $('.cbc-bill-confirm').html("").append("<button type='button' class='btn btn-primary cbc-bill-confirm-button' id='cbcBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
          }
          else{
            $('.cbc-bill-input').html("").append("<input type='text' class='form-control' id='cbc-bill' disabled>");
            $('.cbc-bill-confirm').html("").append("<button type='button' class='btn btn-primary cbc-bill-confirm-button' id='cbcBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
          }
          var fin = 0;
          $('.checkboxCbcService').click(function(){
            if ($(this).is(':checked')){
              var cbcBillRate = parseFloat($(this).attr('id'));
              fin = parseFloat(fin+cbcBillRate);
              $("#cbc-bill").val(fin);
              console.log(fin);
            };
          });
        });
      }

      else{
        console.log("Patient is a student");
        $('.medical_senior_checker_cbc').hide();
        $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
        output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
        for (var i = 0; i < data['display_cbc_services'].length; i++){
          output += "<tr><td><input type='checkbox' class='checkboxCbcService' id="+data['display_cbc_services'][i].service_rate+" value="+data['display_cbc_services'][i].id+"></td><td class='xrayService'>"+data['display_cbc_services'][i].service_description+"</td><td class='cbcServiceRate'>"+data['display_cbc_services'][i].service_rate+"</td></tr>";
        }
        $('.displayServices').html(output);
        if(data['checker'] == '0'){
          $(".displayServices :input").attr("disabled", true);
          $('.cbc-bill-input').html("").append("<input type='text' class='form-control' id='cbc-bill' disabled>");
          $('.cbc-bill-confirm').html("").append("<button type='button' class='btn btn-primary cbc-bill-confirm-button' id='cbcBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
        }
        else{
          $('.cbc-bill-input').html("").append("<input type='text' class='form-control' id='cbc-bill' disabled>");
          $('.cbc-bill-confirm').html("").append("<button type='button' class='btn btn-primary cbc-bill-confirm-button' id='cbcBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
        }
        var fin = 0;
        $('.checkboxCbcService').click(function(){
          if ($(this).is(':checked')){
            var cbcBillRate = parseFloat($(this).attr('id'));
            fin = parseFloat(fin+cbcBillRate);
            $("#cbc-bill").val(fin);
            console.log(fin);
          };
        });
      }
      $('#cbcBillingModal').modal();
    }
  });
});

$(document).on('click', '.cbc-bill-confirm-button', function(){
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
      url: confirmBillingCbc,
      data: {appointment_id:  appointmentId, checked_services_array_id:  checked_services_array_id, checked_services_array_rate:  checked_services_array_rate, _token: token},
      success: function(data)
      {
        $('#addBillingToCbc_'+appointmentId).closest("tr").remove();
        $('#cbcBillingModal').modal("hide");
      }
    });
  return false;
});

// ---------------------------------------------------------------------------------------------------------

$('.addBillingToDrug').click(function(){
  var id = $(this).attr('id').split("_");
  appointmentId = id[1];
  output="";
  $('.displayServices').html(output);
  $.ajax({
    type: "POST",
    url: addBillingDrug,
    data: {appointment_id:  appointmentId, _token: token},
    success: function(data)
    {
      console.log(data['patient_type_id']);
      var dob = new Date(data['patient_info']['birthday']);
      var today = new Date();
      var dayDiff = Math.ceil(today - dob) / (1000 * 60 * 60 * 24 * 365);
      var age = parseInt(dayDiff);
      if(data['patient_type_id'] == 5 && age>59){
        console.log("Patient is Senior");
        $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
        $('.drug_senior_checker_drug').show();
        $('input[type=radio][name=drug_radio_button_medical]').change(function() {
          output="";
          $('.displayServices').html(output);
          if (this.value == '5') {
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
            for (var i = 0; i < data['display_drug_services'].length; i++){
              output += "<tr><td><input type='checkbox' class='checkboxDrugService' id="+data['display_drug_services'][i].service_rate+" value="+data['display_drug_services'][i].id+"></td><td class='drugService'>"+data['display_drug_services'][i].service_description+"</td><td class='xrayServiceRate'>"+data['display_drug_services'][i].service_rate+"</td></tr>";
            }
          }
          else if (this.value == '6') {
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
            for (var i = 0; i < data['display_drug_services_senior'].length; i++){
              output += "<tr><td><input type='checkbox' class='checkboxDrugService' id="+data['display_drug_services_senior'][i].service_rate+" value="+data['display_drug_services_senior'][i].id+"></td><td class='drugService'>"+data['display_drug_services_senior'][i].service_description+"</td><td class='drugServiceRate'>"+data['display_drug_services_senior'][i].service_rate+"</td></tr>";
            }
          }
          $('.displayServices').html(output);
          if(data['checker'] == '0'){
            $(".displayServices :input").attr("disabled", true);
            $('.drug-bill-input').html("").append("<input type='text' class='form-control' id='drug-bill' disabled>");
            $('.drug-bill-confirm').html("").append("<button type='button' class='btn btn-primary drug-bill-confirm-button' id='drugBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
          }
          else{
            $('.drug-bill-input').html("").append("<input type='text' class='form-control' id='drug-bill' disabled>");
            $('.drug-bill-confirm').html("").append("<button type='button' class='btn btn-primary drug-bill-confirm-button' id='drugBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
          }
          var fin = 0;
          $('.checkboxDrugService').click(function(){
            if ($(this).is(':checked')){
              var drugBillRate = parseFloat($(this).attr('id'));
              fin = parseFloat(fin+drugBillRate);
              $("#drug-bill").val(fin);
              console.log(fin);
            };
          });
        });
      }

      else{
        console.log("Patient is a student");
        $('.medical_senior_checker_drug').hide();
        $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
        output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
        for (var i = 0; i < data['display_drug_services'].length; i++){
          output += "<tr><td><input type='checkbox' class='checkboxDrugService' id="+data['display_drug_services'][i].service_rate+" value="+data['display_drug_services'][i].id+"></td><td class='xrayService'>"+data['display_drug_services'][i].service_description+"</td><td class='drugServiceRate'>"+data['display_drug_services'][i].service_rate+"</td></tr>";
        }
        $('.displayServices').html(output);
        if(data['checker'] == '0'){
          $(".displayServices :input").attr("disabled", true);
          $('.drug-bill-input').html("").append("<input type='text' class='form-control' id='drug-bill' disabled>");
          $('.drug-bill-confirm').html("").append("<button type='button' class='btn btn-primary drug-bill-confirm-button' id='drugBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
        }
        else{
          $('.drug-bill-input').html("").append("<input type='text' class='form-control' id='drug-bill' disabled>");
          $('.drug-bill-confirm').html("").append("<button type='button' class='btn btn-primary drug-bill-confirm-button' id='drugBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
        }
        var fin = 0;
        $('.checkboxDrugService').click(function(){
          if ($(this).is(':checked')){
            var drugBillRate = parseFloat($(this).attr('id'));
            fin = parseFloat(fin+drugBillRate);
            $("#drug-bill").val(fin);
            console.log(fin);
          };
        });
      }
      $('#drugBillingModal').modal();
    }
  });
});

$(document).on('click', '.drug-bill-confirm-button', function(){
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
      url: confirmBillingDrug,
      data: {appointment_id:  appointmentId, checked_services_array_id:  checked_services_array_id, checked_services_array_rate:  checked_services_array_rate, _token: token},
      success: function(data)
      {
        $('#addBillingToDrug_'+appointmentId).closest("tr").remove();
        $('#drugBillingModal').modal("hide");
      }
    });
  return false;
});

// ------------------------------------------------------------------------------------------------------------------------------

$('.addBillingToFecalysis').click(function(){
  var id = $(this).attr('id').split("_");
  appointmentId = id[1];
  output="";
  $('.displayServices').html(output);
  $.ajax({
    type: "POST",
    url: addBillingFecalysis,
    data: {appointment_id:  appointmentId, _token: token},
    success: function(data)
    {
      console.log(data['patient_type_id']);
      var dob = new Date(data['patient_info']['birthday']);
      var today = new Date();
      var dayDiff = Math.ceil(today - dob) / (1000 * 60 * 60 * 24 * 365);
      var age = parseInt(dayDiff);
      if(data['patient_type_id'] == 5 && age>59){
        console.log("Patient is Senior");
        $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
        $('.medical_senior_checker_fecalysis').show();
        $('input[type=radio][name=fecalysis_radio_button_medical]').change(function() {
          output="";
          $('.displayServices').html(output);
          if (this.value == '5') {
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
            for (var i = 0; i < data['display_fecalysis_services'].length; i++){
              output += "<tr><td><input type='checkbox' class='checkboxFecalysisService' id="+data['display_fecalysis_services'][i].service_rate+" value="+data['display_fecalysis_services'][i].id+"></td><td class='fecalysisService'>"+data['display_fecalysis_services'][i].service_description+"</td><td class='xrayServiceRate'>"+data['display_fecalysis_services'][i].service_rate+"</td></tr>";
            }
          }
          else if (this.value == '6') {
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
            for (var i = 0; i < data['display_fecalysis_services_senior'].length; i++){
              output += "<tr><td><input type='checkbox' class='checkboxFecalysisService' id="+data['display_fecalysis_services_senior'][i].service_rate+" value="+data['display_fecalysis_services_senior'][i].id+"></td><td class='fecalysisService'>"+data['display_fecalysis_services_senior'][i].service_description+"</td><td class='fecalysisServiceRate'>"+data['display_fecalysis_services_senior'][i].service_rate+"</td></tr>";
            }
          }
          $('.displayServices').html(output);
          if(data['checker'] == '0'){
            $(".displayServices :input").attr("disabled", true);
            $('.fecalysis-bill-input').html("").append("<input type='text' class='form-control' id='fecalysis-bill' disabled>");
            $('.fecalysis-bill-confirm').html("").append("<button type='button' class='btn btn-primary fecalysis-bill-confirm-button' id='fecalysisBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
          }
          else{
            $('.fecalysis-bill-input').html("").append("<input type='text' class='form-control' id='fecalysis-bill' disabled>");
            $('.fecalysis-bill-confirm').html("").append("<button type='button' class='btn btn-primary fecalysis-bill-confirm-button' id='fecalysisBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
          }
          var fin = 0;
          $('.checkboxFecalysisService').click(function(){
            if ($(this).is(':checked')){
              var fecalysisBillRate = parseFloat($(this).attr('id'));
              fin = parseFloat(fin+fecalysisBillRate);
              $("#fecalysis-bill").val(fin);
              console.log(fin);
            };
          });
        });
      }

      else{
        console.log("Patient is a student");
        $('.medical_senior_checker_fecalysis').hide();
        $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
        output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
        for (var i = 0; i < data['display_fecalysis_services'].length; i++){
          output += "<tr><td><input type='checkbox' class='checkboxFecalysisService' id="+data['display_fecalysis_services'][i].service_rate+" value="+data['display_fecalysis_services'][i].id+"></td><td class='drugService'>"+data['display_fecalysis_services'][i].service_description+"</td><td class='drugServiceRate'>"+data['display_fecalysis_services'][i].service_rate+"</td></tr>";
        }
        $('.displayServices').html(output);
        if(data['checker'] == '0'){
          $(".displayServices :input").attr("disabled", true);
          $('.fecalysis-bill-input').html("").append("<input type='text' class='form-control' id='fecalysis-bill' disabled>");
          $('.fecalysis-bill-confirm').html("").append("<button type='button' class='btn btn-primary fecalysis-bill-confirm-button' id='fecalysisBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
        }
        else{
          $('.fecalysis-bill-input').html("").append("<input type='text' class='form-control' id='fecalysis-bill' disabled>");
          $('.fecalysis-bill-confirm').html("").append("<button type='button' class='btn btn-primary fecalysis-bill-confirm-button' id='fecalysisBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
        }
        var fin = 0;
        $('.checkboxFecalysisService').click(function(){
          if ($(this).is(':checked')){
            var fecalysisBillRate = parseFloat($(this).attr('id'));
            fin = parseFloat(fin+fecalysisBillRate);
            $("#fecalysis-bill").val(fin);
            console.log(fin);
          };
        });
      }
      $('#fecalysisBillingModal').modal();
    }
  });
});

$(document).on('click', '.fecalysis-bill-confirm-button', function(){
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
      url: confirmBillingFecalysis,
      data: {appointment_id:  appointmentId, checked_services_array_id:  checked_services_array_id, checked_services_array_rate:  checked_services_array_rate, _token: token},
      success: function(data)
      {
        $('#addBillingToFecalysis_'+appointmentId).closest("tr").remove();
        $('#fecalysisBillingModal').modal("hide");
      }
    });
  return false;
});

// --------------------------------------------------------------------------------------------------------------------------------------------

$('.addBillingToUrinalysis').click(function(){
  var id = $(this).attr('id').split("_");
  appointmentId = id[1];
  output="";
  $('.displayServices').html(output);
  $.ajax({
    type: "POST",
    url: addBillingUrinalysis,
    data: {appointment_id:  appointmentId, _token: token},
    success: function(data)
    {
      console.log(data['patient_type_id']);
      var dob = new Date(data['patient_info']['birthday']);
      var today = new Date();
      var dayDiff = Math.ceil(today - dob) / (1000 * 60 * 60 * 24 * 365);
      var age = parseInt(dayDiff);
      if(data['patient_type_id'] == 5 && age>59){
        console.log("Patient is Senior");
        $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
        $('.medical_senior_checker_urinalysis').show();
        $('input[type=radio][name=urinalysis_radio_button_medical]').change(function() {
          output="";
          $('.displayServices').html(output);
          if (this.value == '5') {
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
            for (var i = 0; i < data['display_urinalysis_services'].length; i++){
              output += "<tr><td><input type='checkbox' class='checkboxUrinalysisService' id="+data['display_urinalysis_services'][i].service_rate+" value="+data['display_urinalysis_services'][i].id+"></td><td class='urinalysisService'>"+data['display_urinalysis_services'][i].service_description+"</td><td class='xrayServiceRate'>"+data['display_urinalysis_services'][i].service_rate+"</td></tr>";
            }
          }
          else if (this.value == '6') {
            output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
            for (var i = 0; i < data['display_urinalysis_services_senior'].length; i++){
              output += "<tr><td><input type='checkbox' class='checkboxUrinalysisService' id="+data['display_urinalysis_services_senior'][i].service_rate+" value="+data['display_urinalysis_services_senior'][i].id+"></td><td class='urinalysisService'>"+data['display_urinalysis_services_senior'][i].service_description+"</td><td class='urinalysisServiceRate'>"+data['display_urinalysis_services_senior'][i].service_rate+"</td></tr>";
            }
          }
          $('.displayServices').html(output);
          if(data['checker'] == '0'){
            $(".displayServices :input").attr("disabled", true);
            $('.urinalysis-bill-input').html("").append("<input type='text' class='form-control' id='urinalysis-bill' disabled>");
            $('.urinalysis-bill-confirm').html("").append("<button type='button' class='btn btn-primary urinalysis-bill-confirm-button' id='urinalysisBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
          }
          else{
            $('.urinalysis-bill-input').html("").append("<input type='text' class='form-control' id='urinalysis-bill' disabled>");
            $('.urinalysis-bill-confirm').html("").append("<button type='button' class='btn btn-primary urinalysis-bill-confirm-button' id='urinalysisBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
          }
          var fin = 0;
          $('.checkboxUrinalysisService').click(function(){
            if ($(this).is(':checked')){
              var urinalysisBillRate = parseFloat($(this).attr('id'));
              fin = parseFloat(fin+urinalysisBillRate);
              $("#urinalysis-bill").val(fin);
              console.log(fin);
            };
          });
        });
      }

      else{
        console.log("Patient is a student");
        $('.medical_senior_checker_urinalysis').hide();
        $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
        output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
        for (var i = 0; i < data['display_urinalysis_services'].length; i++){
          output += "<tr><td><input type='checkbox' class='checkboxUrinalysisService' id="+data['display_urinalysis_services'][i].service_rate+" value="+data['display_urinalysis_services'][i].id+"></td><td class='xrayService'>"+data['display_urinalysis_services'][i].service_description+"</td><td class='drugServiceRate'>"+data['display_urinalysis_services'][i].service_rate+"</td></tr>";
        }
        $('.displayServices').html(output);
        if(data['checker'] == '0'){
          $(".displayServices :input").attr("disabled", true);
          $('.urinalysis-bill-input').html("").append("<input type='text' class='form-control' id='urinalysis-bill' disabled>");
          $('.urinalysis-bill-confirm').html("").append("<button type='button' class='btn btn-primary urinalysis-bill-confirm-button' id='urinalysisBilliConfirmButton_"+appointmentId+"' disabled>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
        }
        else{
          $('.urinalysis-bill-input').html("").append("<input type='text' class='form-control' id='urinalysis-bill' disabled>");
          $('.urinalysis-bill-confirm').html("").append("<button type='button' class='btn btn-primary urinalysis-bill-confirm-button' id='urinalysisBilliConfirmButton_"+appointmentId+"'>Confirm</button><button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>");
        }
        var fin = 0;
        $('.checkboxUrinalysisService').click(function(){
          if ($(this).is(':checked')){
            var urinalysisBillRate = parseFloat($(this).attr('id'));
            fin = parseFloat(fin+urinalysisBillRate);
            $("#urinalysis-bill").val(fin);
            console.log(fin);
          };
        });
      }
      $('#urinalysisBillingModal').modal();
    }
  });
});

$(document).on('click', '.urinalysis-bill-confirm-button', function(){
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
      url: confirmBillingUrinalysis,
      data: {appointment_id:  appointmentId, checked_services_array_id:  checked_services_array_id, checked_services_array_rate:  checked_services_array_rate, _token: token},
      success: function(data)
      {
        $('#addBillingToUrinalysis_'+appointmentId).closest("tr").remove();
        $('#urinalysisBillingModal').modal("hide");
      }
    });
  return false;
});




























































// ------------------PROFILE---------------
// ------------------SEARCH PATIENT---------------
  // $('#searchPatient').keyup(function() {
  //   if($('#searchPatient').val()){
  //     $.ajax({
  //         url: 'search-patient.php',
  //         type: 'POST',
  //         async: true,
  //         data: {
  //             'search_string': $('#searchPatient').val()
  //         },
  //         success:function(response){
  //             output = '';
  //             message=JSON.parse(response);
  //             console.log(message);
  //             // patientId=[];
  //             if(message=='null'){
  //               $('#searchResults').html("");
  //               $('#searchTable').hide();
  //             }
  //             else{
  //               for(i=0; i<message.length; i++) {
  //                 messageSplit = message[i].split("(;;)");
  //                 output += "<tr><td><a class='searchQueryResults' id='resultId_"+messageSplit[0]+"'>"+messageSplit[1]+"</a></td></tr>";
  //               }
  //               $('#searchResults').html(output);
  //               $('#searchTable').show();
  //               $('.searchQueryResults').click(function() {
  //                 var patientId = $(this).attr('id').split('_')[1];
  //                 console.log(patientId);
  //                 $.ajax({
  //                     url: 'search-patient-get-info.php',
  //                     type: 'POST',
  //                     async: true,
  //                     data: {
  //                       'patient_id': patientId
  //                     },
  //                     success:function(response){
  //                         output = '';
  //                         message=jQuery.parseJSON(response);
  //                         $('#ageTd').html(message.age);
  //                         $('#sexTd').html(message.sex);
  //                         $('#courseTd').html(message.degree_program);
  //                         $('#yearlevelTd').html(message.year_level);
  //                         $('#birthdateTd').html(message.birthdate);
  //                         $('#religionTd').html(message.religion);
  //                         $('#nationlityTd').html(message.nationality);
  //                         $('#fatherTd').html(message.father);
  //                         $('#motherTd').html(message.mother);
  //                         $('#homeaddressTd').html(message.street + ', ' + message.town + ', ' + message.province);
  //                         $('#restelTd').html(message.residence_telephone);
  //                         $('#perosnalcontactnumberTd').html(message.personal_contact_number);
  //                         $('#guardiannameTd').html(message.guardian_name);
  //                         $('#guardianaddressTd').html(message.guardian_address);
  //                         $('#guardianrelationshipTd').html(message.guardian_relationship);
  //                         $('#guardiantelTd').html(message.guardian_residence_telephone);
  //                         $('#guardiancpTd').html(message.guardian_residence_cellphone);
  //                         if($('#determine-view-record-button').val()==1){
  //                           $('#patientInfoModalFooter').html('<a href="view-medical-records.php?patient_id=' + patientId +'" class="btn btn-info" role="button">View Medical Records</a><a href="add-new-medical-record-no-appointment.php?patient_id=' + patientId +'" class="btn btn-info" role="button">Add New Record</a>');
  //                         }
  //                         if($('#determine-view-record-button').val()==2){
  //                           $('#patientInfoModalFooter').html('<a href="view-dental-records.php?patient_id=' + patientId +'" class="btn btn-info" role="button">View Dental Records</a><a href="add-new-dental-record-no-appointment.php?patient_id=' + patientId +'" class="btn btn-info" role="button">Add New Record</a>');
  //                         }
  //                     }
  //                 });
  //                 $('#searchPatientRecordInfo').modal();
  //               });
  //             }
  //         }
  //     });
  //   }
  //   else{
  //     $('#searchTable').hide();
  //     $('#searchResults').html("");
  //   }
  // });
});