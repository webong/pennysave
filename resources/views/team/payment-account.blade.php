<div class="section tab-pane active" id="payment-account">
    <div class="col-sm-6 border-right">
        <h3 class="text-center">
            Debiting Account
            <small class="text-sm block margin-top-sm">This is the Account through which your Etibe Contribution will be debited.</small>
        </h3>
        <hr class="hr-sm">

        <div class="text-center text-sm alert alert-warning">This Account <b>NEEDS</b> be set for Etibe to start. <br />To confirm the Account, we will debit <b>100 NGN</b> initially and add to your Personal Savings.</div>
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
    </div>

    <div class="col-sm-6">
        <h3 class="text-center">
            Crediting Account
            <small class="text-sm block margin-top-sm">This is the Account that your turn will be paid into. (Preferably it should be a Bank Account)</small>
        </h3>
        <hr class="hr-sm">
        <div class="text-center text-sm alert alert-warning">If this account is not set, you will be unable to receive your payment when it is your turn to be paid</div>
        
        <button class="btn btn-success btn-lg center-block" type="button" value="Add Now!" data-toggle="modal" data-target="#add-crediting-account-modal">
            <i class="fa fa-plus-circle fa-lg"></i> Add Now!
        </button>
    </div>
</div>

@include('modals._add-crediting-account-modal')

<script src="{{ asset('js/ddslick.js') }}"></script>
<script>
    $(function () {
        $('#select-bank').ddslick({
            height: "150px",
            selectText: "Select Your Bank",
            showSelectedHTML: true,
        });
    });
</script>