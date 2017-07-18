<div class="row messages">
    @if($errors->any())
    <div class="col-md-offset-3 col-md-6 alert text-xl bg-danger text-center">
        <h4>Kindly fix the following form errors</h4>
            @foreach($errors->all() as $error)
                <li class="list-item">{{$error}}</li>
            @endforeach
    </div>
    @endif
    @if(Session::has("message"))
        <div class="col-md-offset-3 col-md-6 alert text-xl bg-success text-center">
            {{ Session::get("message") }}
        </div>
    @endif
    @if(Session::has("error"))
        <div class="col-md-offset-3 col-md-6 alert text-xl bg-danger text-center">
            {{ Session::get("error") }}
        </div>
    @endif
    @if(Session::has("info"))
        <div class="col-md-offset-3 col-md-6 alert text-xl bg-info text-center">
            {{ Session::get("info") }}
        </div>
    @endif
    @if(Session::has("warning"))
        <div class="col-md-offset-3 col-md-6 alert text-xl bg-warning text-center">
            {{ Session::get("warning") }}
        </div>
    @endif
    <div class="col-md-offset-3 col-md-6 alert alert-danger text-xl text-center hidden" id="error-message"></div>
</div>
