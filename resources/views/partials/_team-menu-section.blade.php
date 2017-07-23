<div class="panel-body">
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#team-statusboard" data-toggle="pill">Team Statusboard</a></li>
        <li><a href="#view-members" data-toggle="pill">Members</a></li>
        <li><a href="{{ url('/teams/'. $team->id .'/messages') }}">Messages</a></li>
        <li><a href="#invite-members" data-toggle="pill">Invite Members</a></li>
        <li><a href="chat-area" data-toggle="pill">Chat Area</a></li>
        <li><a href="#settings" data-toggle="pill">Settings/Management</a></li>
    </ul>
</div>
