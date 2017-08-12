<script type="text/javascript">
    $(function() {
        $('#accept-invite').click(function(evt) {
            evt.preventDefault();
            swal({
                title: 'Please Confirm!',
                titleText: 'Please Confirm!',
                html: "You will now be added to the team: <strong>" + $(this).data('team') + "</strong>",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Go Ahead!'
            }).then(function () {
                $('#invite-response').val($('#accept-invite').val());
                $('#invite-confirmation').submit();
            }).catch(swal.noop);
        });
        $('#reject-invite').click(function(evt) {
            evt.preventDefault();
            swal({
                title: 'Are you sure?',
                titleText: 'Are you sure?',
                text: "You cannot join the Team unless you are re-invited",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Decline'
            }).then(function () {
                $('#invite-response').val($('#reject-invite').val());
                $('#invite-confirmation').submit();
            }).catch(swal.noop);
        });
    });
</script>