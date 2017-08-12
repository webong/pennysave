<?php
    if ($team->recurrence == 1) $continuous = "d";
    elseif ($team->recurrence == 2) $continuous = "w";
    elseif ($team->recurrence == 4) $continuous = "M";
?>

<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
    if (!Modernizr.touch || !Modernizr.inputtypes.date) {
        $(function () {
            $('#update_date').datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 2,
                onSelect: function() {
                    $(this).change();
                }
            }).on("change", function() {
                display_status("The date to start will now be <strong>" + moment($('#update_date').val()).format('ddd[.] Do MMM[,] YYYY') + "<br /><p class='text-center'> (" + moment($('#update_date').val()).fromNow() + ")</p></strong>");
            });
        });
    }
    function display_status(msg) {
        $("#new_date_confirm").html(msg);
    };

    $('#start_now').click(function() {
        swal({
            title: 'Are you sure?',
            titleText: 'Are you sure?',
            html: "All members will notified immediately. <br /> First Payments will be " 
                @if ($team->recurrence == 3) + moment().add(2, 'w').fromNow(),
                @else + moment().add(1, '{{ $continuous }}').fromNow(),
                @endif
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Go Ahead!'
        }).then(function () {
                $.ajax({
                type	:	"POST",
                url		: 	"/teams/{{ $team->id }}/start-now",
                data	:	'start=now',
                success	:	function(msg) {
                    console.log(msg);
                    
                },
                error   :   function(msg) {
                    console.log('Error Starting Team' + msg);
                }
            });
        }).catch(swal.noop);
    });

    $('#reschedule-confirm').click(function () {
        $.ajax({
            type	:	"POST",
            url		: 	"/teams/{{ $team->id }}/update-schedule",
            data	:	$('form#reschedule-update-form').serialize(),
            success	:	function(msg) {
                swal({
                    title: 'Successful',
                    titleText: 'Successful',
                    text: 'The date has been successfully rescheduled',
                    type: 'success',
                    timer: 4000
                });
            },
            error   :   function() {
                console.log('Error Updating Date');
            }
        });
    });
    
    $('#mark-as-unread').click(function () {
        // var announceId = 
        $.ajax({
            type	:	"POST",
            url		: 	"/teams/{{ $team->id }}/announcements/id/mark-as-seen",
            data	:	$('form#reschedule-update-form').serialize(),
            success	:	function(msg) {
                swal({
                    title: 'Successful',
                    titleText: 'Successful',
                    text: 'The date has been successfully rescheduled',
                    type: 'success',
                    timer: 4000
                });
            },
            error   :   function() {
                console.log('Error Updating Date');
            }
        });
    });
    // Fill modal with content from link href
    $("#rescheduleDate").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-body").load(link.attr("href"));
    });

    $('#create-announcement').click(function () {
        $.ajax({
            type	:	"POST",
            url		: 	"/teams/{{ $team->id }}/announcements/create",
            data	:	$('form#make-announcement-form').serialize(),
            success	:	function(msg) {
                console.log(msg);
            },
            error   :   function() {
                console.log('Error Updating Date');
            }
        });
    });

    $('.view-notification').click(function () {
        $('#view-announcement-modal .modal-title').html($(this).data('subject'));
        $('#view-announcement-modal .modal-body').html($(this).data('content'));
        $('#view-announcement-modal').modal('show');
        $.ajax({
            type	:	"POST",
            url		: 	"/teams/{{ $team->id }}/announcements/update",
            data	:	'announce_id=' + $(this).data('url'),
            success	:	function(msg) {
                console.log(msg.content);
                console.log(msg.subject);
                $('#view-announcement-modal .modal-title').html(msg.subject);
                $('#view-announcement-modal .modal-body').html(msg.content);
                $('#view-announcement-modal').modal('show');
            },
            error   :   function() {
                console.log('Error Updating Date');
            }
        });
    });

</script>
