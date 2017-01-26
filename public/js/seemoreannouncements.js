$(document).ready( function(){
  $.ajaxSetup({
    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
  });

  $('.see_more_announcement').click(function() {
    id = $(this).attr('id').split("_");
    announcementId = id[3];
    $('#announcement_body_'+ announcementId).css('display','block');
    $('#hide_announcement_'+ announcementId).css('display','block');
    $('#see_more_announcement_'+ announcementId).css('display','none');
  })

  $('.hide_announcement').click(function() {
    id = $(this).attr('id').split("_");
    console.log(id);
    announcementId = id[2];
    $('#announcement_body_'+ announcementId).css('display','none');
    $('#hide_announcement_'+ announcementId).css('display','none');
    $('#see_more_announcement_'+ announcementId).css('display','block');
  })
})