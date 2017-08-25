@extends('layouts.app') 

@section('added_css')
    <link href="{{ asset('css/selectize.bootstrap3.css') }}" rel="stylesheet">
    @include('partials._togglecheckbox') 
@endsection 

@section('content')
    <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
            <div class="col-md-8 col-md-offset-2">
                <p>
                    <div>
                        Add Payment
                    </div>
                </p>
                <input type="hidden" name="email" value="gentleekan@gmail.com"> {{-- required --}}
                <input type="hidden" name="orderID" value="448">
                <input type="hidden" name="amount" value="500000"> {{-- required in kobo --}}
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}} 
                {{ csrf_field() }}

                <p>
                    <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
                        <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                    </button>
                </p>
            </div>
        </div>
    </form>
@endsection