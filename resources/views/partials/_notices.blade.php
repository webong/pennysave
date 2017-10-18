<div class="row messages">
    @if($errors->any())        
        <script>
            $(function () {
                $.alert(
                '@foreach($errors->all() as $error)<li class="list-item">{{$error}}</li>@endforeach', {
                    type: 'danger',
                    title: '<b>Kindly fix the following form errors</b>',
                    position: ['top-right', [0,0]],
                    closeTime: 15000,
                    minTop: 55
                });
            });
        </script>
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
    @if(Session::has("success"))
        <script>
            $(function () {
                $.alert('{{ Session::get("success") }}', {
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
                $.alert('<a class="no-underline" href="{{ url('/teams/invites') }}"><span class="text-lg">Click To View @if($checkInvites->count() > 1) {{ 'Invites' }} @else {{ 'Invite' }} @endif</span></a>', {
                    title: "You Have {{ $checkInvites->count() }} Pending",
                    type: 'info',
                    position: ['top-right', [0,0]],
                    closeTime: 30000,
                    minTop: 55,
                });
            });
        </script>
    @endif
</div>