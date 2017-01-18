$(document).ready( function(){
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $('.see_more_announcements').click(function() {
    announcementId = $(this).attr('id');
    console.log(announcementId);
    console.log('#announcement_body_'+ announcementId)
    $('#announcement_body_'+ announcementId).css('display','block');
  })
})