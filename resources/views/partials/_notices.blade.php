<div class="row messages">
    @if($errors->any())
    <div class="col-md-offset-3 col-md-6 alert alert-danger text-md bold text-center alert-dismissible">
        <h4>Kindly fix the following form errors</h4>
            @foreach($errors->all() as $error)
                <li class="list-item">{{$error}}</li>
            @endforeach
    </div>
    @endif
    @if(Session::has("message"))
        <div class="col-md-offset-3 col-md-6 alert text-md bold alert-success text-center alert-dismissible">
            {{ Session::get("message") }}
        </div>
    @endif
    @if(Session::has("error"))
        <div class="col-md-offset-3 col-md-6 alert alert-danger text-md bold text-center alert-dismissible">
            {{ Session::get("error") }}
        </div>
    @endif
    @if(Session::has("info"))
        <div class="col-md-offset-3 col-md-6 alert text-md bold alert-info text-center alert-dismissible">
            {{ Session::get("info") }}
        </div>
    @endif
    @if(Session::has("warning"))
        <div class="col-md-offset-3 col-md-6 alert text-md bold alert-warning text-center alert-dismissible">
            {{ Session::get("warning") }}
        </div>
    @endif
    <div class="col-md-offset-3 col-md-6 alert alert-danger text-md bold text-center alert-dismissible hidden" id="error-message"></div>

    @if (isset($checkInvites) && ($checkInvites->count()) > 0)
        <div class="alert alert-info text-center alert-dismissible bold text-md bold col-md-6 col-md-offset-3 padding-top-md padding-bottom-md">
            You Have {{ $checkInvites->count() }} Pending
            <br />
            <a class="no-underline text-xl" href="{{ url('/teams/invites') }}"><h4 class="padding-top-sm">
                View @if($checkInvites->count() > 1) {{ 'Invites' }} @else {{ 'Invite' }} @endif
            </h4></a>
        </div>
    @endif
</div>
