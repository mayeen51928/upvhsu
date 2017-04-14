$(document).ready( function(){
  $('input[type="text"], textarea').bind('keyup change', function(event) {
      $(this).val($(this).val().charAt(0).toUpperCase() + $(this).val().substr(1));
    });
  // $('input[type="date"]').bind('keyup change', function() {
  //   if(Math.floor((new Date() - new Date($(this).val()))) <= 0
  //     ){
  //       $(this).val('');
  //     }
  //   });
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
  $('.h1Title').mouseover(
    function(){
      $(this).find('.h3Icon').css("animation", "spin 2s");
    }
  );
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

  $('#loginbutton').click(function(){
    if($('#user_name').val() && $('#password').val()){
      $('#user_name').attr('disabled', 'disabled');
      $('#password').attr('disabled', 'disabled');
  }
  });
  if(getCookie('displaywelcomemodal')==''){
    document.cookie = "displaywelcomemodal=yes";
    $('#announcement_modal').modal();
  }
  function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
$('.announcement_title').click(function(event) {
    var announcementId = $(this).attr('id');
    $.post('/announcementmodal', {announcement_id: announcementId}, function(data, textStatus, xhr) {
      $('#announcementTitleModal').html(data['announcement']['announcement_title']);
      $('#announcementBodyModal').html(data['announcement']['announcement_body']);
      $('#announcement_modal').modal();
    });
    
  });

  // --------------------- Staff Page -----------------------
  $('.medicalStaff .clickToShowSchedule').click(function() {
    $('#staff-modal-body table').html('');
    var staffId = $(this).attr('id').split('_')[1];
    $.post('/viewmedicalstaffinfo', {staff_id: staffId}, function(data, textStatus, xhr) {
      $('#staff-modal-title').html(data['staff_info']['staff_first_name'] + ' ' + data['staff_info']['staff_last_name'] + "'s Schedule");
      if(data['times'])
      {
        for(var i=0; i < data['schedules'].length; i++)
        {
          $('#staff-modal-body table').append("<tr><td class='text-center'>" + data['schedules'][i] +"</td><td>" + data['times'][i] + "</tr>");
        }
      }
      else{
        for(var i=0; i < data['schedules'].length; i++)
        {
          $('#staff-modal-body table').append("<tr><td class='text-center'>" + data['schedules'][i] +"</td></tr>");
        }
      }
      $('#staffinfomodal').modal();
    });
  });

    $("#about_medical").click(function(){
    $('#medicalServicesModal').modal();
  });

  $("#about_dental").click(function(){
    $('#dentalServicesModal').modal();
  });

  $("#about_lab").click(function(){
    $('#labServicesModal').modal();
  });

  $("#about_xray").click(function(){
    $('#xrayServicesModal').modal();
  });

  $(function() {
      $('#about_medical').hover(function() {
          $(this).addClass('hover_medical');
      }, function() {
          $(this).removeClass('hover_medical');
      });
  });

  $(function() {
      $('#about_dental').hover(function() {
          $(this).addClass('hover_dental');
      }, function() {
          $(this).removeClass('hover_dental');
      });
  });

  $(function() {
      $('#about_lab').hover(function() {
          $(this).addClass('hover_lab');
      }, function() {
          $(this).removeClass('hover_lab');
      });
  });

  $(function() {
      $('#about_xray').hover(function() {
          $(this).addClass('hover_xray');
      }, function() {
          $(this).removeClass('hover_xray');
      });
  });
});