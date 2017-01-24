$(document).ready( function(){
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $('.see_more_announcements').click(function() {
    id = $(this).attr('id').split("_");
    announcementId = id[3];
    $('#announcement_body_'+ announcementId).css('display','block');
    $('#see_more_announcements_'+announcementId).removeClass('see_more_announcements').addClass('newClass');
    $('.newClass').click(function() {
      console.log("Hide announcement.");
      $('#announcement_body_'+ announcementId).css('display','none');
      $('#see_more_announcements_'+announcementId).removeClass('newClass').addClass('see_more_announcements');
    })
  })
})