$(document).ready( function(){

  var homeJumbotron = 1 + Math.floor(Math.random() * 3);
  if(homeJumbotron == 1)
  {
    $('#homeJumbotron').css('background-image', 'url(../images/infirm.jpg)');
  }
  else if(homeJumbotron == 2)
  {
    $('#homeJumbotron').css('background-image', 'url(../images/infirm1.jpg)');
  }
  else if(homeJumbotron == 3)
  {
    $('#homeJumbotron').css('background-image', 'url(../images/infirm2.jpg)');
  }

  numOfClicksMedical = 0;
  numOfClicksDental = 0;
  percentageDental = 0;
  percentageMedical = 0;
  $('.h3Title').mouseover(
    function(){
      $(this).find('.h3Icon').css("animation", "spin 2s");
    });
  $(window).scroll( function(){
    /* Check the location of each desired element */
    $('.fadeShow').each( function(i){
      var bottom_of_object = $(this).offset().top + $(this).outerHeight();
      var bottom_of_window = $(window).scrollTop() + $(window).height();
      /* If the object is completely visible in the window, fade it it */
      if( bottom_of_window > bottom_of_object ){
        $(this).animate({'opacity':'1'},500);
      }
    });
  });

  //Home Login
  $('#login').click(function(){
    if(!($('#user_name').val()) && !($('#password').val())){
      $('#loginErrorMessage').html('Enter username and password');
      return false;
    }
    else if(!($('#user_name').val()) && ($('#password').val())){
      $('#loginErrorMessage').html('Enter username');
      return false;
    }
    else if(($('#user_name').val()) && !($('#password').val())){
      $('#loginErrorMessage').html('Enter password');
      return false;
    }
    else{
    } 
  });
  $('.homeForm:first').delay("200").fadeIn();
  $('.homeForm:last').delay("500").fadeIn();

  // --------------------- Staff Page -----------------------
  $('.medicalStaff .medicalStaffImg').click(function() {
    $('#staff-modal-body table').html('');
    var staffId = $(this).attr('id').split('_')[1];
    $.post('/viewmedicalstaffinfo', {staff_id: staffId}, function(data, textStatus, xhr) {
      $('#staff-modal-title').html(data['staff_info']['staff_first_name'] + ' ' + data['staff_info']['staff_last_name'] + "'s Schedule");
      for(var i=0; i < data['schedules'].length; i++)
          {
            $('#staff-modal-body table').append("<tr><td>" + data['schedules'][i] +"</td></tr>");
          }
      $('#staffinfomodal').modal();
    });
    
  });
});