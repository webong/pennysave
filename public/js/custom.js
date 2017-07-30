// Append Laravel CSRF Token on AJAX Request Headers
$.ajaxSetup({
   headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});

// To show Loading GIF on ajax actions
$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading"); },
    ajaxStop: function() { $body.removeClass("loading"); }
});

/* For the Countdown on TextArea to indicated number of characters */
$('.countingdown').keyup(updateCount);
$('.countingdown').keydown(updateCount);

function updateCount() {
    var element = $(this);
    var cs = element.val().length;
    if (cs == 140) {
        element.html($(this).val().substring(0, 140));
        element.next('span').addClass('text-danger').text('You Have Reached The Limit');
    } else {
        if (element.next('span').hasClass('text-danger')) {
            element.next('span').removeClass('text-danger')
        }
        element.next('span').text(cs);
    }
}
