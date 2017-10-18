<div class="section tab-pane @if($payment_account) active @endif" id="team-statusboard">

    @if (! confirm_team_status($team->status, $team->start_date))
        <div class="col-md-10 col-md-offset-1 flex-center">
            <h2 class="text-center padding-bottom-xxl">
                Your <strong class="text-info"> Etibe</strong> 
                @if (\Carbon\Carbon::now()->gte($team->start_date)) was @else is @endif scheduled to start
                <p id="team-start-date" class="no-margin-bottom">{{ $team->start_date->format('l jS F, Y') }}</p>
                <p class="hidden" id="hidden-team-start-date">{{ $team->start_date->format('Y-m-d') }}</p>
                <small class="no-padding-top" id="readable-date">({{ $team->start_date->diffForHumans() }})</small>
            </h2>
        </div>
        <div class="row text-center">
            <button class="btn btn-primary inline" data-toggle="modal" data-target="#reschedule-date-modal">Reschedule Start Date</button>
            <button class="btn btn-primary inline" id="start_now">Start Now Instead</button>
        </div>

        @include('modals._reschedule-modal')

    @else
        <div class="row text-center">
            <button class="btn btn-primary inline" data-toggle="modal" data-target="#make-announcement-modal">Make Announcement</button>
            <button class="btn btn-primary inline" onclick="window.location.href='{{ url("teams/" . $team->id . "/messages/create/everyone") }}'">Send General Message</button>
        </div>
        @if ($team->user->count() > 1)
            <div class="row">
                <?php
                    $current_cycle = 0;
                    foreach ($team->contribution_order as $date) {
                        if ($date->schedule_date->lt(\Carbon\Carbon::now())) {
                            $current_cycle++;
                        }
                    }
                    $current_cycle++;
                ?>
                <div class="col-md-10 col-md-offset-1">
                    <h3 class="text-center margin-bottom-md">You are currently in your <span class="text-info text-xxl">
                        <?php $nf = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                        echo $nf->format($current_cycle); ?></span> cycle
                    </h3>
                </div>
            </div>
            
            <?php $count = 0; ?>
            <div class="col-md-10 col-md-offset-1">
                <table class="table table-striped table-condensed table-responsive text-center">
                    <thead>
                        <tr>
                            <th class="text-center">S/N</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Date Due To Receive</th>
                            <th class="text-center">Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($team->contribution_order as $order)
                            <tr>
                                <td class="vertical-center">{{ ++$count }}</td>
                                <td class="vertical-center">{{ $order->user->full_name() }}</td>
                                <td class="vertical-center">{{ $order->schedule_date->format('jS F, Y') }} <br /> ({{ $order->schedule_date->diffForHumans() }})</td>
                                <td class="vertical-center">@if ($order->status)<span class="alert-success">Paid</span>@else<span class="alert-warning">Not Paid</span>@endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @include('modals._make-announcement-modal')

        @else
            <div class="text-center flex-center">
                <h4 class="text-info">
                    Other members have not joined the Team yet. <br />
                    If you want to have a Personal Savings Plan instead, you can set up one below
                </h4>
            </div>
            <button class="btn btn-primary center-block margin-top-xxl" onclick='window.location.href="{{ url('/create-personal') }}"'>
                Start Personal Plan
            </button>
        @endif
    @endif
</div>
<div class="modal-loading"></div>