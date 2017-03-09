$(document).ready( function(){
$.ajaxSetup({
  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
// ------------------DASHBOARD---------------
$('.addCbcResult').click(function(){
	var cbc_id = $(this).attr('id').split("_")[1];
  $('#hemoglobin-lab, #hemasocrit-lab, #wbc-lab').val('');
	$('#add-cbc-result').modal();
	$('#addCbcResultButton').click(function(){
		if($('#hemoglobin-lab').val() && $('#hemasocrit-lab').val() && $('#wbc-lab').val())
		{
			var hemoglobin = $('#hemoglobin-lab').val();
	      var hemasocrit = $('#hemasocrit-lab').val();
	      var wbc = $('#wbc-lab').val();
	      $.post('/addcbcresult',
	      {
	      	cbc_id: cbc_id,
	      	hemoglobin: hemoglobin,
	      	hemasocrit: hemasocrit,
	      	wbc: wbc,
	      } , function(data){
	      	$('#add-cbc-result').modal('hide');
	      });
	   }
	});
});
$('.addDrugTestResult').click(function(){
  var drug_test_id = $(this).attr('id').split("_")[1];
  $('#drug-test-lab option').prop('selected', function()
  {
    return this.defaultSelected;
  });
  $('#add-drug-test-result').modal();
  $('#addDrugTestResultButton').click(function(){
    if($('#drug-test-lab').val())
    {
      var drug_test_result = $('#drug-test-lab').val();
      $.post('/adddrugtestresult',
      {
        drug_test_id: drug_test_id,
        drug_test_result: drug_test_result,
      } , function(data){
        $('#add-drug-test-result').modal('hide');
      });
    }
  });
});
$('.addFecalysisResult').click(function(){
	var fecalysis_id = $(this).attr('id').split("_")[1];
  $('#macroscopic-lab, #microscopic-lab').val('');
	$('#add-fecalysis-result').modal();
	$('#addFecalysisResultButton').click(function(){
		if($('#macroscopic-lab').val() && $('#microscopic-lab').val())
		{
			var macroscopic = $('#macroscopic-lab').val();
			var microscopic = $('#microscopic-lab').val();
			$.post('/addfecalysisresult',
			{
				fecalysis_id: fecalysis_id,
				macroscopic: macroscopic,
				microscopic: microscopic,
			} , function(data){
				$('#add-fecalysis-result').modal('hide');
			});
		}
	});
});
$('.addUrinalysisResult').click(function(){
	var urinalysis_id = $(this).attr('id').split("_")[1];
  $('#rbc-lab, #pus-cells-lab').val('');
  $('#albumin-lab option, #sugar-lab option').prop('selected', function()
  {
    return this.defaultSelected;
  });
	$('#add-urinalysis-result').modal();
	$('#addUrinalysisResultButton').click(function(){
		if($('#pus-cells-lab').val() && $('#rbc-lab').val() && $('#albumin-lab').val() && $('#sugar-lab').val())
		{
			var pus_cells = $('#pus-cells-lab').val();
			var rbc = $('#rbc-lab').val();
			var albumin = $('#albumin-lab').val();
			var sugar = $('#sugar-lab').val();
			$.post('/addurinalysisresult',
			{
				urinalysis_id: urinalysis_id,
				pus_cells: pus_cells,
				rbc: rbc,
				albumin: albumin,
				sugar: sugar,
			} , function(data){
				$('#add-urinalysis-result').modal('hide');
			});
		}
	});
});

$('.addBillingToCbc').click(function(){
  var id = $(this).attr('id').split("_");
  appointmentId = id[1];
  $.ajax({
    type: "POST",
    url: addBillingCbc,
    data: {appointment_id:  appointmentId, _token: token},
    success: function(data)
    {
      output = '';
      $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
      output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
      for (var i = 0; i < data['display_cbc_services'].length; i++){
        output += "<tr><td><input type='checkbox' class='checkboxCbcService' id="+data['display_cbc_services'][i].service_rate+" value="+data['display_cbc_services'][i].id+"></td><td class='cbcService'>"+data['display_cbc_services'][i].service_description+"</td><td class='cbcServiceRate'>"+data['display_cbc_services'][i].service_rate+"</td></tr>";
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
        };
      });
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

$('.addBillingToDrug').click(function(){
  var id = $(this).attr('id').split("_");
  appointmentId = id[1];
  $.ajax({
    type: "POST",
    url: addBillingDrug,
    data: {appointment_id:  appointmentId, _token: token},
    success: function(data)
    {
      output = '';
      $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
      output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
      for (var i = 0; i < data['display_drug_services'].length; i++){
        output += "<tr><td><input type='checkbox' class='checkboxDrugService' id="+data['display_drug_services'][i].service_rate+" value="+data['display_drug_services'][i].id+"></td><td class='drugService'>"+data['display_drug_services'][i].service_description+"</td><td class='drugServiceRate'>"+data['display_drug_services'][i].service_rate+"</td></tr>";
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
        };
      });
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

$('.addBillingToFecalysis').click(function(){
  var id = $(this).attr('id').split("_");
  appointmentId = id[1];
  $.ajax({
    type: "POST",
    url: addBillingFecalysis,
    data: {appointment_id:  appointmentId, _token: token},
    success: function(data)
    {
      output = '';
      $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
      output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
      for (var i = 0; i < data['display_fecalysis_services'].length; i++){
        output += "<tr><td><input type='checkbox' class='checkboxFecalysisService' id="+data['display_fecalysis_services'][i].service_rate+" value="+data['display_fecalysis_services'][i].id+"></td><td class='fecalysisService'>"+data['display_fecalysis_services'][i].service_description+"</td><td class='fecalysisServiceRate'>"+data['display_fecalysis_services'][i].service_rate+"</td></tr>";
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
        };
      });
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
































$('.addBillingToUrinalysis').click(function(){
  var id = $(this).attr('id').split("_");
  appointmentId = id[1];
  $.ajax({
    type: "POST",
    url: addBillingUrinalysis,
    data: {appointment_id:  appointmentId, _token: token},
    success: function(data)
    {
      output = '';
      $('.patient_name').html('<h4>'+data['patient_info']['patient_first_name']+' '+data['patient_info']['patient_last_name']+'</h4>');
      output += "<tr><th></th><th>Service Description</th><th>Service Rate</th></tr>"
      for (var i = 0; i < data['display_urinalysis_services'].length; i++){
        output += "<tr><td><input type='checkbox' class='checkboxUrinalysisService' id="+data['display_urinalysis_services'][i].service_rate+" value="+data['display_urinalysis_services'][i].id+"></td><td class='urinalysisService'>"+data['display_urinalysis_services'][i].service_description+"</td><td class='urinalysisServiceRate'>"+data['display_urinalysis_services'][i].service_rate+"</td></tr>";
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
        };
      });
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