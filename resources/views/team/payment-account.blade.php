<div class="section tab-pane @if(! $payment_account) active @endif" id="payment-account">
    <div class="col-sm-6 account-section debit-section border-right">
        <h3 class="text-center">
            Debiting Account
            <small class="text-sm block margin-top-sm">This is the Account from which your Etibe Contribution will be debited.</small>
        </h3>
        <hr class="hr-sm">
        <div class="row">
            <button class="btn btn-link text-sm @if(! $team->debit_account->count() || $team->debit_account->count() == 1){{ 'hidden' }}@endif no-underline pull-right no-padding-top-bottom change-selection">
                Choose Another Account
            </button>
        </div>
        @if ($card_account->count())
            <div class="account-selection  @if($team->debit_account->count()) hidden @endif">
                <form class="account-form">
                    <input type="hidden" name="save_account" value="debit-account">
                    <label>Choose An Account To Be Used For Debit</label>
                    <select name="selected_account form-control" class="choose-account-debit" data-placeholder="Select Account To Use">
                        @foreach($card_account as $debit)
                            @if ($debit->account_type == 'bank')
                                @continue
                            @else
                                <option value="{{ $debit->id }}"
                                    data-imagesrc="{{ logo_link($debit) }}"
                                    data-description="{{ account_desc($debit) }}">
                                    {{ ucwords($debit->type_details) . ' | ' . get_card_details($debit->type_details, $debit->last_four_digits)[1] }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </form>
            </div>
            @foreach($card_account as $debit_account)
                @if ($debit_account->account_type == 'bank' || 
                ($team->debit_account->count() && $team->debit_account[0]->id == $debit_account->id))
                    @continue
                @else
                    <div id="{{ $debit_account->id }}" class="hidden view-account-types">
                        <div class="row flex text-md padding-top-md padding-bottom-md">
                            <div class="col-md-4 flex flex-middle">{{ get_card_details($debit_account->type_details, $debit_account->last_four_digits)[0] }}</div>
                            <div class="col-md-8">
                                Card Number: <span class="block bold">{{ get_card_details($debit_account->type_details, $debit_account->last_four_digits)[1] }}</span>
                                Date Added: <span class="block bold">{{ $debit_account->created_at->format('l jS F, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
        @if ($team->debit_account->count())
            @foreach($team->debit_account as $debit)
                <div id="{{ $debit->id }}" class="view-account-types">
                    <div class="row flex text-md padding-top-md padding-bottom-md border-bottom">
                        <div class="col-md-4 flex flex-middle">{{ get_card_details($debit->type_details, $debit->last_four_digits)[0] }}</div>
                        <div class="col-md-8">
                            Card Number: <span class="block bold">{{ get_card_details($debit->type_details, $debit->last_four_digits)[1] }}</span>
                            Date Added: <span class="block bold">{{ $debit->created_at->format('l jS F, Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
            <hr >
            <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                <input type="hidden" name="email" value="{{ Auth::user()->email }}"> {{-- required --}}
                <input type="hidden" name="orderID" value="448">
                <input type="hidden" name="metadata" value="{{ json_encode($metadata) }}">
                <input type="hidden" name="amount" value="10000"> {{-- required in kobo --}}
                <input type="hidden" name="quantity" value="1">

                <button class="btn btn-success btn-lg center-block" type="submit" value="Add Another!">
                    <i class="fa fa-plus-circle fa-lg"></i> Add Another!
                </button>
            </form>
        @else
            <div class="text-center text-sm alert alert-warning account-info margin-top-md">
                This Account <b>NEEDS</b> be set for Etibe to start. <br />To confirm the Account, we will debit <b>100 NGN</b> initially and add to your Personal Savings.
            </div>
            <hr class="hr-sm">
            <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                <input type="hidden" name="email" value="{{ Auth::user()->email }}"> {{-- required --}}
                <input type="hidden" name="orderID" value="448">
                <input type="hidden" name="amount" value="10000"> {{-- required in kobo --}}
                <input type="hidden" name="quantity" value="1">

                <button class="btn btn-success btn-lg center-block" type="submit" value="Pay Now!">
                    <i class="fa fa-plus-circle fa-lg"></i> Add Now!
                </button>
            </form>
        @endif
    </div>

    <div class="col-sm-6 account-section credit-section">
        <h3 class="text-center">
            Crediting Account
            <small class="text-sm block margin-top-sm">This is the Account that your turn will be paid into. <br /> It should be a <b>Bank Account</b></small>
        </h3>
        <hr class="hr-sm">
        <div class="row">
            <button class="btn btn-link text-sm @if(! $team->credit_account->count() || $team->credit_account->count() == 1){{ 'hidden' }}@endif no-underline pull-right no-padding-top-bottom change-selection">
                Choose Another Account
            </button>
        </div>
        @if ($bank_account->count())
            <div class="account-selection @if($team->credit_account->count()) hidden @endif">
                <form class="account-form">
                    <input type="hidden" name="save_account" value="credit-account">
                    <label>Choose Account For Receiving Your Etibe</label>
                    <select name="selected_account" class="choose-account-credit form-control" data-placeholder="Select Account To Use">
                        @foreach($bank_account as $credit)
                            @if ($credit->account_type == 'bank')
                                <option value="{{ $credit->id }}"
                                    data-imagesrc="{{ logo_link($credit) }}"
                                    data-description="{{ account_desc($credit) }}">
                                    @if ($credit->account_type == 'bank')
                                        {{ get_bank_name($credit->type_details) . ' | XXXXXXXX' . $credit->last_four_digits }}
                                    @else
                                        {{ ucwords($credit->type_details) . ' | ' . get_card_details($credit->type_details, $credit->last_four_digits)[1] }}
                                    @endif
                                </option>
                            @else
                                @continue
                            @endif
                        @endforeach
                    </select>
                </form>
            </div>
            @foreach($bank_account as $credit)
                @if ($team->credit_account->count() && $team->credit_account[0]->id == $credit->id)
                    @continue
                @else
                    @if ($credit->account_type == 'bank')
                        <div id="{{ $credit->id }}" class="hidden view-account-types">
                            <?php $bank = \App\Bank::where('code', $credit->type_details)->first(); ?>
                            <div class="row flex text-md padding-top-md padding-bottom-md">
                                <div class="col-xs-4 flex flex-middle"><img src="{{ asset(urldecode($bank->logo)) }}" class="img-responsive img-rounded"></div>
                                <div class="col-xs-8">
                                    Account Number: <span class="bold block">XXXXXXXX{{ $credit->last_four_digits }}</span>
                                    Date Added: <span class="block bold">{{ $credit->created_at->format('l jS F, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        @continue
                    @endif
                @endif
            @endforeach
        @endif
        @if ($team->credit_account->count())
            @foreach($team->credit_account as $credit)
                <div id="{{ $credit->id }}" class="view-account-types">
                    <?php $bank = \App\Bank::where('code', $credit->type_details)->first(); ?>
                    <div class="row flex text-md padding-top-md padding-bottom-md">
                        <div class="col-xs-4 flex flex-middle"><img src="{{ asset(urldecode($bank->logo)) }}" class="img-responsive img-rounded"></div>
                        <div cass="col-xs-8">
                            Account Number: <span class="block bold">XXXXXXXX{{ $credit->last_four_digits }}</span>
                            Date Added: <span class="block bold">{{ $credit->created_at->format('l jS F, Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
            <hr >
            <button class="btn btn-success btn-lg center-block" type="button" value="Add Another!" data-toggle="modal" data-target="#add-crediting-account-modal">
                <i class="fa fa-plus-circle fa-lg"></i> Add Another!
            </button>
        @else            
            <div class="text-center text-sm alert alert-warning account-info margin-top-md">
                If this account is not set, you will <b>NOT</b> be able to receive your payment when it is your turn to be paid.
            </div>
            <hr class="hr-sm">
            <button class="btn btn-success btn-lg center-block" type="button" value="Add Now!" data-toggle="modal" data-target="#add-crediting-account-modal">
                <i class="fa fa-plus-circle fa-lg"></i> Add Now!
            </button>
        @endif
    </div>
</div>

@include('modals._add-crediting-account-modal')

@include('views-js.payment-account-js')

<script src="{{ asset('js/ddslick.js') }}"></script>
<script>
    $(function () {
        $('#select-bank').ddslick({
            height: "150px",
            selectText: "Select Your Bank",
            showSelectedHTML: true,
        });

        var divWidth = $('.choose-account').parents('.col-sm-6').width;
        var varyWidth = $('.choose-account').parents('.col-sm-6').width();

        $('.choose-account-debit').ddslick({
            selectText: "Choose An Account",
            defaultSelectedIndex: null,
            width: ($(window).width() < 768) ? varyWidth : divWidth,
            showSelectedHTML: true,
        });

        $('.choose-account-credit').ddslick({
            selectText: "Choose An Account",
            width: ($(window).width() < 768) ? varyWidth : divWidth,
            showSelectedHTML: true,
        });

    });
</script>