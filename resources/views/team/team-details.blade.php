<div class="section tab-pane active" id="team-statusboard">
    @if (! $team->status)
        <div class="col-md-10 col-md-offset-1 flex-center">
            <h2 class="text-center padding-bottom-xxl">
                Your <strong class="text-info">Etibe</strong> is scheduled to start <br />
                {{ $team->start_date->format('l jS F, Y') }}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-primary pull-right">Reschedule</button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary">Start Now</button>
            </div>
        </div>
    @else
        <div class="col-md-10 col-md-offset-1">
            <h3 class="text-center margin-bottom-md">You are currently in your <span class="text-info">
                <?php $nf = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                 echo $nf->format($team->user->where('pivot.status', 'active')->count()); ?></span> cycle
             </h3>
        </div>
        @if ($team->user->count() > 0)
            <?php $count = 0; ?>
            <h3 class="text-center">Members List</h3>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Date Joined</th>
                        <th>Group Status</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($team->user as $user)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $user->full_name() }}</td>
                            <td>{{ $user->created_at->format('jS F, Y') }}</td>
                            <td>{{ $user->role()->wherePivot('group_id', $team->id)->first()->display_name }}</td>
                            <td>{{ $user->pivot->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center">

            </div>
        @endif
        <hr />
        <div class="col-md-6">
            <button class="btn btn-primary pull-right">Make Announcement</button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-primary">Send General Message</button>
        </div>
    @endif
</div>
