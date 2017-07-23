@extends('layouts._sections')

@section('added_css')
    <link href="{{ asset('css/personal-dashboard.min.css') }}" rel="stylesheet">
@endsection

@section('left-side-menu')
    @include('partials._personal-menu-section')
@endsection

@section('body-title')
    <h2 class="page-heading text-info text-center">View Invites<hr /></h2>
@endsection

@section('main-body-section')
    @if ($allInvites)
        <?php $count = 0; ?>
        <h3 class="text-center">Team Invitations Received</h3>
        <table class="table table-bordered table-condensed table-responsive text-center">
            <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th class="text-center">Name of Inviter</th>
                    <th class="text-center">Name of Team</th>
                    <th class="text-center">Amount To Contribute</th>
                    <th class="text-center">Invitation Sent</th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allInvites as $invites)
                    <tr>
                        <td>{{ ++$count }}</td>
                        <td>{{ $invites->user->full_name() }}</td>
                        <td>{{ $invites->group->name }}</td>
                        <td>{{ number_format($invites->group->amount) }}</td>
                        <td>{{ $invites->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ url('/personal/invites') }}" method="post" id="invite-confirmation">
                                {{ csrf_field() }}
                                <button class="btn btn-success btn-sm" name="accept-invite" value="accept-invite" data-team="{{ $invites->group->name }}" id="accept-invite">Accept</button>
                                <button class="btn btn-danger btn-sm" name="reject-invite" value="reject-invite" data-team="{{ $invites->group->name }}" id="reject-invite">Decline</button>
                                <input type="hidden" name="team_id" value="{{ $invites->team_id }}">
                                <input type="hidden" name="inviter_id" value="{{ $invites->user->id }}">
                                <input type="hidden" name="invite_response" id="invite-response">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center flex-center">
            <h4 class="text-info">
                You do not have any pending invites to Accept/Reject.
            </h4>
        </div>
        <button class="btn btn-primary center-block margin-top-xxl" onclick='window.location.href="{{ url('/dashboard') }}"'>Back To Dashboard</button>
    @endif
@endsection

@section('added_js')
    <script type="text/javascript">
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
        })
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

            // .then(function () {
            //     var deleteList = Array();
            //     $('.checkbox_select:checked').each(function() {
            //         console.log($(this).val());
            //         return;
            //         deleteList.push($(this).val());
            //     });
            //     $('#deleteSection').val(deleteList);
            //     $('#table_selection').submit();
            // })
        });
    </script>
@endsection