<div class="panel-body">
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#payment-account" data-toggle="pill">&#x20A6; &nbsp; Payment Account</a></li>
        <li class=""><a href="#team-statusboard" data-toggle="pill"><i class="fa fa-dashboard"></i> &nbsp; Team Statusboard</a></li>
        <li><a href="#view-members" data-toggle="pill"><i class="fa fa-users"></i> &nbsp;Members</a></li>
        <li><a href="{{ url('/teams/'. $team->id .'/messages') }}"><i class="fa fa-envelope"></i> &nbsp; Messages</a></li>
        <li><a href="#invite-members" data-toggle="pill"><i class="fa fa-user-plus"></i> &nbsp; Invite Members</a></li>
        <li><a href="#notifications" data-toggle="pill"><i class="fa fa-bell"></i> &nbsp; Notifications</a></li>
        <li><a href="{{ url('/teams/'. $team->id .'/chat-area') }}" data-toggle="pill"><i class="fa fa-comments"></i> &nbsp;Chat Area</a></li>
        <li><a href="#settings" data-toggle="pill"><i class="fa fa-cog"></i> &nbsp; Settings/Management</a></li>
    </ul>
</div>
