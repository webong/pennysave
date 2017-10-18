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

    $('#reschedule-date-modal').on('show.bs.modal', function () {
        $(this).find('input#update_date').val($('#hidden-team-start-date').html());
    });

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
                var onStarted = "/teams/{{ $team->id }}/started";
                $.ajax({
                type	:	"POST",
                url		: 	"/teams/{{ $team->id }}/start-now",
                data	:	'start=now',
                success	:	function(msg) {
                    if (msg == onStarted) {
                        window.location.replace(msg);
                    } else if (msg == 'error') {
                        swal({
                            title: 'Error Starting Etibe!',
                            titleText: 'Error Starting Etibe!',
                            html: 'You cannot start Etibe alone. Please invite other team members first ' +
                            'or you can create a ' +
                            '<a class="text-md no-underline bold" href="{{ url('/create-personal') }}">Personal Savings Plan</a> instead',
                            type: 'info',
                            confirmButtonColor: '#3085d6',
                        });
                    } else {
                        var involved = JSON.parse(msg);
                        console.log(involved);
                        var message = (involved.length > 1) ? 'See members who have not added yet' : 'See member who has not added yet'
                        var persons = '<table class="table table-striped table-condensed text-sm margin-top-sm">';
                        $.each(involved, function (index, value) {
                            persons += '<tr><td>' + value + '</td></tr>';
                        });
                        persons += '<tr><td><a class="no-underline" href="#">Send Reminder</a></td></tr></table>';
                        swal({
                            title: 'Missing Debiting Accounts!',
                            titleText: 'Missing Debiting Accounts!',
                            html: 'All members of the team have to add their ' +
                            ' <span class="bold dotted-underline" title="The Account that payments will be withdrawn from">DEBITING</span> ' +
                            ' Account before Etibe can start <br />' +
                            '<div class="text-center"><a href="#" id="show-members" class="no-underline text-sm margin-top-sm">' + message + '</a></div>' +
                            '<div class="col-sm-8 col-md-offset-2 margin-bottom-pull-md hidden">' + persons + '</div>',
                            type: 'info',
                            confirmButtonColor: '#3085d6',
                        });
                    }
                },
                error   :   function(msg) {
                    $.alert('Error Starting Etibe, Please refresh the browser and retry', {
                        type: 'error',
                        position: ['top-right', [0,0]],
                        closeTime: 15000,
                        minTop: 55
                    });
                }
            });
        }).catch(swal.noop);
    });

    $(document).on("click", "#show-members", function () {
        $(this).parent().next().removeClass('hidden');
        $(this).addClass('hidden');
        false;
    });

    $('#reschedule-confirm').click(function () {
        $.ajax({
            type	:	"POST",
            url		: 	"/teams/{{ $team->id }}/update-schedule",
            data	:	$('form#reschedule-update-form').serialize(),
            success	:	function(msg) {
                $('div#reschedule-date-modal').modal('hide');
                swal({
                    title: 'Successful',
                    titleText: 'Successful',
                    text: 'The date has been successfully rescheduled',
                    type: 'success',
                    timer: 4000
                });
                var dates = JSON.parse(msg);
                console.log(dates);
                $('p#team-start-date').html(dates.formatted);
                $('p#hidden-team-start-date')
                    .html($('#reschedule-date-modal input#update_date').val());
                $('small#readable-date').html(dates.readable);
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
                $.alert('Announcement Dispatched Successfully', {
                    type: 'success',
                    position: ['top-right', [0,0]],
                    closeTime: 15000,
                    minTop: 55
                });
            },
            error   :   function() {
                $.alert('Error Dispatching Announcement', {
                    type: 'error',
                    position: ['top-right', [0,0]],
                    closeTime: 15000,
                    minTop: 55
                });
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
