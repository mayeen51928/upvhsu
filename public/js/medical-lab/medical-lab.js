$(document).ready( function(){
$.ajaxSetup({
  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
// ------------------DASHBOARD---------------
$('.addCbcResult').click(function(){
  var cbc_id = $(this).attr('id').split("_")[1];
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
        $('#addCbcResult_'+cbc_id).closest("tr").remove();
        $('#add-cbc-result').modal('hide');
      });
    }
  });
});
$('.addDrugTestResult').click(function(){
  var drug_test_id = $(this).attr('id').split("_")[1];
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
        $('#addDrugTestResult_'+drug_test_id).closest("tr").remove();
        $('#add-drug-test-result').modal('hide');
      });
    }
  });
});
  $('.addFecalysisResult').click(function(){
    $('#add-fecalysis-result').modal();
  });
  $('.addUrinalysisResult').click(function(){
    $('#add-urinalysis-result').modal();
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