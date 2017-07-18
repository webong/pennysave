/* For the Countdown on TextArea to indicated number of characters */
$('.countingdown').keyup(updateCount);
$('.countingdown').keydown(updateCount);

function updateCount() {
    var cs = $(this).val().length;
    if (cs == 140) {
        $('.countingdown').html($(this).val().substring(0, 140));
        $('#characters').addClass('text-danger').text('You Have Reached The Limit');
    } else {
        if ($('#characters').hasClass('text-danger')) {
            $('#characters').removeClass('text-danger')
        }
        $('#characters').text(cs);
    }
}
