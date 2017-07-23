@extends('layouts.app')

@section('added_css')
    <link href="{{ asset('css/selectize.bootstrap3.css') }}" rel="stylesheet">
    @include('partials._togglecheckbox')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <h3 class="panel-heading panel-heading-with-position text-center">
                    Create Personal Plan
                    <div class="position-right">
                        <div class="block-switch">
                            <input id="toggle-flat" class="toggle toggle-flat" type="checkbox" name="smart_suggest">
                            <label for="toggle-flat" data-on="Yes" data-off="No" title="Use Smart Suggest To Help You Set Up Your Savings Plan"></label>
                        </div>
                        <p class="help-text">Use Smart Suggest</p>
                    </div>
                </h3>
                <div class="panel-body">
                    <!-- <form role="form" method="POST" action="{{ route('register') }}"> -->
                    <form role="form" method="POST" action="{{ route('personal-create') }}" class="form_with_amount">
                        {{ csrf_field() }}
                        <p class="text-center">It is easier to follow through on Savings with a <strong>Goal/Target</strong> than without one<hr class="hr-class" /></p>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label sr-only">Target Amount</label>

                            <input id="name" type="text" class="form-control amount" placeholder="Name of Plan" name="name" value="{{ old('name') }}">

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
                                    <span class="input-group-addon no-border-right">&#x20A6;</span>
                                    <input id="target_amount" type="number" class="form-control amount no-border-right no-border-left" placeholder="Target Amount" name="target_amount" value="{{ old('target_amount') }}">
                                    <span class="input-group-addon no-border-left">.00</span>
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
                                    <span class="input-group-addon no-border-right">&#x20A6;</span>
                                    <input id="instalment_amount" type="number" class="form-control no-border-right no-border-left" placeholder="Instalment" name="instalment_amount" data-politespace data-grouplength="3" data-delimiter=", " data-politespace-reverse value="{{ old('instalment_amount') }}" title="The Amount You Intend To Save Regularly To Reach Your Target">
                                    <span class="input-group-addon no-border-left">.00</span>
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
                            <div class="col-md-6 form-group{{ $errors->has('recurrence') ? ' has-error' : '' }}">
                                <label for="recurrence" class="control-label sr-only">Payment Intervals</label>

                                <select name="recurrence" data-placeholder="Select Savings Interval" class="single-select form-control">
                                    @foreach($recurrence as $current)
                                        <option></option>
                                        <option value="{{ $current->id }}"
                                            @if (old('recurrence') == $current->id) {{ ' selected' }}@endif> {{ $current->period }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('recurrence'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('recurrence') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block">Interval At Which To Save Instalment</span>
                            </div>

                            <div class="col-md-6 form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                                <label for="priority" class="control-label sr-only">Priority Level</label>

                                <select name="priority" data-placeholder="Set Priority Level" class="single-select form-control" title="Set How Important it is to reach the Target">
                                    @foreach($priority_level as $priority)
                                        <option></option>
                                        <option value="{{ $priority->id }}"
                                            @if (old('priority') == $priority->id) {{ ' selected' }}@endif> {{ $priority->priority_level     }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                                <span class="help-block">Priority/Importance of Savings</span>
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

                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary btn-lg center-block">
                                Create Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('added_js')
    <script src="{{ asset('js/selectize.min.js') }}"></script>
    <script type="text/javascript">
        $("select").selectize();
    </script>
@endsection
