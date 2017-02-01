$(document).ready( function(){
// ------------------DASHBOARD---------------
  $('.addLaboratoryResult').click(function(){
    $('#add-laboratory-result').modal();
    // console.log($(this).attr('id'));
    // var rowToRemove = $(this).attr('id');
    // var buttonId = ($(this).attr('id').split('_'));
    // var patient_id = buttonId[1];
    // var appointment_id = buttonId[2];
    // var staff_id = buttonId[3];
    // $('#add-laboratory-result').modal();
    // $('#addLabResultButton').click(function(){
    //   if($('#hemoglobin-lab').val()
    //       && $('#hemasocrit-lab').val()
    //       && $('#wbc-lab').val()
    //       && $('#pus-cells-lab').val()
    //       && $('#rbc-lab').val()
    //       && $('#albumin-lab').val()
    //       && $('#sugar-lab').val()
    //       && $('#macroscopic-lab').val()
    //       && $('#microscopic-lab').val()
    //       && $('#drug-test-lab').val())
    //   {
    //     var hemoglobin = $('#hemoglobin-lab').val();
    //     var hemasocrit = $('#hemasocrit-lab').val();
    //     var wbc = $('#wbc-lab').val();
    //     var pusCells = $('#pus-cells-lab').val();
    //     var rbc = $('#rbc-lab').val();
    //     var albumin = $('#albumin-lab').val();
    //     var sugar = $('#sugar-lab').val();
    //     var macroscopic = $('#macroscopic-lab').val();
    //     var microscopic = $('#microscopic-lab').val();
    //     var drugTest = $('#drug-test-lab').val();
    //     $.ajax({
    //         type: "POST",
    //         url: "add-lab-results.php",
    //         async: true,
    //         data: 
    //         {   'patient_id':patient_id,
    //             'appointment_id':appointment_id,
    //             'staff_id': staff_id,
    //             'hemoglobin':hemoglobin,
    //             'hemasocrit':hemasocrit,
    //             'wbc':wbc,
    //             'pus-cells':pusCells,
    //             'rbc':rbc,
    //             'albumin':albumin,
    //             'sugar':sugar,
    //             'macroscopic':macroscopic,
    //             'microscopic':microscopic,
    //             'drug-test':drugTest,
    //         },
    //         success: function(response)
    //         {
    //             message = JSON.parse(response);
    //             console.log(message);
    //             if(message==1){
    //                 console.log("Success!");
    //                 $('#'+rowToRemove).parents('tr').remove();
    //                 $('#add-laboratory-result').modal('hide');
    //             }
    //         }
    //     });
    //   }
    // });
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