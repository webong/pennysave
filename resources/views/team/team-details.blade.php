<div class="section tab-pane active" id="team-statusboard">

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

        <p id="team-debugging"></p>

        @include('modals._reschedule-modal')

    @else
        <div class="row text-center">
            <button class="btn btn-primary inline" data-toggle="modal" data-target="#make-announcement-modal">Make Announcement</button>
            <button class="btn btn-primary inline" onclick="window.location.href='{{ url("teams/" . $team->id . "/messages/create/everyone") }}'">Send General Message</button>
        </div>
        @if ($team->user->count() > 1)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h3 class="text-center margin-bottom-md">You are currently in your <span class="text-info text-xxl">
                        <?php $nf = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                        echo $nf->format($team->user->where('pivot.status', 'active')->count()); ?></span> cycle
                    </h3>
                </div>
            </div>
            
            @include('team.group-arrangements')
            
            <?php $count = 0; ?>
            <h3 class="text-center">Members List</h3>
            <table class="table table-bordered table-condensed table-responsive text-center">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Date Joined</th>
                        <th class="text-center">Group Status</th>
                        <th class="text-center">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($team->user as $user)
                        <tr>
                            <td>{{ ++$count }}</td>
                            <td class="text-left">{{ $user->full_name() }}</td>
                            <td>{{ $user->created_at->format('jS F, Y') }} ({{ $team->created_at->diffForHumans() }})</td>
                            <td>{{ $user->role()->wherePivot('group_id', $team->id)->first()->display_name }}</td>
                            <td>{{ ucfirst($user->pivot->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
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