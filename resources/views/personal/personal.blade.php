@extends('layouts._sections')

@section('left-side-menu')
    <!-- <form role="form" method="POST" action="{{ route('register') }}"> -->
    <form role="form" method="POST" action="{{ route('personal-create') }}">
        {{ csrf_field() }}
        <p class="text-center">It is easier to follow through on Savings with a <strong>Goal/Target</strong> than without one<hr class="hr-class" /></p>

        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-primary btn-lg center-block">
                Create Plan
            </button>
        </div>
    </form>
@endsection

@section('body-title')
    <h2 class="page-heading text-info text-center">{{ $plan_details->name }}<hr /></h2>
@endsection

@section('main-body-section')
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="control-label sr-only">Target Amount</label>

        <input id="name" type="text" class="form-control" placeholder="Name of Plan" name="name" data-politespace data-grouplength="3" data-delimiter=", " data-politespace-reverse value="{{ old('name') }}">

        @if ($errors->has('name'))
          <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
          </span>
        @endif
        <span class="help-block">Select A Name For This Plan (Possibly Related To Your Target)</span>
    </div>

    <div class="row">
        <div class="col-md-6 form-group{{ $errors->has('target_amount') ? ' has-error' : '' }}">
            <label for="target_amount" class="control-label sr-only">Target Amount</label>

            <div class="input-group">
                <span class="input-group-addon">&#x20A6;</span>
                <input id="target_amount" type="number" class="form-control" placeholder="Target Amount" name="target_amount" data-politespace data-grouplength="3" data-delimiter=", " data-politespace-reverse value="{{ old('target_amount') }}">
                <span class="input-group-addon">.00</span>
            </div>

            @if ($errors->has('target_amount'))
              <span class="help-block">
                  <strong>{{ $errors->first('target_amount') }}</strong>
              </span>
            @endif
            <span class="help-block">Amount You Are Targetting To Save</span>
        </div>

        <div class="col-md-6 form-group{{ $errors->has('instalment_amount') ? ' has-error' : '' }}">
            <label for="instalment_amount" class="control-label sr-only">Amount</label>

            <div class="input-group">
                <span class="input-group-addon">&#x20A6;</span>
                <input id="instalment_amount" type="number" class="form-control" placeholder="Instalment" name="instalment_amount" data-politespace data-grouplength="3" data-delimiter=", " data-politespace-reverse value="{{ old('instalment_amount') }}" title="The Amount You Intend To Save Regularly To Reach Your Target">
                <span class="input-group-addon">.00</span>
            </div>

            @if ($errors->has('instalment_amount'))
              <span class="help-block">
                  <strong>{{ $errors->first('instalment_amount') }}</strong>
              </span>
            @endif
            <span class="help-block">Instalment Amount To Save</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
            <label for="start_date" class="control-label sr-only">Start Date</label>

            <input id="start_date" type="date" class="form-control" placeholder="Start Date" name="start_date" value="{{ old('start_date') }}" required>

            @if ($errors->has('start_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
            <span class="help-block">Date To Commence Saving</span>
        </div>

        <div class="col-md-6 form-group{{ $errors->has('target_date') ? ' has-error' : '' }}">
            <label for="target_date" class="control-label sr-only">Target Date</label>

            <input id="target_date" type="date" class="form-control" placeholder="Target Date" name="target_date" value="{{ old('target_date') }}" required>

            @if ($errors->has('target_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('target_date') }}</strong>
                </span>
            @endif
            <span class="help-block">Date You Intend To Have Reached Target Amount</span>
        </div>
    </div>
@endsection
