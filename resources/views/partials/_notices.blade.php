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
        <script>
            $(function () {
                $.alert('{{ Session::get("message") }}', {
                    type: 'success',
                    position: ['top-right', [0,0]],
                    closeTime: 15000,
                    minTop: 55
                });
            });
        </script>
    @endif
    @if(Session::has("error"))
        <script>
            $(function () {
                $.alert('{{ Session::get("error") }}', {
                    type: 'danger',
                    position: ['top-right', [0,0]],
                    closeTime: 15000,
                    minTop: 55
                });
            });
        </script>
    @endif
    @if(Session::has("info"))
        <script>
            $(function () {
                $.alert('{{ Session::get("info") }}', {
                    type: 'info',
                    position: ['top-right', [0,0]],
                    closeTime: 15000,
                    minTop: 55
                });
            });
        </script>
    @endif
    @if(Session::has("warning"))
        <script>
            $(function () {
                $.alert('{{ Session::get("warning") }}', {
                    type: 'warning',
                    position: ['top-right', [0,0]],
                    closeTime: 15000,
                    minTop: 55
                });
            });
        </script>
    @endif

    @if (isset($checkInvites) && ($checkInvites->count()) > 0)
        <script>
            $(function () {
                $.alert('<a class="no-underline" href="{{ url('/teams/invites') }}"><span class="text-lg">View @if($checkInvites->count() > 1) {{ 'Invites' }} @else {{ 'Invite' }} @endif</span></a>', {
                    title: "You Have {{ $checkInvites->count() }} Pending",
                    type: 'info',
                    position: ['top-right', [0,0]],
                    closeTime: 15000,
                    minTop: 55,
                    autoClose: false
                });
            });
        </script>
    @endif
</div>
