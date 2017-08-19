@if ($team->contribution_order->count())
    <div class="row margin-bottom-md">
        <div class="col-sm-4 text-center"><span class="color-received padding-left-lg"></span>&nbsp;&nbsp; Received</div>
        <div class="col-sm-4 text-center left-border-no-xs"><span class="color-current padding-left-lg"></span>&nbsp;&nbsp; Current</div>
        <div class="col-sm-4 text-center left-border-no-xs"><span class="color-waiting padding-left-lg"></span>&nbsp;&nbsp; Waiting</div>
    </div>
    <div class="row">
        @foreach ($team->contribution_order as $order)
            <div class="user-section col-xs-12 col-sm-6 col-lg-4 padding-round-md">
                <div class="flex-center img-rounded user-received text-center padding-round-lg bg-received relative">
                    <div class="height-50 img-circle" style="background: url('{{ asset('/storage/avatars/default.jpg') }}') no-repeat;background-size:contain;">
                    </div>
                    <div class="padding-round-sm margin-top-sm bold">
                        {{ $order->user->full_name() }}
                    </div>
                </div>
                <div class="text-center margin-top-md margin-bottom-md">{{ $order->schedule_date }}</div>
            </div>
        @endforeach
        <div class="user-section col-xs-12 col-sm-6 col-lg-4 padding-round-md">
            <div class="flex-center img-rounded user-received text-center padding-round-lg bg-current relative">
                <div class="height-50 img-circle" style="background: url('{{ asset('/storage/avatars/default.jpg') }}') no-repeat;background-size:contain;">
                </div>
                <div class="padding-round-sm margin-top-sm bold">
                    William Smith
                </div> 
            </div>
            <div class="text-center margin-top-md margin-bottom-md">September</div>
        </div>
        <div class="user-section col-xs-12 col-sm-6 col-lg-4 padding-round-md">
            <div class="flex-center img-rounded user-received text-center padding-round-lg bg-waiting relative">
                <div class="height-50 img-circle" style="background: url('{{ asset('/storage/avatars/default.jpg') }}') no-repeat;background-size:contain;">
                </div>
                <div class="padding-round-sm margin-top-sm bold">
                    Paul Linus
                </div> 
            </div>
            <div class="text-center margin-top-md margin-bottom-md">November</div>
        </div>
        <div class="user-section col-xs-12 col-sm-6 col-lg-4 padding-round-md">
            <div class="flex-center img-rounded user-received text-center padding-round-lg bg-waiting relative">
                <div class="height-50 img-circle" style="background: url('{{ asset('/storage/avatars/default.jpg') }}') no-repeat;background-size:contain;">
                </div>
                <div class="padding-round-sm margin-top-sm bold">
                    Aniekan Offiong
                </div>
            </div>
            <div class="text-center margin-top-md margin-bottom-md">April</div>
        </div>
    </div>
@endif