<div class="section tab-pane active" id="team-statusboard">
    @if ( confirm_team_status($team->status, $team->start_date))
        <div class="col-md-10 col-md-offset-1 flex-center">
            <h2 class="text-center padding-bottom-xxl">
                Your <strong class="text-info">Etibe</strong> is scheduled to start <br />
                {{ $team->start_date->format('l jS F, Y') }}<br /><small>({{ $team->start_date->diffForHumans() }})</small>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-primary pull-right" onclick="window.location.href='{{ url("/teams/' .$team->id .'/settings") }}'">Reschedule Start Date</button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary">Start Now Instead</button>
            </div>
        </div>
    @else
        @if ($team->user->count() > 1)
            <div class="col-md-10 col-md-offset-1">
                <h3 class="text-center margin-bottom-md">You are currently in your <span class="text-info text-xxl">
                    <?php $nf = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                    echo $nf->format($team->user->where('pivot.status', 'active')->count()); ?></span> cycle
                </h3>
            </div>
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
                            <td>{{ $user->full_name() }}</td>
                            <td>{{ $user->created_at->format('jS F, Y') }} ({{ $team->created_at->diffForHumans() }})</td>
                            <td>{{ $user->role()->wherePivot('group_id', $team->id)->first()->display_name }}</td>
                            <td>{{ ucfirst($user->pivot->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr />
            <div class="col-md-6">
                <button class="btn btn-primary pull-right">Make Announcement</button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary">Send General Message</button>
            </div>
        @else
            <div class="text-center flex-center">
                <h4 class="text-info">
                    Other members have not joined the Team yet. <br /> If you want to have a Personal Savings Plan instead, you can set up one below
                </h4>
            </div>
            <button class="btn btn-primary center-block margin-top-xxl" onclick='window.location.href="{{ url('/create-personal') }}"'>Start Personal Plan</button>
        @endif
    @endif
</div>
