$(document).ready( function(){
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $('.see_more_announcements').click(function() {
    announcementId = $(this).attr('id');
    console.log("Show announcement.");
    $('#announcement_body_'+ announcementId).css('display','block');
    $('#'+announcementId).css('display','none');
    $('.see_more_button').html("").append("<a class=see_more_announcements_hide id="+announcementId+"><br/>See more <i class='fa fa-caret-down'></i></a>");
  })

  $('.see_more_announcements_hide').click(function() {
      announcementId = $(this).attr('id');
      console.log("Hide announcement.");
      $('#announcement_body_'+ announcementId).css('display','none');
      $('#'+announcementId).css('display','none');
      $('.see_more_button').html("").append("<a class=see_more_announcements id="+announcementId+"><br/>See more <i class='fa fa-caret-down'></i></a>");
    })
})