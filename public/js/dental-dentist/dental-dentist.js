$(document).ready( function(){
// ----------------------------- Dashboard -----------------------------





// ----------------------------- End of Dashboard ----------------------






// ----------------------------- Profile -----------------------------





// ----------------------------- End of Profile ----------------------









// ----------------------------- Manage Schedule -----------------------------

$('.addmoredentalsched').click(function(){
    $(this).parents('.dental_manage').find('tbody').append('<tr class="schedule_tr"><td><input type="date" class="form-control"/></td><td><input type="time" class="form-control starthour"/></td><td><input type="time" class="form-control endhour"/></td><td><button class="btn btn-danger btn-sm removedentalsched">Remove</button></td></tr>');
    $('.removedentalsched').click(function(){
        // console.log($(this).closest('tr'));
        $(this).closest('tr').remove();
    });
});
$('.removedentalsched').click(function(){
    // console.log($(this).closest('tr'));
    $(this).closest('tr').remove();
});
$('#adddentalschedule').click(function(){
    var schedules = [];
    $('.schedule_tr').each(function(){
        if($(this).find('input[type="date"]').val() && $(this).find('.starthour').val() && $(this).find('.endhour').val()){
            schedules.push($(this).find('input[type="date"]').val() + ' ' + $(this).find('.starthour').val() + ':00;;;' + $(this).find('input[type="date"]').val() + ' ' + $(this).find('.endhour').val() + ':00');
            console.log(schedules);
        }
    });
    if(schedules.length > 0){
        $.ajax({
            url: addDentalSchedule,
            type: 'POST',
            dataType: 'json',
            data: {schedules:  schedules, _token: token},
            success: function(data) {
                $('button').attr('disabled', 'disabled');
                $('input').attr('disabled', 'disabled');
                $('#manageschedulepanel').css('background-color', '#d6e9c6');
            },
            error: function(xhr, textStatus, errorThrown) {
            }
        });
    }
    
});

// ----------------------------- End of Manage Schedule ----------------------
});