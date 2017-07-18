<div class="section tab-pane" id="view-members">
    @foreach ($team->user as $user)
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <img src="{{ urldecode(asset($user->avatar)) }}" alt="{{ $user->full_name() }}" class="img-rounded img-responsive" />
            <div class="caption text-center">
                <h3>{{ $user->full_name() }}</h3>
                <p>{{ $user->email }}</p>
                <p><a href="{{ url('members/' . $user->id) }}" class="btn btn-primary" role="button">View Details</a></p>
            </div>
        </div>
    </div>
    @endforeach
</div>
